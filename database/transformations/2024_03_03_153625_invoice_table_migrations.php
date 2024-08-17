<?php

use App\Models\Attachment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InvoiceTableMigrations extends Migration
{
    public function up()
    {
        // Connect to remote database
        DB::connection('remote_mysql')->table('invoice')->orderBy('id')->chunk(100, function ($invoices) {
            foreach ($invoices as $invoice) {
                if (Invoice::where('id', $invoice->id)->exists() || Invoice::where('invoice_id', $invoice->invoiceID)->exists()) {
                    continue;
                } else {
                    // Dispatch a job for each invoice
                    ProcessInvoice::dispatch($invoice);
                }
            }
        });
    }

    public function down()
    {
        // Define the rollback logic if necessary
    }
}

class ProcessInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function handle()
    {
        try {
            // Create a new model instance
            $localInvoice = new Invoice();
            $localInvoice->id = (int) $this->invoice->id;
            $localInvoice->invoice_id = $this->invoice->invoiceID;
            $localInvoice->ref_number = $this->invoice->referenceNumber;
            $localInvoice->company_id = $this->invoice->company;
            $localInvoice->customer_id = (int) $this->invoice->customerID;
            $localInvoice->user_id = $this->invoice->employeeID;
            $localInvoice->invoice_date = $this->invoice->invoiceDate;
            $localInvoice->due_date = $this->invoice->paymentDate;
            $localInvoice->departure_date = $this->invoice->departureDate;
            $localInvoice->total = $this->invoice->orderTotal;
            $localInvoice->currency = 'gbp';
            $localInvoice->status = $this->invoice->status == 1 ? 'paid' : 'pending';
            $localInvoice->notes = $this->invoice->notes;

            $revenue = $this->processProducts($localInvoice);
            $localInvoice->revenue = $revenue;

            $localInvoice->save();

            $this->processPayments($localInvoice);
            $this->processAttachments($localInvoice);
        } catch (\PDOException $e) {
            $this->handlePDOException($e, $localInvoice);
        }
    }

    protected function processProducts($localInvoice)
    {
        $product_Ids = substr($this->invoice->productID, 0, -1);
        $product_Ids = explode(',', $product_Ids);

        $product_costs = substr($this->invoice->productCostPrice, 0, -1);
        $product_costs = explode(',', $product_costs);

        $product_prices = substr($this->invoice->productSellingPrice, 0, -1);
        $product_prices = explode(',', $product_prices);

        $product_quantities = substr($this->invoice->productQuantity, 0, -1);
        $product_quantities = explode(',', $product_quantities);

        $revenue = 0;
        foreach ($product_Ids as $key => $product_id) {
            if ($product_id != '' && $product_id != 'null' && $product_id != 'undefined') {
                $cost = $product_costs[$key] ? (float) $product_costs[$key] : 0;
                $price = $product_prices[$key] ? (float) $product_prices[$key] : 0;
                $revenue += $price - $cost;
                $localInvoice_product = [
                    'type' => 'invoice',
                    'ref_id' => (int) $this->invoice->id,
                    'catalogue_id' => $product_id,
                    'cost' => $cost,
                    'price' => $price,
                    'quantity' => $product_quantities[$key],
                    'revenue' => $price - $cost,
                    'currency' => 'gbp'
                ];
                Product::create($localInvoice_product);
            }
        }

        return $revenue;
    }

    protected function processPayments($localInvoice)
    {
        if ($this->invoice->paymentAmount) {
            $payment_amounts = substr($this->invoice->paymentAmount, 0, -1);
            $payment_amounts = explode(',', $payment_amounts);

            $payment_dates = substr($this->invoice->paidDate, 0, -1);
            $payment_dates = explode(',', $payment_dates);

            $payment_modes = substr($this->invoice->paymentType, 0, -1);
            $payment_modes = explode(',', $payment_modes);

            foreach ($payment_amounts as $key => $payment_amount) {
                if ($payment_amount != '' && $payment_amount != 'null' && $payment_amount != 'undefined') {
                    $date = $payment_dates[$key] == 'Invalid date' ? $this->invoice->invoiceDate : $payment_dates[$key];
                    $localInvoice_payment = [
                        'type' => 'invoice',
                        'ref_id' => (int) $this->invoice->id,
                        'amount' => $payment_amount,
                        'date' => $date,
                        'mode' => $payment_modes[$key],
                        'currency' => 'gbp'
                    ];
                    Payment::create($localInvoice_payment);
                }
            }
        }
    }

    protected function processAttachments($localInvoice)
    {
        $invoice_attachments = json_decode($this->invoice->attachments, true);
        if ($invoice_attachments) {
            foreach ($invoice_attachments as $attachment) {
                $url = env('REMOTE_APP_URL') . "/Invoice-" . $this->invoice->invoiceID . "/" . $attachment;
                try {
                    $client = new Client([
                        'verify' => false
                    ]);
                    $response = $client->get($url);

                    // Get file metadata
                    $size = (int) $response->getHeader('Content-Length')[0];
                    $mimeType = $response->getHeader('Content-Type')[0];
                    $extension = pathinfo($url, PATHINFO_EXTENSION);
                    // Generate a unique filename
                    $filename = uniqid() . '.' . $extension;
                    // Store the file
                    Storage::put('invoices/' . $filename, $response->getBody());
                    // Get the full path to the stored file
                    $filePath = 'invoices/' . $filename;

                    $attachmentLocal = [
                        'type' => 'invoice',
                        'ref_id' => (int) $this->invoice->id,
                        'name' => $attachment,
                        'extension' => $extension,
                        'mime_type' => $mimeType,
                        'size' => $size,
                        'url' => $filePath
                    ];
                    Attachment::create($attachmentLocal);
                } catch (\Exception $e) {
                    // Handle exceptions
                    Log::error('Error processing attachment for invoice ' . $this->invoice->id . ': ' . $e->getMessage());
                }
            }
        }
    }

    protected function handlePDOException($e, $localInvoice)
    {
        if ($e->getCode() == '23000' && strpos($e->getMessage(), '1452') !== false) {
            // Foreign key constraint violation, map added_by to id first_admin_id
            Log::warning('Foreign key constraint violation for invoice ID ' . $this->invoice->id . '. Mapping added_by to ID first_admin_id.');
            $first_admin_id = User::where('role', 'admin')->first()->id;
            $localInvoice->user_id = $first_admin_id;
            $localInvoice->save();
        } else {
            // Rethrow the exception if it's not a specific foreign key or integrity constraint violation
            throw $e;
        }
    }
}
