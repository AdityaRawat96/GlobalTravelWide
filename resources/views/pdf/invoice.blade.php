<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    @if($view)
    <style>
        @font-face {
            font-family: "Poppins";
            src: url("{{ asset('fonts/Poppins-Regular.ttf') }}") format("truetype");
        }

        .invoice-details {
            line-height: 12px !important;
        }
    </style>
    @else
    <style>
        @font-face {
            font-family: "Poppins";
            src: url("{{ storage_path('fonts/Poppins-Regular.ttf') }}") format("truetype");
        }
    </style>
    @endif

    <style>
        .content {
            font-family: "Poppins", sans-serif !important;
        }

        th {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="content" style="max-width: 1000px; left: 0; right: 0; margin: auto">
        <table style="position: relative; width: 100%">
            <tr style="position: relative; width: 100%">
                <td style="position: relative; width: 50%">
                    @if($view)
                    <img src="{{ Storage::drive('public')->url($invoice->company->logo) }}" alt="Invoice logo" style="height: 50px; margin: 10px" />
                    @else
                    <img src="{{ storage_path('app/public/' . $invoice->company->logo) }}" alt="Invoice logo" style="height: 50px; margin: 10px" />
                    @endif
                </td>
                <td style="position: relative; width: 50%; text-align: right">
                    <h3>INVOICE</h3>
                </td>
            </tr>
        </table>
        <div class="seperator" style="position: relative; width: 100%; border-bottom: 1px solid #000; margin: 10px 0">
        </div>
        <div class="invoice-info">
            <table style="
            position: relative;
            width: 100%;
            font-size: 10px;
            padding: 0px 10px;
            margin-left: auto;
            margin-right: auto;
          ">
                <tr style="position: relative; width: 100%">
                    <td style="position: relative; width: 33%">
                        <address>
                            F3, 298 Romford Road<br />
                            London<br />
                            E7 9HD<br />
                            Phone: 0203 0020535<br />
                        </address>
                    </td>
                    <td style="position: relative; width: 33%">
                        INVOICE TO
                        <address>
                            <strong>{{$invoice->customer->name}}</strong><br />
                            Phone: {{$invoice->customer->phone}}<br />
                            Email: {{$invoice->customer->email}}
                        </address>
                    </td>
                    <td style="position: relative; width: 33%">
                        <table class="invoice-details" style="
                            position: relative;
                            width: 200px;
                            font-size: 10px;
                            line-height: 8px;
                            margin-left: auto;
                        ">
                            <tr>
                                <td style="font-weight: bold">Invoice#:</td>
                                <td style="text-align: right">{{$invoice->invoice_id}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Reference Number:</td>
                                <td style="text-align: right">{{$invoice->ref_number}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Invoice Date:</td>
                                <td style="text-align: right">{{date("d-m-Y", strtotime($invoice->invoice_date))}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Departure Date:</td>
                                <td style="text-align: right">{{date("d-m-Y", strtotime($invoice->departure_date))}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Payment Due:</td>
                                <td style="text-align: right">{{date("d-m-Y", strtotime($invoice->due_date))}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Payment Status:</td>
                                <td style="text-align: right">
                                    @if($invoice->due_date < now() && $invoice->status == 'pending')
                                        <span style="color: red">Overdue</span>
                                        @else
                                        {{ucfirst($invoice->status)}}
                                        @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br /><br />
        </div>
        <table class="table table-striped" style="width: 100%; font-size: 10px; text-align: left">
            <thead>
                <tr>
                    <th style="text-align: left">Quantity</th>
                    <th style="text-align: left">Service</th>
                    <th style="text-align: left">Description</th>
                    <th style="text-align: right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice_products as $product)
                <tr>
                    <td>{{$product->quantity}}</td>
                    <td>{{$product->catalogue->name}}</td>
                    <td>{{$product->catalogue->description}}</td>
                    <td style="text-align: right">{{ $invoice->currencySymbol }}
                        {{ number_format($product->price, 2, '.', ',') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br /><br />
        <table class="table" style="
          font-size: 10px;
          text-align: left;
          width: 46%;
          right: 0;
          left: 0;
          margin-left: auto;
        ">
            <tr>
                <th style="text-align: left">Total:</th>
                <td style="text-align: right">{{ $invoice->currencySymbol }}
                    {{number_format($invoice->total, 2, '.', ',')}}
                </td>
            </tr>
            <?php $amount_paid = 0; ?>
            @foreach($invoice_payments as $payment)
            <tr>
                <td style="text-align: left">{{ucfirst($payment->mode)}} Payment on
                    {{date("d-m-Y", strtotime($payment->date))}}
                </td>
                <td style="text-align: right">{{ $invoice->currencySymbol }}
                    {{ number_format($payment->amount, 2, '.', ',') }}
                </td>
            </tr>
            <?php $amount_paid += $payment->amount; ?>
            @endforeach
            <tr>
                <th style="text-align: left">Amount Due:</th>
                <td style="text-align: right">{{ $invoice->currencySymbol }}
                    {{number_format(($invoice->total - $amount_paid), 2, '.', ',')}}
                </td>
            </tr>
        </table>
        <br />
        <div class="seperator" style="position: relative; width: 100%; border-bottom: 1px solid #000; margin: 10px 0">
        </div>
        <div class="terms" style="font-size: 8px">
            <p>
                <b>Notes / Terms</b><br />
                Additional Information<br />
            </p>
            @if($invoice->company->id == 1)
            <p>
                * Deposits: All deposits are non-refundable.<br>
                * Changes: After ticket issuance, before and after departure changes not permitted (Airline Rules &
                Regulations may apply)<br>
                * Cancellations: Before departure and after departure ticket is non-refundable (Airline Rules &
                Regulations may vary).<br>
                *Admin Charges: Where a reservation is cancelled or modified after confirm ticket is issued; there is an
                admin charge of {{ $invoice->currencySymbol }}45 per ticket plus airline cancellation charges if ticket
                is refundable. Kindly note
                that where there has been a no-show for a flight, the ticket will be non-refundable. <br>
                *Schedule Changes: Passenger will able to change the date in case of schedule change or flight
                cancellation +- 3 days depending on flight availability. Please note if you wish to change out of these
                days, you will be charged an admin fee of {{ $invoice->currencySymbol }}45 plus if there is any fare
                difference.<br>
                * Hotel Bookings: All confirm hotel bookings are non-refundable & after booking confirmation changes not
                permitted.<br>
                * Special Requests: Special request can be sent to hotels & airlines but can't be guaranteed.<br>
                * Additional charges: Some City Councils and Resorts charge additional fees which must be paid by guests
                directly. These cannot be prepaid.<br>
                * Check-in: Please note, for international long-haul flights you need to be at the check-in counter at
                least 3hrs prior to departure, and for short haul flights the check-in time is 1hr 45min.<br>
                * RE-CONFIRMATION- PLEASE RE-CONFIRM YOUR FLIGHTS WITH THE AIRLINE/TRAVEL CONSULTANT 72HRS PRIOR TO
                DEPARTURE.<br>
                * Documents: We do not accept any responsibility if your travel documents are not in order. Please check
                validity of the passport, visa and any immigration requirements before undertaking your journey.<br>
                * Insurance: We strongly advise you to take out travel insurance to cover any eventualities arising due
                to delay/cancellation of flights, Loss/delay of luggage or any other medical conditions which may come
                between your journeys.<br>
                * For full terms and conditions please follow the link - https://globaltravelwide.com/termsandconditions
            </p>
            @else
            <p>
                * All deposits are non-refundable<br>
                * Special request can be sent to hotels & airlines but can't be guaranteed.<br>
                * All confirm hotel bookings are non-refundable & after booking confirmation changes not permitted<br>
                * Company holds the right to provide the alternative option of the hotel in case of earlier provides
                option is not available.<br>
                * Before departure and after departure ticket is non-refundable (Airline Rules & Regulations may
                vary).<br>
                * After ticket issuance, before and after departure changes not permitted (Airline Rules & Regulations
                may vary).<br>
                *Where a reservation is cancelled or modified after confirm ticket is issued; there is an admin charge
                of {{ $invoice->currencySymbol }}45 per ticket plus airline cancellation charges if ticket is
                refundable. Kindly note that where
                there has been a no-show for a flight, the ticket will be non-refundable. <br>
                *Passenger will able to change the date in case of schedule change or flight cancellation +- 3 days
                depending on flight availability. Please note if you wish to change out of these days, you will be
                charged an admin fee of {{ $invoice->currencySymbol }}45 plus if there is any fare difference.<br>
                * Once you applied for a visa and later if any circumstances you want to get the passport back visa fee
                is non-refundable.<br>
                * Please note, for international long-haul flights you need to be at the check-in counter at least 3hrs
                prior to departure, and for short haul flights the check-in time is 1hr 45min.<br>
                * RE-CONFIRMATION- PLEASE RE-CONFIRM YOUR FLIGHTS WITH THE AIRLINE/TRAVEL CONSULTANT 72HRS PRIOR TO
                DEPARTURE.<br>
                * Visa is not guaranteed under any circumstances. In case of delay in obtaining or rejection of the visa
                from the embassy/portal, the company shall not be held responsible for the related costs including
                flight changes and hotel booking.<br>
                * We do not accept any responsibility if your travel documents are not in order. Please check validity
                of the passport, visa and any immigration requirements before undertaking your journey.<br>
                * We strongly advise you to take out travel insurance to cover any eventualities arising due to
                delay/cancellation of flights, Loss/delay of luggage or any other medical conditions which may come
                between your journeys.<br>
                * For full terms and conditions please follow the link -
                https://www.ontimehajjumrah.com/termsandconditions
            </p>
            @endif
            <br />
            <p>
                <b>Account Details</b><br />
                Global Travelwide Ltd.<br />
                Bank Name: Santander | Sort Code: 090129 | Account No:63602928
                <br />
                Bank Name: NatWest | Sort Code: 517057 | Account No:89222709
                <br />
            </p>
        </div>
        <div class="footer" style="
          position: relative;
          width: 100%;
          text-align: center;
          font-size: 8px;
        ">
            @if($invoice->company->id == 1)
            <span>Global Travelwide LTD, Registered in England & Wales number 13124484</span>
            @else
            <span>Ontime Hajj & Umrah T/A Global Travelwide LTD, Registered in England
                & Wales number 13124484</span>
            @endif
        </div>
    </div>
</body>

</html>