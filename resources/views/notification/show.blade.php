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
                    {{ str_pad($notification->id, 5, '0', STR_PAD_LEFT) }}
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
                    <li class="breadcrumb-item text-muted">Notifications</li>
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
                        <h3 class="fw-bold m-0">Notification Details</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div class="content">
                    <!--begin::Form-->
                    <form class="form"
                        action="{{isset($notification) ? route(Auth::user()->role . '.notification.update', $notification->id) : route(Auth::user()->role . '.notification.store')}}"
                        id="kt_create_form" method="{{isset($notification) ? 'PUT' : 'POST'}}">
                        @csrf
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Date</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="date" id="notification_date"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        placeholder="Pick date & time"
                                        value="{{isset($notification->date) ? $notification->date : null}}" disabled />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Title</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="title" id="title"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        placeholder="Notification title"
                                        value="{{isset($notification->title) ? $notification->title : null}}"
                                        disabled />
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
                                    <textarea name="description" class="form-control form-control-lg form-control-solid"
                                        rows="3" placeholder="Description"
                                        disabled>{{isset($notification->description) ? $notification->description : null}}</textarea>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    Attachments
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <!--begin::Dropzone-->
                                    <div class="dropzone dropzone-queue mb-2" id="kt_dropzonejs">
                                        <!--begin::Controls-->
                                        <div class="dropzone-panel mb-lg-0 mb-2 d-none">
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
                                            </div>
                                        </div>
                                        <!--end::Items-->
                                    </div>
                                    <!--end::Dropzone-->
                                    @if(count($notification_attachments) == 0)
                                    <!--begin::Hint-->
                                    <span class="form-text text-muted">
                                        No attachments found.
                                    </span>
                                    <!--end::Hint-->
                                    @endif
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
                            <a href="{{route(Auth::user()->role . '.notification.edit', $notification->id)}}"
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
<script src="{{asset('js/notification/show.js')}}"></script>
<!--end::Custom Javascript-->
@foreach ($notification_attachments as $attach)
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
@stop