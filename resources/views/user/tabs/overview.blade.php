<!--begin::details View-->
<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <!--begin::Card header-->
    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Card body-->
    <div class="card-body p-9">
        <!--begin::Row-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{$user->first_name}}
                    {{$user->last_name}}</span>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Input group-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Email<i class="fas fa-exclamation-circle ms-1 fs-7"
                    data-bs-toggle="tooltip" title="Phone number must be active"></i></label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-8 d-flex align-items-center">
                <span class="fw-bold fs-6 text-gray-800 me-2">{{$user->email}}</span>
                <span class="badge badge-success">Verified</span>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Contact Phone
            </label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-8 d-flex align-items-center">
                <span class="fw-bold fs-6 text-gray-800 me-2">{{isset($user->phone) ? $user->phone : '-'}}</span>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Notes</label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{$user->notes}}</span>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Attachments</label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-4">
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
                @if(count($user_attachments) == 0)
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
</div>
<!--end::details View-->

<!--begin::Sign-in Method-->
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_signin_method">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Sign-in Method</h3>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Content-->
    <div id="kt_account_settings_signin_method" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body border-top p-9">
            <!--begin::Password-->
            <div class="d-flex flex-wrap align-items-center mb-10">
                <!--begin::Label-->
                <div id="kt_signin_password">
                    <div class="fs-6 fw-bold mb-1">Password</div>
                    <div class="fw-semibold text-gray-600">************</div>
                </div>
                <!--end::Label-->
                <!--begin::Edit-->
                <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                    <!--begin::Form-->
                    <form class="form" action="{{route(Auth::user()->role.'.user.updatePassword', $user->id)}}"
                        id="kt_signin_change_password" method="POST">
                        @csrf
                        <div class="row mb-1">
                            <div class="col-lg-4">
                                <div class="fv-row mb-8" data-kt-password-meter="true">
                                    <!--begin::Wrapper-->
                                    <div class="mb-1">
                                        <label for="password" class="form-label fs-6 fw-bold mb-3">New Password</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid"
                                            name="password" id="password" />
                                        <!--begin::Meter-->
                                        <div class="d-flex align-items-center mt-3 mb-3"
                                            data-kt-password-meter-control="highlight">
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                            </div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                            </div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                            </div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                        </div>
                                        <!--end::Meter-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Hint-->
                                    <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &
                                        symbols.</div>
                                    <!--end::Hint-->
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Confirm New
                                        Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid"
                                        name="confirmpassword" id="confirmpassword" />
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button type="button" id="kt_password_submit" class="btn btn-primary">
                                <span class="indicator-label">Update Password</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <button id="kt_password_cancel" type="button"
                                class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Edit-->
                <!--begin::Action-->
                <div id="kt_signin_password_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-primary">Reset Password</button>
                </div>
                <!--end::Action-->
            </div>
            <!--end::Password-->

        </div>
        <!--end::Card body-->
    </div>
    <!--end::Content-->
</div>
<!--end::Sign-in Method-->