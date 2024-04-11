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
                    Attendance
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
                    <li class="breadcrumb-item text-muted">Attendance</li>
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
            <div class="d-flex flex-column flex-xxl-row">
                <!--begin::Content-->
                <div class="flex-xxl-row-fluid mb-10 mb-xxl-0 me-xxl-7 me-xxxl-10">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <h2 class="card-title fw-bold">Calendar</h2>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Calendar-->
                            <div id="kt_calendar_app"></div>
                            <!--end::Calendar-->
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
                                <label class="form-label fw-bold fs-6 text-gray-700">Attendance:
                                    {{ $formattedDate }}</label>
                                <!--end::Label-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Row-->
                            <div class="d-flex align-items-center mb-2">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs050.svg-->
                                <span class="svg-icon svg-icon-1 svg-icon-{{ isset($attendance->in_time) ? 'success' : 'danger' }} me-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <circle fill="currentColor" cx="12" cy="12" r="8" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Event start date/time-->
                                <div class="fs-6">
                                    <span class="fw-bold">In-Time :</span>
                                    <span data-kt-calendar="event_start_date">
                                        @if(isset($attendance->in_time) )
                                        {{ $attendance->in_time }}
                                        @else
                                        <span class="badge badge-light-danger">Not Marked</span>
                                        @endif
                                    </span>
                                </div>
                                <!--end::Event start date/time-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="d-flex align-items-center mb-9">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs050.svg-->
                                <span class="svg-icon svg-icon-1 svg-icon-{{ isset($attendance->out_time) ? 'success' : 'danger' }} me-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <circle fill="currentColor" cx="12" cy="12" r="8" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Event end date/time-->
                                <div class="fs-6">
                                    <span class="fw-bold">Out-Time:</span>
                                    <span data-kt-calendar="event_end_date">
                                        @if(isset($attendance->out_time))
                                        {{ $attendance->out_time }}
                                        @else
                                        <span class="badge badge-light-danger">Not Marked</span>
                                        @endif
                                    </span>
                                </div>
                                <!--end::Event end date/time-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Separator-->
                            <div class="separator separator-dashed mb-8"></div>
                            <!--end::Separator-->
                            <!--begin::Actions-->
                            <div class="mb-0">
                                <!--begin::Row-->
                                <div class="row mb-5">
                                    @if(!isset($attendance->in_time) || !isset($attendance->out_time))
                                    <!--begin::Col-->
                                    <div class="col">
                                        <!--begin::Form-->
                                        <form class="form" action="{{isset($attendance) ? route(Auth::user()->role . '.attendance.update', $attendance->id) : route(Auth::user()->role . '.attendance.store')}}" id="kt_create_form" method="{{isset($attendance) ? 'PUT' : 'POST'}}" enctype="multipart/form-data">
                                            @csrf
                                            <button type="button" id="kt_form_submit" class="btn btn-primary w-100">
                                                <span class="indicator-label">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen016.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z" fill="currentColor" />
                                                            <path opacity="0.3" d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    Mark {{isset($attendance->in_time) ? 'Out' : 'In'}} time
                                                </span>
                                                </span>
                                                <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </form>
                                    </div>
                                    <!--end::Col-->
                                    @endif

                                    @if(isset($attendance->in_time) && isset($attendance->out_time))
                                    <!--begin::Col-->
                                    <div class="col">
                                        <div class="bg-light-primary rounded border-primary border border-dashed p-5">
                                            <div class="d-flex align-items-center mb-2">
                                                <!--begin::Event start date/time-->
                                                <div class="fs-6">
                                                    <span class="fw-bold">Total Time:</span><br>
                                                    <span>
                                                        {{ $attendance->duration }}
                                                    </span>
                                                </div>
                                                <!--end::Event start date/time-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Col-->
                                    @endif
                                </div>
                                <!--end::Row-->
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
@include('attendance.modals.addEvents')
@include('attendance.modals.viewEvents')
@stop


@section('pagespecificstyles')
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
<!--end::Vendor Stylesheets-->
@stop

@section('pagespecificscripts')
<script>
    let ATTENDANCE_DATA = @json($attendances);
</script>

<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('js/attendance/index.js')}}"></script>
<script src="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<!--end::Custom Javascript-->
@stop