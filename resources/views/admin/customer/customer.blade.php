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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Customer
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
                    <li class="breadcrumb-item text-muted">Customers</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xl-row">
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                    <!--begin::Card-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Card body-->
                        <div class="card-body pt-15">
                            <!--begin::Summary-->
                            <div class="d-flex flex-center flex-column mb-5">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-150px symbol-circle mb-7">
                                    <img src="{{isset($data['user']->avatar) ? Storage::disk('s3')->url($data['user']->avatar) : asset('media/svg/avatars/blank.svg')}}"
                                        alt="image" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Name-->
                                <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">
                                    {{$data["user"]->first_name}}
                                    {{$data["user"]->last_name}}
                                </a>
                                <!--end::Name-->
                                <!--begin::Email-->
                                <a href="#"
                                    class="fs-5 fw-semibold text-muted text-hover-primary mb-6">{{$data["user"]->email}}</a>
                                <!--end::Email-->
                            </div>
                            <!--end::Summary-->
                            <!--begin::Details toggle-->
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bold">Details</div>
                                @if($data['transactions'] && count($data['transactions']))
                                <!--begin::Badge-->
                                <div class="badge badge-light-info d-inline">Premium user</div>
                                <!--begin::Badge-->
                                @endif
                            </div>
                            <!--end::Details toggle-->
                            <div class="separator separator-dashed my-3"></div>
                            <!--begin::Details content-->
                            <div class="pb-5 fs-6">
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">Account ID</div>
                                <div class="text-gray-600">#SL{{ str_pad($data["user"]->id, 5, "0", STR_PAD_LEFT) }}
                                </div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">Billing Email</div>
                                <div class="text-gray-600">
                                    <a href="#" class="text-gray-600 text-hover-primary">{{$data["user"]->email}}</a>
                                </div>
                                <!--begin::Details item-->

                                @if($data['transactions'] && count($data['transactions']))
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">Latest Transaction</div>
                                <div class="text-gray-600">
                                    <span
                                        class="text-gray-600 text-hover-primary">#{{$data['transactions'][0]->id}}</span>
                                </div>
                                <!--begin::Details item-->
                                @endif
                            </div>
                            <!--end::Details content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->
                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-15">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#kt_ecommerce_customer_overview">Overview</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_customer_services">Pricing</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_customer_general">General Settings</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_customer_advanced">Advanced Settings</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->
                    <!--begin:::Tab content-->
                    <div class="tab-content" id="myTabContent">

                        @include('admin.customer.tabs.overview')
                        @include('admin.customer.tabs.services')
                        @include('admin.customer.tabs.general')
                        @include('admin.customer.tabs.advanced')

                    </div>
                    <!--end:::Tab content-->
                </div>
                <!--end::Content-->
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
@include('admin.customer.modals.update_email_modal')
@include('admin.customer.modals.update_password_modal')
@include('admin.customer.modals.add_transaction_modal')
@include('admin.customer.modals.view_transaction_modal')
@stop


@section('pagespecificstyles')
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
<!--end::Vendor Stylesheets-->
@stop

@section('pagespecificscripts')
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('js/widgets.bundle.js')}}"></script>
<script src="{{asset('js/custom/widgets.js')}}"></script>
<script src="{{asset('js/custom/apps/customer/services.js')}}"></script>
<script src="{{asset('js/custom/apps/customer/discount.js')}}"></script>
<script src="{{asset('js/custom/apps/customer/general.js')}}"></script>
<script src="{{asset('js/custom/apps/customer/advanced.js')}}"></script>
<script src="{{asset('js/custom/apps/customer/main.js')}}"></script>
<!--end::Custom Javascript-->
@stop