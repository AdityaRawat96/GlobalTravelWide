 <!--begin::Modals-->
 <!--begin::Modal - Services - Add-->
 <div class="modal fade" id="kt_modal_add_service" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Form-->
             <form class="form" action="{{route('admin.service.store')}}" id="kt_modal_add_service_form" method="POST">
                 @csrf
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_add_service_header">
                     <!--begin::Modal title-->
                     <h2 class="fw-bold">Add Service</h2>
                     <!--end::Modal title-->
                     <!--begin::Close-->
                     <div id="kt_modal_add_service_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_add_service_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_add_service_header"
                         data-kt-scroll-wrappers="#kt_modal_add_service_scroll" data-kt-scroll-offset="300px">
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Name</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="text" class="form-control form-control-solid" placeholder="" name="name" />
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="fs-6 fw-semibold mb-2">Description</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <textarea class="form-control form-control-solid" name="description" id="description"
                                 rows="4"></textarea>
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Type</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <select class="form-select form-select-solid" data-control="select2"
                                 data-hide-search="true" data-placeholder="Select service type" name="type"
                                 id="add_service_type_select">
                                 <option value="fixed">Fixed Price</option>
                                 <option value="variable">Variable Price</option>
                             </select>
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7" id="add_service_dependency_select_container" style="display: none;">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Dependency</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <select class="form-select form-select-solid" data-control="select2"
                                 data-hide-search="true" data-placeholder="Select service dependency" name="dependency"
                                 id="add_service_dependency_select">
                                 <option value="products">Number of products packed</option>
                                 <option value="boxes">Number of boxes used</option>
                                 <option value="incoming_packages">Number of incoming packages</option>
                                 <option value="outgoing_packages">Number of outgoing packages</option>
                             </select>
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Unit Price</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="number" class="form-control form-control-solid" placeholder="" name="price" />
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
                     <button type="reset" id="kt_modal_add_service_cancel" class="btn btn-light me-3">Discard</button>
                     <!--end::Button-->
                     <!--begin::Button-->
                     <button type="button" id="kt_modal_add_service_submit" class="btn btn-primary">
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
 <!--end::Modal - Services - Update-->
 <!--begin::Modal - Services - Update-->
 <div class="modal fade" id="kt_modal_update_service" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Form-->
             <form class="form" action="{{route('admin.service.update', 1)}}" id="kt_modal_update_service_form"
                 method="POST">
                 @method('PUT')
                 @csrf
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_update_service_header">
                     <!--begin::Modal title-->
                     <h2 class="fw-bold">Update Service</h2>
                     <!--end::Modal title-->
                     <!--begin::Close-->
                     <div id="kt_modal_update_service_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_update_service_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_update_service_header"
                         data-kt-scroll-wrappers="#kt_modal_update_service_scroll" data-kt-scroll-offset="300px">
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Name</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="text" class="form-control form-control-solid" placeholder="" name="name" />
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="fs-6 fw-semibold mb-2">Description</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <textarea class="form-control form-control-solid" name="description" id="description"
                                 rows="4"></textarea>
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Type</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <select class="form-select form-select-solid" data-control="select2"
                                 data-hide-search="true" data-placeholder="Select service type" name="type"
                                 id="update_service_type_select">
                                 <option value="fixed">Fixed Price</option>
                                 <option value="variable">Variable Price</option>
                             </select>
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7" id="update_service_dependency_select_container"
                             style="display: none;">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Dependency</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <select class="form-select form-select-solid" data-control="select2"
                                 data-hide-search="true" data-placeholder="Select service dependency" name="dependency"
                                 id="update_service_dependency_select">
                                 <option value="products">Number of products packed</option>
                                 <option value="boxes">Number of boxes used</option>
                                 <option value="incoming_packages">Number of incoming packages</option>
                                 <option value="outgoing_packages">Number of outgoing packages</option>
                             </select>
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fs-6 fw-semibold mb-2">Unit Price</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="number" class="form-control form-control-solid" placeholder="" name="price" />
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
                     <button type="reset" id="kt_modal_update_service_cancel"
                         class="btn btn-light me-3">Discard</button>
                     <!--end::Button-->
                     <!--begin::Button-->
                     <button type="button" id="kt_modal_update_service_submit" class="btn btn-primary">
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
 <!--end::Modal - Services - Update-->
 <!--begin::Modal - Adjust Balance-->
 <div class="modal fade" id="kt_services_export_modal" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Modal header-->
             <div class="modal-header">
                 <!--begin::Modal title-->
                 <h2 class="fw-bold">Export Services</h2>
                 <!--end::Modal title-->
                 <!--begin::Close-->
                 <div id="kt_services_export_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                 <form id="kt_services_export_form" class="form" action="#">
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
                         <button type="reset" id="kt_services_export_cancel" class="btn btn-light me-3">Discard</button>
                         <button type="submit" id="kt_services_export_submit" class="btn btn-primary">
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