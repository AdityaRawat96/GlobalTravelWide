<div>
    <!--begin::Stepper-->

    <div class="stepper stepper-links d-flex flex-column " id="kt_create_account_stepper"
        id="kt_modal_create_app_stepper">
        <!--begin::Nav-->
        <div class="stepper-nav mb-5">

            <!--begin::Step 1-->
            <div class="stepper-item {{$currentStep == 0 ? 'current' : ''}}" data-kt-stepper-element="nav"
                wire:click="setCurrentStep(0)">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-01-30-131017/core/html/src/media/icons/duotune/maps/map004.svg-->
                        <span
                            class="stepper-check svg-icon svg-icon-muted svg-icon-2hx {{$currentStep == 0 ? 'text-primary' : ''}}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M18.4 5.59998C21.9 9.09998 21.9 14.8 18.4 18.3C14.9 21.8 9.2 21.8 5.7 18.3L18.4 5.59998Z"
                                    fill="currentColor" />
                                <path
                                    d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM19.9 11H13V8.8999C14.9 8.6999 16.7 8.00005 18.1 6.80005C19.1 8.00005 19.7 9.4 19.9 11ZM11 19.8999C9.7 19.6999 8.39999 19.2 7.39999 18.5C8.49999 17.7 9.7 17.2001 11 17.1001V19.8999ZM5.89999 6.90002C7.39999 8.10002 9.2 8.8 11 9V11.1001H4.10001C4.30001 9.4001 4.89999 8.00002 5.89999 6.90002ZM7.39999 5.5C8.49999 4.7 9.7 4.19998 11 4.09998V7C9.7 6.8 8.39999 6.3 7.39999 5.5ZM13 17.1001C14.3 17.3001 15.6 17.8 16.6 18.5C15.5 19.3 14.3 19.7999 13 19.8999V17.1001ZM13 4.09998C14.3 4.29998 15.6 4.8 16.6 5.5C15.5 6.3 14.3 6.80002 13 6.90002V4.09998ZM4.10001 13H11V15.1001C9.1 15.3001 7.29999 16 5.89999 17.2C4.89999 16 4.30001 14.6 4.10001 13ZM18.1 17.1001C16.6 15.9001 14.8 15.2 13 15V12.8999H19.9C19.7 14.5999 19.1 16.0001 18.1 17.1001Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title">
                            Country
                        </h3>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Step 1-->

            <!--begin::Step 2-->
            <div class="stepper-item {{$currentStep == 1 ? 'current' : ''}}" data-kt-stepper-element="nav"
                wire:click="setCurrentStep(1)">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-01-30-131017/core/html/src/media/icons/duotune/ecommerce/ecm001.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx {{$currentStep == 1 ? 'text-primary' : ''}}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M18.041 22.041C18.5932 22.041 19.041 21.5932 19.041 21.041C19.041 20.4887 18.5932 20.041 18.041 20.041C17.4887 20.041 17.041 20.4887 17.041 21.041C17.041 21.5932 17.4887 22.041 18.041 22.041Z"
                                    fill="currentColor" />
                                <path opacity="0.3"
                                    d="M6.04095 22.041C6.59324 22.041 7.04095 21.5932 7.04095 21.041C7.04095 20.4887 6.59324 20.041 6.04095 20.041C5.48867 20.041 5.04095 20.4887 5.04095 21.041C5.04095 21.5932 5.48867 22.041 6.04095 22.041Z"
                                    fill="currentColor" />
                                <path opacity="0.3"
                                    d="M7.04095 16.041L19.1409 15.1409C19.7409 15.1409 20.141 14.7409 20.341 14.1409L21.7409 8.34094C21.9409 7.64094 21.4409 7.04095 20.7409 7.04095H5.44095L7.04095 16.041Z"
                                    fill="currentColor" />
                                <path
                                    d="M19.041 20.041H5.04096C4.74096 20.041 4.34095 19.841 4.14095 19.541C3.94095 19.241 3.94095 18.841 4.14095 18.541L6.04096 14.841L4.14095 4.64095L2.54096 3.84096C2.04096 3.64096 1.84095 3.04097 2.14095 2.54097C2.34095 2.04097 2.94096 1.84095 3.44096 2.14095L5.44096 3.14095C5.74096 3.24095 5.94096 3.54096 5.94096 3.84096L7.94096 14.841C7.94096 15.041 7.94095 15.241 7.84095 15.441L6.54096 18.041H19.041C19.641 18.041 20.041 18.441 20.041 19.041C20.041 19.641 19.641 20.041 19.041 20.041Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title">
                            Products
                        </h3>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Step 2-->

            <!--begin::Step 3-->
            <div class="stepper-item {{$currentStep == 2 ? 'current' : ''}}" data-kt-stepper-element="nav"
                wire:click="setCurrentStep(2)">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-01-30-131017/core/html/src/media/icons/duotune/ecommerce/ecm007.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx {{$currentStep == 2 ? 'text-primary' : ''}}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9ZM10 8H4C3.4 8 3 8.4 3 9V11C3 11.6 3.4 12 4 12H10V8Z"
                                    fill="currentColor" />
                                <path d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z"
                                    fill="currentColor" />
                                <path opacity="0.3"
                                    d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2ZM4 12V21C4 21.6 4.4 22 5 22H10V12H4ZM20 12V21C20 21.6 19.6 22 19 22H14V12H20Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title">
                            Boxes
                        </h3>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Step 3-->

            <!--begin::Step 4-->
            <div class="stepper-item {{$currentStep == 3 ? 'current' : ''}}" data-kt-stepper-element="nav"
                wire:click="setCurrentStep(3)">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-01-30-131017/core/html/src/media/icons/duotune/layouts/lay002.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx {{$currentStep == 3 ? 'text-primary' : ''}}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 7H3C2.4 7 2 6.6 2 6V3C2 2.4 2.4 2 3 2H6C6.6 2 7 2.4 7 3V6C7 6.6 6.6 7 6 7Z"
                                    fill="currentColor" />
                                <path opacity="0.3"
                                    d="M13 7H10C9.4 7 9 6.6 9 6V3C9 2.4 9.4 2 10 2H13C13.6 2 14 2.4 14 3V6C14 6.6 13.6 7 13 7ZM21 6V3C21 2.4 20.6 2 20 2H17C16.4 2 16 2.4 16 3V6C16 6.6 16.4 7 17 7H20C20.6 7 21 6.6 21 6ZM7 13V10C7 9.4 6.6 9 6 9H3C2.4 9 2 9.4 2 10V13C2 13.6 2.4 14 3 14H6C6.6 14 7 13.6 7 13ZM14 13V10C14 9.4 13.6 9 13 9H10C9.4 9 9 9.4 9 10V13C9 13.6 9.4 14 10 14H13C13.6 14 14 13.6 14 13ZM21 13V10C21 9.4 20.6 9 20 9H17C16.4 9 16 9.4 16 10V13C16 13.6 16.4 14 17 14H20C20.6 14 21 13.6 21 13ZM7 20V17C7 16.4 6.6 16 6 16H3C2.4 16 2 16.4 2 17V20C2 20.6 2.4 21 3 21H6C6.6 21 7 20.6 7 20ZM14 20V17C14 16.4 13.6 16 13 16H10C9.4 16 9 16.4 9 17V20C9 20.6 9.4 21 10 21H13C13.6 21 14 20.6 14 20ZM21 20V17C21 16.4 20.6 16 20 16H17C16.4 16 16 16.4 16 17V20C16 20.6 16.4 21 17 21H20C20.6 21 21 20.6 21 20Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title">
                            Services
                        </h3>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Step 4-->
            <!--begin::Step 5-->
            <div class="stepper-item {{$currentStep == 4 ? 'current' : ''}}" data-kt-stepper-element="nav"
                wire:click="setCurrentStep(4)">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-01-30-131017/core/html/src/media/icons/duotune/files/fil013.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx {{$currentStep == 4 ? 'text-primary' : ''}}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                                <path
                                    d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.2C9.7 3 10.2 3.20001 10.4 3.60001ZM16 12H13V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V12H8C7.4 12 7 12.4 7 13C7 13.6 7.4 14 8 14H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z"
                                    fill="currentColor" />
                                <path opacity="0.3"
                                    d="M11 14H8C7.4 14 7 13.6 7 13C7 12.4 7.4 12 8 12H11V14ZM16 12H13V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title">
                            Labels
                        </h3>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Step 5-->
            <!--begin::Step 6-->
            <div class="stepper-item {{$currentStep == 5 ? 'current' : ''}}" data-kt-stepper-element="nav"
                wire:click="setCurrentStep(5)">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-01-30-131017/core/html/src/media/icons/duotune/ecommerce/ecm006.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx {{$currentStep == 5 ? 'text-primary' : ''}}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20 8H16C15.4 8 15 8.4 15 9V16H10V17C10 17.6 10.4 18 11 18H16C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18H21C21.6 18 22 17.6 22 17V13L20 8Z"
                                    fill="currentColor" />
                                <path opacity="0.3"
                                    d="M20 18C20 19.1 19.1 20 18 20C16.9 20 16 19.1 16 18C16 16.9 16.9 16 18 16C19.1 16 20 16.9 20 18ZM15 4C15 3.4 14.6 3 14 3H3C2.4 3 2 3.4 2 4V13C2 13.6 2.4 14 3 14H15V4ZM6 16C4.9 16 4 16.9 4 18C4 19.1 4.9 20 6 20C7.1 20 8 19.1 8 18C8 16.9 7.1 16 6 16Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title">
                            Shipping
                        </h3>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Step 6-->
            <!--begin::Step 7-->
            <div class="stepper-item {{$currentStep == 6 ? 'current' : ''}}" data-kt-stepper-element="nav"
                wire:click="setCurrentStep(6)">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-01-30-131017/core/html/src/media/icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx {{$currentStep == 6 ? 'text-primary' : ''}}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title">
                            Review
                        </h3>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Step 7-->
            <!--begin::Step 8-->
            <div class="stepper-item {{$currentStep == 7 ? 'current' : ''}}" data-kt-stepper-element="nav"
                wire:click="setCurrentStep(7)">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-01-30-131017/core/html/src/media/icons/duotune/general/gen026.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx {{$currentStep == 7 ? 'text-primary' : ''}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                <path
                                    d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                    fill="currentColor" />
                                <path
                                    d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z"
                                    fill="white" />
                            </svg></span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title">
                            Completed
                        </h3>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Step 8-->
        </div>
        <!--end::Nav-->

        <!--begin::Form-->
        <div class="form d-flex flex-column flex-lg-row" id="order-form-container">
            <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                @include('user.order.update-wizard-step.aside')
            </div>
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <div>
                    @include('user.order.update-wizard-step.step0')
                    @include('user.order.update-wizard-step.step1')
                    @include('user.order.update-wizard-step.step2')
                    @include('user.order.update-wizard-step.step3')
                    @include('user.order.update-wizard-step.step4')
                    @include('user.order.update-wizard-step.step5')
                    @include('user.order.update-wizard-step.step6')
                    @include('user.order.update-wizard-step.step7')
                </div>

                <!--begin::Actions-->
                <div class="d-flex flex-stack pt-10">
                    <!--begin::Wrapper-->
                    <div class="me-2">
                        <button type="button" class="btn btn-lg btn-light-primary me-3 order-back-button"
                            style="{{$currentStep != 0 && $currentStep != 7 ? '' : 'display: none'}}">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                            <span class="svg-icon svg-icon-3 me-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1" fill="currentColor" />
                                    <path
                                        d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Back
                        </button>
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Wrapper-->
                    <div>
                        <button type="button" class="btn btn-lg btn-primary order-continue-button"
                            style="{{ $currentStep != 7 ? '' : 'display: none !important'}}">
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <span class="indicator-label">{{ $currentStep != 6 ? 'Continue' : 'Update Order'}}
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                <span class="svg-icon svg-icon-3 ms-2 me-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                            transform="rotate(-180 18 13)" fill="currentColor" />
                                        <path
                                            d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </button>

                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Actions-->
            </div>

        </div>
        <!--end::Form-->

    </div>
    <!--end::Stepper-->
</div>