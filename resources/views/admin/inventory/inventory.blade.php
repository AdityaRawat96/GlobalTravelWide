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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Product
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
                    <li class="breadcrumb-item text-muted">Products</li>
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
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                        transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-product-table-filter="search"
                                class="form-control form-control-solid w-250px ps-15" placeholder="Search Products" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar" style="flex: 1;">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-product-table-toolbar="base"
                            style="margin-left: auto;">
                            <!--begin::Filter-->
                            <div class="w-150px me-3">
                                <!--begin::Select2-->
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Status"
                                    data-kt-ecommerce-product-filter="status">
                                    <option></option>
                                    <option value="all">All</option>
                                    <option value="Published">Published</option>
                                    <option value="Scheduled">Scheduled</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <!--end::Select2-->
                            </div>
                            <!--end::Filter-->
                            <!--begin::Filter-->
                            <div class="w-150px me-3">
                                <!--begin::Select2-->
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Stock"
                                    data-kt-ecommerce-product-filter="stock">
                                    <option></option>
                                    <option value="all">All</option>
                                    <option value="in-stock">In-Stock</option>
                                    <option value="out-of-stock">Out of Stock</option>
                                </select>
                                <!--end::Select2-->
                            </div>
                            <!--end::Filter-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
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
                                <th class="text-end min-w-125px">
                                    <span><b>In-Stock</b></span><br>
                                    <span class="text-primary">Working</span>
                                </th>
                                <th class="text-end min-w-100px">Price ($)</th>
                                <th class="text-end min-w-100px">Status</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            @foreach($products as $index=>$product)
                            <!--begin::Table row-->
                            <tr id="datatable-row-{{$index}}"
                                class="{{$product->stock == 0 ? 'product-out-of-stock' : 'product-in-stock'}}">
                                <!--begin::Category=-->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!--begin::Thumbnail-->
                                        <a href="../../demo1/dist/apps/ecommerce/catalog/edit-product.html"
                                            class="symbol symbol-50px">
                                            <span class="symbol-label"
                                                style="background-image:url({{Storage::disk('s3')->url($product->image)}});"></span>
                                        </a>
                                        <!--end::Thumbnail-->
                                        <div class="ms-5">
                                            <!--begin::Title-->
                                            <a href="../../demo1/dist/apps/ecommerce/catalog/edit-product.html"
                                                class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                                data-kt-ecommerce-product-filter="product_name">{{ substr($product->name, 0, 20)}}{{strlen($product->name) > 20 ? '...' : ''}}</a>
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
                                <td class="text-end" data-order="16">
                                    <span class="fw-bold ms-3 d-block">{{$product->stock}}</span>
                                    <span class="text-primary fw-bold ms-3 d-block">{{$product->working}}</span>
                                </td>
                                <!--end::Qty=-->
                                <!--begin::Price=-->
                                <td class="text-end">{{$product->price}}</td>
                                <!--end::Price=-->
                                <!--begin::Status=-->
                                <td class="text-end" data-order="{{ucfirst($product->status)}}">
                                    <!--begin::Badges-->
                                    @if($product->status === "published")
                                    <div class="badge badge-light-success">
                                        @elseif($product->status === "inactive")
                                        <div class="badge badge-light-danger">
                                            @elseif($product->status === "scheduled")
                                            <div class="badge badge-light-warning">
                                                @else($product->status === "draft")
                                                <div class="badge badge-light-primary">
                                                    @endif
                                                    {{ucfirst($product->status)}}
                                                </div>
                                                <!--end::Badges-->
                                </td>
                                <!--end::Status=-->
                                <!--begin::Action=-->
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_update_stock"
                                                onclick="updateStockModal(`{{$product->asin}}`, `{{$product->stock}}`, `{{$product->working}}`)">Update
                                                Stock</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{route('admin.inventory.edit', $product->id)}}"
                                                class="menu-link px-3">Edit</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3"
                                                onclick="deleteTableRow(`{{route('admin.inventory.delete',$product->id)}}`, `{{$index}}`)"
                                                data-kt-ecommerce-product-filter="delete_row">Delete</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                                <!--end::Action=-->
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
@include('admin.inventory.modals')
@stop

@section('pagespecificstyles')
<!--begin::Vendor Stylesheets(used for this page only)-->
<link rel="stylesheet" href="{{asset('css/order.css')}}" />
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
<script src="{{asset('js/custom/apps/inventory/inventory.js')}}"></script>
<script src="{{asset('js/custom/apps/inventory/update_stock.js')}}"></script>
<!--end::Custom Javascript-->
@stop