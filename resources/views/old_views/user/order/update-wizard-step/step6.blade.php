<!--begin::Step 1-->
<div class="{{$currentStep == 6 ? 'current' : ''}} flex-column" data-kt-stepper-element="content">
    <!--begin::Order details-->
    <div class="card card-flush py-4 w-100">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Packing details</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div class="d-flex flex-column gap-10">
                @foreach($bins as $key=>$bin)
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <span class="badge py-3 px-4 fs-7 badge-light-primary">{{$key + 1}}.
                            {{$bin['name']}}</span>
                        <br><br>
                        <img class="img-fluid-svg" src="{{$bin['image']}}">
                        <br><br>
                        <span>Dimensions: {{$bin['w']}} X {{$bin['h']}} X
                            {{$bin['d']}}</span><br>
                        <span>Weight: {{$bin['gross_weight']}} Lbs</span>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <h5>Contents</h5><br>
                        <table class="table table-row-dashed">
                            @foreach($bin['products'] as $index=>$product)
                            <tr>
                                <td class="table-summary-label">{{$index}}</td>
                                <td class="table-summary-data">X {{$product['qty']}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="table-summary-label"><b>Total Products</b></td>
                                <td class="table-summary-data"><b>{{$bin['total_products']}}</b></td>
                            </tr>
                            <tr>
                                <td class="table-summary-label"><b>Total Value</b></td>
                                <td class="table-summary-data"><b>$
                                        {{number_format($bin['total_price'], 2)}}</b></td>
                            </tr>
                        </table>
                    </div>
                    @if($carrier_selected)
                    <div class="col-md-4 col-sm-12">
                        <h5>Cost Breakdown</h5><br>
                        <table class="table table-row-dashed">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td class="table-summary-label">Import Tax:</td>
                                    <td class="table-summary-data">$
                                        {{number_format($bin['import_fee'], 2)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-summary-label">Shipment:</td>
                                    <td class="table-summary-data">$
                                        {{number_format($bin['carriers'][$carrier_selected]['shipping_fee'], 2)}}
                                    </td>
                                </tr>

                                @if($bin['insurance_selected'])
                                <tr>
                                    <td class="table-summary-label">Insurance:</td>
                                    <td class="table-summary-data">$
                                        {{number_format($bin['insurance_price'], 2)}}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="table-summary-label">Total:</td>
                                    <td class="table-summary-data">$
                                        {{$bin['insurance_selected'] ? number_format($bin['insurance_price'] + $bin['carriers'][$carrier_selected]['total_fee'], 2) : number_format($bin['carriers'][$carrier_selected]['total_fee'], 2)}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                <!--begin::Separator-->
                <div class="separator"></div>
                <!--end::Separator-->
                @endforeach
            </div>
        </div>
        <!--end::Card header-->
    </div>
    <div class="card card-flush py-4 w-100 mt-5">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Services</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div class="d-flex flex-column gap-10">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_services_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="max-w-125px">SERVICE NAME</th>
                                <th class="min-w-125px">UNIT PRICE</th>
                                <th class="min-w-125px">QUANTITY</th>
                                <th class="min-w-125px">TOTAL</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            @foreach($services as $sevice_index=>$service)
                            <tr>
                                <td>
                                    <div class="text-gray-800 fw-boldest fs-5">{{$service['name']}}</div>
                                    <div class="text-gray-400 fw-bold d-block">{{$service['description']}}</div>
                                </td>
                                <td>
                                    <div class="text-gray-800 fw-boldest fs-5 UnitPrice">
                                        ${{number_format($service['price'], 2)}}
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control fba-custom-texboxt Quantity" step="1" placeholder="0" value="{{$service['qty']}}" aria-invalid="false" wire:change="serviceUpdate($event.target.value, '{{$service['id']}}')" {{$service['disabled'] ? 'disabled' : ''}}>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-gray-800 fw-boldest fs-5 UnitPrice">
                                        {{$service['id'] == 'DISCOUNT' ? '-' : ''}}${{number_format($service['total'], 2)}}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>

                <div class="flex justify-end mt-2 text-end">
                    <span class="fs-3">
                        Overall Total:
                        <b class="generalTotal">${{number_format($order_total, 2)}}</b>
                    </span>
                    <br /><br />
                    <small class="fs-6">
                        Cost per product:
                        <b class="cost_per_product">${{$product_count ? number_format($order_total / $product_count, 2) : 0}}</b>
                    </small>
                </div>
            </div>
        </div>
        <!--end::Card header-->
    </div>
    <!--end::Order details-->
</div>
<!--end::Step 1-->