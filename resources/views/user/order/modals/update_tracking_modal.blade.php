 <!--begin::Modal - Trackings - Update-->
 <div class="modal fade" id="kt_modal_update_tracking" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Form-->
             <form class="form" action="{{route('user.order.update', $data['order']->order_id)}}"
                 id="kt_modal_update_tracking_form" method="POST">
                 @csrf
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_update_tracking_header">
                     <!--begin::Modal title-->
                     <h2 class="fw-bold">Update Tracking Details</h2>
                     <!--end::Modal title-->
                     <!--begin::Close-->
                     <div id="kt_modal_update_tracking_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_update_tracking_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_update_tracking_header"
                         data-kt-scroll-wrappers="#kt_modal_update_tracking_scroll" data-kt-scroll-offset="300px">

                         <!--begin::Input group-->
                         <div class="fv-row mb-5">
                             <!--begin::Tracking-->
                             <label class="required fs-6 fw-semibold mb-2">Carrier</label>
                             <!--end::Status-->
                             <!--begin::Input-->
                             <input type="text" class="form-control form-control-solid" id="tracking_carrier_name"
                                 name="tracking_carrier_name"
                                 value="{{$data['tracking'] ? $data['tracking']['carrier_name'] : ''}}" hidden />
                             <select class="form-select form-select-solid order_status" id="tracking_carrier"
                                 name="tracking_carrier"
                                 onchange="$('#tracking_carrier_name').val($('#tracking_carrier option:selected').text())">
                                 <option value="">Select a carrier</option>
                                 @foreach($data['carriers'] as $carrier_id=>$carrier)
                                 <option value="{{$carrier_id}}"
                                     {{$data['tracking'] && $data['tracking']['carrier_id'] == $carrier_id ? 'selected' : ''}}>
                                     {{$carrier['name']}}</option>
                                 @endforeach
                             </select>
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <div class="fv-row mb-5">
                             <!--begin::Tracking-->
                             <label class="fs-6 fw-semibold mb-2">Tracking ID</label>
                             <!--end::Tracking-->
                             <!--begin::Input-->
                             <input type="text" class="form-control form-control-solid" name="tracking_id"
                                 value="{{$data['tracking'] ? $data['tracking']['tracking_id'] : ''}}" />
                             <!--end::Input-->
                         </div>
                     </div>
                     <!--end::Scroll-->
                 </div>
                 <!--end::Modal body-->
                 <!--begin::Modal footer-->
                 <div class="modal-footer flex-center">
                     <!--begin::Button-->
                     <button type="reset" id="kt_modal_update_tracking_cancel"
                         class="btn btn-light me-3">Discard</button>
                     <!--end::Button-->
                     <!--begin::Button-->
                     <button type="button" id="kt_modal_update_tracking_submit" class="btn btn-primary">
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
 <!--end::Modal - Trackings - Update-->