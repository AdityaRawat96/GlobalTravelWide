<!--begin::Step 1-->
<div class="{{$currentStep == 5 ? 'current' : ''}}" data-kt-stepper-element="content">
    <!--begin::Order details-->
    <div class="card card-flush py-4 w-100">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Shipping details</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <form action="#" id="validate_address_form">
                <div class="d-flex flex-column gap-10">

                    <div class="row mb-5">
                        <div class="col-sm-6">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="add_address_later"
                                    data-gtm-form-interact-field-id="0" wire:model="add_shipping_details_later">
                                <label class="form-check-label" for="add_address_later">
                                    Add shipping details later
                                </label>
                            </div>
                        </div>
                    </div>

                    @if(!$add_shipping_details_later)

                    <div class="row mb-5">
                        <div class="col-sm-6">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="fba_warehouse" checked
                                    data-gtm-form-interact-field-id="0" wire:model="fba_warehouse_select"
                                    wire:click="clearShippingAddress()">
                                <label class="form-check-label" for="fba_warehouse">
                                    Select FBA Amazon warehouses
                                </label>
                            </div>
                        </div>
                    </div>
                    @if($fba_warehouse_select)
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Amazon Fulfillment Centers</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-solid warehouses" data-control="select2"
                            data-hide-search="true" data-placeholder="Select warehouse" name="warehouses"
                            wire:model="shipping_address.warehouse_id" wire:change="setShippingAddress(true)">
                            <option value="" default>Select a warehouse</option>
                            @foreach($warehouses as $warehouse)
                            <option value="{{$warehouse->id}}">{{$warehouse->zip.", ".$warehouse->country}}</option>
                            @endforeach
                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    @else
                    <div class="row">
                        <!--begin::Input group-->
                        <div class="col-sm-12 col-md-4 col-lg-3 mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid shipping_address_name"
                                placeholder="" name="name" wire:model="shipping_address.name" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-sm-12 col-md-4 col-lg-3 mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Company Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="" name="company"
                                wire:model="shipping_address.company" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-sm-12 col-md-4 col-lg-3 mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Phone</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="phone" class="form-control form-control-solid" placeholder="" name="phone"
                                wire:model="shipping_address.phone" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-sm-12 col-md-4 col-lg-3 mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Email</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" class="form-control form-control-solid" placeholder="" name="email"
                                wire:model="shipping_address.email" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-sm-12 col-md-4 col-lg-3 mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Country</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                data-placeholder="Select country" name="country" wire:model="shipping_address.country">
                                <option value="">Select a country</option>
                                @foreach($countries as $country)
                                <option value="{{$country->name}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-sm-12 col-md-4 col-lg-3 mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Zip</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="" name="zip"
                                wire:model="shipping_address.zip" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-sm-12 col-md-4 col-lg-3 mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">City</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="" name="city"
                                wire:model="shipping_address.city" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-sm-12 col-md-4 col-lg-3 mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">State/ Provice</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="" name="state"
                                wire:model="shipping_address.state" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-sm-12 col-md-6 mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Address Line 1</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="" name="address_1"
                                wire:model="shipping_address.address_1" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-sm-12 col-md-6 mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">Address Line 2</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="" name="address_2"
                                wire:model="shipping_address.address_2" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <br>
                    @endif
                    @if($shipping_address)
                    <div class="address-copy-container w-100 d-flex justify-content-end align-items-end">
                        <div class="ship_from_address_tooltip">
                            <button type="button" class="btn btn-info"
                                onclick="tooltipMouseIn('ship_from_address_tooltip_text_2', `{{json_encode($shipping_address)}}`)"
                                onmouseout="tooltipMouseOut('ship_from_address_tooltip_text_2')">
                                <span class="tooltiptext" id="ship_from_address_tooltip_text_2">Copy to
                                    clipboard</span>
                                <i class="fas fa-copy mx-2"></i>
                                Copy address
                            </button>
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1">
                            <!--begin::Content-->
                            <div class="fw-semibold">
                                <div class="fs-6 text-gray-700">
                                    You would need to add shipping details later in order for us to process your order.
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    @endif
                </div>
            </form>
        </div>
        <!--end::Card header-->
    </div>
    <!--end::Order details-->
</div>
<!--end::Step 1-->