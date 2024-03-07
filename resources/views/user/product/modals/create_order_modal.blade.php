 <!--begin::Modal - Orders - Update-->
 <div class="modal fade" id="kt_modal_create_order" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered modal-xl">
         <!--begin::Modal content-->
         <div class="modal-content">
             <form class="form" action="{{route('user.order.createWithProducts')}}" id="create_order_form" method="POST"
                 data-search="{{route('user.product.searchProduct')}}">
                 @csrf
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_create_order_header">
                     <!--begin::Modal title-->
                     <h2 class="fw-bold">Create Order</h2>
                     <!--end::Modal title-->
                     <!--begin::Close-->
                     <div id="kt_modal_create_order_close" class="btn btn-icon btn-sm btn-active-icon-primary"
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
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_create_order_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_create_order_header"
                         data-kt-scroll-wrappers="#kt_modal_create_order_scroll" data-kt-scroll-offset="300px">

                         <table class="table align-middle table-row-dashed fs-6 gy-5"
                             id="kt_ecommerce_create_order_table">
                             <thead>
                                 <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                     <th></th>
                                     <th>Product</th>
                                     <th class="pe-5">In-Stock</th>
                                     <th class="pe-5">Bundle</th>
                                     <th class="pe-5">Send from Inventory</th>
                                     <th class="pe-5">Outgoing</th>
                                 </tr>
                             </thead>
                             <tbody class="create_order_table_body" style="vertical-align: top;">

                             </tbody>
                         </table>
                     </div>
                     <!--end::Scroll-->

                 </div>
                 <!--end::Modal body-->
                 <!--begin::Modal footer-->
                 <div class="modal-footer flex-end">
                     <!--begin::Button-->
                     <button type="reset" id="kt_modal_create_order_cancel" class="btn btn-light me-3"
                         data-bs-dismiss="modal">Discard</button>
                     <!--end::Button-->
                     <!--begin::Button-->
                     <button type="button" id="kt_modal_create_order_submit" class="btn btn-primary">
                         <span class="indicator-label">Submit</span>
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
 <!--end::Modal - Orders - Update-->
 <style>
#create_order_form .error {
    color: red !important;
    font-size: 12px !important;
}

#create_order_form input[type='number'],
select {
    min-width: 200px
}

.create_order_table_body .form-control.form-control-solid {
    min-width: 50px;
    max-width: 200px;
}
 </style>