<!--begin::Step 2-->
<div class="{{$currentStep == 2 ? 'current' : ''}} flex-column" data-kt-stepper-element="content">
    @if($products_not_packed)
    <!--begin::Not packed Items-->
    <div class="card card-flush py-4 w-100 mb-5">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Items not packed</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">

            <div class="d-flex flex-column gap-10">
                <div>
                    <!--begin::Selected products-->
                    <div class="row row-cols-1 row-cols-xl-2 row-cols-md-1 border border-dashed rounded pt-3 pb-1 px-5 mb-5 mh-300px overflow-scroll" id="kt_ecommerce_edit_order_selected_products">

                        @foreach($products_not_packed as $key=>$product)
                        <div class="col my-2" data-kt-ecommerce-edit-order-filter="product" data-kt-ecommerce-edit-order-id="product_1">

                            <div class="align-items-center border border-dashed rounded p-3 bg-body">
                                <div class="row">
                                    <div class="col-12">
                                        <span class="badge py-3 px-4 fs-7 badge-light-primary">Qty:
                                            {{$product['qty']}}</span>
                                        @if($product['bundle'])
                                        <span class="badge py-3 px-4 fs-7 badge-light-success">Bundle
                                            ({{$product['bundle']}} Units)</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex mt-3">
                                    <!--begin::Thumbnail-->
                                    <a href="#" class="symbol symbol-50px">
                                        <span class="symbol-label border border-dashed border-primary rounded" style="background-image:url({{$product['image']}})"></span>
                                    </a>
                                    <!--end::Thumbnail-->
                                    <div class="ms-5">
                                        <!--begin::Title-->
                                        <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">{{$product['asin']}}</a>
                                        <!--end::Title-->
                                        <!--begin::Price-->
                                        <div class="fw-semibold fs-7">Price: $
                                            <span data-kt-ecommerce-edit-order-filter="price">{{number_format($product['price'], 2)}}</span>
                                        </div>
                                        <!--end::Price-->
                                        <!--begin::SKU-->
                                        <!-- <div class="text-muted fs-7">SKU: {{$product['asin']}}</div> -->
                                        <!--end::SKU-->
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach

                    </div>
                    <!--begin::Selected products-->
                </div>
            </div>
        </div>
        <!--end::Card header-->
    </div>
    <!--end::Not packed Items-->
    @endif

    @if($bins)
    <!--begin::Order details-->
    <div class="card card-flush py-4 w-100">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Summary of {{count($bins)}} boxes
                </h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">

            <div class="d-flex flex-column gap-10">

                <label class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" wire:model="combine_products" wire:change="combineProducts()">
                    <span class="form-check-label fw-semibold text-muted">Pack different ASINs together.</span>
                </label>
                <p>
                    When disabled, the same ASIN items are placed in the same box.
                </p>
                <br>

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
                        <br><br>
                        <div class="fv-row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="bins.{{$key}}.insurance_selected" />
                                <label class="form-check-label">
                                    Package Insurance
                                </label>
                            </div>
                        </div>
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
    <!--end::Order details-->
    @endif
</div>
<!--end::Step 2-->