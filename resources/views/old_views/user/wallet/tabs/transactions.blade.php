  <!--begin::Card-->
  <div class="card">
      <!--begin::Card header-->
      <div class="card-header border-0 pt-6">
          <!--begin::Card title-->
          <div class="card-title">
              <!--begin::Search-->
              <div class="d-flex align-items-center position-relative my-1">
                  <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                  <span class="svg-icon svg-icon-1 position-absolute ms-6">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                              transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                          <path
                              d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                              fill="currentColor" />
                      </svg>
                  </span>
                  <!--end::Svg Icon-->
                  <input type="text" kt-transcations-table-filter="search"
                      class="form-control form-control-solid w-250px ps-15" placeholder="Search Transactions" />
              </div>
              <!--end::Search-->
          </div>
          <!--begin::Card title-->
      </div>
      <!--end::Card header-->
      <!--begin::Card body-->
      <div class="card-body pt-0">
          <!--begin::Table-->
          <table class="table align-middle table-row-dashed gy-5" id="kt-transcations-table">
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
                                  <span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24"
                                          fill="none" xmlns="http://www.w3.org/2000/svg">
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