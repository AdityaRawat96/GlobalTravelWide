@extends('layouts.auth')

@section('content')
<!--begin::Authentication - Sign-in -->
<div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!--begin::Body-->
    <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
        <!--begin::Form-->
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10">
                <!--begin::Form-->
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('login') }}"
                    method="POST">
                    @csrf
                    <!--begin::Heading-->
                    <div class="text-center mb-11">
                        <!--begin::Title-->
                        <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                        <!--end::Title-->
                    </div>
                    <!--begin::Heading-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="email" placeholder="Email / Username" name="email" autocomplete="email"
                            class="form-control bg-transparent" value="{{ old('email') }}" />
                        @if ($errors->has('username') || $errors->has('email'))
                        <div class="fv-plugins-message-container invalid-feedback invalid-feedback-email">
                            <div data-field="email" data-validator="regexp">
                                {{ $errors->first('username') ?: $errors->first('email') }}
                            </div>
                        </div>
                        @endif
                        <!--end::Email-->
                    </div>
                    <!--end::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Password-->
                        <input type="password" placeholder="Password" name="password" autocomplete="off"
                            class="form-control bg-transparent" />
                        @error('password')
                        <div class="fv-plugins-message-container invalid-feedback invalid-feedback-password">
                            <div data-field="password" data-validator="regexp">{{ $message }}</div>
                        </div>
                        @enderror
                        <!--end::Password-->
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Accept-->
                    <div class="fv-row mb-8">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="remember" />
                            <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">Remember me</span>
                        </label>
                    </div>
                    <!--end::Accept-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                        <div></div>
                        <!--begin::Link-->
                        <a href="password/reset" class="link-primary">Forgot Password ?</a>
                        <!--end::Link-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">Sign In</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </button>
                    </div>
                    <!--end::Submit button-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Form-->

    </div>
    <!--end::Body-->
    <!--begin::Aside-->
    <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
        style="background-image: url(media/misc/auth-bg.png)">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
            <!--begin::Logo-->
            <a href="/" class="mb-15">
                <img alt="Logo" src="{{asset('media/logos/logo.png')}}" class="h-60px h-lg-80px" />
            </a>
            <!--end::Logo-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Aside-->
</div>
<!--end::Authentication - Sign-in-->
@endsection

@section('pagespecificscripts')
<!--begin::Custom Javascript(used for this page only)-->
<script src="js/custom/authentication/sign-in/general.js"></script>
<!--end::Custom Javascript-->
@stop