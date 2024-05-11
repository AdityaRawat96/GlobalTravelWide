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

    .refund-details {
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
                    <img src="{{ Storage::drive('public')->url($refund->company->logo) }}" alt="Refund logo"
                        style="height: 50px; margin: 10px" />
                    @else
                    <img src="{{ storage_path('app/public/' . $refund->company->logo) }}" alt="Refund logo"
                        style="height: 50px; margin: 10px" />
                    @endif
                </td>
                <td style="position: relative; width: 50%; text-align: right">
                    <h3>REFUND RECEIPT</h3>
                </td>
            </tr>
        </table>
        <div class="seperator" style="position: relative; width: 100%; border-bottom: 1px solid #000; margin: 10px 0">
        </div>
        <div class="refund-info">
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
                        REFUND TO
                        <address>
                            <strong>{{$refund->customer->name}}</strong><br />
                            Phone: {{$refund->customer->phone}}<br />
                            Email: {{$refund->customer->email}}
                        </address>
                    </td>
                    <td style="position: relative; width: 33%">
                        <table class="refund-details" style="
                            position: relative;
                            width: 200px;
                            font-size: 10px;
                            line-height: 8px;
                            margin-left: auto;
                        ">
                            <tr>
                                <td style="font-weight: bold">Refund#:</td>
                                <td style="text-align: right">{{$refund->refund_id}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Reference Number:</td>
                                <td style="text-align: right">{{$refund->ref_number}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Applied Date:</td>
                                <td style="text-align: right">{{date("d-m-Y", strtotime($refund->refund_date))}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Refund Date:</td>
                                <td style="text-align: right">{{date("d-m-Y", strtotime($refund->due_date))}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Payment Status:</td>
                                <td style="text-align: right">
                                    @if($refund->due_date < now() && $refund->status == 'pending')
                                        <span style="color: red">Overdue</span>
                                        @else
                                        {{ucfirst($refund->status)}}
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
                @foreach($refund_products as $product)
                <tr>
                    <td>{{$product->quantity}}</td>
                    <td>{{$product->catalogue->name}}</td>
                    <td>{{$product->catalogue->description}}</td>
                    <td style="text-align: right">£ {{ number_format($product->price, 2, '.', ',') }}</td>
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
                <th style="text-align: right">£ {{number_format($refund->total, 2, '.', ',')}}</th>
            </tr>
            <?php $amount_paid = 0; ?>
            @foreach($refund_payments as $payment)
            <tr>
                <td style="text-align: left">{{ucfirst($payment->mode)}} Payment on
                    {{date("d-m-Y", strtotime($payment->date))}}
                </td>
                <td style="text-align: right">£ {{ number_format($payment->amount, 2, '.', ',') }}</td>
            </tr>
            <?php $amount_paid += $payment->amount; ?>
            @endforeach
            <tr>
                <th style="text-align: left">Refund Due:</th>
                <th style="text-align: right">£ {{number_format(($refund->total - $amount_paid), 2, '.', ',')}}</th>
            </tr>
        </table>
        <br />
        <div class="seperator" style="position: relative; width: 100%; border-bottom: 1px solid #000; margin: 10px 0">
        </div>
        <div class="footer" style="
          position: relative;
          width: 100%;
          text-align: center;
          font-size: 8px;
        ">
            @if($refund->company->id == 1)
            <span>Global Travelwide LTD, Registered in England & Wales number 13124484</span>
            @elseif($quotation->company->id == 2)
            <span>Ontime Hajj & Umrah T/A Global Travelwide LTD, Registered in England
                & Wales number 13124484</span>
            @endif
        </div>
    </div>
</body>

</html>