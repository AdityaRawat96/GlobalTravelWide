 <!--begin::Modal - Shippings - Update-->
 <div class="modal fade" id="kt_modal_update_shipping" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered modal-lg">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Form-->
             <form class="form" action="{{route('admin.order.update', $data['order']->order_id)}}"
                 id="kt_modal_update_shipping_form" method="POST">
                 @csrf
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_update_shipping_header">
                     <!--begin::Modal title-->
                     <h2 class="fw-bold">Update Order Shipping</h2>
                     <!--end::Modal title-->
                     <!--begin::Close-->
                     <div id="kt_modal_update_shipping_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                         <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                         <span class="svg-icon svg-icon-1">
                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                     transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                 <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                     fill="currentColor" />
                             </svg>
                         </span>
                         <!--end::Svg Icon-->
                     </div>
                     <!--end::Close-->
                 </div>
                 <!--end::Modal header-->
                 <!--begin::Modal body-->
                 <div class="modal-body py-10 px-lg-17">
                     <!--begin::Scroll-->
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_update_shipping_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_update_shipping_header"
                         data-kt-scroll-wrappers="#kt_modal_update_shipping_scroll" data-kt-scroll-offset="300px">
                         <div class="mt-5">
                             <h3>Shipping Details:</h3><br>
                             <table class="table">
                                 <thead>
                                     <tr>
                                         <th>Box</th>
                                         <th>Carrier</th>
                                         <th>Tracking</th>
                                     </tr>
                                 </thead>
                                 @foreach($data['bins'] as $index=>$bin)
                                 <tr>
                                     <td>
                                         <span class="fs-4 d-block mt-3">Box {{$index + 1}}</span>
                                     </td>
                                     <td>
                                         <select name="box-tracking-carrier[]" aria-label="Select a Carrier"
                                             data-placeholder="Select a carrier..."
                                             class="form-select form-select-solid fw-semibold">
                                             <option value="">Select carrier</option>
                                             @foreach($data['carriers'] as $key=>$carrier)
                                             <option value="{{$carrier->id}}"
                                                 {{ $data['shipping'] ? ((isset($data['shipping'][$index]) && $data['shipping'][$index]['carrier_id'] == $carrier->id) ? "selected" : "") : null }}>
                                                 {{$carrier->name}}
                                             </option>
                                             @endforeach
                                         </select>
                                     </td>
                                     <td>
                                         <input name="box-tracking-id[]" type="text"
                                             class="form-control form-control-solid" placeholder=""
                                             value="{{($data['shipping'] && isset($data['shipping'][$index]))  ? $data['shipping'][$index]['tracking_id'] : null}}" />
                                     </td>
                                 </tr>
                                 @endforeach
                             </table>
                         </div>
                     </div>
                     <!--end::Scroll-->
                 </div>
                 <!--end::Modal body-->
                 <!--begin::Modal footer-->
                 <div class="modal-footer flex-center">
                     <!--begin::Button-->
                     <button type="reset" id="kt_modal_update_shipping_cancel"
                         class="btn btn-light me-3">Discard</button>
                     <!--end::Button-->
                     <!--begin::Button-->
                     <button type="button" id="kt_modal_update_shipping_submit" class="btn btn-primary">
                         <span class="indicator-label">Submit</span>
                         <span class="indicator-progress">Please wait...
                             <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                     </button>
                     <!--end::Button-->
                 </div>
                 <!--end::Modal footer-->
             </form>
             <!--end::Form-->
         </div>
     </div>
 </div>
 <!--end::Modal - Shippings - Update-->