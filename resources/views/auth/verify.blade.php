@extends('layouts.auth')

@section('content')
<!--begin::Page bg image-->
<style>
body {
    background-image: url("{{ asset('media/auth/bg5.jpg') }}");
}

[data-theme="dark"] body {
    background-image: url("{{ asset('media/auth/bg5-dark.jpg') }}")
}
</style>
<!--end::Page bg image-->
<!--begin::Authentication - Signup Welcome Message -->
<div class="d-flex flex-column flex-center flex-column-fluid">
    <!--begin::Content-->
    <div class="d-flex flex-column flex-center text-center p-10">
        <!--begin::Wrapper-->
        <div class="card card-flush w-lg-650px py-5">
            <div class="card-body py-15 py-lg-20">
                <!--begin::Logo-->
                <div class="mb-14">
                    <a href="{{route('home')}}" class="">
                        <img alt="Logo" src="{{asset('media/logos/logo.png')}}" class="h-40px" />
                    </a>
                </div>
                <!--end::Logo-->
                <!--begin::Title-->
                <h1 class="fw-bolder text-gray-900 mb-5">Verify your email</h1>
                <!--end::Title-->

                @if (!session('resent'))
                <!--begin::Action-->
                <div class="fs-6 mb-8">
                    <span class="fw-semibold text-gray-500">Did’t receive an email?</span>
                    <br><br>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">Send again</button>
                    </form>
                </div>
                <!--end::Action-->
                @endif
                @if (session('resent'))
                <div class="mb-8">
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                </div>
                @endif

                <!--begin::Illustration-->
                <div class="mb-0">
                    <img src="{{asset('media/auth/please-verify-your-email.png')}}"
                        class="mw-100 mh-300px theme-light-show" alt="" />
                    <img src="{{asset('media/auth/please-verify-your-email-dark.png')}}"
                        class="mw-100 mh-300px theme-dark-show" alt="" />
                </div>
                <!--end::Illustration-->
            </div>
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Content-->
</div>
<!--end::Authentication - Signup Welcome Message-->
@endsection