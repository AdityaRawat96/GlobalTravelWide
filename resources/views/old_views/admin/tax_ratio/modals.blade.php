 <!--begin::Modals-->
 <!--begin::Modal - Tax_ratios - Add-->
 <div class="modal fade" id="kt_modal_add_tax_ratio" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Form-->
             <form class="form" action="{{route('admin.tax_ratio.store')}}" id="kt_modal_add_tax_ratio_form"
                 method="POST">
                 @csrf
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_add_tax_ratio_header">
                     <!--begin::Modal title-->
                     <h2 class="fw-bold">Add Tax Ratio</h2>
                     <!--end::Modal title-->
                     <!--begin::Close-->
                     <div id="kt_modal_add_tax_ratio_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_add_tax_ratio_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_add_tax_ratio_header"
                         data-kt-scroll-wrappers="#kt_modal_add_tax_ratio_scroll" data-kt-scroll-offset="300px">

                         <!--begin::Input group-->
                         <div class="fv-row mb-7">

                             <input type="text" name="country_id" value="{{$country_id}}" hidden>
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Tax Ratio</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="number" class="form-control form-control-solid" placeholder=""
                                 name="tax_ratio" />
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="row g-9 mb-7">
                             <!--begin::Col-->
                             <div class="col-md-6 fv-row">
                                 <!--begin::Label-->
                                 <label class="required fs-6 fw-semibold mb-2">Min. Price</label>
                                 <!--end::Label-->
                                 <!--begin::Input-->
                                 <input type="number" class="form-control form-control-solid" placeholder=""
                                     name="min_price" />
                                 <!--end::Input-->
                             </div>
                             <!--end::Col-->
                             <!--begin::Col-->
                             <div class="col-md-6 fv-row">
                                 <!--begin::Label-->
                                 <label class="required fs-6 fw-semibold mb-2">Max. Price</label>
                                 <!--end::Label-->
                                 <!--begin::Input-->
                                 <input type="number" class="form-control form-control-solid" placeholder=""
                                     name="max_price" />
                                 <!--end::Input-->
                             </div>
                             <!--end::Col-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Details toggle-->
                         <div class="fw-bold fs-3 rotate collapsible mb-8 mt-8" data-bs-toggle="collapse"
                             href="#kt_modal_upload_file" role="button" aria-expanded="false"
                             aria-controls="kt_box_view_details">Or upload from a file
                             <span class="ms-2 rotate-180">
                                 <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                 <span class="svg-icon svg-icon-3">
                                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                         <path
                                             d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                             fill="currentColor" />
                                     </svg>
                                 </span>
                                 <!--end::Svg Icon-->
                             </span>
                         </div>
                         <!--end::Billing toggle-->
                         <!--begin::Billing form-->
                         <div id="kt_modal_upload_file" class="collapse show">
                             <!--begin::Input group-->
                             <div class="fv-row mb-7">
                                 <!--begin::Input-->
                                 <input type="file" class="form-control form-control-solid"
                                     accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                     name="excel_file" />
                                 <!--end::Input-->
                             </div>
                             <!--end::Input group-->
                             <!--begin::Description-->
                             <div class="text-muted fs-7">Upload the file in excel format containing the data. <a
                                     href="{{ asset('excel_templates/WareHouseTaxRatios.xlsx') }}">Sample file</a></div>
                             <!--end::Description-->
                         </div>
                         <!--end::Billing form-->
                     </div>
                     <!--end::Scroll-->
                 </div>
                 <!--end::Modal body-->
                 <!--begin::Modal footer-->
                 <div class="modal-footer flex-center">
                     <!--begin::Button-->
                     <button type="reset" id="kt_modal_add_tax_ratio_cancel" class="btn btn-light me-3">Discard</button>
                     <!--end::Button-->
                     <!--begin::Button-->
                     <button type="button" id="kt_modal_add_tax_ratio_submit" class="btn btn-primary">
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
 <!--end::Modal - Tax_ratios - Update-->
 <!--begin::Modal - Tax_ratios - Update-->
 <div class="modal fade" id="kt_modal_update_tax_ratio" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Form-->
             <form class="form" action="{{route('admin.tax_ratio.update', 1)}}" id="kt_modal_update_tax_ratio_form"
                 method="POST">
                 @method('PUT')
                 @csrf
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_update_tax_ratio_header">
                     <!--begin::Modal title-->
                     <h2 class="fw-bold">Update Tax_ratio</h2>
                     <!--end::Modal title-->
                     <!--begin::Close-->
                     <div id="kt_modal_update_tax_ratio_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_update_tax_ratio_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_update_tax_ratio_header"
                         data-kt-scroll-wrappers="#kt_modal_update_tax_ratio_scroll" data-kt-scroll-offset="300px">

                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <input type="text" name="country_id" value="{{$country_id}}" hidden>
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Tax Ratio</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="number" class="form-control form-control-solid" placeholder=""
                                 name="tax_ratio" />
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="row g-9 mb-7">
                             <!--begin::Col-->
                             <div class="col-md-6 fv-row">
                                 <!--begin::Label-->
                                 <label class="required fs-6 fw-semibold mb-2">Min. Price</label>
                                 <!--end::Label-->
                                 <!--begin::Input-->
                                 <input type="number" class="form-control form-control-solid" placeholder=""
                                     name="min_price" />
                                 <!--end::Input-->
                             </div>
                             <!--end::Col-->
                             <!--begin::Col-->
                             <div class="col-md-6 fv-row">
                                 <!--begin::Label-->
                                 <label class="required fs-6 fw-semibold mb-2">Max. Price</label>
                                 <!--end::Label-->
                                 <!--begin::Input-->
                                 <input type="number" class="form-control form-control-solid" placeholder=""
                                     name="max_price" />
                                 <!--end::Input-->
                             </div>
                             <!--end::Col-->
                         </div>
                         <!--end::Input group-->
                     </div>
                     <!--end::Scroll-->
                 </div>
                 <!--end::Modal body-->
                 <!--begin::Modal footer-->
                 <div class="modal-footer flex-center">
                     <!--begin::Button-->
                     <button type="reset" id="kt_modal_update_tax_ratio_cancel"
                         class="btn btn-light me-3">Discard</button>
                     <!--end::Button-->
                     <!--begin::Button-->
                     <button type="button" id="kt_modal_update_tax_ratio_submit" class="btn btn-primary">
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
 <!--end::Modal - Tax_ratios - Update-->
 <!--begin::Modal - Adjust Balance-->
 <div class="modal fade" id="kt_tax_ratios_export_modal" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Modal header-->
             <div class="modal-header">
                 <!--begin::Modal title-->
                 <h2 class="fw-bold">Export Tax_ratios</h2>
                 <!--end::Modal title-->
                 <!--begin::Close-->
                 <div id="kt_tax_ratios_export_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
             <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                 <!--begin::Form-->
                 <form id="kt_tax_ratios_export_form" class="form" action="#">
                     <!--begin::Input group-->
                     <div class="fv-row mb-10">
                         <!--begin::Label-->
                         <label class="fs-5 fw-semibold form-label mb-5">Select Export Format:</label>
                         <!--end::Label-->
                         <!--begin::Input-->
                         <select data-control="select2" data-placeholder="Select a format" data-hide-search="true"
                             name="format" class="form-select form-select-solid">
                             <option value="excell">Excel</option>
                             <option value="pdf">PDF</option>
                             <option value="cvs">CVS</option>
                             <option value="zip">ZIP</option>
                         </select>
                         <!--end::Input-->
                     </div>
                     <!--end::Input group-->
                     <!--begin::Input group-->
                     <div class="fv-row mb-10">
                         <!--begin::Label-->
                         <label class="fs-5 fw-semibold form-label mb-5">Select Date Range:</label>
                         <!--end::Label-->
                         <!--begin::Input-->
                         <input class="form-control form-control-solid" placeholder="Pick a date" name="date" />
                         <!--end::Input-->
                     </div>
                     <!--end::Input group-->
                     <!--begin::Row-->
                     <div class="row fv-row mb-15">
                         <!--begin::Label-->
                         <label class="fs-5 fw-semibold form-label mb-5">Payment Type:</label>
                         <!--end::Label-->
                         <!--begin::Radio group-->
                         <div class="d-flex flex-column">
                             <!--begin::Radio button-->
                             <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                 <input class="form-check-input" type="checkbox" value="1" checked="checked"
                                     name="payment_type" />
                                 <span class="form-check-label text-gray-600 fw-semibold">All</span>
                             </label>
                             <!--end::Radio button-->
                             <!--begin::Radio button-->
                             <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                 <input class="form-check-input" type="checkbox" value="2" checked="checked"
                                     name="payment_type" />
                                 <span class="form-check-label text-gray-600 fw-semibold">Visa</span>
                             </label>
                             <!--end::Radio button-->
                             <!--begin::Radio button-->
                             <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                 <input class="form-check-input" type="checkbox" value="3" name="payment_type" />
                                 <span class="form-check-label text-gray-600 fw-semibold">Mastercard</span>
                             </label>
                             <!--end::Radio button-->
                             <!--begin::Radio button-->
                             <label class="form-check form-check-custom form-check-sm form-check-solid">
                                 <input class="form-check-input" type="checkbox" value="4" name="payment_type" />
                                 <span class="form-check-label text-gray-600 fw-semibold">American
                                     Express</span>
                             </label>
                             <!--end::Radio button-->
                         </div>
                         <!--end::Input group-->
                     </div>
                     <!--end::Row-->
                     <!--begin::Actions-->
                     <div class="text-center">
                         <button type="reset" id="kt_tax_ratios_export_cancel"
                             class="btn btn-light me-3">Discard</button>
                         <button type="submit" id="kt_tax_ratios_export_submit" class="btn btn-primary">
                             <span class="indicator-label">Submit</span>
                             <span class="indicator-progress">Please wait...
                                 <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                         </button>
                     </div>
                     <!--end::Actions-->
                 </form>
                 <!--end::Form-->
             </div>
             <!--end::Modal body-->
         </div>
         <!--end::Modal content-->
     </div>
     <!--end::Modal dialog-->
 </div>
 <!--end::Modal - New Card-->
 <!--end::Modals-->