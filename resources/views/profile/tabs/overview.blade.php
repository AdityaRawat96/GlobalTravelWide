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
                <span class="fw-bold fs-6 text-gray-800">{{$data["user"]->first_name}}
                    {{$data["user"]->last_name}}</span>
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
                <span class="fw-bold fs-6 text-gray-800 me-2">{{$data['user']->email}}</span>
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
                <span
                    class="fw-bold fs-6 text-gray-800 me-2">{{isset($data['user']->phone) ? $data['user']->phone : '-'}}</span>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Card body-->
</div>
<!--end::details View-->