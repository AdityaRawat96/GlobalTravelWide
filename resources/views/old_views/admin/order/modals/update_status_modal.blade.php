 <!--begin::Modal - Statuss - Update-->
 <div class="modal fade" id="kt_modal_update_status" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered modal-lg">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Form-->
             <form class="form" action="{{route('admin.order.update', $data['order']->order_id)}}"
                 id="kt_modal_update_status_form" method="POST">
                 @csrf
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_update_status_header">
                     <!--begin::Modal title-->
                     <h2 class="fw-bold">Update Order Status</h2>
                     <!--end::Modal title-->
                     <!--begin::Close-->
                     <div id="kt_modal_update_status_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_update_status_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_update_status_header"
                         data-kt-scroll-wrappers="#kt_modal_update_status_scroll" data-kt-scroll-offset="300px">

                         <!--begin::Input group-->
                         <div class="fv-row mb-5">
                             <!--begin::Status-->
                             <status class="required fs-6 fw-semibold mb-2">Status</status>
                             <!--end::Status-->
                             <!--begin::Input-->
                             <select class="form-select form-select-solid order_status" name="order_status">
                                 <option value="Pending" {{ $data['order']->status == "Pending" ? "selected" : "" }}>
                                     Pending</option>
                                 <option value="Submitted"
                                     {{ $data['order']->status == "Submitted" ? "selected" : "" }}>
                                     Submitted
                                 </option>
                                 <option value="In-transit"
                                     {{ $data['order']->status == "In-transit" ? "selected" : "" }}>
                                     In-transit
                                 </option>
                                 <option value="Received" {{ $data['order']->status == "Received" ? "selected" : "" }}>
                                     Received
                                 </option>
                                 <option value="Processing"
                                     {{ $data['order']->status == "Processing" ? "selected" : "" }}>
                                     Processing
                                 </option>
                                 <option value="Needs Attention"
                                     {{ $data['order']->status == "Needs Attention" ? "selected" : "" }}>
                                     Needs Attention
                                 </option>
                                 <option value="Shipped" {{ $data['order']->status == "Shipped" ? "selected" : "" }}>
                                     Shipped
                                 </option>
                             </select>
                             <!--end::Input-->
                         </div><br>
                         <!--end::Input group-->
                         <div class="orer-status-sections section-in-transit mt-5">
                             <h3>Tracking Details:</h3><br>
                             <table class="table">
                                 <tr>
                                     <td>Carrier:</td>
                                     <td>{{$data['tracking'] ? $data['tracking']['carrier_name'] : ""}}</td>
                                 </tr>
                                 <tr>
                                     <td>Tracking ID:</td>
                                     <td>{{$data['tracking'] ? $data['tracking']['tracking_id'] : ""}}</td>
                                 </tr>
                             </table>
                         </div>
                         <div class="orer-status-sections section-received mt-5">
                             <h3>Incoming Products:</h3><br>
                             <table class="table align-middle table-row-dashed fs-6 gy-5"
                                 id="kt_ecommerce_edit_order_product_table">
                                 <thead>
                                     <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                         <th>Product</th>
                                         <th>INCOMING</th>
                                         <th>RECEIVED</th>
                                         <th>DAMAGED/ MISSING</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($data['incoming_products'] as $index=>$product)
                                     <tr>
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
                                             <input name="products_received_asin[{{$index}}]" type="text"
                                                 class="form-control form-control-solid" value="{{$index}}" hidden />
                                         </td>
                                         <!--end::Product=-->
                                         <td>
                                             <!--begin::Input group-->
                                             <div class="fv-row mb-5">
                                                 <!--begin::label-->
                                                 <label class="required fs-6 fw-semibold mb-2">Quantity</label>
                                                 <!--end::label-->
                                                 <!--begin::Input-->
                                                 <input disabled type="number" class="form-control form-control-solid"
                                                     value="{{isset($product['total']) ? $product['total'] : 0}}" />
                                                 <!--end::Input-->
                                             </div>
                                             <!--end::Input group-->
                                         </td>
                                         <td>
                                             <!--begin::Input group-->
                                             <div class="fv-row mb-5">
                                                 <!--begin::label-->
                                                 <label class="required fs-6 fw-semibold mb-2">Quantity</label>
                                                 <!--end::label-->
                                                 <!--begin::Input-->
                                                 <input name="products_received_qty[{{$index}}]" type="number"
                                                     class="form-control form-control-solid"
                                                     value="{{isset($product['received']) ? $product['received'] : 0}}"
                                                     {{$data['order']->is_express ? '' : 'disabled'}} />
                                                 <!--end::Input-->
                                             </div>
                                             <!--end::Input group-->
                                         </td>
                                         <td>
                                             <!--begin::Input group-->
                                             <div class="fv-row mb-5">
                                                 <!--begin::label-->
                                                 <label class="required fs-6 fw-semibold mb-2">Quantity</label>
                                                 <!--end::label-->
                                                 <!--begin::Input-->
                                                 <input name="products_received_damaged[{{$index}}]" type="number"
                                                     class="form-control form-control-solid"
                                                     value="{{isset($product['damaged']) ? $product['damaged'] : 0}}"
                                                     {{$data['order']->is_express ? '' : 'disabled'}} />
                                                 <!--end::Input-->
                                             </div>
                                             <!--end::Input group-->
                                         </td>
                                     </tr>
                                     @endforeach
                                 </tbody>
                             </table>
                         </div>
                         <div class="orer-status-sections section-needs-attention mt-5">
                             <div class="fv-row mb-5">
                                 <!--begin::Status-->
                                 <label class="fs-6 fw-semibold mb-2">Issue Description</label>
                                 <!--end::Status-->
                                 <!--begin::Input-->
                                 <textarea class="form-control form-control-solid" rows="5"
                                     name="admin_notes">{{$data['order']['admin_notes']}}</textarea>
                                 <!--end::Input-->
                             </div>
                         </div>
                         <div class="orer-status-sections section-shipped mt-5">
                             <h3>Incoming Products:</h3><br>
                             <table class="table align-middle table-row-dashed fs-6 gy-5"
                                 id="kt_ecommerce_edit_order_product_table">
                                 <thead>
                                     <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                         <th>Product</th>
                                         <th>TOTAL</th>
                                         <th>SHIPPED</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($data['outgoing_products'] as $index=>$product)
                                     <tr>
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
                                             <input name="products_shipped_asin[{{$index}}]" type="text"
                                                 class="form-control form-control-solid" value="{{$index}}" hidden />
                                         </td>
                                         <!--end::Product=-->
                                         <td>
                                             <!--begin::Input group-->
                                             <div class="fv-row mb-5">
                                                 <!--begin::label-->
                                                 <label class="required fs-6 fw-semibold mb-2">Quantity</label>
                                                 <!--end::label-->
                                                 <!--begin::Input-->
                                                 <input disabled type="number" class="form-control form-control-solid"
                                                     value="{{isset($product['total']) ? $product['total'] : 0}}" />
                                                 <!--end::Input-->
                                             </div>
                                             <!--end::Input group-->
                                         </td>
                                         <td>
                                             <!--begin::Input group-->
                                             <div class="fv-row mb-5">
                                                 <!--begin::label-->
                                                 <label class="required fs-6 fw-semibold mb-2">Quantity</label>
                                                 <!--end::label-->
                                                 <!--begin::Input-->
                                                 <input name="products_shipped_qty[{{$index}}]" type="number"
                                                     class="form-control form-control-solid"
                                                     value="{{isset($product['shipped']) ? $product['shipped'] : 0}}" />
                                                 <!--end::Input-->
                                             </div>
                                             <!--end::Input group-->
                                         </td>
                                     </tr>
                                     @endforeach
                                 </tbody>
                             </table>
                         </div>
                     </div>
                     <!--end::Scroll-->
                 </div>
                 <!--end::Modal body-->
                 <!--begin::Modal footer-->
                 <div class="modal-footer flex-center">
                     <!--begin::Button-->
                     <button type="reset" id="kt_modal_update_status_cancel" class="btn btn-light me-3">Discard</button>
                     <!--end::Button-->
                     <!--begin::Button-->
                     <button type="button" id="kt_modal_update_status_submit" class="btn btn-primary">
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
 <!--end::Modal - Statuss - Update-->