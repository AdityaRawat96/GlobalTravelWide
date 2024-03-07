<!--begin::Payment methods-->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header card-header-stretch pb-0">
        <!--begin::Title-->
        <div class="card-title">
            <h3 class="m-0">Payment Methods</h3>
        </div>
        <!--end::Title-->
    </div>
    <!--end::Card header-->
    <!--begin::Tab content-->
    <div id="kt_billing_payment_tab_content" class="card-body">
        <div id="kt_billing_creditcard">
            <!--begin::Title-->
            <h3 class="mb-5">My Cards</h3>
            <!--end::Title-->
            <!--begin::Row-->
            <div class="row gx-9 gy-6">
                @if($data['saved_cards'])
                @foreach($data['saved_cards'] as $card)
                <!--begin::Col-->
                <div class="col-xl-6 saved-card-{{$card->id}}" data-kt-billing-element="card">
                    <!--begin::Card-->
                    <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
                        <!--begin::Info-->
                        <div class="d-flex flex-column py-2">
                            <!--begin::Owner-->
                            <div class="d-flex align-items-center fs-4 fw-bold mb-5">{{$card->card_name}}
                                @if($card->default)
                                <span class="badge badge-light-success fs-7 ms-2">Primary</span>
                                @endif
                            </div>
                            <!--end::Owner-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Icon-->
                                <img src="{{asset('media/svg/card-logos/'.$card->card_type.'.svg')}}" alt=""
                                    class="me-4" />
                                <!--end::Icon-->
                                <!--begin::Details-->
                                <div>
                                    <div class="fs-4 fw-bold">{{ucfirst($card->card_type)}} ****
                                        {{substr($card->card_number, -4);}}</div>
                                    <div class="fs-6 fw-semibold text-gray-400">Card expires at
                                        {{$card->card_expiry_month < 10 ? "0".$card->card_expiry_month : $card->card_expiry_month }}/{{substr($card->card_expiry_year, 2)}}
                                    </div>
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Info-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-2">
                            <button class="btn btn-sm btn-light btn-active-light-primary me-3"
                                data-kt-billing-action="card-delete"
                                onclick="deleteCard(`{{$card->id}}`, `{{route('user.profile.deleteCard', $card->id)}}`)">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">Delete</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                            <button class="btn btn-sm btn-light btn-active-light-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_update_card"
                                onclick="editCard({{json_encode($card)}})">Edit</button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
                @endforeach
                @endif
                <!--begin::Col-->
                <div class="col-xl-6">
                    <!--begin::Notice-->
                    <div
                        class="notice d-flex bg-light-primary rounded border-primary border border-dashed h-lg-100 p-6">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                            <!--begin::Content-->
                            <div class="mb-3 mb-md-0 fw-semibold">
                                <h4 class="text-gray-900 fw-bold">Important Note!</h4>
                                <div class="fs-6 text-gray-700 pe-7">Please carefully read
                                    <a href="#" class="fw-bold me-1">Product Terms</a>adding
                                    <br />your new payment card
                                </div>
                            </div>
                            <!--end::Content-->
                            <!--begin::Action-->
                            <a href="#" class="btn btn-primary px-6 align-self-center text-nowrap"
                                data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">Add Card</a>
                            <!--end::Action-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Notice-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
    </div>
    <!--end::Tab content-->
</div>
<!--end::Payment methods-->
<!--begin::Billing Address-->
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Title-->
        <div class="card-title">
            <h3>Billing Address</h3>
        </div>
        <!--end::Title-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body">
        <!--begin::Addresses-->
        <div class="row gx-9 gy-6">
            @if($data['saved_addresses'])
            @foreach($data['saved_addresses'] as $address_index=>$address)
            <!--begin::Col-->
            <div class="col-xl-6 saved-address-{{$address->id}}" data-kt-billing-element="address">
                <!--begin::Address-->
                <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
                    <!--begin::Details-->
                    <div class="d-flex flex-column py-2">
                        <div class="d-flex align-items-center fs-5 fw-bold mb-5">Address {{$address_index+1}}
                            @if($address->default)
                            <span class="badge badge-light-success fs-7 ms-2">Primary</span>
                            @endif
                        </div>
                        <div class="fs-6 fw-semibold text-gray-600">{{$address->address1}}
                            <br />{{$address->address2}}
                            <br />{{$address->country}}
                        </div>
                    </div>
                    <!--end::Details-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center py-2">
                        <button class="btn btn-sm btn-light btn-active-light-primary me-3"
                            data-kt-billing-action="address-delete"
                            onclick="deleteAddress(`{{$address->id}}`, `{{route('user.profile.deleteAddress', $address->id)}}`)">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">Delete</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </button>
                        <button class="btn btn-sm btn-light btn-active-light-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_update_address"
                            onclick="editAddress({{json_encode($address)}})">Edit</button>

                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Address-->
            </div>
            <!--end::Col-->
            @endforeach
            @endif
            <!--begin::Col-->
            <div class="col-xl-6">
                <!--begin::Notice-->
                <div
                    class="notice d-flex bg-light-primary rounded border-primary border border-dashed flex-stack h-xl-100 mb-10 p-6">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                        <!--begin::Content-->
                        <div class="mb-3 mb-md-0 fw-semibold">
                            <h4 class="text-gray-900 fw-bold">This is a very important note!</h4>
                            <div class="fs-6 text-gray-700 pe-7">Writing headlines for blog posts is much science
                                and probably cool audience</div>
                        </div>
                        <!--end::Content-->
                        <!--begin::Action-->
                        <a href="#" class="btn btn-primary px-6 align-self-center text-nowrap" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_new_address">New Address</a>
                        <!--end::Action-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Notice-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Addresses-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Billing Address-->