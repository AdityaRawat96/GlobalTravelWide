<!--begin::Step 0-->
<div class="{{$currentStep == 0 ? 'current' : ''}}" data-kt-stepper-element="content">
    <!--begin::Main column-->
    <!--begin::Order details-->
    <div class="card py-4 w-100">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Select Country</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <form action="#" id="validate_country_form" method="POST">
                <!-- begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                        <span class="required">Select Country</span>
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                            title="Select Country to make results more effective"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="country-id" aria-label="Select a Country" data-placeholder="Select a country..."
                        class="form-select form-select-solid form-select-lg fw-semibold" wire:model="country_id">
                        <option value="">Select country</option>
                        @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>
                <!-- end::Input group-->
            </form>


        </div>
        <!--end::Card header-->
    </div>
    <!--end::Order details-->
    <!--end::Main column-->
</div>
<!--end::Step 0-->