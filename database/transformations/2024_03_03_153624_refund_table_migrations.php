<?php

use App\Models\Attachment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Refund;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class RefundTableMigrations extends Migration
{
    public function up()
    {
        // Connect to remote database
        DB::connection('remote_mysql')->table('refund')->orderBy('id')->chunk(100, function ($refunds) {
            foreach ($refunds as $refund) {
                try {
                    // Create a new model instance
                    $localRefund = new Refund();
                    $localRefund->id = (int) $refund->id;
                    $localRefund->refund_id = $refund->refundID;
                    $localRefund->ref_number = $refund->referenceNumber;
                    $localRefund->company_id = $refund->company;
                    $localRefund->customer_id = (int) $refund->customerID;
                    $localRefund->user_id = $refund->employeeID;
                    $localRefund->refund_date = $refund->refundDate;
                    $localRefund->due_date = $refund->paymentDate;
                    $localRefund->total = $refund->orderTotal;
                    $localRefund->currency = 'gbp';
                    $localRefund->status = $refund->status == 1 ? 'paid' : 'pending';
                    $localRefund->notes = $refund->notes;

                    // remove last char then ids split by comma
                    $product_Ids = substr($refund->productID, 0, -1);
                    $product_Ids = explode(',', $product_Ids);

                    $product_costs = substr($refund->productCostPrice, 0, -1);
                    $product_costs = explode(',', $product_costs);

                    $product_prices = substr($refund->productSellingPrice, 0, -1);
                    $product_prices = explode(',', $product_prices);

                    $product_quantities = substr($refund->productQuantity, 0, -1);
                    $product_quantities = explode(',', $product_quantities);

                    $revenue = 0;
                    foreach ($product_Ids as $key => $product_id) {
                        $revenue += $product_prices[$key] - $product_costs[$key];
                        $localRefund_product = [
                            'type' => 'refund',
                            'ref_id' => (int) $refund->id,
                            'catalogue_id' => $product_id,
                            'cost' => $product_costs[$key],
                            'price' => $product_prices[$key],
                            'quantity' => $product_quantities[$key],
                            'revenue' => $product_prices[$key] - $product_costs[$key],
                            'currency' => 'gbp'
                        ];
                        Product::create($localRefund_product);
                    }

                    // remove last char then ids split by comma
                    if ($refund->paymentAmount) {
                        $payment_amounts = substr($refund->paymentAmount, 0, -1);
                        $payment_amounts = explode(',', $payment_amounts);

                        $payment_dates = substr($refund->paidDate, 0, -1);
                        $payment_dates = explode(',', $payment_dates);

                        $payment_modes = substr($refund->paymentType, 0, -1);
                        $payment_modes = explode(',', $payment_modes);

                        foreach ($payment_amounts as $key => $payment_amount) {
                            $localRefund_payment = [
                                'type' => 'refund',
                                'ref_id' => (int) $refund->id,
                                'amount' => $payment_amount,
                                'date' => $payment_dates[$key],
                                'mode' => $payment_modes[$key],
                                'currency' => 'gbp'
                            ];
                            Payment::create($localRefund_payment);
                        }
                    }


                    $localRefund->revenue = $revenue;

                    $localRefund->save();

                    // parse json string to array
                    $refund_attachments = json_decode($refund->attachments, true);
                    if ($refund_attachments) {
                        foreach ($refund_attachments as $attachment) {
                            $url = env('REMOTE_APP_URL') . "/Refund-" . $refund->refundID . "/" . $attachment;
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
                                Storage::put('refunds/' . $filename, $response->getBody());
                                // Get the full path to the stored file
                                $filePath = 'refunds/' . $filename;
                                // You can now use $filePath, $size, $mimeType, and $extension
                                // for further processing or database storage

                                $attachmentLocal['type'] = 'refund';
                                $attachmentLocal['ref_id'] = (int) $refund->id;
                                $attachmentLocal['name'] = $attachment;
                                $attachmentLocal['extension'] = $extension;
                                $attachmentLocal['mime_type'] = $mimeType;
                                $attachmentLocal['size'] = $size;
                                $attachmentLocal['url'] = $filePath;
                                Attachment::create($attachmentLocal);
                            } catch (\Exception $e) {
                                // Handle exceptions
                                echo $e->getMessage();
                            }
                        }
                    }
                } catch (\PDOException $e) {
                    if ($e->getCode() == '23000' && strpos($e->getMessage(), '1452') !== false) {
                        // Foreign key constraint violation, map added_by to id first_admin_id
                        Log::warning('Foreign key constraint violation for refund ID ' . $refund->id . '. Mapping added_by to ID first_admin_id.');
                        $first_admin_id = User::where('role', 'admin')->first()->id;
                        $localRefund->user_id = $first_admin_id;
                        $localRefund->save();
                    } else {
                        // Rethrow the exception if it's not the specific foreign key constraint violation
                        throw $e;
                    }
                }
            }
        });
    }

    public function down()
    {
        // Define the rollback logic if necessary
    }
}
