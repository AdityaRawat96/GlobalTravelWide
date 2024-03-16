<!--begin::Step 7-->
<div class="{{$currentStep == 7 ? 'current' : ''}}" data-kt-stepper-element="content">
    <!--begin::Main column-->
    <!--begin::Order details-->
    <div class="card py-4" style="position: relative; width: 100%;">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Order Updated Successfully!</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div class="w-100">
                <!--begin::Subheading-->
                <div class="text-muted fw-semibold fs-3 mt-8">Your Order ID is -
                    <b>{{$order->is_express ? "E" : "I"}}FBA{{ str_pad($order->id, 5, "0", STR_PAD_LEFT) }}</b>
                </div>
                <!--end::Subheading-->
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <span class="text-muted fw-semibold fs-3">Amount:
                            <b>$ {{number_format($order_total, 2, '.', '')}}</b></span>
                        <br><br><br>
                        @if($order->is_express)
                        <h3>Tracking Details:</h3>
                        <br>

                        @if($show_tracking_form)
                        <form class="form" id="tracking_info_form">
                            <!-- begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Input-->
                                <label class="required mb-3" for="tracking_carrier">Carrier</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Select carrier" name="tracking_carrier"
                                    wire:model="tracking_info.carrier_id" id="tracking_carrier">
                                    <option value="">Select a carrier</option>
                                    @foreach($shippings as $carrier_id=>$carrier)
                                    <option value="{{$carrier_id}}">{{$carrier['name']}}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!-- end::Input group-->
                            <!-- begin::Input group-->
                            <div class="fv-row mt-5">
                                <!--begin::Input-->
                                <label class="required mb-3" for="tracking_id">Tracking ID</label>
                                <input type="text" class="form-control form-control-solid" placeholder=""
                                    name="tracking_id" wire:model="tracking_info.tracking_id"
                                    style="text-transform:uppercase" />
                                <!--end::Input-->
                            </div>
                            <!-- end::Input group-->
                            <div class="d-flex flex-rows justify-content-end mt-5">
                                <button class="btn btn-danger mx-1" type="button"
                                    wire:click="toggleTrackingForm(false)">
                                    Cancel
                                </button>
                                <button type="button" id="set_tracking_submit" class="btn btn-success mx-1"
                                    onclick="setTrackingInfo()">
                                    <span class="indicator-label">Update</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>
                        @else
                        @if($is_tracking_set)
                        <div class="tracking_details d-flex flex-rows">
                            <table class="table flex-1">
                                <tr>
                                    <td>Carrier:</td>
                                    <td>{{$tracking_info['carrier_name']}}</td>
                                </tr>
                                <tr>
                                    <td>Tracking ID:</td>
                                    <td>{{$tracking_info['tracking_id']}}</td>
                                </tr>
                            </table>
                            <button class="btn btn-primary p-2 h-50" wire:click="toggleTrackingForm(true)">
                                <i class="fas fa-pencil"></i>
                            </button>
                        </div>
                        @else
                        <button class="btn btn-success" type="button" wire:click="toggleTrackingForm(true)">
                            <i class="fas fa-plus mx-3"></i>Add Tracking details
                        </button>
                        @endif
                        @endif

                        <br><br><br>
                        <h3>Shipping Details:</h3>
                        <br>
                        <div class="text-muted fw-semibold fs-5">Please ship your products to below address:</div>
                        <div class="d-flex flex-row">
                            <p class="mt-3 fs-5 flex-1">
                                <span>{{$warehouse_address['name']. " #SL" . str_pad($user->id, 5, "0", STR_PAD_LEFT)}}</span><br>
                                <span>{{ $warehouse_address['street'] }}</span><br>
                                <span>#{{$order->is_express ? "E" : "I"}}FBA{{ str_pad($order->id, 5, "0", STR_PAD_LEFT) }}</span><br>
                                <span>{{ $warehouse_address['city'] }}</span><br>
                                <span>{{ $warehouse_address['state'] }} {{ $warehouse_address['zip'] }}</span>
                            </p>
                            <div class="address-copy-container">
                                <div class="ship_from_address_tooltip">
                                    <button type="button" class="btn btn-primary"
                                        onclick="tooltipMouseIn('ship_from_address_tooltip_text_3')"
                                        onmouseout="tooltipMouseOut('ship_from_address_tooltip_text_3')">
                                        <span class="tooltiptext" id="ship_from_address_tooltip_text_3">Copy to
                                            clipboard</span>
                                        <i class="fas fa-copy mx-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        @endif
                        <a href="{{route('admin.order.view', $order_id)}}">
                            <button type="button" class="btn btn-primary px-8">View Order</button>
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!--begin::Illustration-->
                        <div class="text-center px-4 py-15">
                            <img src="{{asset('media/illustrations/jolly/Working with papers.svg')}}" alt=""
                                class="mw-100 mh-300px" />
                        </div>
                        <!--end::Illustration-->
                    </div>
                </div>
            </div>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Order details-->
    <!--end::Main column-->
</div>
<!--end::Step 7-->