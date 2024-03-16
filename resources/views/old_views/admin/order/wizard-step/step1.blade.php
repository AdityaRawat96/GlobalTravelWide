<!--begin::Step 1-->
<div class="{{$currentStep == 1 ? 'current' : ''}}" data-kt-stepper-element="content">

    <!--begin::Order details-->
    <div class="card card-flush py-4 w-100">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Select Products</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">

            <div class="d-flex flex-column gap-10">
                <!--begin::Input group-->
                <div>
                    <!--begin::Label-->
                    <label class="form-label">Add products to this order</label>
                    <!--end::Label-->
                    <!--begin::Selected products-->
                    <div class="row row-cols-1 row-cols-xl-2 row-cols-md-1 border border-dashed rounded pt-3 pb-1 px-5 mb-5 mh-300px overflow-scroll"
                        id="kt_ecommerce_edit_order_selected_products">
                        @if(!$products)
                        <!--begin::Empty message-->
                        <span class="w-100 text-muted">Select one or more products from the details menu after searching
                            by ASIN below.</span>
                        <!--end::Empty message-->
                        @endif

                        @foreach($products as $key=>$product)
                        <div class="col my-2 shipping-product">
                            <div class="align-items-center border border-dashed rounded p-3 bg-body">
                                <div class="d-flex">
                                    <div style="flex:1"></div>
                                    <a data-kt-box-table-filter="delete_row"
                                        class="mx-2 btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                        wire:click="editProduct({{$key}})">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Design/Edit.svg-->
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path
                                                        d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                                        fill="currentColor" fill-rule="nonzero"
                                                        transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                                    <rect fill="currentColor" opacity="0.3" x="5" y="20" width="15"
                                                        height="2" rx="1" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <a data-kt-box-table-filter="delete_row"
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                        onclick="deleteProduct({{$key}})">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                    fill="currentColor"></path>
                                                <path opacity="0.5"
                                                    d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                    fill="currentColor"></path>
                                                <path opacity="0.5"
                                                    d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                </div>

                                <div class="d-flex mt-3">
                                    <!--begin::Thumbnail-->
                                    <a href="#" class="symbol symbol-50px">
                                        <span class="symbol-label rounded"
                                            style="background-image:url({{$product['image']}})"></span>
                                    </a>
                                    <!--end::Thumbnail-->
                                    <div class="ms-5">
                                        <!--begin::Title-->
                                        <a href="#"
                                            class="text-gray-800 text-hover-primary fs-5 fw-bold">{{$product['asin']}}</a>
                                        <!--end::Title-->
                                        <!--begin::Price-->
                                        <div class="fw-semibold fs-7">Price: $
                                            <span
                                                data-kt-ecommerce-edit-order-filter="price">{{number_format($product['price'], 2)}}</span>
                                        </div>
                                        <!--end::Price-->
                                        <!--begin::SKU-->
                                        <div class="badge-container">
                                            <span class="badge py-3 px-4 fs-7 badge-light-primary">Qty:
                                                {{$product['qty']}}</span>
                                            @if(isset($product['bundle']) && $product['bundle'] != "none")
                                            <span class="badge py-3 px-4 fs-7 badge-light-success">
                                                {{ucfirst($product['bundle'])}}
                                            </span>
                                            @endif
                                        </div>
                                        <!--end::SKU-->
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach

                    </div>
                    <!--begin::Selected products-->
                    <div class="row mt-5 mb-5">
                        <div class="col-md-4 col-sm-12 mt-3">
                            <!--begin::Total price-->
                            <div class="fs-5">Total Cost: $
                                <span class="fw-bold"
                                    id="kt_ecommerce_edit_order_total_price">{{number_format($totalPrice, 2)}}</span>
                            </div>
                            <!--end::Total price-->
                        </div>
                        <div class="col-md-4 col-sm-12 mt-3">
                            <!--begin::Total weight-->
                            <div class="fs-5">Total Weight:
                                <span class="fw-bold" id="kt_ecommerce_edit_order_total_weight">{{$totalWeight}}</span>
                            </div>
                            <!--end::Total weight-->
                        </div>
                        <div class="col-md-4 col-sm-12 mt-3">
                            <!--begin::Total deci weight-->
                            <div class="fs-5">Total Deci:
                                <span class="fw-bold" id="kt_ecommerce_edit_order_total_deci">{{$totalDeci}}</span>
                            </div>
                            <!--end::Total deci weight-->
                        </div>
                    </div>

                </div>
                <!--end::Input group-->
                <!--begin::Separator-->
                <div class="separator"></div>
                <!--end::Separator-->
                <!--begin::Form-->

                <form class="form" action="{{route('user.order.searchASIN')}}" id="search_product_form" method="POST">
                    @csrf
                    <div class="row mt-5">
                        <div class="col-md-4 col-sm-12 mb-5">
                            <!-- begin::Input group-->
                            <div class="fv-row form-group">
                                <!--begin::Search products-->
                                <input type="text" class="form-control form-control-solid" id="product-asin"
                                    placeholder="Product ASIN" maxlength="10" name="product-asin"
                                    wire:model="current_product.asin"
                                    {{isset($current_product['isValid']) && $current_product['isValid'] ? "disabled" : ""}} />
                                @if(isset($current_product['isValid']) && !$current_product['isValid'] &&
                                strlen($current_product['asin']) == 10)
                                <span class="text-danger">Product not found</span>
                                @endif
                                <!--end::Search products-->
                            </div>
                            <!-- end::Input group-->
                        </div>
                        @if((!isset($current_product['bundle'])) || (isset($current_product['bundle']) &&
                        $current_product['bundle'] == "none"))
                        <div class="col-md-4 col-sm-12 mb-5">
                            <!-- begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid" placeholder="Quantity"
                                    name="product-qty" wire:model="current_product.qty" />
                                <!--end::Input-->
                            </div>
                            <!-- end::Input group-->
                        </div>
                        @endif
                        <div class="col-md-4 col-sm-12 mb-5">
                            <!-- begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Input-->
                                <select name="product-bundle" id="product-bundle" placeholder="Bundling"
                                    class="form-control form-control-solid" wire:model="current_product.bundle"
                                    wire:change="resetBundling">
                                    <option value="none" default selected>No Bundle</option>
                                    <option value="bundle">Bundle</option>
                                    <option value="debundle">De-Bundle</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!-- end::Input group-->
                        </div>
                    </div>

                    @if(isset($current_product['bundle']) && $current_product['bundle'] != "none")

                    <div class="row mt-8">
                        <h3 class="mb-8">Incoming</h3>
                        <div class="col-md-4 col-sm-12">
                            <!-- begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Input-->
                                <label class="required mb-3" for="incoming_packages">Packages sending to
                                    warehouse</label>
                                <input type="number" class="form-control form-control-solid" placeholder=""
                                    name="incoming_packages" wire:model="current_product.qty"
                                    wire:keyup="calulateIncomingTotal()" />
                                <!--end::Input-->
                            </div>
                            <!-- end::Input group-->
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label class="required mb-3" for="incoming-packages">Do packages contain multiple
                                items?</label>
                            <div class="row row-cols-1 row-cols-md-2 g-5">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Option-->
                                    <input type="radio" class="btn-check" name="package_multiple_items"
                                        id="kt_radio_buttons_2_option_1"
                                        {{isset($current_product['units']) && $current_product['units'] > 1 ? "checked" : ""}}>
                                    <label onclick="$('#incoming_units_container').removeClass('d-none')"
                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary p-3 d-flex justify-content-center align-items-center h-60"
                                        for="kt_radio_buttons_2_option_1">
                                        <span class="d-block fw-semibold text-start">
                                            <span class="text-dark fw-bold d-block fs-4">Yes</span>
                                        </span>
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Option-->
                                    <input type="radio" class="btn-check" name="package_multiple_items"
                                        id="kt_radio_buttons_2_option_2"
                                        {{isset($current_product['units']) && $current_product['units'] <= 1 ? "checked" : ""}}>
                                    <label onclick="$('#incoming_units_container').addClass('d-none')"
                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary p-3 d-flex justify-content-center align-items-center h-60"
                                        for="kt_radio_buttons_2_option_2">
                                        <span class="d-block fw-semibold text-start">
                                            <span class="text-dark fw-bold d-block fs-4">No</span>
                                        </span>
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="{{isset($current_product['units']) && $current_product['units'] <= 1 ? 'd-none' : ''}}"
                                id="incoming_units_container">
                                <!-- begin::Input group-->
                                <div class="fv-row">
                                    <!--begin::Input-->
                                    <label class="required mb-3" for="incoming_package_items">Items in each
                                        package</label>
                                    <input type="number" class="form-control form-control-solid" placeholder=""
                                        name="incoming_package_items" wire:model="current_product.units"
                                        wire:keyup="calulateIncomingTotal()" />
                                    <!--end::Input-->
                                </div>
                                <!-- end::Input group-->
                            </div>
                        </div>
                    </div>

                    <div class="row mt-8">
                        <h3 class="mb-8">Outgoing</h3>
                        <div class="col-md-4 col-sm-12">
                            <!-- begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Input-->
                                <label class="required mb-3" for="outgoing_package_items">Outgoing Product ASIN</label>
                                <input type="text" class="form-control form-control-solid" id="outgoing-product-asin"
                                    placeholder="Product ASIN" maxlength="10" name="outgoing-product-asin"
                                    wire:model="outgoing_product.asin"
                                    {{isset($outgoing_product['isValid']) && $outgoing_product['isValid'] ? "disabled" : ""}} />
                                @if(isset($outgoing_product['isValid']) && !$outgoing_product['isValid'] &&
                                strlen($outgoing_product['asin']) == 10)
                                <span class="text-danger">Product not found</span>
                                @endif
                            </div>
                            <!-- end::Input group-->

                        </div>
                        <div class="col-md-4 col-sm-12">
                            <!-- begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Input-->
                                <label class="required mb-3" for="outgoing_package_items">Items to put in bundle
                                    package</label>
                                <input type="number" class="form-control form-control-solid" placeholder=""
                                    name="outgoing_package_items" wire:model="outgoing_product.units"
                                    wire:keyup="calulateIncomingTotal()" />
                                <!--end::Input-->
                            </div>
                            <!-- end::Input group-->

                        </div>
                    </div>

                    <div class="row mt-8 mb-5">
                        <h3 class="mb-8">Summary</h3>
                        <div class="col-md-8 col-sm-12">
                            <table>
                                <tr>
                                    <td>
                                        <b>
                                            <span class="w-100">Incoming:</span>
                                        </b>
                                    </td>
                                    <td class="px-5 py-2">
                                        <span class="w-100">{{$incoming_total_items ? $incoming_total_items : 0}}
                                            Items in
                                            {{isset($current_product['qty']) ? $current_product['qty'] : 0}}
                                            Packages</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>
                                            <span class=" w-100">Outgoing:</span>
                                        </b>
                                    </td>
                                    <td class="px-5 py-2">
                                        <span
                                            class="w-100">{{isset($outgoing_product['units']) ? $outgoing_product['units'] : 0}}
                                            count in
                                            {{isset($outgoing_product['qty']) ? $outgoing_product['qty'] : 0}}
                                            Packages</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>
                                            <span class="w-100">Items Left:</span>
                                        </b>
                                    </td>
                                    <td class="px-5 py-2">
                                        <span class="w-100">
                                            {{(isset($outgoing_product['qty']) && $incoming_total_items && $outgoing_product['qty'] && $outgoing_product['units']) ? $incoming_total_items % ($outgoing_product['qty'] *  $outgoing_product['units']): 0}}
                                            Items</span>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>

                    @endif

                    <div class="row mt-5">
                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <div class="form-group mt-5">
                                <label for="order_notes">Notes for this product:</label>
                                <textarea class="form-control form-control-solid mt-3" name="order_notes"
                                    id="order_notes" rows="4" wire:model="current_product.notes"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-8">
                        <div class="col-md-8 col-sm-12">
                            <button class="btn btn-primary form-control" type="button" onclick="addProduct()">Add
                                Product</button>
                        </div>
                    </div>
                </form>

                <!--begin::Separator-->
                <div class="separator"></div>
                <!--end::Separator-->

                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <div
                            class="row border border-dashed border-gray-300 rounded px-3 py-3 mb-6 mt-6 bg-light-primary">
                            <div class="col-md-8 col-sm-12">
                                <span><b>SHIP FROM ADDRESS:</b></span>
                                <br>
                                <p>
                                    <span>{{$warehouse_address['name']. " #SL" . str_pad($user->id, 5, "0", STR_PAD_LEFT)}}</span><br>
                                    <span>{{ $warehouse_address['street'] }}</span><br>
                                    <span>{{ $warehouse_address['city'] }}</span><br>
                                    <span>{{ $warehouse_address['state'] }} {{ $warehouse_address['zip'] }}</span>
                                </p>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="address-copy-container">
                                    <div class="ship_from_address_tooltip">
                                        <button type="button" class="btn btn-primary"
                                            onclick="tooltipMouseIn('ship_from_address_tooltip_text_1')"
                                            onmouseout="tooltipMouseOut('ship_from_address_tooltip_text_1')">
                                            <span class="tooltiptext" id="ship_from_address_tooltip_text_1">Copy to
                                                clipboard</span>
                                            <i class="fas fa-copy mx-2"></i>
                                            Copy address
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        <!--end::Card header-->
    </div>
    <!--end::Order details-->

</div>
<!--end::Step 1-->