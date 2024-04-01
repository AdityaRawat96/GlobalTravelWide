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
                <h1 class="page-heading d-flex fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ str_pad($reminder->id, 5, '0', STR_PAD_LEFT) }}
                </h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="/" class="text-primary text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Reminders</li>
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
            <!--begin::Basic info-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Reminder Details</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div class="content">
                    <!--begin::Form-->
                    <form class="form"
                        action="{{isset($reminder) ? route(Auth::user()->role . '.reminder.update', $reminder->id) : route(Auth::user()->role . '.reminder.store')}}"
                        id="kt_create_form" method="{{isset($reminder) ? 'PUT' : 'POST'}}">
                        @csrf
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label
                                    class="col-lg-4 col-form-label required fw-semibold fs-6 required">Customer</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Input group-->
                                    <div class="mb-5 fv-row">
                                        <input id="customer_name" type="text" class="form-control form-control-solid"
                                            value="{{isset($reminder) ? $reminder->customer->name : null}}"
                                            placeholder="Customer Name" disabled />
                                    </div>
                                    <!--end::Input group-->
                                    <div class="customer_details {{isset($reminder) ? '' : 'd-none'}}">
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input id="customer_email" type="text"
                                                class="form-control form-control-solid"
                                                value="{{isset($reminder) ? $reminder->customer->email : null}}"
                                                placeholder="Customer Email" disabled />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input id="customer_phone" type="text"
                                                class="form-control form-control-solid"
                                                value="{{isset($reminder) ? $reminder->customer->phone : null}}"
                                                placeholder="Customer Phone" disabled />
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Date</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="date" id="reminder_date"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        placeholder="Pick date & time"
                                        value="{{isset($reminder->date) ? $reminder->date : null}}" disabled />
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Description</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <textarea name="notes" class="form-control form-control-lg form-control-solid"
                                        rows="3" placeholder="Description"
                                        disabled>{{isset($reminder->notes) ? $reminder->notes : null}}</textarea>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card body-->
                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="reset"
                                class="reset btn btn-light btn-active-light-primary me-2">Discard</button>
                            <a href="{{route(Auth::user()->role . '.reminder.edit', $reminder->id)}}"
                                class="btn btn-primary">Edit</a>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Basic info-->
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
@stop

@section('pagespecificscripts')
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('js/reminder/show.js')}}"></script>
<!--end::Custom Javascript-->
@stop