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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Order
                    Details</h1>
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
                    <li class="breadcrumb-item text-muted">Orders</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Order details page-->
            <div class="d-flex flex-column gap-7 gap-lg-10">

                <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
                    <!--begin::Button-->
                    <a href="{{route('user.order.index')}}" class="btn btn-icon btn-primary btn-sm ">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr074.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2657 11.4343L15.45 7.25C15.8642 6.83579 15.8642 6.16421 15.45 5.75C15.0358 5.33579 14.3642 5.33579 13.95 5.75L8.40712 11.2929C8.01659 11.6834 8.01659 12.3166 8.40712 12.7071L13.95 18.25C14.3642 18.6642 15.0358 18.6642 15.45 18.25C15.8642 17.8358 15.8642 17.1642 15.45 16.75L11.2657 12.5657C10.9533 12.2533 10.9533 11.7467 11.2657 11.4343Z" fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                    <!--end::Button-->
                    @if($data['order']->status != "Shipped")
                    <!--begin::Button-->
                    <a href="{{route('user.order.edit', $data['order']->order_id)}}" class="btn btn-primary btn-sm">
                        <i class="fas fa-pencil"></i>
                        Edit</a>
                    <!--end::Button-->
                    @endif

                </div>

                <div class="form d-flex flex-column flex-lg-row">
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                        <!--begin::Aside column-->
                        <div class="aside-column">
                            <!--begin::Order details-->
                            <div class="card card-flush py-4 mb-5">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Order Details</h2>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <div class="d-flex flex-column gap-10">
                                        <!--begin::Input group-->
                                        <div class="fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Order ID</label>
                                            <!--end::Label-->
                                            <div class="d-flex">
                                                <div class="fw-bold fs-3">
                                                    {{$data['order']->is_express ? "E" : "I"}}FBA{{ str_pad($data['order']->id, 5, "0", STR_PAD_LEFT) }}
                                                </div>
                                                <!--end::Input-->
                                                <span class="badge badge-light-warning mt-3" style="margin-left: auto">{{$data['order']->status}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card header-->
                            </div>
                            <!--end::Order details-->
                            <!--begin::Product details-->
                            <div class="card card-flush py-4 mb-5">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Product Details</h2>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <div class="d-flex flex-column gap-10">
                                        <div class="packed-products">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_edit_order_product_table">
                                                <thead>
                                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                        <th>Product</th>
                                                        <th class="text-end pe-5">Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($data['products'] as $index=>$product)
                                                    <tr>
                                                        <!--begin::Product=-->
                                                        <td>
                                                            <div class="d-flex align-items-center" data-kt-ecommerce-edit-order-filter="product">
                                                                <!--begin::Thumbnail-->
                                                                <a href="#" class="symbol symbol-50px">
                                                                    <span class="symbol-label rounded" style="background-image:url({{$product['image']}})"></span>
                                                                </a>
                                                                <!--end::Thumbnail-->
                                                                <div class="ms-5">
                                                                    <!--begin::Title-->
                                                                    <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">Product
                                                                        {{$index + 1}}</a>
                                                                    <!--end::Title-->

                                                                    <!--begin::Price-->
                                                                    <div class="fw-semibold fs-7">Price: $
                                                                        <span data-kt-ecommerce-edit-order-filter="price">{{number_format($product['price'], 2)}}</span>
                                                                    </div>
                                                                    <!--end::Price-->
                                                                    <!--begin::SKU-->
                                                                    <div class="text-muted fs-7">ASIN:
                                                                        {{$product['asin']}}
                                                                    </div>
                                                                    <!--end::SKU-->
                                                                    @if(isset($product['bundle']) && $product['bundle']
                                                                    != "none")
                                                                    <span class="badge py-3 px-4 fs-7 badge-light-success">
                                                                        {{ucfirst($product['bundle'])}}
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <!--end::Product=-->
                                                        <!--begin::Qty=-->
                                                        <td class="text-end pe-5">
                                                            <span class="fw-bold text-warning ms-3">{{$product['qty']}}</span>
                                                        </td>
                                                        <!--end::Qty=-->
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--begin::Button-->
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_update_products">View Products</button>
                                        <!--end::Button-->
                                    </div>
                                </div>
                                <!--end::Card header-->
                            </div>
                            <!--end::Product details-->
                            <!--begin::Selected carrier-->
                            <div class="card card-flush py-4 mb-5">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Carrier Details</h2>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <div class="d-flex flex-column gap-10">
                                        <div class="carrier-list">
                                            <div class="align-items-center border border-dashed rounded p-3 bg-body mb-5">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <!--begin:Option-->
                                                        <label class="d-flex flex-stack mb-5 cursor-pointer">
                                                            <!--begin:Label-->
                                                            <span class="d-flex align-items-center me-2">
                                                                <!--begin:Icon-->
                                                                <div class="symbol symbol-45px me-4">
                                                                    @if($data['carrier']['logo'])
                                                                    <img src="{{Storage::disk('s3')->url($data['carrier']['logo'])}}" alt="carrier logo" class="img-fluid">
                                                                    @else
                                                                    <span class="symbol-label bg-primary">
                                                                        <i class="text-inverse-primary fs-1 lh-0 fonticon-delivery"></i>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                                <!--end:Icon-->
                                                                <!--begin:Info-->
                                                                <span class="d-flex flex-column">
                                                                    <b>{{$data['carrier']['name']}}</b>
                                                                </span>
                                                                <!--end:Info-->
                                                            </span>
                                                            <!--end:Label-->
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table class="table table-row-dashed">
                                                            <tr>
                                                                <td class="table-summary-label">Shipping time</td>
                                                                <td class="table-summary-data">1-6 days</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="table-summary-label">Import fee</td>
                                                                <td class="table-summary-data">$
                                                                    {{number_format($data['carrier']['import_fee'], 2)}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="table-summary-label">Shipment fee</td>
                                                                <td class="table-summary-data">$
                                                                    {{number_format($data['carrier']['shipping_fee'], 2)}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="table-summary-label">Total</td>
                                                                <td class="table-summary-data">$
                                                                    {{number_format($data['carrier']['total_fee'], 2)}}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Option-->
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card header-->
                            </div>
                            <!--end::Selected carrier-->
                            <!--begin::Label details-->
                            <div class="card card-flush py-4 mb-5">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Labels</h2>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <div class="d-flex flex-column gap-10">
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-row-dashed">
                                                    <tr>
                                                        <td class="table-summary-label">Product FNSKU Labels</td>
                                                        <td class="table-summary-data">
                                                            {{ $data['fnsku_label_count'] }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-summary-label">Combined FNSKU Labels</td>
                                                        <td class="table-summary-data">
                                                            {{ $data['order']->fnsku_labels ? count(json_decode($data['order']->fnsku_labels, true)) : 0 }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-summary-label">FBA and Shipping Labels</td>
                                                        <td class="table-summary-data">
                                                            {{ count(json_decode($data['order']->fba_labels, true)) }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <!--begin::Button-->
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_view_labels">View Labels</button>
                                        <!--end::Button-->
                                    </div>
                                </div>
                                <!--end::Card header-->
                            </div>
                            <!--end::Label details-->
                            <!--begin::Shipping details-->
                            <div class="card card-flush py-4 mb-5">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Shipping Address</h2>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    @if($data['shipping_address'])
                                    <div class="d-flex flex-column gap-10">
                                        <p>
                                            <b>{{ $data['shipping_address']['name'] . ", " . $data['shipping_address']['company'] }}</b>
                                            <br>
                                            <br>{{ $data['shipping_address']['phone'] }},
                                            <br>{{ $data['shipping_address']['email'] }},
                                            <br>
                                            <br>{{ $data['shipping_address']['address_1'] }},
                                            @if($data['shipping_address']['address_2'])
                                            <br>{{ $data['shipping_address']['address_2'] }},
                                            @endif
                                            <br>{{ $data['shipping_address']['city'] }},
                                            <br>{{ $data['shipping_address']['state'] . ", " . $data['shipping_address']['zip'] }}.
                                            <br>{{ $data['shipping_address']['country'] }}.
                                        </p>
                                    </div>
                                    @else
                                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed my-5 p-6">
                                        <!--begin::Icon-->
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-01-30-131017/core/html/src/media/icons/duotune/general/gen044.svg-->
                                        <span class="svg-icon svg-icon-2tx svg-icon-warning me-4"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                                <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                                <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <!--end::Icon-->
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-stack flex-grow-1">
                                            <!--begin::Content-->
                                            <div class="fw-semibold">
                                                <div class="fs-6 text-gray-700">No Shipping information provided.
                                                </div>
                                            </div>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--begin::Button-->
                                    <a href="{{route('user.order.edit', $data['order']->order_id)}}" class="btn btn-primary btn-sm form-control">
                                        Add Shipping</a>
                                    <!--end::Button-->
                                    @endif
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Shipping details-->
                            @if($data['order']->is_express)
                            <!--begin::Tracking Info-->
                            <div class="card card-flush py-4 mb-5">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Tracking Info</h2>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    @if($data['tracking'])
                                    <div class="d-flex flex-column gap-10">
                                        <table class="table table-row-dashed">
                                            <tbody>
                                                <tr>
                                                    <td>Carrier</td>
                                                    <td>{{$data['tracking']['carrier_name']}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tracking ID</td>
                                                    <td>{{$data['tracking']['tracking_id']}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!--begin::Button-->
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_update_tracking">Update Tracking</button>
                                        <!--end::Button-->
                                    </div>
                                    @else
                                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed my-5 p-6">
                                        <!--begin::Icon-->
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-01-30-131017/core/html/src/media/icons/duotune/general/gen044.svg-->
                                        <span class="svg-icon svg-icon-2tx svg-icon-warning me-4"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                                <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                                                <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <!--end::Icon-->
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-stack flex-grow-1">
                                            <!--begin::Content-->
                                            <div class="fw-semibold">
                                                <div class="fs-6 text-gray-700">No Tracking information provided.
                                                </div>
                                            </div>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-primary btn-sm form-control" data-bs-toggle="modal" data-bs-target="#kt_modal_update_tracking">Add
                                        Tracking</button>
                                    <!--end::Button-->
                                    @endif
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Tracking Info-->
                            @endif
                        </div>
                        <!--end::Aside column-->
                    </div>
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="flex-column">
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
                                        @foreach($data['bins'] as $key=>$bin)
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <span class="badge py-3 px-4 fs-7 badge-light-primary">{{$key + 1}}.
                                                    {{$bin['name']}}</span>
                                                <br><br>
                                                <img class="img-fluid-svg" src="{{$bin['image']}}">
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
                                                        <td class="table-summary-data"><b>{{$bin['total_products']}}</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-summary-label"><b>Total Value</b></td>
                                                        <td class="table-summary-data"><b>$
                                                                {{number_format($bin['total_price'], 2)}}</b></td>
                                                    </tr>
                                                </table>
                                            </div>
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
                                                                {{number_format($bin['shipping_fee'], 2)}}
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
                                                                {{$bin['insurance_selected'] ? number_format($bin['insurance_price'] + $bin['shipping_fee'] + $bin['import_fee'], 2) : number_format($bin['shipping_fee'] + $bin['import_fee'], 2)}}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <span>Dimensions: {{$bin['w']}} X {{$bin['h']}} X
                                                    {{$bin['d']}}</span><br>
                                                <span>Weight: {{$bin['gross_weight']}} Lbs</span>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                @if($data['shipping'] && isset($data['shipping'][$key]) &&
                                                $data['shipping'][$key]['tracking_id'])
                                                <div class="d-flex w-100">
                                                    <div class="symbol symbol-45px me-4">
                                                        <img src="{{Storage::disk('s3')->url($data['shipping'][$key]['carrier_logo'])}}" alt="carrier logo" class="img-fluid">
                                                    </div>
                                                    <div>
                                                        <b>Tracking ID:</b><br />
                                                        <span>{{$data['shipping'][$key]['tracking_id']}}</span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
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
                                                        <th class="min-w-125px text-end">UNIT PRICE</th>
                                                        <th class="min-w-125px text-end">QUANTITY</th>
                                                        <th class="min-w-125px text-end">TOTAL</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-semibold text-gray-600">
                                                    @foreach($data['services'] as $sevice_index=>$service)
                                                    <tr>
                                                        <td>
                                                            <div class="text-gray-800 fw-boldest fs-5">
                                                                {{$service['name']}}
                                                            </div>
                                                            <div class="text-gray-400 fw-bold d-block">
                                                                {{$service['description']}}
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="text-gray-800 fw-boldest fs-5 UnitPrice">
                                                                ${{number_format($service['price'], 2)}}
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="text-gray-800 fw-boldest fs-5 UnitPrice">
                                                                {{$service['qty']}}
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
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
                                                <b class="generalTotal">${{number_format($data['order']->total, 2)}}</b>
                                            </span>
                                            <br /><br />
                                            <small class="fs-6">
                                                Cost per product:
                                                <b class="cost_per_product">${{number_format($data['order']->total / $data['order']->product_count, 2)}}</b>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card header-->
                            </div>
                            @if($data['product_notes'])
                            <div class="card card-flush py-4 w-100 mt-5">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Product Notes:</h2>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_edit_order_product_table">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                <th>Product</th>
                                                <th class="pe-5">Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data['products'] as $index=>$product)
                                            @if(isset($product['notes']) && $product['notes'])
                                            <tr>
                                                <!--begin::Product=-->
                                                <td>
                                                    <div class="d-flex align-items-center" data-kt-ecommerce-edit-order-filter="product">
                                                        <!--begin::Thumbnail-->
                                                        <a href="#" class="symbol symbol-50px">
                                                            <span class="symbol-label rounded" style="background-image:url({{$product['image']}})"></span>
                                                        </a>
                                                        <!--end::Thumbnail-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">Product
                                                                {{$index + 1}}</a>
                                                            <!--end::Title-->

                                                            <!--begin::Price-->
                                                            <div class="fw-semibold fs-7">Price: $
                                                                <span data-kt-ecommerce-edit-order-filter="price">{{number_format($product['price'], 2)}}</span>
                                                            </div>
                                                            <!--end::Price-->
                                                            <!--begin::SKU-->
                                                            <div class="text-muted fs-7">ASIN:
                                                                {{$product['asin']}}
                                                            </div>
                                                            <!--end::SKU-->
                                                            @if(isset($product['bundle']) && $product['bundle']
                                                            != "none")
                                                            <span class="badge py-3 px-4 fs-7 badge-light-success">
                                                                {{ucfirst($product['bundle'])}}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <!--end::Product=-->
                                                <!--begin::Qty=-->
                                                <td class="text-end pe-5">
                                                    <textarea class="form-control" rows="3" readonly>{{$product['notes']}}</textarea>
                                                </td>
                                                <!--end::Qty=-->
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Card header-->
                            </div>
                            @endif
                            <!--end::Order details-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Order details page-->
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
@include('user.order.modals.update_tracking_modal')
@include('user.order.modals.update_products_modal')
@include('user.order.modals.view_labels_modal')
@stop

@section('pagespecificstyles')
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css/order.css')}}" rel="stylesheet" type="text/css" />
<!--end::Vendor Stylesheets-->
@stop

@section('pagespecificscripts')
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('plugins/custom/datatables/responsive.bootstrap.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('js/custom/apps/orders/view.js')}}"></script>
<script src="{{asset('js/custom/apps/orders/update_tracking.js')}}"></script>
<script src="{{asset('js/widgets.bundle.js')}}"></script>
<script src="{{asset('js/custom/widgets.js')}}"></script>
<!--end::Custom Javascript-->
@stop