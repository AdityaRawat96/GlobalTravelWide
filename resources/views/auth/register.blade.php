@extends('layouts.auth')

@section('content')

<!--begin::Authentication - Sign-up -->
<div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!--begin::Body-->
    <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
        <!--begin::Form-->
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10">
                <!--begin::Form-->
                <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" action="{{route('register')}}" method="POST">
                    @csrf
                    <!--begin::Heading-->
                    <div class="text-center mb-11">
                        <!--begin::Title-->
                        <h1 class="text-dark fw-bolder mb-3">Sign Up</h1>
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <!-- <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div> -->
                        <!--end::Subtitle=-->
                    </div>
                    <!--begin::Heading-->
                    <!--begin::Login options-->
                    <!-- <div class="row g-3 mb-9"> -->
                    <!--begin::Col-->
                    <!-- <div class="col-md-6"> -->
                    <!--begin::Google link=-->
                    <!-- <a href="#"
                                class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                <img alt="Logo" src="media/svg/brand-logos/google-icon.svg"
                                    class="h-15px me-3" />Sign in with Google</a> -->
                    <!--end::Google link=-->
                    <!-- </div> -->
                    <!--end::Col-->
                    <!--begin::Col-->
                    <!-- <div class="col-md-6"> -->
                    <!--begin::Google link=-->
                    <!-- <a href="#"
                                class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                <img alt="Logo" src="media/svg/brand-logos/apple-black.svg"
                                    class="theme-light-show h-15px me-3" />
                                <img alt="Logo" src="media/svg/brand-logos/apple-black-dark.svg"
                                    class="theme-dark-show h-15px me-3" />Sign in with Apple</a> -->
                    <!--end::Google link=-->
                    <!-- </div> -->
                    <!--end::Col-->
                    <!-- </div> -->
                    <!--end::Login options-->
                    <!--begin::Separator-->
                    <!-- <div class="separator separator-content my-14">
                        <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
                    </div> -->
                    <!--end::Separator-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="text" placeholder="First Name" name="first_name" autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Email-->
                    </div>
                    <!--begin::Input group-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="text" placeholder="Last Name" name="last_name" autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Email-->
                    </div>
                    <!--begin::Input group-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Email-->
                    </div>
                    <!--begin::Input group-->
                    <div class="fv-row mb-8" data-kt-password-meter="true">
                        <!--begin::Wrapper-->
                        <div class="mb-1">
                            <!--begin::Input wrapper-->
                            <div class="position-relative mb-3">
                                <input class="form-control bg-transparent" type="password" placeholder="Password" name="password" autocomplete="off" />
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                            </div>
                            <!--end::Input wrapper-->
                            <!--begin::Meter-->
                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                            <!--end::Meter-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Hint-->
                        <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
                        <!--end::Hint-->
                    </div>
                    <!--end::Input group=-->
                    <!--end::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Repeat Password-->
                        <input placeholder="Repeat Password" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Repeat Password-->
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Accept-->
                    <div class="fv-row mb-8">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="toc" value="1" />
                            <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">I Accept the
                                <a href="#" class="ms-1 link-primary">Terms</a></span>
                        </label>
                    </div>
                    <!--end::Accept-->
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_up_submit" class="btn btn-theme">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">Sign up</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </button>
                    </div>
                    <!--end::Submit button-->
                    <!--begin::Sign up-->
                    <div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account?
                        <a href="{{route('login')}}" class="link-primary fw-semibold">Sign in</a>
                    </div>
                    <!--end::Sign up-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Form-->

    </div>
    <!--end::Body-->
    <!--begin::Aside-->
    <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url(media/misc/auth-bg.png)">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
            <!--begin::Logo-->
            <a href="/" class="mb-15">
                <img alt="Logo" src="{{asset('media/logos/logo.png')}}" class="h-60px h-lg-80px" />
            </a>
            <!--end::Logo-->
            <!--begin::Image-->
            <img src="media/auth/sign_up.svg" class="auth_asde_img mt-15" alt="auth image" style="max-width: 600px;" />
            <!--end::Image-->
            <!--begin::Title-->
            <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7 mt-10">Fast, Efficient and
                Productive</h1>
            <!--end::Title-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Aside-->
</div>
<!--end::Authentication - Sign-up-->

@endsection

@section('pagespecificscripts')
<!--begin::Custom Javascript(used for this page only)-->
<script src="js/custom/authentication/sign-up/general.js"></script>
<!--end::Custom Javascript-->
@stop