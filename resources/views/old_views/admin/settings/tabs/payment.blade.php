<!--begin::Basic info-->
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_settings_details" aria-expanded="true" aria-controls="kt_account_settings_details">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Payment Details</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Content-->
    <div id="kt_account_settings_settings_details" class="collapse show">
        <!--begin::Form-->
        <form class="form" action="{{route('admin.settings.update')}}" id="kt_account_settings_details_form"
            method="POST">
            @csrf
            <input name="type" value="payment" hidden />
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Label Group-->
                <div class="row mt-5 mb-6">
                    <div class="col-12">
                        <h4>Bank Transfer:</h4>
                    </div>
                </div>
                <!--end::Label Group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Bank Name</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="bank_name" class="form-control form-control-lg form-control-solid"
                            value="{{isset($settings['payment']) ? $settings['payment']->bank_name : ''}}" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">SWIFT Code</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="swift_code" class="form-control form-control-lg form-control-solid"
                            value="{{isset($settings['payment']) ? $settings['payment']->swift_code : ''}}" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Bank Address</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <textarea name="bank_address" class="form-control form-control-lg form-control-solid"
                            rows="3">{{isset($settings['payment']) ? $settings['payment']->bank_address : ''}}</textarea>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Recipient Name</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="recipient_name" class="form-control form-control-lg form-control-solid"
                            value="{{isset($settings['payment']) ? $settings['payment']->recipient_name : ''}}" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Routing Number</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="routing_number" class="form-control form-control-lg form-control-solid"
                            value="{{isset($settings['payment']) ? $settings['payment']->routing_number : ''}}" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Account Number</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="account_number" class="form-control form-control-lg form-control-solid"
                            value="{{isset($settings['payment']) ? $settings['payment']->account_number : ''}}" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="recipient_email"
                            class="form-control form-control-lg form-control-solid"
                            value="{{isset($settings['payment']) ? $settings['payment']->recipient_email : ''}}" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Phone</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="recipient_phone"
                            class="form-control form-control-lg form-control-solid"
                            value="{{isset($settings['payment']) ? $settings['payment']->recipient_phone : ''}}" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Address</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <textarea name="recipient_address" class="form-control form-control-lg form-control-solid"
                            rows="3">{{isset($settings['payment']) ? $settings['payment']->recipient_address : ''}}</textarea>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Label Group-->
                <div class="row mt-5 mb-6">
                    <div class="col-12">
                        <h4>Payoneer:</h4>
                    </div>
                </div>
                <!--end::Label Group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Payoneer Account</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="PAYONEER_ACCOUNT"
                            class="form-control form-control-lg form-control-solid"
                            value="{{isset($settings['payment']) ? $settings['payment']->PAYONEER_ACCOUNT : ''}}" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                    onclick="window.location.reload()">Discard</button>
                <button type="submit" id="kt_account_settings_details_submit" class="btn btn-primary">
                    <span class="indicator-label">Save
                        Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->