 <!--begin::Modal - Productss - Update-->
 <div class="modal fade" id="kt_modal_update_products" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Modal header-->
             <div class="modal-header" id="kt_modal_update_products_header">
                 <!--begin::Modal title-->
                 <h2 class="fw-bold">Products shipping status</h2>
                 <!--end::Modal title-->
                 <!--begin::Close-->
                 <div id="kt_modal_update_products_close" class="btn btn-icon btn-sm btn-active-icon-primary"
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
                 <div class="scroll-y me-n7 pe-7" id="kt_modal_update_products_scroll" data-kt-scroll="true"
                     data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                     data-kt-scroll-dependencies="#kt_modal_update_products_header"
                     data-kt-scroll-wrappers="#kt_modal_update_products_scroll" data-kt-scroll-offset="300px">

                     <div class="row">
                         <div class="col-sm-12 col-md-6"></div>
                         <div class="col-sm-12 col-md-6">
                             <label class="form-label fw-bold">Filter:</label>
                             <select class="form-select form-select-solid mb-5" data-control="select2"
                                 data-placeholder="Select option" data-hide-search="true"
                                 data-select2-id="select2-data-1-2n3m" id="view_products_filter">
                                 <option value="all">All</option>
                                 <option value="bundled">Bundled / De-Bundled</option>
                             </select>
                         </div>
                     </div>

                     <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                         <li class="nav-item">
                             <a class="nav-link active" data-bs-toggle="tab" href="#kt_products_incoming">Incoming</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" data-bs-toggle="tab" href="#kt_products_outgoing">Outgoing</a>
                         </li>
                     </ul>
                     <div class="tab-content" id="myTabContent">
                         <div class="tab-pane fade show active" id="kt_products_incoming" role="tabpanel">


                             <table class="table align-middle table-row-dashed fs-6 gy-5"
                                 id="kt_ecommerce_edit_order_product_table">
                                 <thead>
                                     <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                         <th>Product</th>
                                         <th class="text-end pe-5">Quantity</th>
                                         <th class="text-end pe-5">Received</th>
                                         <th class="text-end pe-5">Damaged</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($data['incoming_products'] as $index=>$product)
                                     <tr
                                         class="{{isset($product['bundle']) && $product['bundle'] != 'none' ? 'bundled-item' : 'unbundled-item'}}">
                                         <!--begin::Product=-->
                                         <td>
                                             <div class="d-flex align-items-center"
                                                 data-kt-ecommerce-edit-order-filter="product">
                                                 <!--begin::Thumbnail-->
                                                 <a href="#" class="symbol symbol-50px">
                                                     <span
                                                         class="symbol-label border border-dashed border-primary rounded"
                                                         style="background-image:url({{$product['image']}})"></span>
                                                 </a>
                                                 <!--end::Thumbnail-->
                                                 <div class="ms-5">
                                                     <!--begin::Title-->
                                                     <a href="#"
                                                         class="text-gray-800 text-hover-primary fs-5 fw-bold">{{$index}}</a>
                                                     <!--end::Title-->

                                                     <!--begin::Price-->
                                                     <div class="fw-semibold fs-7">Price: $
                                                         <span
                                                             data-kt-ecommerce-edit-order-filter="price">{{number_format($product['price'], 2)}}</span>
                                                     </div>
                                                     <!--end::Price-->
                                                     @if(isset($product['bundle']) && $product['bundle'] != "none")
                                                     <span class="badge py-3 px-4 fs-7 badge-light-success">
                                                         {{ucfirst($product['bundle'])}}
                                                     </span>
                                                     @endif
                                                 </div>
                                             </div>
                                         </td>
                                         <!--end::Product=-->
                                         <!--begin::Qty=-->
                                         <td class="text-end pe-5">
                                             <span class="fw-bold text-warning ms-3">{{$product['total']}}</span>
                                         </td>
                                         <!--end::Qty=-->
                                         <td class="text-end pe-5">
                                             <span
                                                 class="fw-bold text-warning ms-3">{{isset($product['received']) ? $product['received'] : 0}}</span>
                                         </td>
                                         <td class="text-end pe-5">
                                             <span
                                                 class="fw-bold text-warning ms-3">{{isset($product['damaged']) ? $product['damaged'] : 0}}</span>
                                         </td>
                                     </tr>
                                     @endforeach
                                 </tbody>
                             </table>
                         </div>
                         <div class="tab-pane fade" id="kt_products_outgoing" role="tabpanel">
                             <table class="table align-middle table-row-dashed fs-6 gy-5"
                                 id="kt_ecommerce_edit_order_product_table">
                                 <thead>
                                     <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                         <th>Product</th>
                                         <th class="text-end pe-5">Quantity</th>
                                         <th class="text-end pe-5">Shipped</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($data['outgoing_products'] as $index=>$product)
                                     <tr
                                         class="{{isset($product['bundle']) && $product['bundle'] != 'none' ? 'bundled-item' : 'unbundled-item'}}">
                                         <!--begin::Product=-->
                                         <td>
                                             <div class="d-flex align-items-center"
                                                 data-kt-ecommerce-edit-order-filter="product">
                                                 <!--begin::Thumbnail-->
                                                 <a href="#" class="symbol symbol-50px">
                                                     <span
                                                         class="symbol-label border border-dashed border-primary rounded"
                                                         style="background-image:url({{$product['image']}})"></span>
                                                 </a>
                                                 <!--end::Thumbnail-->
                                                 <div class="ms-5">
                                                     <!--begin::Title-->
                                                     <a href="#"
                                                         class="text-gray-800 text-hover-primary fs-5 fw-bold">{{$index}}</a>
                                                     <!--end::Title-->

                                                     <!--begin::Price-->
                                                     <div class="fw-semibold fs-7">Price: $
                                                         <span
                                                             data-kt-ecommerce-edit-order-filter="price">{{number_format($product['price'], 2)}}</span>
                                                     </div>
                                                     <!--end::Price-->
                                                     @if(isset($product['bundle']) && $product['bundle'] != "none")
                                                     <span class="badge py-3 px-4 fs-7 badge-light-success">
                                                         {{ucfirst($product['bundle'])}}
                                                     </span>
                                                     @endif
                                                 </div>
                                             </div>
                                         </td>
                                         <!--end::Product=-->
                                         <!--begin::Qty=-->
                                         <td class="text-end pe-5">
                                             <span class="fw-bold text-warning ms-3">{{$product['total']}}</span>
                                         </td>
                                         <!--end::Qty=-->
                                         <td class="text-end pe-5">
                                             <span
                                                 class="fw-bold text-warning ms-3">{{isset($product['shipped']) ? $product['shipped'] : 0}}</span>
                                         </td>
                                     </tr>
                                     @endforeach
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
                 <!--end::Scroll-->
             </div>
             <!--end::Modal body-->
             <!--begin::Modal footer-->
             <div class="modal-footer flex-center">
                 <!--begin::Button-->
                 <button type="reset" id="kt_modal_update_products_cancel" class="btn btn-light me-3"
                     data-bs-dismiss="modal">Discard</button>
                 <!--end::Button-->
             </div>
             <!--end::Modal footer-->
         </div>
     </div>
 </div>
 <!--end::Modal - Productss - Update-->