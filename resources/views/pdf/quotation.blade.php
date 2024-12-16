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

        .quotation-details {
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
                    <img src="{{ Storage::drive('public')->url($quotation->company->logo) }}" alt="Quotation logo"
                        style="height: 50px; margin: 10px" />
                    @else
                    <img src="{{ storage_path('app/public/' . $quotation->company->logo) }}" alt="Quotation logo"
                        style="height: 50px; margin: 10px" />
                    @endif
                </td>
                <td style="position: relative; width: 50%; text-align: right">
                    <h3>QUOTATION</h3>
                </td>
            </tr>
        </table>
        <div class="seperator" style="position: relative; width: 100%; border-bottom: 1px solid #000; margin: 10px 0">
        </div>
        <div class="quotation-info">
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
                        QUOTATION TO
                        <address>
                            <strong>{{isset($quotation->customer->name) ? $quotation->customer->name : ""}}</strong><br />
                            Phone: {{isset($quotation->customer->phone) ? $quotation->customer->phone : ""}}<br />
                            Email: {{isset($quotation->customer->email) ? $quotation->customer->email : ""}}
                        </address>
                    </td>
                    <td style="position: relative; width: 33%">
                        <table class="quotation-details" style="
                            position: relative;
                            width: 200px;
                            font-size: 10px;
                            line-height: 8px;
                            margin-left: auto;
                        ">
                            <tr>
                                <td style="font-weight: bold">Quotation#:</td>
                                <td style="text-align: right">{{$quotation->quotation_id}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Reference Number:</td>
                                <td style="text-align: right">{{$quotation->ref_number}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Quotation Date:</td>
                                <td style="text-align: right">{{date("d-m-Y", strtotime($quotation->due_date))}}</td>
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
                    <th style="text-align: left">Airline</th>
                    <th style="text-align: left">From</th>
                    <th style="text-align: left">To</th>
                    <th style="text-align: left">Departure Time</th>
                    <th style="text-align: left">Arrival Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation_airlines as $airline)
                <tr>
                    <td style="text-align: left">{{$airline->name}}</td>
                    <td style="text-align: left">{{$airline->departure_airport}}</td>
                    <td style="text-align: left">{{$airline->arrival_airport}}</td>
                    <td style="text-align: left">{{date("d-m-Y H:i", strtotime($airline->departure_time))}}</td>
                    <td style="text-align: left">{{date("d-m-Y H:i", strtotime($airline->arrival_time))}}</td>
                </tr>
                @endforeach
            </tbody>
            @if($quotation->airline_notes != null)
            <tfoot>
                <tr>
                    <th style="text-align: left" colspan="5">
                        <b>Description/ Notes:</b>
                    </th>
                </tr>
                <tr>
                    <td style="text-align: left" colspan="5">{{$quotation->airline_notes}}</td>
                </tr>
            </tfoot>
            @endif
        </table>
        <br /><br />
        <table class="table table-striped" style="width: 100%; font-size: 10px; text-align: left">
            <thead>
                <tr>
                    <th style="text-align: left">Hotel</th>
                    <th style="text-align: left">Check-in Time</th>
                    <th style="text-align: left">Check-out Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation_hotels as $hotel)
                <tr>
                    <td style="text-align: left">{{$hotel->name}}</td>
                    <td style="text-align: left">{{date("d-m-Y H:i", strtotime($hotel->checkin_time))}}</td>
                    <td style="text-align: left">{{date("d-m-Y H:i", strtotime($hotel->checkout_time))}}</td>
                </tr>
                @endforeach
            </tbody>
            @if($quotation->hotel_notes != null)
            <tfoot>
                <tr>
                    <th style="text-align: left" colspan="3">
                        <b>Description/ Notes:</b>
                    </th>
                </tr>
                <tr>
                    <td style="text-align: left" colspan="3">{{$quotation->hotel_notes}}</td>
                </tr>
            </tfoot>
            @endif
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
                <th style="text-align: right">£ {{number_format($quotation->price, 2, '.', ',')}}</th>
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
            <p>
                All quotes are subjected to availability and are not guaranteed until the ticket(s) or hotels have been
                issued or confirmed, irrespective of the fact that the full payment has been made as airline fares, seat
                availability & hotel rate changes on an ongoing basis.<br>
                For full terms and conditions please follow the link <a
                    href="http://travelwide.co.uk/terms-and-conditions/"
                    target="_blank">www.globaltravelwide.com/terms-and-conditions</a>
            </p>
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
            @if($quotation->company->id == 1)
            <span>Global Travelwide LTD, Registered in England & Wales number 13124484</span>
            @elseif($quotation->company->id == 2)
            <span>Ontime Hajj & Umrah T/A Global Travelwide LTD, Registered in England
                & Wales number 13124484</span>
            @endif
        </div>
    </div>
</body>

</html>