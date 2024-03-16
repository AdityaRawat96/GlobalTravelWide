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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Wallet
                    Details</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="#" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Wallet</li>
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
            <!--begin::Navbar-->
            <div class="card mb-5 mb-xl-10 card bg-primary">
                <div class="card-body pt-9 pb-0">
                    <div class="row">
                        <div class="col-12">
                            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Shopping/Wallet.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#FFF" opacity="0.3" cx="20.5" cy="12.5" r="1.5" />
                                        <rect fill="#FFF" opacity="0.3" transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) " x="3" y="3" width="18" height="7" rx="1" />
                                        <path d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z" fill="#FFF" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <div class="text-white fw-bold fs-2 mb-2 mt-5 wallet_balance_label">
                                $ {{number_format($data["wallet_balance"], 2)}}
                            </div>
                            <div class="fw-semibold text-white">Wallet Balance</div>
                        </div>
                    </div>
                    <!--begin::Navs-->
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold" style="justify-content: end;">
                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link nav-link-wallet-tab ms-0 me-10 py-5 active" href="" data-target="#wallet-tab-billing">Add Funds</a>
                        </li>
                        <!--end::Nav item-->
                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link nav-link-wallet-tab ms-0 me-10 py-5" href="" data-target="#wallet-tab-transactions">Transactions</a>
                        </li>
                        <!--end::Nav item-->
                    </ul>
                    <!--begin::Navs-->
                </div>
            </div>
            <!--end::Navbar-->

            <div class="wallet-sections-tabs">
                <div class="wallet-sections-tab-container" id="wallet-tab-billing">
                    @include('user.wallet.tabs.billing')
                </div>
                <div class="wallet-sections-tab-container d-none" id="wallet-tab-transactions">
                    @include('user.wallet.tabs.transactions')
                </div>
            </div>

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
@include('user.wallet.modals.view_transaction_modal')
@stop

@section('pagespecificstyles')
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
<!--end::Vendor Stylesheets-->
<link href="{{asset('css/wallet.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('pagespecificscripts')
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('plugins/custom/datatables/responsive.bootstrap.min.js')}}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('js/widgets.bundle.js')}}"></script>
<script src="{{asset('js/custom/widgets.js')}}"></script>

<!-- <script src="{{asset('js/custom/pages/user-profile/general.js')}}"></script>
<script src="{{asset('js/custom/account/billing/general.js')}}"></script> -->
<script src="{{asset('js/custom/utilities/modals/new-card.js')}}"></script>
<script src="{{asset('js/custom/utilities/modals/new-address.js')}}"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="{{asset('js/custom/apps/wallet/main.js')}}"></script>
<!--end::Custom Javascript-->
@stop