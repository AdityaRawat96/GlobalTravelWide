 <!--begin::Modals-->
 <!--begin::Modal - Stock - Update-->
 <div class="modal fade" id="kt_modal_update_stock" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Form-->
             <form class="form" action="{{route('admin.inventory.stock')}}" id="kt_modal_update_stock_form"
                 method="POST">
                 @csrf
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_update_stock_header">
                     <!--begin::Modal title-->
                     <h2 class="fw-bold">Update product stock</h2>
                     <!--end::Modal title-->
                     <!--begin::Close-->
                     <div id="kt_modal_update_stock_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_update_stock_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_update_stock_header"
                         data-kt-scroll-wrappers="#kt_modal_update_stock_scroll" data-kt-scroll-offset="300px">

                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <input type="text" name="customer_id" value="{{$customer_id}}" hidden>
                             <input type="text" id="product_asin" name="asin" value="" hidden>
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class=" fs-6 fw-semibold mb-2">Current Stock</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="number" class="form-control form-control-solid" placeholder=""
                                 id="current_stock" name="current_stock" readonly />
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Updated Stock</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="number" class="form-control form-control-solid" placeholder=""
                                 id="updated_stock" name="updated_stock" />
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class=" fs-6 fw-semibold mb-2">Current Working</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="number" class="form-control form-control-solid" placeholder=""
                                 id="current_working" name="current_working" readonly />
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Updated Working</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="number" class="form-control form-control-solid" placeholder=""
                                 id="updated_working" name="updated_working" />
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="fs-6 fw-semibold mb-2">Notes</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <textarea name="stock_notes" class="form-control form-control-solid" id="stock_notes"
                                 cols="30" rows="5"></textarea>
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--end::Billing form-->
                     </div>
                     <!--end::Scroll-->
                 </div>
                 <!--end::Modal body-->
                 <!--begin::Modal footer-->
                 <div class="modal-footer flex-center">
                     <!--begin::Button-->
                     <button type="reset" id="kt_modal_update_stock_cancel" class="btn btn-light me-3">Discard</button>
                     <!--end::Button-->
                     <!--begin::Button-->
                     <button type="button" id="kt_modal_update_stock_submit" class="btn btn-primary">
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
 <!--end::Modal - Stock - Update-->
 <!--end::Modals-->