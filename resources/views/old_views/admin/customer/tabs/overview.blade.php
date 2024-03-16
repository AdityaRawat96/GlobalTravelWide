    <!--begin:::Tab pane-->
    <div class="tab-pane fade show active" id="kt_ecommerce_customer_overview" role="tabpanel">
        <div class="row row-cols-1 row-cols-md-2 mb-6 mb-xl-9">
            <div class="col">
                <!--begin::Card-->
                <div class="card pt-4 h-md-100 mb-6 mb-md-0">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="fw-bold">Wallet Balance</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="fw-bold fs-2">
                            <div class="d-flex">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen030.svg-->

                                <span class="svg-icon svg-icon-info svg-icon-2x">
                                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Shopping/Wallet.svg--><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="currentColor" opacity="0.3" cx="20.5" cy="12.5" r="1.5" />
                                            <rect fill="currentColor" opacity="0.3"
                                                transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) "
                                                x="3" y="3" width="18" height="7" rx="1" />
                                            <path
                                                d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z"
                                                fill="currentColor" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                                <!--end::Svg Icon-->
                                <div class="ms-2">$ {{number_format($data['balance'], 2)}}
                                </div>
                            </div>
                            <div class="fs-7 fw-normal text-muted">Current balance in customer's wallet.</div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            @if($data['transactions'] && count($data['transactions']))
            <div class="col">
                <!--begin::Reward Tier-->
                <a href="#" class="card bg-info hoverable h-md-100">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen020.svg-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 18V16H10V18L9 20H15L14 18Z" fill="currentColor" />
                                <path opacity="0.3"
                                    d="M20 4H17V3C17 2.4 16.6 2 16 2H8C7.4 2 7 2.4 7 3V4H4C3.4 4 3 4.4 3 5V9C3 11.2 4.8 13 7 13C8.2 14.2 8.8 14.8 10 16H14C15.2 14.8 15.8 14.2 17 13C19.2 13 21 11.2 21 9V5C21 4.4 20.6 4 20 4ZM5 9V6H7V11C5.9 11 5 10.1 5 9ZM19 9C19 10.1 18.1 11 17 11V6H19V9ZM17 21V22H7V21C7 20.4 7.4 20 8 20H16C16.6 20 17 20.4 17 21ZM10 9C9.4 9 9 8.6 9 8V5C9 4.4 9.4 4 10 4C10.6 4 11 4.4 11 5V8C11 8.6 10.6 9 10 9ZM10 13C9.4 13 9 12.6 9 12V11C9 10.4 9.4 10 10 10C10.6 10 11 10.4 11 11V12C11 12.6 10.6 13 10 13Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bold fs-2 mt-5">Premium Member</div>
                        <div class="fw-semibold text-white">Tier Milestone Reached</div>
                    </div>
                    <!--end::Body-->
                </a>
                <!--end::Reward Tier-->
            </div>
            @endif
        </div>
        <!--begin::Card-->
        <div class="card pt-4 mb-6 mb-xl-9">
            <!--begin::Card header-->
            <div class="card-header border-0">
                <!--begin::Card title-->
                <div class="card-title w-100">
                    <h2>Transaction History</h2>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_transaction" style=" margin-left: auto;">Add
                        Transaction</button>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0 pb-5">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed gy-5" id="kt_table_customers_payment">
                    <!--begin::Table head-->
                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                        <!--begin::Table row-->
                        <tr class="text-start text-muted text-uppercase gs-0">
                            <th>ID</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th class="min-w-100px">Date</th>
                            <th>Description</th>
                            <th>Receipt</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fs-6 fw-semibold text-gray-600">
                        @foreach($data['transactions'] as $transaction)
                        <!--begin::Table row-->
                        <tr>
                            <!--begin::order=-->
                            <td>
                                <span class="text-gray-600 text-hover-primary mb-1">#{{$transaction->id}}</span>
                            </td>
                            <!--end::order=-->
                            <!--begin::Status=-->
                            <td>
                                @if($transaction->status == 'failed')
                                <span class="badge badge-light-danger">{{$transaction->status}}</span>
                                @elseif($transaction->status == 'pending')
                                <span class="badge badge-light-warning">{{$transaction->status}}</span>
                                @elseif($transaction->status == 'success')
                                <span class="badge badge-light-success">{{$transaction->status}}</span>
                                @else
                                <span class="badge badge-light-primary">{{$transaction->status}}</span>
                                @endif
                            </td>
                            <!--end::Status=-->
                            <!--begin::Amount=-->
                            <td>${{number_format($transaction->amount)}}</td>
                            <!--end::Amount=-->
                            <!--begin::Date=-->
                            <td>{{$transaction->created_at}}</td>
                            <!--end::Date=-->
                            <td style="text-transform: capitalize;">
                                {{$transaction->type == 'manual' ? $transaction->notes : $transaction->type}}
                            </td>
                            <td>
                                @if(isset($transaction->receipt))
                                <a href="{{Storage::disk('s3')->url($transaction->receipt)}}"
                                    id="transaction-receipt-{{$transaction->id}}">
                                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-03-24-172858/core/html/src/media/icons/duotune/files/fil008.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM11.7 17.7L16 14C16.4 13.6 16.4 12.9 16 12.5C15.6 12.1 15.4 12.6 15 13L11 16L9 15C8.6 14.6 8.4 14.1 8 14.5C7.6 14.9 8.1 15.6 8.5 16L10.3 17.7C10.5 17.9 10.8 18 11 18C11.2 18 11.5 17.9 11.7 17.7Z"
                                                fill="currentColor" />
                                            <path
                                                d="M10.4343 15.4343L9.25 14.25C8.83579 13.8358 8.16421 13.8358 7.75 14.25C7.33579 14.6642 7.33579 15.3358 7.75 15.75L10.2929 18.2929C10.6834 18.6834 11.3166 18.6834 11.7071 18.2929L16.25 13.75C16.6642 13.3358 16.6642 12.6642 16.25 12.25C15.8358 11.8358 15.1642 11.8358 14.75 12.25L11.5657 15.4343C11.2533 15.7467 10.7467 15.7467 10.4343 15.4343Z"
                                                fill="currentColor" />
                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                @endif
                            </td>
                            <!--begin::Action=-->
                            <td class="text-end">
                                <div class="d-flex justify-content-end flex-shrink-0">
                                    <a data-bs-toggle="modal" data-bs-target="#kt_modal_view_transaction"
                                        onclick="viewTransaction('{{$transaction->id}}', '{{$transaction}}')"
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-03-24-172858/core/html/src/media/icons/duotune/arrows/arr024.svg-->
                                        <span class="svg-icon svg-icon-3"><svg width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M10 4L18 12L10 20H14L21.3 12.7C21.7 12.3 21.7 11.7 21.3 11.3L14 4H10Z"
                                                    fill="currentColor" />
                                                <path opacity="0.3"
                                                    d="M3 4L11 12L3 20H7L14.3 12.7C14.7 12.3 14.7 11.7 14.3 11.3L7 4H3Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                </div>
                            </td>
                            <!--end::Action=-->
                        </tr>
                        <!--end::Table row-->
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end:::Tab pane-->