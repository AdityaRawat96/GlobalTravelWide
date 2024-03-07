    <!--begin:::Tab pane-->
    <div class="tab-pane fade" id="kt_ecommerce_customer_services" role="tabpanel">
        <!--begin::Card-->
        <div class="card pt-4 mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header border-0">
                <!--begin::Card title-->
                <div class="card-title w-100">
                    <h2>Shipping Pricing</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0 pb-5">
                <form class="form" action="{{route('admin.customer.updateDiscount', $data['user']->id)}}"
                    id="kt_ecommerce_shipping_discount_form" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-4 fv-row">
                            <label>Discount (%)</label>
                            <input type="number" name="shipping_discount"
                                class="form-control form-control-lg form-control-solid mt-3 mb-3 mb-lg-0"
                                value="{{$data['user_data']->discount}}">
                        </div>
                    </div>
                    <!--end::Table-->
                    <div class="mt-5 mb-5 d-flex justify-content-end">
                        <!--begin::Button-->
                        <button type="button" id="kt_ecommerce_shipping_discount_submit" class="btn btn-light-primary">
                            <span class="indicator-label">Update Discount</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                </form>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        <!--begin::Card-->
        <div class="card pt-4 mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header border-0">
                <!--begin::Card title-->
                <div class="card-title w-100">
                    <h2>Services Pricing</h2>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0 pb-5">
                <form class="form" action="{{route('admin.customer.updateServices', $data['user']->id)}}"
                    id="kt_ecommerce_customer_services_form" method="POST">
                    @csrf
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed gy-5">
                        <!--begin::Table head-->
                        <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                            <!--begin::Table row-->
                            <tr class="text-start text-muted text-uppercase gs-0">
                                <th>ID</th>
                                <th>Service</th>
                                <th>Price($)</th>
                                <th class="max-w-150px">Custom Price($)</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fs-6 fw-semibold text-gray-600">
                            @foreach($data['services'] as $service)
                            <!--begin::Table row-->
                            <tr>
                                <!--begin::order=-->
                                <td>
                                    <span class="text-gray-600 text-hover-primary mb-1">#{{$service->id}}</span>
                                </td>
                                <!--end::order=-->
                                <td>{{$service->name}}</td>
                                <td>{{$service->price}}</td>
                                <td>
                                    <input type="text" name="service[{{$service->id}}]"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        value="{{$service->custom_price}}">
                                </td>
                            </tr>
                            <!--end::Table row-->
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                    <div class="mt-5 mb-5 d-flex justify-content-end">
                        <!--begin::Button-->
                        <button type="button" id="kt_ecommerce_customer_services_submit" class="btn btn-light-primary">
                            <span class="indicator-label">Update Pricing</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                </form>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end:::Tab pane-->