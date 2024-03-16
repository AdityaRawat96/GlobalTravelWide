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
                            <input type="text" data-kt-order-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Orders" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt-orders-table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Order ID</th>
                                <th class="min-w-125px">Order Date</th>
                                <th class="min-w-125px">Amount</th>
                                <th class="min-w-125px">Status</th>
                                <th class="min-w-125px">
                                    <span><b>Units expected</b></span><br>
                                    <span class="text-primary">Units located</span>
                                </th>
                                <th class="text-end min-w-70px">Details</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600">
                            @foreach($data["orders"] as $index=>$order)
                            <tr>
                                <td>
                                    <span class="text-gray-800 text-hover-primary fw-bold">
                                        {{$order->is_express ? "E" : "I"}}FBA{{ str_pad($order->id, 5, "0", STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td>{{date("d, M Y", strtotime($order->created_at))}}</td>
                                <td>$ {{number_format($order->total, 2)}}</td>
                                <td>
                                    <span class="badge badge-light status-badge-{{strtolower($order->status)}} fw-bold px-4 py-3">{{$order->status}}</span>
                                </td>
                                <td>
                                    <span><b>{{$order->product_count}}</b></span><br>
                                    <span class="text-primary">{{$order->shipped_product_count}}</span>
                                </td>
                                <!--begin::Action=-->
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{route('user.order.view', $order->order_id)}}" class="menu-link px-3">View</a>
                                        </div>
                                        <!--end::Menu item-->
                                        @if($order->status != "Processing" || $order->status != "Needs Attention" ||
                                        $order->status != "Shipped")
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{route('user.order.edit', $order->order_id)}}" class="menu-link px-3">Edit</a>
                                        </div>
                                        <!--end::Menu item-->
                                        @endif
                                        @if($order->status != "Processing" || $order->status != "Needs Attention" ||
                                        $order->status != "Shipped")
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" onclick="deleteTableRow(`{{route('user.order.delete', $order->order_id)}}`, `{{$index}}`)" data-kt-ecommerce-product-filter="delete_row">Delete</a>
                                        </div>
                                        <!--end::Menu item-->
                                        @endif
                                    </div>
                                    <!--end::Menu-->
                                </td>
                                <!--end::Action=-->
                            </tr>
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

@section('pagespecificdrawers')
@stop

@section('pagespecificmodals')
@stop

@section('pagespecificstyles')
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/custom/filepond/filepond.css')}}" rel="stylesheet" />
<link href="{{asset('plugins/custom/filepond/filepond-plugin-image-preview.css')}}" rel="stylesheet" />
<link href="{{asset('plugins/custom/filepond/filepond-plugin-get-file.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('css/order.css')}}" />
<!--end::Vendor Stylesheets-->
@stop

@section('pagespecificscripts')
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('plugins/custom/datatables/responsive.bootstrap.min.js')}}"></script>
<!-- include FilePond library -->
<script src="{{asset('plugins/custom/filepond/filepond.min.js')}}"></script>
<!-- include FilePond plugins -->
<script src="{{asset('plugins/custom/filepond/filepond-plugin-image-preview.min.js')}}"></script>
<!-- include FilePond jQuery adapter -->
<script src="{{asset('plugins/custom/filepond/filepond.jquery.js')}}"></script>
<!-- include FilePond image download plugin -->
<script src="{{asset('plugins/custom/filepond/filepond-plugin-get-file.js')}}"></script>
<!--end::Vendors Javascript-->
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('js/custom/apps/orders/index.js')}}"></script>
<script src="{{asset('js/widgets.bundle.js')}}"></script>
<script src="{{asset('js/custom/widgets.js')}}"></script>
<!--end::Custom Javascript-->
@stop