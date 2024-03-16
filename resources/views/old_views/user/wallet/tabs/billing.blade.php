<form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation" data-cc-on-file="false"
    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="kt_wallet_topup_form" enctype="multipart/form-data">
    @csrf
    <!--begin::Payment details-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header card-header-stretch pb-0">
            <!--begin::Title-->
            <div class="card-title">
                <h3 class="m-0">Payment Details</h3>
            </div>
            <!--end::Title-->
        </div>
        <!--end::Card header-->
        <!--begin::Tab content-->
        <div class="card-body">
            <!--begin::Input group-->
            <div class="d-flex flex-column mb-7 fv-row">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                    <span class="required">Amount ($)</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                        title="Specify the amount to be added to your wallet"></i>
                </label>
                <!--end::Label-->
                <input type="number" class="form-control form-control-solid card_amount" placeholder=""
                    name="card_amount" value="5000" placeholder="Enter amount to be added to your wallet" />

                <div class="amount-tags-container">
                    <div
                        class="amount-tag border border-primary bg-light-primary border-dashed rounded w-80px h-30px py-2 px-2 me-6 mb-3 mt-3">
                        <!--begin::Number-->
                        <div class="d-flex align-items-center">
                            <div class="fw-bold counted" data-kt-countup="true" data-kt-countup-value="500"
                                data-kt-countup-prefix="$" data-kt-initialized="1">+500</div>
                        </div>
                        <!--end::Number-->
                    </div>
                    <div
                        class="amount-tag border border-primary bg-light-primary border-dashed rounded w-80px h-30px py-2 px-2 me-6 mb-3 mt-3">
                        <!--begin::Number-->
                        <div class="d-flex align-items-center">
                            <div class="fw-bold counted" data-kt-countup="true" data-kt-countup-value="1000"
                                data-kt-countup-prefix="$" data-kt-initialized="1">+1,000</div>
                        </div>
                        <!--end::Number-->
                    </div>
                    <div
                        class="amount-tag border border-primary bg-light-primary border-dashed rounded w-80px h-30px py-2 px-2 me-6 mb-3 mt-3">
                        <!--begin::Number-->
                        <div class="d-flex align-items-center">
                            <div class="fw-bold counted" data-kt-countup="true" data-kt-countup-value="5000"
                                data-kt-countup-prefix="$" data-kt-initialized="1">+5,000</div>
                        </div>
                        <!--end::Number-->
                    </div>
                    <div
                        class="amount-tag border border-primary bg-light-primary border-dashed rounded w-80px h-30px py-2 px-2 me-6 mb-3 mt-3">
                        <!--begin::Number-->
                        <div class="d-flex align-items-center">
                            <div class="fw-bold counted" data-kt-countup="true" data-kt-countup-value="10000"
                                data-kt-countup-prefix="$" data-kt-initialized="1">+10,000</div>
                        </div>
                        <!--end::Number-->
                    </div>
                </div>
            </div>
            <!--end::Input group-->
        </div>
        <!--end::Tab content-->
    </div>
    <!--end::Payment details-->
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
            @if($data["saved_addresses"] && count($data["saved_addresses"]))
            <!--begin::Title-->
            <h3 class="mb-5">Saved Addresses</h3>
            <!--begin::Addresses-->
            @endif
            <div class="row gx-9 gy-6">
                @if($data['saved_addresses'])
                @foreach($data['saved_addresses'] as $address_index=>$address)
                <!--begin::Col-->
                <div class="col-xl-4 saved-address-{{$address->id}}" data-kt-billing-element="address">
                    <!--begin::Address-->
                    <div class="card card-dashed saved-address h-xl-100 flex-row flex-stack flex-wrap p-6 {{$data['default_address']->id == $address->id ? 'bg-light-primary border-primary' : '' }}"
                        onclick="selectAddress($(this), {{json_encode($address)}})">
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
                    </div>
                    <!--end::Address-->
                </div>
                <!--end::Col-->
                @endforeach
                @endif
                <!--begin::Col-->
                <div class="col-xl-4">
                    <!--begin::Notice-->
                    <div class="notice d-flex  rounded  border border-dashed h-lg-100 p-6">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                            <!--begin::Content-->
                            <div class="mb-3 mb-md-0 fw-semibold">
                                <div class="fs-6 text-gray-700 pe-7">Click here to add a new billing address.</div>
                            </div>
                            <!--end::Content-->
                            <!--begin::Action-->
                            <button type="button" class="btn btn-primary px-6 align-self-center text-nowrap"
                                onclick="addNewAddress()">New
                                Address</button>
                            <!--end::Action-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Notice-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Addresses-->

            <div class="mt-8 d-none" id="add-new-address-container">
                <!--begin::Title-->
                <h3 class="mt-8 mb-5">Address Details</h3>
                <!--end::Title-->
                <!--begin::Input group-->
                <div class="row mb-5">
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <!--begin::Label-->
                        <label class="required fs-5 fw-semibold mb-2">First name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" placeholder="" name="first_name"
                            value="{{isset($data['default_address']) ? $data['default_address']->first_name : ''}}" />
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <!--end::Label-->
                        <label class="required fs-5 fw-semibold mb-2">Last name</label>
                        <!--end::Label-->
                        <!--end::Input-->
                        <input type="text" class="form-control form-control-solid" placeholder="" name="last_name"
                            value="{{isset($data['default_address']) ? $data['default_address']->last_name : ''}}" />
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="d-flex flex-column mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-5 fw-semibold mb-2">Company</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input class="form-control form-control-solid" placeholder="" name="company"
                        value="{{isset($data['default_address']) ? $data['default_address']->company : ''}}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="d-flex flex-column mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-5 fw-semibold mb-2">Email</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input class="form-control form-control-solid" placeholder="" name="email"
                        value="{{isset($data['default_address']) ? $data['default_address']->email : ''}}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="d-flex flex-column mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-5 fw-semibold mb-2">Phone</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input class="form-control form-control-solid" placeholder="" name="phone"
                        value="{{isset($data['default_address']) ? $data['default_address']->phone : ''}}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="d-flex flex-column mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                        <span class="required">Country</span>
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                            title="Your payment statements may very based on selected country"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Select-->
                    <select name="country" data-control="select2" data-dropdown-parent="#kt_wallet_topup_form"
                        data-placeholder="Select a Country..." class="form-select form-select-solid"
                        data-value="{{isset($data['default_address']) ? $data['default_address']->country : ''}}">
                        <option value="">Select a Country...</option>
                        <option value="AF">Afghanistan</option>
                        <option value="AX">Aland Islands</option>
                        <option value="AL">Albania</option>
                        <option value="DZ">Algeria</option>
                        <option value="AS">American Samoa</option>
                        <option value="AD">Andorra</option>
                        <option value="AO">Angola</option>
                        <option value="AI">Anguilla</option>
                        <option value="AG">Antigua and Barbuda</option>
                        <option value="AR">Argentina</option>
                        <option value="AM">Armenia</option>
                        <option value="AW">Aruba</option>
                        <option value="AU">Australia</option>
                        <option value="AT">Austria</option>
                        <option value="AZ">Azerbaijan</option>
                        <option value="BS">Bahamas</option>
                        <option value="BH">Bahrain</option>
                        <option value="BD">Bangladesh</option>
                        <option value="BB">Barbados</option>
                        <option value="BY">Belarus</option>
                        <option value="BE">Belgium</option>
                        <option value="BZ">Belize</option>
                        <option value="BJ">Benin</option>
                        <option value="BM">Bermuda</option>
                        <option value="BT">Bhutan</option>
                        <option value="BO">Bolivia, Plurinational State of</option>
                        <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                        <option value="BA">Bosnia and Herzegovina</option>
                        <option value="BW">Botswana</option>
                        <option value="BR">Brazil</option>
                        <option value="IO">British Indian Ocean Territory</option>
                        <option value="BN">Brunei Darussalam</option>
                        <option value="BG">Bulgaria</option>
                        <option value="BF">Burkina Faso</option>
                        <option value="BI">Burundi</option>
                        <option value="KH">Cambodia</option>
                        <option value="CM">Cameroon</option>
                        <option value="CA">Canada</option>
                        <option value="CV">Cape Verde</option>
                        <option value="KY">Cayman Islands</option>
                        <option value="CF">Central African Republic</option>
                        <option value="TD">Chad</option>
                        <option value="CL">Chile</option>
                        <option value="CN">China</option>
                        <option value="CX">Christmas Island</option>
                        <option value="CC">Cocos (Keeling) Islands</option>
                        <option value="CO">Colombia</option>
                        <option value="KM">Comoros</option>
                        <option value="CK">Cook Islands</option>
                        <option value="CR">Costa Rica</option>
                        <option value="CI">Côte d'Ivoire</option>
                        <option value="HR">Croatia</option>
                        <option value="CU">Cuba</option>
                        <option value="CW">Curaçao</option>
                        <option value="CZ">Czech Republic</option>
                        <option value="DK">Denmark</option>
                        <option value="DJ">Djibouti</option>
                        <option value="DM">Dominica</option>
                        <option value="DO">Dominican Republic</option>
                        <option value="EC">Ecuador</option>
                        <option value="EG">Egypt</option>
                        <option value="SV">El Salvador</option>
                        <option value="GQ">Equatorial Guinea</option>
                        <option value="ER">Eritrea</option>
                        <option value="EE">Estonia</option>
                        <option value="ET">Ethiopia</option>
                        <option value="FK">Falkland Islands (Malvinas)</option>
                        <option value="FJ">Fiji</option>
                        <option value="FI">Finland</option>
                        <option value="FR">France</option>
                        <option value="PF">French Polynesia</option>
                        <option value="GA">Gabon</option>
                        <option value="GM">Gambia</option>
                        <option value="GE">Georgia</option>
                        <option value="DE">Germany</option>
                        <option value="GH">Ghana</option>
                        <option value="GI">Gibraltar</option>
                        <option value="GR">Greece</option>
                        <option value="GL">Greenland</option>
                        <option value="GD">Grenada</option>
                        <option value="GU">Guam</option>
                        <option value="GT">Guatemala</option>
                        <option value="GG">Guernsey</option>
                        <option value="GN">Guinea</option>
                        <option value="GW">Guinea-Bissau</option>
                        <option value="HT">Haiti</option>
                        <option value="VA">Holy See (Vatican City State)</option>
                        <option value="HN">Honduras</option>
                        <option value="HK">Hong Kong</option>
                        <option value="HU">Hungary</option>
                        <option value="IS">Iceland</option>
                        <option value="IN">India</option>
                        <option value="ID">Indonesia</option>
                        <option value="IR">Iran, Islamic Republic of</option>
                        <option value="IQ">Iraq</option>
                        <option value="IE">Ireland</option>
                        <option value="IM">Isle of Man</option>
                        <option value="IL">Israel</option>
                        <option value="IT">Italy</option>
                        <option value="JM">Jamaica</option>
                        <option value="JP">Japan</option>
                        <option value="JE">Jersey</option>
                        <option value="JO">Jordan</option>
                        <option value="KZ">Kazakhstan</option>
                        <option value="KE">Kenya</option>
                        <option value="KI">Kiribati</option>
                        <option value="KP">Korea, Democratic People's Republic of</option>
                        <option value="KW">Kuwait</option>
                        <option value="KG">Kyrgyzstan</option>
                        <option value="LA">Lao People's Democratic Republic</option>
                        <option value="LV">Latvia</option>
                        <option value="LB">Lebanon</option>
                        <option value="LS">Lesotho</option>
                        <option value="LR">Liberia</option>
                        <option value="LY">Libya</option>
                        <option value="LI">Liechtenstein</option>
                        <option value="LT">Lithuania</option>
                        <option value="LU">Luxembourg</option>
                        <option value="MO">Macao</option>
                        <option value="MG">Madagascar</option>
                        <option value="MW">Malawi</option>
                        <option value="MY">Malaysia</option>
                        <option value="MV">Maldives</option>
                        <option value="ML">Mali</option>
                        <option value="MT">Malta</option>
                        <option value="MH">Marshall Islands</option>
                        <option value="MQ">Martinique</option>
                        <option value="MR">Mauritania</option>
                        <option value="MU">Mauritius</option>
                        <option value="MX">Mexico</option>
                        <option value="FM">Micronesia, Federated States of</option>
                        <option value="MD">Moldova, Republic of</option>
                        <option value="MC">Monaco</option>
                        <option value="MN">Mongolia</option>
                        <option value="ME">Montenegro</option>
                        <option value="MS">Montserrat</option>
                        <option value="MA">Morocco</option>
                        <option value="MZ">Mozambique</option>
                        <option value="MM">Myanmar</option>
                        <option value="NA">Namibia</option>
                        <option value="NR">Nauru</option>
                        <option value="NP">Nepal</option>
                        <option value="NL">Netherlands</option>
                        <option value="NZ">New Zealand</option>
                        <option value="NI">Nicaragua</option>
                        <option value="NE">Niger</option>
                        <option value="NG">Nigeria</option>
                        <option value="NU">Niue</option>
                        <option value="NF">Norfolk Island</option>
                        <option value="MP">Northern Mariana Islands</option>
                        <option value="NO">Norway</option>
                        <option value="OM">Oman</option>
                        <option value="PK">Pakistan</option>
                        <option value="PW">Palau</option>
                        <option value="PS">Palestinian Territory, Occupied</option>
                        <option value="PA">Panama</option>
                        <option value="PG">Papua New Guinea</option>
                        <option value="PY">Paraguay</option>
                        <option value="PE">Peru</option>
                        <option value="PH">Philippines</option>
                        <option value="PL">Poland</option>
                        <option value="PT">Portugal</option>
                        <option value="PR">Puerto Rico</option>
                        <option value="QA">Qatar</option>
                        <option value="RO">Romania</option>
                        <option value="RU">Russian Federation</option>
                        <option value="RW">Rwanda</option>
                        <option value="BL">Saint Barthélemy</option>
                        <option value="KN">Saint Kitts and Nevis</option>
                        <option value="LC">Saint Lucia</option>
                        <option value="MF">Saint Martin (French part)</option>
                        <option value="VC">Saint Vincent and the Grenadines</option>
                        <option value="WS">Samoa</option>
                        <option value="SM">San Marino</option>
                        <option value="ST">Sao Tome and Principe</option>
                        <option value="SA">Saudi Arabia</option>
                        <option value="SN">Senegal</option>
                        <option value="RS">Serbia</option>
                        <option value="SC">Seychelles</option>
                        <option value="SL">Sierra Leone</option>
                        <option value="SG">Singapore</option>
                        <option value="SX">Sint Maarten (Dutch part)</option>
                        <option value="SK">Slovakia</option>
                        <option value="SI">Slovenia</option>
                        <option value="SB">Solomon Islands</option>
                        <option value="SO">Somalia</option>
                        <option value="ZA">South Africa</option>
                        <option value="KR">South Korea</option>
                        <option value="SS">South Sudan</option>
                        <option value="ES">Spain</option>
                        <option value="LK">Sri Lanka</option>
                        <option value="SD">Sudan</option>
                        <option value="SR">Suriname</option>
                        <option value="SZ">Swaziland</option>
                        <option value="SE">Sweden</option>
                        <option value="CH">Switzerland</option>
                        <option value="SY">Syrian Arab Republic</option>
                        <option value="TW">Taiwan, Province of China</option>
                        <option value="TJ">Tajikistan</option>
                        <option value="TZ">Tanzania, United Republic of</option>
                        <option value="TH">Thailand</option>
                        <option value="TG">Togo</option>
                        <option value="TK">Tokelau</option>
                        <option value="TO">Tonga</option>
                        <option value="TT">Trinidad and Tobago</option>
                        <option value="TN">Tunisia</option>
                        <option value="TR">Turkey</option>
                        <option value="TM">Turkmenistan</option>
                        <option value="TC">Turks and Caicos Islands</option>
                        <option value="TV">Tuvalu</option>
                        <option value="UG">Uganda</option>
                        <option value="UA">Ukraine</option>
                        <option value="AE">United Arab Emirates</option>
                        <option value="GB">United Kingdom</option>
                        <option value="US">United States</option>
                        <option value="UY">Uruguay</option>
                        <option value="UZ">Uzbekistan</option>
                        <option value="VU">Vanuatu</option>
                        <option value="VE">Venezuela, Bolivarian Republic of</option>
                        <option value="VN">Vietnam</option>
                        <option value="VI">Virgin Islands</option>
                        <option value="YE">Yemen</option>
                        <option value="ZM">Zambia</option>
                        <option value="ZW">Zimbabwe</option>
                    </select>
                    <!--end::Select-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="d-flex flex-column mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-5 fw-semibold mb-2">Address Line 1</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input class="form-control form-control-solid" placeholder="" name="address1"
                        value="{{isset($data['default_address']) ? $data['default_address']->address1 : ''}}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="d-flex flex-column mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-5 fw-semibold mb-2">Address Line 2</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input class="form-control form-control-solid" placeholder="" name="address2"
                        value="{{isset($data['default_address']) ? $data['default_address']->address2 : ''}}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="d-flex flex-column mb-5 fv-row">
                    <!--begin::Label-->
                    <label class="fs-5 fw-semibold mb-2 required">Town</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input class="form-control form-control-solid" placeholder="" name="city"
                        value="{{isset($data['default_address']) ? $data['default_address']->city : ''}}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row g-9 mb-5">
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <!--begin::Label-->
                        <label class="fs-5 fw-semibold mb-2 required">State / Province</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="" name="state"
                            value="{{isset($data['default_address']) ? $data['default_address']->state : ''}}" />
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <!--begin::Label-->
                        <label class="fs-5 fw-semibold mb-2 required">Post Code</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="" name="postcode"
                            value="{{isset($data['default_address']) ? $data['default_address']->postcode : ''}}" />
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <!--end::Billing Address-->
    <!--begin::Payment methods-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header card-header-stretch pb-0">
            <!--begin::Title-->
            <div class="card-title">
                <h3 class="m-0">Payment Method</h3>
            </div>
            <!--end::Title-->
        </div>
        <!--end::Card body-->
        <!--begin::Tab content-->
        <div id="kt_billing_payment_tab_content" class="card-body">

            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link nav-link-billing-tab ms-0 me-10 py-5 active" href=""
                        data-target="#billing-tab-card" data-type="card">Card</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link nav-link-billing-tab ms-0 me-10 py-5" href="" data-target="#billing-tab-bank"
                        data-type="bank">Bank Transfer</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link nav-link-billing-tab ms-0 me-10 py-5" href="" data-target="#billing-tab-payoneer"
                        data-type="payoneer">Payoneer</a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--begin::Navs-->

            <div class="billing-sections-tabs mt-8">
                <div class="billing-sections-tab-container" id="billing-tab-card">
                    <div id="kt_billing_creditcard">
                        <!--begin::Title-->
                        <h3 class="mb-5">Saved Cards</h3>
                        <!--end::Title-->
                        <!--begin::Row-->
                        <div class="row gx-9 gy-6">
                            @if($data['saved_cards'])
                            @foreach($data['saved_cards'] as $card)
                            <!--begin::Col-->
                            <div class="col-xl-4 saved-card-{{$card->id}}" data-kt-billing-element="card">
                                <!--begin::Card-->
                                <div class="card card-dashed h-xl-100 saved-card flex-row flex-stack flex-wrap p-6 {{$data['default_card']->id == $card->id ? 'bg-light-primary border-primary' : '' }}"
                                    onclick="selectCard($(this), {{json_encode($card)}})">
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
                                                    {{substr($card->card_number, -4);}}
                                                </div>
                                                <div class="fs-6 fw-semibold text-gray-400">Card expires at
                                                    {{$card->card_expiry_month < 10 ? "0".$card->card_expiry_month : $card->card_expiry_month }}/{{substr($card->card_expiry_year, 2)}}
                                                </div>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Col-->
                            @endforeach
                            @endif
                            <!--begin::Col-->
                            <div class="col-xl-4">
                                <!--begin::Notice-->
                                <div class="notice d-flex  rounded  border border-dashed h-lg-100 p-6">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                        <!--begin::Content-->
                                        <div class="mb-3 mb-md-0 fw-semibold">
                                            <div class="fs-6 text-gray-700 pe-7">Or click here to add a new card for
                                                billing.
                                            </div>
                                        </div>
                                        <!--end::Content-->
                                        <!--begin::Action-->
                                        <button type="button" onclick="addNewCard()"
                                            class="btn btn-primary px-6 align-self-center text-nowrap">New Card</button>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Notice-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <div class="mt-8 d-none" id="add-new-card-container">
                            <!--begin::Title-->
                            <h3 class="mt-8 mb-5">Card Details</h3>
                            <!--end::Title-->
                            <!--begin::Row-->
                            <div class="row gx-9 gy-6">
                                <div class="col-12">
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                            <span class="required">Name On Card</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify a card holder's name"></i>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid" placeholder=""
                                            name="card_name" value="Max Doe"
                                            value="{{isset($data['default_card']) ? $data['default_card']->card_name : ''}}" />
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold form-label mb-2">Card Number</label>
                                        <!--end::Label-->
                                        <!--begin::Input wrapper-->
                                        <div class="position-relative">
                                            <!--begin::Input-->
                                            <input id="card_number" type="text" class="form-control form-control-solid"
                                                placeholder="Enter card number" name="card_number"
                                                value="4111 1111 1111 1111"
                                                value="{{isset($data['default_card']) ? $data['default_card']->card_number : ''}}" />
                                            <!--end::Input-->
                                            <!--begin::Card logos-->
                                            <div class="position-absolute translate-middle-y top-50 end-0 me-5">
                                                <img class="card-logo-input card-logo-visa h-25px d-none"
                                                    src="{{asset('media/svg/card-logos/visa.svg')}}" alt="" />
                                                <img class="card-logo-input card-logo-mastercard h-25px d-none"
                                                    src="{{asset('media/svg/card-logos/mastercard.svg')}}" alt="" />
                                                <img class="card-logo-input card-logo-american-express h-25px d-none"
                                                    src="{{asset('media/svg/card-logos/american-express.svg')}}"
                                                    alt="" />
                                            </div>
                                            <!--end::Card logos-->
                                        </div>
                                        <!--end::Input wrapper-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-10">
                                        <!--begin::Col-->
                                        <div class="col-md-8 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-semibold form-label mb-2">Expiration
                                                Date</label>
                                            <!--end::Label-->
                                            <!--begin::Row-->
                                            <div class="row fv-row">
                                                <!--begin::Col-->
                                                <div class="col-6">
                                                    <select name="card_expiry_month"
                                                        class="form-select form-select-solid" data-control="select2"
                                                        data-hide-search="true" data-placeholder="Month"
                                                        data-value="{{isset($data['default_card']) ? $data['default_card']->card_expiry_month : ''}}">
                                                        <option></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-6">
                                                    <select name="card_expiry_year"
                                                        class="form-select form-select-solid" data-control="select2"
                                                        data-hide-search="true" data-placeholder="Year"
                                                        data-value="{{isset($data['default_card']) ? $data['default_card']->card_expiry_year : ''}}">
                                                        <option></option>
                                                        <option value="2022">2022</option>
                                                        <option value="2023">2023</option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                        <option value="2026">2026</option>
                                                        <option value="2027">2027</option>
                                                        <option value="2028">2028</option>
                                                        <option value="2029">2029</option>
                                                        <option value="2030">2030</option>
                                                        <option value="2031">2031</option>
                                                        <option value="2032">2032</option>
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-4 fv-row">
                                            <!--begin::Label-->
                                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                <span class="required">CVV</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                    title="Enter a card CVV code"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input wrapper-->
                                            <div class="position-relative">
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid" minlength="3"
                                                    maxlength="4" placeholder="CVV" name="card_cvv"
                                                    value="{{isset($data['default_card']) ? $data['default_card']->card_cvv : ''}}" />
                                                <!--end::Input-->
                                                <!--begin::CVV icon-->
                                                <div class="position-absolute translate-middle-y top-50 end-0 me-3">
                                                    <!--begin::Svg Icon | path: icons/duotune/finance/fin002.svg-->
                                                    <span class="svg-icon svg-icon-2hx">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M22 7H2V11H22V7Z" fill="currentColor" />
                                                            <path opacity="0.3"
                                                                d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19ZM14 14C14 13.4 13.6 13 13 13H5C4.4 13 4 13.4 4 14C4 14.6 4.4 15 5 15H13C13.6 15 14 14.6 14 14ZM16 15.5C16 16.3 16.7 17 17.5 17H18.5C19.3 17 20 16.3 20 15.5C20 14.7 19.3 14 18.5 14H17.5C16.7 14 16 14.7 16 15.5Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::CVV icon-->
                                            </div>
                                            <!--end::Input wrapper-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="billing-sections-tab-container d-none" id="billing-tab-bank">
                    <div class="payment-method-header">
                        <div>
                            <img src="{{asset('media/icons/duotune/finance/fin001.svg')}}" alt="bank-img"
                                style="max-width: 100px; height: auto; margin-right: 20px" class="w-100px me-10">
                        </div>
                        <div class="px-3">
                            <p>
                                <span>
                                    <b>Bank Details</b>
                                </span><br><br>
                                <span><b>Bank Name:
                                    </b>{{isset($data['payment']) ? $data['payment']->bank_name : ''}}</span><br>
                                <span><b>SWIFT Code:
                                    </b>{{isset($data['payment']) ? $data['payment']->swift_code : ''}}</span><br>
                                <span><b>Bank Address:
                                    </b>{{isset($data['payment']) ? $data['payment']->bank_address : ''}}</span>
                            </p>
                        </div>
                        <div class="px-3">
                            <p>
                                <span>
                                    <b>Recipient Details</b>
                                </span><br><br>
                                <span><b>Recipient Name:
                                    </b>{{isset($data['payment']) ? $data['payment']->recipient_name : ''}}</span><br>
                                <span><b>Routing Number:
                                    </b>{{isset($data['payment']) ? $data['payment']->routing_number : ''}}</span><br>
                                <span><b>Account Number:
                                    </b>{{isset($data['payment']) ? $data['payment']->account_number : ''}}</span><br>
                                <span><b>Email:
                                    </b>{{isset($data['payment']) ? $data['payment']->recipient_email : ''}}</span><br>
                                <span><b>Phone:
                                    </b>{{isset($data['payment']) ? $data['payment']->recipient_phone : ''}}</span><br>
                                <span><b>Address:
                                    </b>{{isset($data['payment']) ? $data['payment']->recipient_address : ''}}</span>
                            </p>
                        </div>
                    </div><br>
                    <hr>
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Receipt</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="file" class="form-control form-control-solid" placeholder="" name="receipt_bank" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">Notes</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea class="form-control form-control-solid" placeholder="" name="notes_bank"
                            rows="6"></textarea>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="billing-sections-tab-container d-none" id="billing-tab-payoneer">
                    <div class="payment-method-header">
                        <div>
                            <img src="{{asset('media/wallet/payoneer.png')}}" alt="bank-img"
                                style="max-width: 100px; height: auto; margin-right: 20px">
                        </div>
                        <div>
                            <p>
                                <span>
                                    <b>To pay with Payoneer</b>
                                </span><br><br>
                                <span>{{isset($data['payment']) ? $data['payment']->PAYONEER_ACCOUNT : ''}}</span><br>
                            </p>
                        </div>
                    </div><br>
                    <hr>
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Receipt</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="file" class="form-control form-control-solid" placeholder=""
                            name="receipt_payoneer" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">Notes</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea class="form-control form-control-solid" placeholder="" name="notes_payoneer"
                            rows="6"></textarea>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer d-flex flex-end">
            <!--begin::Button-->
            <button type="button" id="kt_wallet_topup_form_submit" class="btn btn-primary">
                <span class="indicator-label">Pay & Continue</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Payment methods-->
</form>
<div id="payment-success-container" class="d-none">
    <div class="card">
        <div class="card-body">
            <!--begin::Wrapper-->
            <div class="w-100">
                <!--begin::Heading-->
                <div class="pb-12 text-center mt-8">
                    <!--begin::Title-->
                    <h1 class="fw-bold text-dark">Successfully Added Funds!</h1>
                    <!--end::Title-->
                    <!--begin::Description-->
                    <div class="fw-semibold text-muted fs-4 order_id_container"></div>
                    <div class="fw-semibold text-muted fs-4mt-5">You will receive an email with with the summary of your
                        latest transaction!</div>
                    <!--end::Description-->
                </div>
                <!--end::Heading-->
                <!--begin::Actions-->
                <div class="d-flex flex-center pb-20">
                    <button onclick="window.location.reload()" type="button" class="btn btn-lg btn-primary">Add
                        More</button>
                </div>
                <!--end::Actions-->
                <!--begin::Illustration-->
                <div class="text-center px-4">
                    <img src="{{asset('media/illustrations/sketchy-1/9.png')}}" alt="" class="mww-100 mh-350px">
                </div>
                <!--end::Illustration-->
            </div>
        </div>
    </div>
</div>