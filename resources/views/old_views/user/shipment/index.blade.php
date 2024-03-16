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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Shipment
                    List</h1>
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
                    <li class="breadcrumb-item text-muted">Shipments</li>
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
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-product-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Products" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_products_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">Product</th>
                                <th class="min-w-100px">Title</th>
                                <th class="text-end min-w-100px">ASIN</th>
                                <th class="text-end min-w-100px">Incoming</th>
                                <th class="text-end min-w-100px">Received</th>
                                <th class="text-end min-w-100px">Damaged</th>
                                <th class="text-end min-w-100px">History</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            @foreach($products as $index=>$product)

                            <!--begin::Table row-->
                            <tr id="datatable-row-{{$index}}">
                                <form class="form update_shipment_form" action="{{route('user.shipment.update', $product->asin)}}" method="POST" id="update_shipment_form_{{$index}}" data-valid="true" data-index="{{$index}}">
                                    @csrf
                                    <!--begin::Category=-->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <!--begin::Thumbnail-->
                                            <a href="../../demo1/dist/apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
                                                <span class="symbol-label" style="background-image:url({{Storage::disk('s3')->url($product->image)}});"></span>
                                            </a>
                                            <!--end::Thumbnail-->
                                            <div class="ms-5">
                                                <!--begin::Title-->
                                                <a href="../../demo1/dist/apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name">{{ substr($product->name, 0, 20)}}{{strlen($product->name) > 20 ? '...' : ''}}</a>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </td>
                                    <!--end::Category=-->
                                    <td>
                                        <span class="fw-bold">{{$product->title}}</span>
                                    </td>
                                    <!--begin::SKU=-->
                                    <td class="text-end">
                                        <span class="fw-bold">{{$product->asin}}</span>
                                    </td>
                                    <!--end::SKU=-->
                                    <!--begin::Qty=-->
                                    <td class="text-end" data-order="{{$product->incoming}}">
                                        <!-- begin::Input group-->
                                        <div class="fv-row">
                                            <!--begin::Input-->
                                            <input type="number" class="form-control form-control-solid product_qty" placeholder="" name="product_qty" style="max-width: 150px" value="{{$product->incoming}}" data-received="{{$product->received}}" data-damaged="{{$product->damaged}}" data-index="{{$index}}" />
                                            <!--end::Input-->
                                        </div>
                                        <!-- end::Input group-->
                                    </td>
                                    <!--end::Qty=-->
                                    <!--begin::received=-->
                                    <td class="text-end">{{$product->received}}</td>
                                    <!--end::received=-->
                                    <!--begin::damaged=-->
                                    <td class=" text-end">{{$product->damaged}}
                                    </td>
                                    <!--end::damaged=-->
                                    <td class="text-end">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_view_shipment" onclick="viewShipmentHistory(`{{route('user.shipment.history', $product->asin)}}`)" data-kt-product-table-select="update_shipment"><i class="fas fa-list my-3"></i></a>
                                    </td>
                                    <!--begin::Action=-->
                                    <td class="text-end">
                                        <!--begin::Button-->
                                        <button type="submit" onclick="update_shipment_form_submit({{$index}})" class="btn btn-primary form-control" id="button_update_shipment_{{$index}}">
                                            <span class="indicator-label">Update</span>
                                            <span class="indicator-progress">
                                                <span class="spinner-border spinner-border-sm align-middle ms-2 my-1"></span></span>
                                        </button>
                                        <!--end::Button-->
                                    </td>
                                    <!--end::Action=-->
                                </form>
                            </tr>
                            <!--end::Table row-->
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->

                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->
@endsection
<style>
    .menu-item {
        text-align: start;
    }

    .btn-copy {
        padding: 10px !important;
        border: none !important;
        background-color: #FFFFFF !important;
        margin-top: 10px;
        color: #009EF7 !important;
    }

    .btn-copy i {
        color: #009EF7 !important;
    }

    .swal2-container .swal2-html-container {
        max-height: fit-content !important;
    }
</style>

@section('pagespecificdrawers')
@stop

@section('pagespecificmodals')
@include('user.shipment.modals.view_shipment_modal')
@stop

@section('pagespecificstyles')
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
<!--end::Vendor Stylesheets-->
@stop

@section('pagespecificscripts')
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('plugins/custom/datatables/responsive.bootstrap.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('js/custom/apps/shipments/index.js')}}"></script>
<script src="{{asset('js/custom/apps/shipments/update-shipment.js')}}"></script>
<!--end::Custom Javascript-->
@stop