 <!--begin::Modal - Productss - Update-->
 <div class="modal fade" id="kt_modal_view_labels" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Modal header-->
             <div class="modal-header" id="kt_modal_view_labels_header">
                 <!--begin::Modal title-->
                 <h2 class="fw-bold">Lables Uploaded</h2>
                 <!--end::Modal title-->
                 <!--begin::Close-->
                 <div id="kt_modal_view_labels_close" class="btn btn-icon btn-sm btn-active-icon-primary"
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
                 <div class="scroll-y me-n7 pe-7" id="kt_modal_view_labels_scroll" data-kt-scroll="true"
                     data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                     data-kt-scroll-dependencies="#kt_modal_view_labels_header"
                     data-kt-scroll-wrappers="#kt_modal_view_labels_scroll" data-kt-scroll-offset="300px">

                     <h3>Product FNSKU Labels</h3>

                     <table class="table align-middle table-row-dashed fs-6 gy-5"
                         id="kt_ecommerce_edit_order_product_table">
                         <thead>
                             <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                 <th>Product</th>
                                 <th class="text-end pe-5">Labels</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach($data['products'] as $index=>$product)
                             <tr>
                                 <!--begin::Product=-->
                                 <td>
                                     <div class="d-flex align-items-center"
                                         data-kt-ecommerce-edit-order-filter="product">
                                         <!--begin::Thumbnail-->
                                         <a href="#" class="symbol symbol-50px">
                                             <span class="symbol-label border border-dashed border-primary rounded"
                                                 style="background-image:url({{$product['image']}})"></span>
                                         </a>
                                         <!--end::Thumbnail-->
                                         <div class="ms-5">
                                             <!--begin::Title-->
                                             <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">Product
                                                 {{$index + 1}}</a>
                                             <!--end::Title-->

                                             <!--begin::Price-->
                                             <div class="fw-semibold fs-7">Price: $
                                                 <span
                                                     data-kt-ecommerce-edit-order-filter="price">{{number_format($product['price'], 2)}}</span>
                                             </div>
                                             <!--end::Price-->
                                             <!--begin::SKU-->
                                             <div class="text-muted fs-7">ASIN:
                                                 {{$product['asin']}}
                                             </div>
                                             <!--end::SKU-->
                                             @if(isset($product['bundle']) && $product['bundle'] != "none")
                                             <span class="badge py-3 px-4 fs-7 badge-light-success">
                                                 {{ucfirst($product['bundle'])}}
                                             </span>
                                             @endif
                                         </div>
                                     </div>
                                 </td>
                                 <!--end::Product=-->
                                 <td class="text-end pe-5">
                                     @if(isset($product['label_file']) && $product['label_file'])
                                     <a href="{{Storage::disk('s3')->url($product['label_file'])}}" download>
                                         <i class="fas fa-file text-primary" style="font-size: 2em;"></i>
                                     </a>
                                     @else
                                     <span class="badge py-3 px-4 fs-7 badge-light-warning">No Label</span>
                                     @endif
                                 </td>
                             </tr>
                             @endforeach
                         </tbody>
                     </table>
                     <br><br>
                     <h3>Combined FNSKU Labels</h3>
                     <br>
                     @if($data['order']->fnsku_labels && count(json_decode($data['order']->fnsku_labels, true)))
                     <div class="row">
                         @foreach(json_decode($data['order']->fnsku_labels, true) as $fnsku_label)
                         <div class="col-md-2 col-sm-3">
                             <a href="{{Storage::disk('s3')->url($fnsku_label)}}" download>
                                 <i class="fas fa-file text-primary m-3" style="font-size: 2em;"></i>
                             </a>
                         </div>
                         @endforeach
                     </div>
                     @else
                     <span class="badge py-3 px-4 fs-7 badge-light-warning">No Labels</span>
                     @endif
                     <br><br>
                     <h3>FBA Labels</h3>
                     <br>
                     @if(count(json_decode($data['order']->fba_labels, true)))
                     <div class="row">
                         @foreach(json_decode($data['order']->fba_labels, true) as $fba_label)
                         <div class="col-md-2 col-sm-3">
                             <a href="{{Storage::disk('s3')->url($fba_label)}}" download>
                                 <i class="fas fa-file text-primary m-3" style="font-size: 2em;"></i>
                             </a>
                         </div>
                         @endforeach
                     </div>
                     @else
                     <span class="badge py-3 px-4 fs-7 badge-light-warning">No Labels</span>
                     @endif
                 </div>
                 <!--end::Scroll-->
             </div>
             <!--end::Modal body-->
             <!--begin::Modal footer-->
             <div class="modal-footer flex-center">
                 <!--begin::Button-->
                 <button type="reset" id="kt_modal_view_labels_cancel" class="btn btn-light me-3"
                     data-bs-dismiss="modal">Discard</button>
                 <!--end::Button-->
             </div>
             <!--end::Modal footer-->

         </div>
     </div>
 </div>
 <!--end::Modal - Productss - Update-->