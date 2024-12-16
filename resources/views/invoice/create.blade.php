@extends('layouts.master')

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{isset($invoice) ? "Update" : "Create" }} Invoice
                </h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Invoices</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            @if(isset($invoice))
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Secondary button-->
                <a href="{{'/' . Auth::user()->role . '/invoice/' . $invoice->id}}"
                    class="btn btn-sm fw-bold btn-danger" id="delete-invoice">Delete</a>
                <!--end::Secondary button-->
            </div>
            <!--end::Actions-->
            @endif
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xxl-row">
                <!--begin::Content-->
                <div class="flex-xxl-row-fluid mb-10 mb-xxl-0 me-xxl-7 me-xxxl-10">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body p-12">
                            <!--begin::Form-->
                            <form class="form"
                                action="{{isset($invoice) ? route(Auth::user()->role . '.invoice.update', $invoice->id) : route(Auth::user()->role . '.invoice.store')}}"
                                id="kt_create_form" method="{{isset($invoice) ? 'PUT' : 'POST'}}"
                                enctype="multipart/form-data">
                                @csrf
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-start flex-xxl-row">
                                    <!--begin::Input group-->
                                    <div class="fv-row fw-row me-4 order-2">
                                        <div class="d-flex align-items-center flex-equal " data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" title="Specify invoice date">
                                            <!--begin::Date-->
                                            <div class="fs-6 fw-bold text-gray-700 text-nowrap required">Date:</div>
                                            <!--end::Date-->
                                            <!--begin::Input-->
                                            <div class="position-relative d-flex align-items-center w-150px">
                                                <!--begin::Datepicker-->
                                                <input class="form-control form-control-transparent fw-bold pe-5"
                                                    placeholder="Select date" name="invoice_date"
                                                    value="{{isset($invoice) ? (new DateTime($invoice->invoice_date))->format('d-M-Y') : date('d-M-Y')}}" />
                                                <!--end::Datepicker-->
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-2 position-absolute ms-4 end-0">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div
                                        class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                        <span class="fs-4 fw-bold text-gray-800">Invoice #</span>
                                        <input type="text" name="invoice_id" id="invoice_id"
                                            class="form-control form-control-flush fw-bold text-muted fs-3 w-150px"
                                            value="{{isset($invoice) ? $invoice->invoice_id : time() }}" disabled />
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row order-3 fw-row">
                                        <div class="d-flex align-items-center justify-content-end flex-equal"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                            title="Specify invoice due date">
                                            <!--begin::Date-->
                                            <div class="fs-6 fw-bold text-gray-700 text-nowrap required">Due Date:</div>
                                            <!--end::Date-->
                                            <!--begin::Input-->
                                            <div class="position-relative d-flex align-items-center w-150px">
                                                <!--begin::Datepicker-->
                                                <input class="form-control form-control-transparent fw-bold pe-5"
                                                    placeholder="Select date" name="due_date"
                                                    value="{{isset($invoice) ? (new DateTime($invoice->due_date))->format('d-M-Y') : null}}" />
                                                <!--end::Datepicker-->
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-2 position-absolute end-0 ms-4">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Top-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-10"></div>
                                <!--end::Separator-->
                                <!--begin::Wrapper-->
                                <div class="mb-0">
                                    <!--begin::Row-->
                                    <div class="row gx-10 mb-5">
                                        <!--begin::Col-->
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Reference
                                                number</label>
                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <input name="ref_number" type="text"
                                                    class="form-control form-control-solid"
                                                    placeholder="Enter a reference number"
                                                    value="{{isset($invoice) ? $invoice->ref_number : null}}" />
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <!--end::Input group-->
                                            <label
                                                class="form-label fs-6 fw-bold text-gray-700 mb-3 required">Company</label>
                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <select name="company_id"
                                                    class="form-select form-select-lg form-select-solid"
                                                    data-control="select2" data-placeholder="Select a company">
                                                    @foreach($companies as $company)
                                                    <option value="{{$company->id}}"
                                                        {{isset($invoice) && $invoice->company_id == $company->id ? "selected"  : ""}}>
                                                        {{$company->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <!--end::Input group-->
                                            <label class="form-label fs-6 fw-bold text-gray-700 mb-3 required">Departure
                                                date</label>
                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <input class="form-control form-control-solid" placeholder="Select date"
                                                    name="departure_date"
                                                    value="{{isset($invoice) ? (new DateTime($invoice->departure_date))->format('d-M-Y') : null}}" />
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <!--end::Input group-->
                                            <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Affiliate</label>
                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <select id="affiliate" name="affiliate_id"
                                                    class="form-select form-select-lg form-select-solid"
                                                    data-control="select2" data-placeholder="Select a affiliate"
                                                    data-allow-clear="true">
                                                    <option value="">Select a affiliate</option>
                                                    @foreach($affiliates as $affiliate)
                                                    <option value="{{$affiliate->id}}"
                                                        {{isset($invoice) && isset($invoice->affiliate) && $invoice->affiliate->id == $affiliate->id ? "selected"  : ""}}>
                                                        {{"C" . str_pad($affiliate->id, 5, '0', STR_PAD_LEFT) . " - " . $affiliate->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <!--end::Input group-->
                                            <div id="commission_field"
                                                class="{{isset($invoice) && $invoice->commission ? '' : 'd-none'}}">
                                                <label
                                                    class="form-label fs-6 fw-bold text-gray-700 mb-3 required">Commission(£)</label>
                                                <!--begin::Input group-->
                                                <div class="mb-5 fv-row">
                                                    <input id="commission" name="commission" type="text"
                                                        class="form-control form-control-solid"
                                                        placeholder="Enter affiliate commission"
                                                        value="{{isset($invoice) ? $invoice->commission : '0.00'}}" />
                                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-bold text-gray-700 mb-3 required">Default
                                                currency</label>
                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <select id="currency" name="currency"
                                                    class="form-select form-select-lg form-select-solid"
                                                    data-control="select2" data-placeholder="Select a currency">
                                                    <option value="gbp"
                                                        {{isset($invoice) && $invoice->currency == 'gbp' ? "selected"  : ""}}>
                                                        Great British Pound (£)</option>
                                                    <option value="pkr"
                                                        {{isset($invoice) && $invoice->currency == 'pkr' ? "selected"  : ""}}>
                                                        Pakistani Rupee (₨)</option>
                                                </select>
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <!--end::Input group-->
                                            <label
                                                class="form-label fs-6 fw-bold text-gray-700 mb-3 {{isset($invoice) ? '' : 'required'}}">Carrier</label>
                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <select id="carrier" name="carrier_id"
                                                    class="form-select form-select-lg form-select-solid"
                                                    data-control="select2" data-placeholder="Select a carrier">
                                                    <option value="">Select a carrier</option>
                                                    @foreach($carriers as $carrier)
                                                    <option value="{{$carrier->id}}"
                                                        {{isset($invoice) && isset($invoice->carrier) && $invoice->carrier->id == $carrier->id ? "selected"  : ""}}>
                                                        {{"C" . str_pad($carrier->id, 5, '0', STR_PAD_LEFT) . " - " . $carrier->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <!--end::Input group-->
                                            <label
                                                class="form-label fs-6 fw-bold text-gray-700 mb-3 required">Customer</label>
                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <select id="customer" name="customer_id"
                                                    class="form-select form-select-lg form-select-solid"
                                                    data-control="select2" data-placeholder="Select a customer">
                                                    <option value="">Select a customer</option>
                                                    @foreach($customers as $customer)
                                                    <option value="{{$customer->id}}"
                                                        {{isset($invoice) && isset($invoice->customer) && $invoice->customer->id == $customer->id ? "selected"  : ""}}>
                                                        {{"C" . str_pad($customer->id, 5, '0', STR_PAD_LEFT) . " - " . $customer->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <!--end::Input group-->
                                            <div class="customer_details {{isset($invoice) ? '' : 'd-none'}}">
                                                <!--begin::Input group-->
                                                <div class="mb-5">
                                                    <input id="customer_email" type="text"
                                                        class="form-control form-control-solid"
                                                        value="{{isset($invoice->customer) ? $invoice->customer->email : null}}"
                                                        placeholder="Customer Email" disabled />
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-5">
                                                    <input id="customer_phone" type="text"
                                                        class="form-control form-control-solid"
                                                        value="{{isset($invoice->customer) ? $invoice->customer->phone : null}}"
                                                        placeholder="Customer Phone" disabled />
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed my-10"></div>
                                    <!--end::Separator-->
                                    <h4 class="mt-8 mb-3">Products</h4>
                                    <!--begin::Table Items-->
                                    <div class="table-responsive mb-10">
                                        <!--begin::Table-->
                                        <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items"
                                            id="product_table">
                                            <!--begin::Table head-->
                                            <thead>
                                                <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                                    <th class="min-w-200px w-375px required">Item</th>
                                                    <th class="min-w-100px w-100px required">QTY</th>
                                                    <th class="min-w-100px w-200px required">Cost</th>
                                                    <th class="min-w-100px w-200px required">Price</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody>
                                                @if(isset($invoice))
                                                @foreach($invoice_products as $index => $invoice_product)
                                                <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                                    <td class="pe-7">
                                                        <!--begin::Input group-->
                                                        <div class="mb-5 fv-row">
                                                            <select name="product[{{ $index  }}]"
                                                                class="form-select form-select-lg form-select-solid product_select"
                                                                data-control="select2"
                                                                data-placeholder="Select a product">
                                                                <option value="">Select a product</option>
                                                                @foreach($products as $product)
                                                                <option value="{{$product->id}}"
                                                                    {{$product->id == $invoice_product->catalogue_id ? 'selected' : ''}}>
                                                                    {{str_pad($product->id, 5, '0', STR_PAD_LEFT) . " - " . $product->name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                        <!--end::Input group-->
                                                        <input type="text"
                                                            class="form-control form-control-solid product_description"
                                                            placeholder="Description"
                                                            value="{{$invoice_product->catalogue->description}}" />
                                                    </td>
                                                    <td class="ps-0">
                                                        <div class="mb-5 fv-row">
                                                            <input class="form-control form-control-solid" type="number"
                                                                min="1" name="quantity[{{ $index  }}]" placeholder="1"
                                                                value="{{$invoice_product->quantity}}"
                                                                data-kt-element="quantity" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-solid mb-5 fv-row">
                                                            <span class="input-group-text elements_alt">£</span>
                                                            <input type="text"
                                                                class="form-control form-control-solid text-end"
                                                                name="cost[{{ $index  }}]" placeholder="0.00"
                                                                value="{{$invoice_product->cost}}"
                                                                data-kt-element="cost" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="input-group input-group-solid mb-5 fv-row elements_alt">
                                                            <span class="input-group-text elements_alt">₨</span>
                                                            <input type="text" class="form-control text-end"
                                                                name="cost_alt[{{ $index  }}]]" placeholder="0.00"
                                                                value="{{isset($invoice_product->cost_alt) ? $invoice_product->cost_alt : '0.00'}}"
                                                                data-kt-element="cost_alt" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-solid mb-5 fv-row">
                                                            <span class="input-group-text elements_alt">£</span>
                                                            <input type="text"
                                                                class="form-control form-control-solid text-end"
                                                                name="price[{{ $index  }}]" placeholder="0.00"
                                                                value="{{$invoice_product->price}}"
                                                                data-kt-element="price" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="input-group input-group-solid mb-5 fv-row elements_alt">
                                                            <span class="input-group-text elements_alt">₨</span>
                                                            <input type="text" class="form-control text-end"
                                                                name="price_alt[{{ $index  }}]]" placeholder="0.00"
                                                                value="{{isset($invoice_product->price_alt) ? $invoice_product->price_alt : '0.00'}}"
                                                                data-kt-element="price_alt" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="pt-5 text-end">
                                                        <button type="button"
                                                            class="btn btn-icon btn-active-color-primary"
                                                            data-kt-element="remove-item">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                        fill="currentColor" />
                                                                    <path opacity="0.5"
                                                                        d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                        fill="currentColor" />
                                                                    <path opacity="0.5"
                                                                        d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                        fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                                    <td class="pe-7">
                                                        <!--begin::Input group-->
                                                        <div class="mb-5 fv-row">
                                                            <select name="product[]"
                                                                class="form-select form-select-lg form-select-solid product_select"
                                                                data-control="select2"
                                                                data-placeholder="Select a product">
                                                                <option value="">Select a product</option>
                                                                @foreach($products as $product)
                                                                <option value="{{$product->id}}">
                                                                    {{str_pad($product->id, 5, '0', STR_PAD_LEFT) . " - " . $product->name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                        <!--end::Input group-->
                                                        <input type="text"
                                                            class="form-control form-control-solid product_description"
                                                            placeholder="Description" />
                                                    </td>
                                                    <td class="ps-0">
                                                        <div class="mb-5 fv-row">
                                                            <input class="form-control form-control-solid" type="number"
                                                                min="1" name="quantity[]" placeholder="1" value="1"
                                                                data-kt-element="quantity" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-solid mb-5 fv-row">
                                                            <span class="input-group-text elements_alt">£</span>
                                                            <input type="text"
                                                                class="form-control form-control-solid text-end"
                                                                name="cost[]" placeholder="0.00" value="0.00"
                                                                data-kt-element="cost" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="input-group input-group-solid mb-5 fv-row elements_alt">
                                                            <span class="input-group-text elements_alt">₨</span>
                                                            <input type="text" class="form-control text-end"
                                                                name="cost_alt[]" placeholder="0.00" value="0.00"
                                                                data-kt-element="cost_alt" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-solid mb-5 fv-row">
                                                            <span class="input-group-text elements_alt">£</span>
                                                            <input type="text"
                                                                class="form-control form-control-solid text-end"
                                                                name="price[]" placeholder="0.00" value="0.00"
                                                                data-kt-element="price" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="input-group input-group-solid mb-5 fv-row elements_alt">
                                                            <span class="input-group-text elements_alt">₨</span>
                                                            <input type="text" class="form-control text-end"
                                                                name="price_alt[]" placeholder="0.00" value="0.00"
                                                                data-kt-element="price_alt" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="pt-5 text-end">
                                                        <button type="button"
                                                            class="btn btn-icon btn-active-color-primary"
                                                            data-kt-element="remove-item">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                        fill="currentColor" />
                                                                    <path opacity="0.5"
                                                                        d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                        fill="currentColor" />
                                                                    <path opacity="0.5"
                                                                        d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                        fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endif

                                            </tbody>
                                            <!--end::Table body-->
                                            <!--begin::Table foot-->
                                            <tfoot>
                                                <tr
                                                    class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                                                    <th class="text-primary" colspan="2">
                                                        <button class="btn btn-link py-1 text-primary"
                                                            data-kt-element="add-item">Add
                                                            item</button>
                                                    </th>
                                                    <th colspan="1" class="border-bottom border-bottom-dashed ps-0">
                                                        <div class="d-flex flex-column align-items-start">
                                                            <div class="fs-6">Subtotal</div>
                                                        </div>
                                                    </th>
                                                    <th colspan="3" class="border-bottom border-bottom-dashed text-end">
                                                        £
                                                        <span data-kt-element="sub-total">0.00</span>
                                                    </th>
                                                </tr>
                                                <tr
                                                    class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700 elements_alt">
                                                    <th class="text-primary" colspan="2">
                                                    </th>
                                                    <th colspan="1" class="border-bottom border-bottom-dashed ps-0">
                                                    </th>
                                                    <th colspan="3" class="border-bottom border-bottom-dashed text-end">
                                                        ₨
                                                        <span data-kt-element="sub-total-alt">0.00</span>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                            <!--end::Table foot-->
                                        </table>
                                    </div>
                                    <!--end::Table Items -->

                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed my-10"></div>
                                    <!--end::Separator-->
                                    <h4 class="mt-8 mb-3">Payments</h4>
                                    <!--begin::Table Payments-->
                                    <div class="table-responsive mb-10">
                                        <!--begin::Table-->
                                        <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700"
                                            data-kt-element="payments" id="payment_table">
                                            <!--begin::Table head-->
                                            <thead>
                                                <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                                    <th class="min-w-180px w-300px required">Mode</th>
                                                    <th class="min-w-180px required">Date</th>
                                                    <th class="min-w-150px required">Amount</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody>
                                                @if(isset($invoice))
                                                @foreach($invoice_payments as $index => $invoice_payment)
                                                <tr class="border-bottom border-bottom-dashed"
                                                    data-kt-element="payment">
                                                    <td class="pe-7">
                                                        <!--begin::Input group-->
                                                        <div class="mb-5 fv-row">
                                                            <select name="payment_mode[{{ $index  }}]"
                                                                class="form-select form-select-lg form-select-solid"
                                                                data-control="select2"
                                                                data-placeholder="Select a payment mode">
                                                                <option value="">Select a payment mode</option>
                                                                <option value="bank"
                                                                    {{$invoice_payment->mode == 'bank' ? 'selected' : ''}}>
                                                                    Bank Payment</option>
                                                                <option value="cash"
                                                                    {{$invoice_payment->mode == 'cash' ? 'selected' : ''}}>
                                                                    Cash Payment</option>
                                                                <option value="other"
                                                                    {{$invoice_payment->mode == 'other' ? 'selected' : ''}}>
                                                                    Other</option>
                                                            </select>
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="ps-0">
                                                        <div class="mb-5 fv-row">
                                                            <input class="form-control form-control-solid"
                                                                placeholder="Select payment date"
                                                                name="payment_date[{{ $index  }}]"
                                                                value="{{(new DateTime($invoice_payment->date))->format('d-M-Y')}}"
                                                                data-kt-element="payment_date" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-solid mb-5 fv-row">
                                                            <span class="input-group-text elements_alt">£</span>
                                                            <input type="text"
                                                                class="form-control form-control-solid text-end"
                                                                name="payment_amount[{{ $index  }}]]" placeholder="0.00"
                                                                value="{{$invoice_payment->amount}}"
                                                                data-kt-element="payment_amount" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="input-group input-group-solid mb-5 fv-row elements_alt">
                                                            <span class="input-group-text elements_alt">₨</span>
                                                            <input type="text" class="form-control text-end"
                                                                name="payment_amount_alt[{{ $index  }}]]"
                                                                placeholder="0.00"
                                                                value="{{isset($invoice_payment->amount_alt) ? $invoice_payment->amount_alt : '0.00'}}"
                                                                data-kt-element="payment_amount_alt" />
                                                            <div class="fv-plugins-message-container invalid-feedback">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="pt-5 text-end">
                                                        <button type="button"
                                                            class="btn btn-icon btn-active-color-primary"
                                                            data-kt-element="remove-payment">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                        fill="currentColor" />
                                                                    <path opacity="0.5"
                                                                        d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                        fill="currentColor" />
                                                                    <path opacity="0.5"
                                                                        d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                        fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <!--begin::Empty template-->
                                                <tr data-kt-element="empty">
                                                    <th colspan="5" class="text-muted text-center py-10">No items</th>
                                                </tr>
                                                <!--end::Empty template-->
                                                @endif
                                            </tbody>
                                            <!--end::Table body-->
                                            <!--begin::Table foot-->
                                            <tfoot>
                                                <tr
                                                    class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                                                    <th class="text-primary" colspan="2">
                                                        <button class="btn btn-link py-1 text-primary"
                                                            data-kt-element="add-payment">
                                                            Add payment
                                                        </button>
                                                    </th>
                                                    <th colspan="1" class="border-bottom border-bottom-dashed ps-0">
                                                        <div class="d-flex flex-column align-items-start">
                                                            <div class="fs-6">Paid</div>
                                                        </div>
                                                    </th>
                                                    <th colspan="3" class="border-bottom border-bottom-dashed text-end">
                                                        £
                                                        <span data-kt-element="paid-total">0.00</span>
                                                    </th>
                                                </tr>
                                                <tr
                                                    class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700 elements_alt">
                                                    <th class="text-primary" colspan="2">
                                                    </th>
                                                    <th colspan="1" class="border-bottom border-bottom-dashed ps-0">
                                                    </th>
                                                    <th colspan="3" class="border-bottom border-bottom-dashed text-end">
                                                        ₨
                                                        <span data-kt-element="paid-total-alt">0.00</span>
                                                    </th>
                                                </tr>
                                                <tr class="align-top fw-bold text-gray-700">
                                                    <th colspan="2"></th>
                                                    <th colspan="1" class="fs-4 ps-0">Total</th>
                                                    <th colspan="3" class="text-end fs-4 text-nowrap">£
                                                        <span data-kt-element="grand-total">0.00</span>
                                                    </th>
                                                </tr>
                                                <tr class="align-top fw-bold text-gray-700 elements_alt">
                                                    <th colspan="2"></th>
                                                    <th colspan="1" class="fs-4 ps-0"></th>
                                                    <th colspan="3" class="text-end fs-4 text-nowrap">₨
                                                        <span data-kt-element="grand-total-alt">0.00</span>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                            <!--end::Table foot-->
                                        </table>
                                    </div>
                                    <!--end::Table Payments -->

                                    <!--begin::Notes-->
                                    <div class="mb-0">
                                        <label class="form-label fs-6 fw-bold text-gray-700">Internal Notes</label>
                                        <textarea name="notes" class="form-control form-control-solid" rows="3"
                                            placeholder="Thanks for your business">{{isset($invoice) ? $invoice->notes : null}}</textarea>
                                    </div>
                                    <!--end::Notes-->
                                </div>
                                <!--end::Wrapper-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
                <!--begin::Sidebar-->
                <div class="flex-xxl-auto min-w-xxl-300px attachments-create">
                    <!--begin::Card-->
                    <div class="card card-sticky">
                        <!--begin::Card body-->
                        <div class="card-body p-10">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label fw-bold fs-6 text-gray-700">Attachments</label>
                                <!--end::Label-->
                                <!--begin::FileInput-->
                                <!-- <input type="file" name="logo" class="form-control form-control-solid" /> -->
                                <!--begin::Input group-->
                                <div class="form-group fv-row">
                                    <!--begin::Col-->
                                    <div class="col-12">
                                        <!--begin::Dropzone-->
                                        <div class="dropzone dropzone-queue mb-2" id="kt_dropzonejs">
                                            <!--begin::Controls-->
                                            <div class="dropzone-panel mb-lg-0 mb-2">
                                                <a class="dropzone-select btn btn-sm btn-primary me-2">Attach files</a>
                                                <a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove
                                                    All</a>
                                            </div>
                                            <!--end::Controls-->

                                            <!--begin::Items-->
                                            <div class="dropzone-items wm-200px">
                                                <div class="dropzone-item" style="display:none">
                                                    <!--begin::File-->
                                                    <div class="dropzone-file">
                                                        <a href="#" class="dropzone-filename d-block"
                                                            title="some_image_file_name.jpg">
                                                            <span data-dz-name>some_image_file_name.jpg</span>
                                                            <strong>(<span data-dz-size>340kb</span>)</strong>
                                                        </a>
                                                        <div class="dropzone-error" data-dz-errormessage></div>
                                                    </div>
                                                    <!--end::File-->

                                                    <!--begin::Progress-->
                                                    <div class="dropzone-progress">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-primary" role="progressbar"
                                                                aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"
                                                                data-dz-uploadprogress>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Progress-->

                                                    <!--begin::Toolbar-->
                                                    <div class="dropzone-toolbar">
                                                        <span class="dropzone-start"><i
                                                                class="bi bi-play-fill fs-3"></i></span>
                                                        <span class="dropzone-cancel" data-dz-remove
                                                            style="display: none;"><i class="bi bi-x fs-3"></i></span>
                                                        <span class="dropzone-delete" data-dz-remove><i
                                                                class="bi bi-x fs-1"></i></span>
                                                    </div>
                                                    <!--end::Toolbar-->
                                                </div>
                                            </div>
                                            <!--end::Items-->
                                        </div>
                                        <!--end::Dropzone-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--end::FileInput-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Separator-->
                            <div class="separator separator-dashed mb-8"></div>
                            <!--end::Separator-->
                            <!--begin::Actions-->
                            <div class="mb-0">
                                <!--begin::Row-->
                                <div class="row mb-5">
                                    <!--begin::Col-->
                                    <div class="col">
                                        <a href="#"
                                            class="btn btn-light btn-active-light-primary w-100 reset">Dismiss</a>
                                    </div>
                                    <!--end::Col-->
                                    @if(isset($invoice))
                                    <!--begin::Col-->
                                    <div class="col">
                                        <a href="{{route(Auth::user()->role . '.invoice.showPdf', $invoice->id)}}"
                                            class="btn btn-primary btn-active-light-primary w-100">Download</a>
                                    </div>
                                    <!--end::Col-->
                                    @endif
                                </div>
                                <!--end::Row-->

                                <button type="button" id="kt_form_submit" class="btn btn-primary w-100">
                                    <span class="indicator-label">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen016.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z"
                                                    fill="currentColor" />
                                                <path opacity="0.3"
                                                    d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        {{isset($invoice) ? 'Update' : 'Create'}} Invoice
                                    </span>
                                    </span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->
            </div>
            <!--end::Layout-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->
@endsection

@section('pagespecificdrawers')
@stop

@section('pagespecificmodals')
@include('invoice.templates')
@stop


@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
<!--begin::Custom Javascript(used for this page only)-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shortcut-buttons-flatpickr@0.1.0/dist/themes/light.min.css">
<script src="https://cdn.jsdelivr.net/npm/shortcut-buttons-flatpickr@0.1.0/dist/shortcut-buttons-flatpickr.min.js">
</script>
<script src="{{asset('js/invoice/create.js')}}"></script>
<!--end::Custom Javascript-->
@if(isset($invoice))
@foreach ($invoice_attachments as $attach)
<?php
$path = Storage::url($attach->path) . $attach->url;
?>

<script>
    $("document").ready(() => {
        var path = "{{ $path }}";
        var fileSize = "{$fileSize}}";
        var file = new File([path], "{{ $attach->name }}", {
            type: "{{ $attach->mime_type }}",
            lastModified: "{{ $attach->updated_at }}",
            size: "{{ $attach->size }}" // Set file size in bytes
        });
        file['status'] = "added";
        file['_removeLink'] = "a.dz-remove";
        file['webkitRelativePath'] = "";
        file['accepted'] = true;
        file['dataURL'] = path;
        file['upload'] = {
            bytesSent: 0,
            filename: "{{ $attach->name }}",
            progress: 100,
            total: "{{ $attach->size }}", // Set total file size in bytes
            uuid: "{{ md5($attach->id) }}"
        };
        myDropzone.emit("addedfile", file, path);
        myDropzone.files.push(file);
    });
</script>
@endforeach
@endif
@stop