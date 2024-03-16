 <!--begin::Modal - Shipments - View-->
 <div class="modal fade" id="kt_modal_view_shipment" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered modal-xl">
         <!--begin::Modal content-->
         <div class="modal-content">
             <form class="form" action="#" id="view_shipment_form" method="POST">
                 @csrf
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_view_shipment_header">
                     <!--begin::Modal title-->
                     <h2 class="fw-bold">Shipment History</h2>
                     <!--end::Modal title-->
                     <!--begin::Close-->
                     <div id="kt_modal_view_shipment_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                         <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                         <span class="svg-icon svg-icon-1">
                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                 <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
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
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_view_shipment_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_view_shipment_header" data-kt-scroll-wrappers="#kt_modal_view_shipment_scroll" data-kt-scroll-offset="300px">

                         <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_view_shipment_table">
                             <thead>
                                 <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                     <th>ASIN</th>
                                     <th class="pe-5">Date</th>
                                     <th class="text-end pe-5">Incoming</th>
                                     <th class="text-end pe-5">Received</th>
                                     <th class="text-end pe-5">Damaged</th>
                                     <th class="pe-5">Notes</th>
                                 </tr>
                             </thead>
                             <tbody id="view_shipment_table_body" style="vertical-align: top;">

                             </tbody>
                         </table>
                     </div>
                     <!--end::Scroll-->

                 </div>
                 <!--end::Modal body-->
                 <!--begin::Modal footer-->
                 <div class="modal-footer flex-end">
                     <!--begin::Button-->
                     <button type="reset" id="kt_modal_view_shipment_cancel" class="btn btn-primary me-3" data-bs-dismiss="modal">Discard</button>
                     <!--end::Button-->
                 </div>
                 <!--end::Modal footer-->
             </form>
         </div>
     </div>
 </div>
 <!--end::Modal - Shipments - View-->
 <style>
     #view_shipment_form .error {
         color: red !important;
         font-size: 12px !important;
     }

     #view_shipment_form input[type='number'],
     select {
         min-width: 200px
     }
 </style>