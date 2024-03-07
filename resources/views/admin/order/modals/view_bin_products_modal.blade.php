 <!--begin::Modal - Productss - Update-->
 <div class="modal fade" id="kt_modal_view_bin_products" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered modal-xl">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Modal header-->
             <div class="modal-header" id="kt_modal_view_bin_products_header">
                 <!--begin::Modal title-->
                 <h2 class="fw-bold">Products contained</h2>
                 <!--end::Modal title-->
                 <!--begin::Close-->
                 <div id="kt_modal_view_bin_products_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
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
                 <div class="scroll-y me-n7 pe-7" id="kt_modal_view_bin_products_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_view_bin_products_header" data-kt-scroll-wrappers="#kt_modal_view_bin_products_scroll" data-kt-scroll-offset="300px">
                     @foreach($data['bins'] as $index => $bin)
                     <div class="bin_products_{{$index}} bin_products_container d-none">
                         <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_edit_order_product_table">
                             <thead>
                                 <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                     <th>Product</th>
                                     <th>Title</th>
                                     <th>Weight</th>
                                     <th>Dimensions</th>
                                     <th class="text-end pe-5">Quantity</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($bin['products'] as $index=>$product)
                                 <tr>
                                     <!--begin::Product=-->
                                     <td>
                                         <div class="d-flex align-items-center" data-kt-ecommerce-edit-order-filter="product">
                                             <a href="#" class="symbol symbol-50px">
                                                 <span class="symbol-label border border-dashed border-primary rounded" style="background-image:url({{$data['product_map'][$index]['image']}})"></span>
                                             </a>
                                             <div class="ms-5">
                                                 <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">
                                                     {{$index}}
                                                 </a>
                                                 <div class="fw-semibold fs-7">Price: $
                                                     <span data-kt-ecommerce-edit-order-filter="price">
                                                         {{number_format($product['price'], 2)}}
                                                     </span>
                                                 </div>
                                                 @if($data['product_map'][$index]['bundle'] != 'none')
                                                 <span class="badge py-3 px-4 fs-7 badge-light-success">
                                                     {{$data['product_map'][$index]['bundle']}}
                                                 </span>
                                                 @endif
                                             </div>
                                         </div>
                                     </td>
                                     <td class="mw-250px">
                                         <small>{{$data['product_map'][$index]['title']}}</small>
                                     </td>
                                     <td>
                                         {{$data['product_map'][$index]['weight']}} lbs
                                     </td>
                                     <td>
                                         {{$data['product_map'][$index]['length']}} x
                                         {{$data['product_map'][$index]['width']}} x
                                         {{$data['product_map'][$index]['height']}} in
                                     </td>
                                     <td class="text-end pe-5">
                                         <span class="fw-bold text-warning ms-3">{{$product['qty']}}</span>
                                     </td>
                                 </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                     @endforeach
                 </div>
                 <!--end::Scroll-->
             </div>
             <!--end::Modal body-->
             <!--begin::Modal footer-->
             <div class="modal-footer flex-center">
                 <!--begin::Button-->
                 <button type="reset" id="kt_modal_view_bin_products_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Dismiss</button>
                 <!--end::Button-->
             </div>
             <!--end::Modal footer-->
         </div>
     </div>
 </div>
 <!--end::Modal - Productss - Update-->