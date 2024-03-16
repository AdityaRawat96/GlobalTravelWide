@extends('layouts.master')

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Place
                    Order</h1>
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
        <div id="kt_app_content_container" class="app-container container-fluid">

            @livewire('update-order-wizard', ['orderID' => $orderID])

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
@livewireStyles
<link rel="stylesheet" href="{{asset('css/order.css')}}" />
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/custom/filepond/filepond.css')}}" rel="stylesheet" />
<link href="{{asset('plugins/custom/filepond/filepond-plugin-image-preview.css')}}" rel="stylesheet" />
<link href="{{asset('plugins/custom/filepond/filepond-plugin-get-file.css')}}" rel="stylesheet" />
<!--end::Vendor Stylesheets-->
@stop

@section('pagespecificscripts')
@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validation-unobtrusive/4.0.0/jquery.validate.unobtrusive.min.js"
    integrity="sha512-xq+Vm8jC94ynOikewaQXMEkJIOBp7iArs3IhFWSWdRT3Pq8wFz46p+ZDFAR7kHnSFf+zUv52B3prRYnbDRdgog=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
<script defer src="https://unpkg.com/alpinejs@3.2.4/dist/cdn.min.js"></script>
<!--end::Vendors Javascript-->
<script src="{{asset('js/custom/apps/orders/main.js')}}"></script>
<script src="{{asset('js/custom/apps/orders/edit.js')}}"></script>
@stop