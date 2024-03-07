<!--begin::Step 3-->
<div class="{{$currentStep == 3 ? 'current' : ''}}" data-kt-stepper-element="content">
    <!--begin::Order details-->
    <div class="card card-flush py-4 w-100">
        @if(isset($services) && count($services))
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Additional Services</h2>
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
                                        <input type="number" class="form-control fba-custom-texboxt Quantity" step="1"
                                            placeholder="0" value="{{$service['qty']}}" aria-invalid="false"
                                            wire:change="serviceUpdate($event.target.value, '{{$service['id']}}')"
                                            {{$service['disabled'] ? 'disabled' : ''}}>
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
                        <b class="cost_per_product">${{number_format($order_total / $product_count, 2)}}</b>
                    </small>
                </div>

            </div>
        </div>
        <!--end::Card header-->
        @endif
    </div>
    <!--end::Order details-->
</div>
<!--end::Step 3-->