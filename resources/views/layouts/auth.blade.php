<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="description" content="{{env('APP_NAME')}} CRM application" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="{{env('APP_NAME')}} | Revolutionizing your business operations through comprehensive fulfillment and shipping services." />
    <meta property="og:url" content="{{env('APP_URL')}}" />
    <meta property="og:site_name" content="{{env('APP_NAME')}} | Auth" />
    <link rel="canonical" href="{{env('APP_URL')}}" />
    <link rel="shortcut icon" href="{{asset('media/logos/favicon.ico')}}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{asset('plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank app-blank">
    <!--begin::Theme mode setup on page load-->
    <script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-theme-mode");
        } else {
            if (localStorage.getItem("data-theme") !== null) {
                themeMode = localStorage.getItem("data-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-theme", themeMode);
    }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        @yield('content')
    </div>
    <!--end::Root-->
    <!--begin::Javascript-->
    <script>
    var hostUrl = "";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{asset('plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('js/scripts.bundle.js')}}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Page-specific Javascript -->
    @yield('pagespecificscripts')
    <!--end::Custom Page-specific Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->
<style>
.btn-theme {
    background-color: #FF004F;
    color: white !important;
    padding-left: 30px !important;
    padding-right: 30px !important;
}

.btn-theme:hover,
.btn-theme:focus,
.btn-theme:active {
    color: white !important;
    background-color: #FF004F !important;
}

@media (max-width: 992px) {
    .auth_asde_img {
        display: none;
    }
}
</style>

</html>