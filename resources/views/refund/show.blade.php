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
                    {{ str_pad($refund->refund_id, 5, '0', STR_PAD_LEFT) }}
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
                    <li class="breadcrumb-item text-muted">Refunds</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                @if($refund->currency == 'pkr')
                @if($refund->type == 'Office Refund')
                <a href="{{ env('APP_URL') . '/' . Auth::user()->role . '/refund/' . $refund->id . '?currency=pkr' }}">
                    <button class="btn btn-primary btn-sm">Customer copy</button>
                </a>
                @else
                <a href="{{ env('APP_URL') . '/' . Auth::user()->role . '/refund/' . $refund->id }}">
                    <button class="btn btn-primary btn-sm">Office copy</button>
                </a>
                @endif
                @endif
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
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xxl-row">
                <!--begin::Content-->
                <div class="flex-xxl-row-fluid mb-10 mb-xxl-0 me-xxl-7 me-xxxl-10">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body p-12">
                            @include('pdf.refund', ['refund' => $refund, 'refund_products' => $refund_products,
                            'refund_payments' => $refund_payments, 'view' => true])
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
                <!--begin::Sidebar-->
                <div class="flex-xxl-auto min-w-xxl-300px">
                    <!--begin::Card-->
                    <div class="card card-sticky">
                        <!--begin::Card body-->
                        <div class="card-body p-10">
                            @if($refund->notes)
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label fw-bold fs-6 text-gray-700">Notes</label>
                                <!--end::Label-->
                                <p>
                                    {{$refund->notes}}
                                </p>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Separator-->
                            <div class="separator separator-dashed mb-8"></div>
                            <!--end::Separator-->
                            @endif
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
                                                        <a href="#" class="dropzone-filename d-block" title="some_image_file_name.jpg">
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
                                        @if(count($refund_attachments) == 0)
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
                                        <a href="#" class="btn btn-light btn-active-light-primary w-100 reset">Dismiss</a>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col">
                                        @if($refund->type == 'Office Refund')
                                        <a href="{{ '/' . Auth::user()->role . '/refund/showPdf/' . $refund->id }}" class="btn btn-primary btn-active-light-primary w-100">
                                            Download
                                        </a>
                                        @else
                                        <a href="{{ '/' . Auth::user()->role . '/refund/showPdf/' . $refund->id . '?currency=pkr' }}" class="btn btn-primary btn-active-light-primary w-100">
                                            Download
                                        </a>
                                        @endif
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Secondary button-->
                                <a href="{{'/' . Auth::user()->role . '/refund/' . $refund->id}}" class="btn fw-bold btn-danger w-100" id="delete-refund">Delete</a>
                                <!--end::Secondary button-->
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
@stop

@section('pagespecificstyles')
@stop

@section('pagespecificscripts')
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('js/refund/show.js')}}"></script>
<!--end::Custom Javascript-->
@foreach ($refund_attachments as $attach)
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