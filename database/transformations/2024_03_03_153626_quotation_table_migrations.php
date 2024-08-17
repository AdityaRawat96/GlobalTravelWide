<?php

use App\Models\Airline;
use App\Models\Hotel;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class QuotationTableMigrations extends Migration
{
    public function up()
    {
        // Connect to remote database
        DB::connection('remote_mysql')->table('quotation')->orderBy('id')->chunk(100, function ($quotations) {
            foreach ($quotations as $quotation) {
                if (Quotation::where('id', $quotation->id)->exists() || Quotation::where('quotation_id', $quotation->quotationID)->exists()) {
                    continue;
                } else {
                    // Dispatch a job for each quotation
                    ProcessQuotation::dispatch($quotation);
                }
            }
        });
    }

    public function down()
    {
        // Define the rollback logic if necessary
    }
}

class ProcessQuotation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $quotation;

    public function __construct($quotation)
    {
        $this->quotation = $quotation;
    }

    public function handle()
    {
        try {
            // Create a new model instance
            $localQuotation = new Quotation();
            $localQuotation->id = (int) $this->quotation->id;
            $localQuotation->quotation_id = $this->quotation->quotationID;
            $localQuotation->ref_number = $this->quotation->referenceNumber;
            $localQuotation->company_id = $this->quotation->company;
            $localQuotation->customer_id = (int) $this->quotation->customerID;
            $localQuotation->user_id = (int) $this->quotation->employeeID;
            $localQuotation->quotation_date = $this->quotation->quotationDate;
            $localQuotation->cost = $this->quotation->costPrice;
            $localQuotation->price = $this->quotation->sellingPrice;
            $localQuotation->airline_notes = $this->quotation->airlineDescription;
            $localQuotation->hotel_notes = $this->quotation->hotelDescription;
            $localQuotation->save();

            $this->processAirlines($localQuotation);
            $this->processHotels($localQuotation);
        } catch (\PDOException $e) {
            $this->handlePDOException($e, $localQuotation);
        }
    }

    protected function processAirlines()
    {
        if (empty($this->quotation->airlineName)) {
            return;
        }
        $airlineNames = substr($this->quotation->airlineName, 0, -1);
        $airlineNames = explode('|', $airlineNames);

        $airlineFroms = substr($this->quotation->airlineFrom, 0, -1);
        $airlineFroms = explode('|', $airlineFroms);

        $airlineTos = substr($this->quotation->airlineTo, 0, -1);
        $airlineTos = explode('|', $airlineTos);

        $airlineDepartures = substr($this->quotation->airlineDeparture, 0, -1);
        $airlineDepartures = explode('|', $airlineDepartures);

        $airlineArrivals = substr($this->quotation->airlineArrival, 0, -1);
        $airlineArrivals = explode('|', $airlineArrivals);

        foreach ($airlineNames as $key => $airlineName) {
            $formatted_arrival_time = date('Y-m-d H:i:s', strtotime($airlineArrivals[$key]));
            $formatted_departure_time = date('Y-m-d H:i:s', strtotime($airlineDepartures[$key]));

            $localQuotation_airline = [
                'quotation_id' => (int) $this->quotation->id,
                'name' => $airlineName,
                'arrival_airport' => $airlineTos[$key],
                'departure_airport' => $airlineFroms[$key],
                'arrival_time' => $formatted_arrival_time,
                'departure_time' => $formatted_departure_time,
            ];
            Airline::create($localQuotation_airline);
        }
    }

    protected function processHotels()
    {
        if (empty($this->quotation->hotelName)) {
            return;
        }
        $hotelNames = substr($this->quotation->hotelName, 0, -1);
        $hotelNames = explode('|', $hotelNames);

        $hotelCheckins = substr($this->quotation->hotelCheckIn, 0, -1);
        $hotelCheckins = explode('|', $hotelCheckins);

        $hotelCheckouts = substr($this->quotation->hotelCheckOut, 0, -1);
        $hotelCheckouts = explode('|', $hotelCheckouts);

        foreach ($hotelNames as $key => $hotelName) {
            $formatted_checkin_time = date('Y-m-d H:i:s', strtotime($hotelCheckins[$key]));
            $formatted_checkout_time = date('Y-m-d H:i:s', strtotime($hotelCheckouts[$key]));

            $localQuotation_hotel = [
                'quotation_id' => (int) $this->quotation->id,
                'name' => $hotelName,
                'checkin_time' => $formatted_checkin_time,
                'checkout_time' => $formatted_checkout_time,
            ];
            Hotel::create($localQuotation_hotel);
        }
    }

    protected function handlePDOException($e, $localQuotation)
    {
        if ($e->getCode() == '23000' && strpos($e->getMessage(), '1452') !== false) {
            // Foreign key constraint violation, map added_by to id first_admin_id
            Log::warning('Foreign key constraint violation for quotation ID ' . $this->quotation->id . '. Mapping added_by to ID first_admin_id.');
            $first_admin_id = User::where('role', 'admin')->first()->id;
            $localQuotation->user_id = $first_admin_id;
            $localQuotation->save();
        } else {
            // Rethrow the exception if it's not a specific foreign key or integrity constraint violation
            throw $e;
        }
    }
}
