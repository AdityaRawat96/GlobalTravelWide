 <!--begin::Modal - Productss - Update-->
 <div class="modal fade" id="kt_modal_update_package_cost" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Form-->
             <form class="form" action="{{route('admin.order.updateCost', $data['order']->order_id)}}"
                 id="kt_modal_update_package_cost_form" method="POST">
                 @csrf
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_update_package_cost_header">
                     <!--begin::Modal title-->
                     <h2 class="fw-bold">Package Cost</h2>
                     <!--end::Modal title-->
                     <!--begin::Close-->
                     <div id="kt_modal_update_package_cost_close" class="btn btn-icon btn-sm btn-active-icon-primary"
                         data-bs-dismiss="modal">
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
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_update_package_cost_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_update_package_cost_header"
                         data-kt-scroll-wrappers="#kt_modal_update_package_cost_scroll" data-kt-scroll-offset="300px">
                         <input type="text" id="cost_update_bin_id" name="box_id" hidden>
                         <!--begin::Input group-->
                         <div class="fv-row mb-5">
                             <label class="required fs-6 fw-semibold mb-2">Import Fee ($)</label>
                             <input type="text" class="form-control form-control-solid" name="import_charges"
                                 id="modal_import_fee" />
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-5">
                             <label class="required fs-6 fw-semibold mb-2">Shipping Fee ($)</label>
                             <input type="text" class="form-control form-control-solid" name="shipping_fee"
                                 id="modal_shipping_fee" />
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-5">
                             <label class="fs-6 fw-semibold mb-2">Total</label>
                             <input type="text" class="form-control form-control-solid" name="fee_total" disabled
                                 id="modal_total_fee" />
                         </div>
                         <!--end::Input group-->

                     </div>
                     <!--end::Scroll-->
                 </div>
                 <!--end::Modal body-->
                 <!--begin::Modal footer-->
                 <div class="modal-footer flex-center">
                     <!--begin::Button-->
                     <button type="reset" id="kt_modal_update_package_cost_cancel"
                         class="btn btn-light me-3">Discard</button>
                     <!--end::Button-->
                     <!--begin::Button-->
                     <button type="button" id="kt_modal_update_package_cost_submit" class="btn btn-primary">
                         <span class="indicator-label">Update</span>
                         <span class="indicator-progress">Please wait...
                             <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                     </button>
                     <!--end::Button-->
                 </div>
                 <!--end::Modal footer-->
             </form>
         </div>
     </div>
 </div>
 <!--end::Modal - Productss - Update-->