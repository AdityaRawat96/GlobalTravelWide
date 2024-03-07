 <!--begin::Modals-->
 <!--begin::Modal - Transactions - View-->
 <div class="modal fade" id="kt_modal_view_transaction" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Modal header-->
             <div class="modal-header" id="kt_modal_view_transaction_header">
                 <!--begin::Modal title-->
                 <h2 class="fw-bold">View Transaction</h2>
                 <!--end::Modal title-->
                 <!--begin::Close-->
                 <div id="kt_modal_view_transaction_close" class="btn btn-icon btn-sm btn-active-icon-primary"
                     data-bs-dismiss="modal">
                     <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                     <span class="svg-icon svg-icon-1">
                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                 <div class="scroll-y me-n7 pe-7" id="kt_modal_view_transaction_scroll" data-kt-scroll="true"
                     data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                     data-kt-scroll-dependencies="#kt_modal_view_transaction_header"
                     data-kt-scroll-wrappers="#kt_modal_view_transaction_scroll" data-kt-scroll-offset="300px">
                     <!--begin::Input group-->
                     <div class="fv-row mb-7">
                         <!--begin::Label-->
                         <label class="fs-6 fw-semibold mb-2">Transcation ID</label>
                         <!--end::Label-->
                         <!--begin::Input-->
                         <input type="text" class="form-control form-control-solid" placeholder="" name="transaction_id"
                             disabled />
                         <!--end::Input-->
                     </div>
                     <!--end::Input group-->
                     <!--begin::Input group-->
                     <div class="fv-row mb-7">
                         <!--begin::Label-->
                         <label class="fs-6 fw-semibold mb-2">Description</label>
                         <!--end::Label-->
                         <!--begin::Input-->
                         <input type="text" class="form-control form-control-solid" placeholder="" name="type"
                             disabled />
                         <!--end::Input-->
                     </div>
                     <!--end::Input group-->
                     <!--begin::Input group-->
                     <div class="fv-row mb-7">
                         <!--begin::Label-->
                         <label class="fs-6 fw-semibold mb-2">Amount ($)</label>
                         <!--end::Label-->
                         <!--begin::Input-->
                         <input type="number" class="form-control form-control-solid" placeholder="" name="amount"
                             disabled />
                         <!--end::Input-->
                     </div>
                     <!--end::Input group-->
                     <!--begin::Input group-->
                     <div class="fv-row mb-7">
                         <!--begin::Label-->
                         <label class="fs-6 fw-semibold mb-2">Status</label>
                         <!--end::Label-->
                         <!--begin::Input-->
                         <input type="text" class="form-control form-control-solid" placeholder="" name="status"
                             disabled />
                         <!--end::Input-->
                     </div>
                     <!--end::Input group-->
                     <!--begin::Input group-->
                     <div class="fv-row mb-7 receipt-download">
                         <!--begin::Label-->
                         <label class="fs-6 fw-semibold mb-2 d-block">Receipt</label>
                         <!--end::Label-->
                         <!--begin::Input-->
                         <a href="#" id="transaction-receipt-modal">
                             <button type="button" class="btn btn-primary d-block">Download</button>
                         </a>
                         <!--end::Input-->
                     </div>
                     <!--end::Input group-->
                     <!--begin::Input group-->
                     <div class="fv-row mb-7">
                         <!--begin::Label-->
                         <label class="required fs-6 fw-semibold mb-2">Notes</label>
                         <!--end::Label-->
                         <!--begin::Input-->
                         <textarea class="form-control form-control-solid" name="notes" id="notes" rows="6"
                             disabled></textarea>
                         <!--end::Input-->
                     </div>
                     <!--end::Input group-->
                 </div>
                 <!--end::Scroll-->
             </div>
             <!--end::Modal body-->
             <!--begin::Modal footer-->
             <div class="modal-footer flex-center">
                 <!--begin::Button-->
                 <button type="reset" id="kt_modal_view_transaction_cancel" class="btn btn-light me-3"
                     data-bs-dismiss="modal">Discard</button>
                 <!--end::Button-->
             </div>
             <!--end::Modal footer-->

         </div>
     </div>
 </div>
 <!--end::Modal - Transactions - View-->
 <!--begin::Modal - Transactions - Update-->
 <div class="modal fade" id="kt_modal_update_transaction" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Form-->
             <form class="form" action="{{route('admin.transaction.update', 1)}}" id="kt_modal_update_transaction_form"
                 method="POST">
                 @method('PUT')
                 @csrf
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_update_transaction_header">
                     <!--begin::Modal title-->
                     <h2 class="fw-bold">Update Transaction</h2>
                     <!--end::Modal title-->
                     <!--begin::Close-->
                     <div id="kt_modal_update_transaction_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_update_transaction_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_update_transaction_header"
                         data-kt-scroll-wrappers="#kt_modal_update_transaction_scroll" data-kt-scroll-offset="300px">
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="fs-6 fw-semibold mb-2">Amount ($)</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="number" class="form-control form-control-solid" placeholder=""
                                 name="amount" />
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="fs-6 fw-semibold mb-2">Status</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <select class="form-control form-control-solid" name="status">
                                 <option value="pending">Pending</option>
                                 <option value="success">Success</option>
                                 <option value="failed">Failed</option>
                             </select>
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7 receipt-download">
                             <!--begin::Label-->
                             <label class="fs-6 fw-semibold mb-2 d-block">Receipt</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <a href="#" id="transaction-receipt-modal">
                                 <button type="button" class="btn btn-primary d-block">Download</button>
                             </a>
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Notes</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <textarea class="form-control form-control-solid" name="notes" id="notes"
                                 rows="6"></textarea>
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <div class="billing_address mt-5">
                             <br>
                             <h3>Billing Address:</h3>
                             <span class="billing_address_field"></span>
                         </div>
                     </div>
                     <!--end::Scroll-->
                 </div>
                 <!--end::Modal body-->
                 <!--begin::Modal footer-->
                 <div class="modal-footer flex-center">
                     <!--begin::Button-->
                     <button type="reset" id="kt_modal_update_transaction_cancel"
                         class="btn btn-light me-3">Discard</button>
                     <!--end::Button-->
                     <!--begin::Button-->
                     <button type="button" id="kt_modal_update_transaction_submit" class="btn btn-primary">
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
 <!--end::Modal - Transactions - Update-->
 <!--end::Modals-->