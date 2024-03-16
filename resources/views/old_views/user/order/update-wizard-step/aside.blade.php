 <!--begin::Aside column-->
 <div class="aside-column">
     @if($currentStep == 1)
     <!--begin::Selected product-->
     <div class="card card-flush py-4 mb-5">
         <!--begin::Card header-->
         <div class="card-header">
             <div class="card-title">
                 <h2>Product Details</h2>
             </div>
         </div>
         <!--end::Card header-->
         <!--begin::Card body-->
         <div class="card-body pt-0">
             <div class="d-flex flex-column gap-10">
                 <div class="add-product-container">
                     @if(isset($current_product['isValid']) && isset($current_product['qty']))
                     <span class="badge py-3 px-4 fs-7 badge-light-primary">Qty: {{$current_product['qty']}}</span>
                     @endif
                     @if(isset($current_product['isValid']) && isset($current_product['bundle']) &&
                     $current_product['bundle'] != "none")
                     <span class="badge py-3 px-4 fs-7 badge-light-success">
                         {{ucfirst($current_product['bundle'])}}
                     </span>
                     @endif
                     @if(isset($current_product['image']))
                     <style>
                         .image-input-placeholder {
                             background-image: url("{{$current_product['image']}}");
                         }
                     </style>
                     @else
                     <style>
                         .image-input-placeholder {
                             background-image: url('{{asset("media/svg/files/blank-image.svg")}}');
                         }

                         [data-theme="dark"] .image-input-placeholder {
                             background-image: url('{{asset("media/svg/files/blank-image-dark.svg")}}');
                         }
                     </style>
                     @endif
                     <style>
                         .add-product-container .form-control:disabled {
                             background-color: #FFF !important;
                         }
                     </style>
                     <div class="product-image-container mt-3">
                         <div class="image-input image-input-empty image-input-placeholder mb-3" data-kt-image-input="true">
                             <div class="image-input-wrapper w-150px h-150px"></div>
                         </div>
                     </div>

                     @if(isset($current_product['price']))
                     <div class="row">
                         <div class="col-12">
                             <div class="fw-bold fs-3 mb-5">$ {{number_format($current_product['price'], 2)}}
                             </div>
                         </div>
                     </div>

                     <div class="row mb-3">
                         <div class="col-12">
                             <label>Dimensions</label>
                         </div>
                         <div class="col-4">
                             <input class="form-control" type="text" value="{{$current_product['length']}}" disabled>
                         </div>
                         <div class="col-4">
                             <input class="form-control" type="text" value="{{$current_product['width']}}" disabled>
                         </div>
                         <div class="col-4">
                             <input class="form-control" type="text" value="{{$current_product['height']}}" disabled>
                         </div>
                     </div>


                     <div class="row mb-3">
                         <div class="col-6">
                             <label>Actual Wt.</label>
                             <input class="form-control" type="text" value="{{$current_product['a_weight']}}" disabled>
                         </div>
                         <div class="col-6">
                             <label>Deci Wt.</label>
                             <input class="form-control" type="text" value="{{$current_product['d_weight']}}" disabled>
                         </div>
                     </div>

                     <div class="row mb-3">
                         <div class="col-12">
                             <label>Description</label>
                             <div class="order-product-description">
                                 {{$current_product['title']}}
                             </div>
                         </div>
                     </div>

                     <div class="row mb-3 mt-5">
                         <div class="col-12">
                             @if($editing_product)
                             <!--begin::Button-->
                             <button type="button" class="btn btn-danger form-control" wire:click="discardProductChanges()">
                                 <span class="indicator-label">Discard Changes</span>
                             </button>
                             <!--end::Button-->
                             @elseif(isset($current_product['isValid']))
                             <!--begin::Button-->
                             <button type="button" class="btn btn-danger form-control" wire:click="clearProduct()">
                                 <span class="indicator-label">Discard Changes</span>
                             </button>
                             <!--end::Button-->
                             @endif
                         </div>
                     </div>


                     @endif
                 </div>
             </div>
         </div>
         <!--end::Card header-->
     </div>
     <!--end::Selected product-->

     @if(isset($outgoing_product['isValid']) && $outgoing_product['isValid'] == true && $current_product['bundle'] !=
     "none")
     <!--begin::Selected product-->
     <div class="card card-flush py-4 mb-5">
         <!--begin::Card header-->
         <div class="card-header">
             <div class="card-title">
                 <h2>Outgoing Product</h2>
             </div>
         </div>
         <!--end::Card header-->
         <!--begin::Card body-->
         <div class="card-body pt-0">
             <div class="d-flex flex-column gap-10">
                 <div class="add-product-container">
                     @if(isset($outgoing_product['isValid']) && isset($outgoing_product['qty']))
                     <span class="badge py-3 px-4 fs-7 badge-light-primary">Qty: {{$outgoing_product['qty']}}</span>
                     @endif
                     @if(isset($outgoing_product['isValid']))
                     <style>
                         .image-input-placeholder-output {
                             background-image: url("{{$outgoing_product['image']}}");
                         }
                     </style>
                     @else
                     <style>
                         .image-input-placeholder-output {
                             background-image: url('{{asset("media/svg/files/blank-image.svg")}}');
                         }

                         [data-theme="dark"] .image-input-placeholder-output {
                             background-image: url('{{asset("media/svg/files/blank-image-dark.svg")}}');
                         }
                     </style>
                     @endif
                     <div class="product-image-container">
                         <div class="image-input image-input-empty image-input-placeholder-output mb-3" data-kt-image-input="true">
                             <div class="image-input-wrapper w-150px h-150px"></div>
                         </div>
                     </div>

                     @if(isset($outgoing_product['isValid']))
                     <div class="row">
                         <div class="col-12">
                             <div class="fw-bold fs-3 mb-5">$ {{number_format($outgoing_product['price'], 2)}}
                             </div>
                         </div>
                     </div>

                     <div class="row mb-3">
                         <div class="col-12">
                             <label>Dimensions</label>
                         </div>
                         <div class="col-4">
                             <input class="form-control" type="text" value="{{$outgoing_product['length']}}" disabled>
                         </div>
                         <div class="col-4">
                             <input class="form-control" type="text" value="{{$outgoing_product['width']}}" disabled>
                         </div>
                         <div class="col-4">
                             <input class="form-control" type="text" value="{{$outgoing_product['height']}}" disabled>
                         </div>
                     </div>


                     <div class="row mb-3">
                         <div class="col-6">
                             <label>Actual Wt.</label>
                             <input class="form-control" type="text" value="{{$outgoing_product['a_weight']}}" disabled>
                         </div>
                         <div class="col-6">
                             <label>Deci Wt.</label>
                             <input class="form-control" type="text" value="{{$outgoing_product['d_weight']}}" disabled>
                         </div>
                     </div>

                     <div class="row mb-3">
                         <div class="col-12">
                             <label>Description</label>
                             <div class="order-product-description">
                                 {{$outgoing_product['title']}}
                             </div>
                         </div>
                     </div>

                     <div class="row mb-3 mt-5">
                         <div class="col-12">
                             @if(isset($outgoing_product['isValid']))
                             <!--begin::Button-->
                             <button type="button" class="btn btn-danger form-control" wire:click="clearOutgoingProduct()">
                                 <span class="indicator-label">Discard Changes</span>
                             </button>
                             <!--end::Button-->
                             @endif
                         </div>
                     </div>


                     @endif
                 </div>
             </div>
         </div>
         <!--end::Card header-->
     </div>
     @endif
     <!--end::Selected product-->
     @endif
     @if($currentStep >= 2)
     <!--begin::Product details-->
     <div class="card card-flush py-4 mb-5">
         <!--begin::Card header-->
         <div class="card-header">
             <div class="card-title">
                 <h2>Product Details</h2>
             </div>
             @if($currentStep == 6)
             <div class="card-actions pt-5">
                 <button type="button" wire:click="setCurrentStep(1)" class="float-right btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                     <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                     <span class="svg-icon svg-icon-3">
                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                             <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                         </svg>
                     </span>
                     <!--end::Svg Icon-->
                 </button>
             </div>
             @endif
         </div>
         <!--end::Card header-->
         <!--begin::Card body-->
         <div class="card-body pt-0">
             <div class="d-flex flex-column gap-10">
                 <div class="packed-products">
                     <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_edit_order_product_table">
                         <thead>
                             <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                 <th>Product</th>
                                 <th class="text-end pe-5">Quantity</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach($products as $index=>$product)
                             <tr>
                                 <!--begin::Product=-->
                                 <td>
                                     <div class="d-flex align-items-center" data-kt-ecommerce-edit-order-filter="product">
                                         <!--begin::Thumbnail-->
                                         <a href="#" class="symbol symbol-50px">
                                             <span class="symbol-label rounded" style="background-image:url({{$product['image']}})"></span>
                                         </a>
                                         <!--end::Thumbnail-->
                                         <div class="ms-5">
                                             <!--begin::Title-->
                                             <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">Product
                                                 {{$index + 1}}</a>
                                             <!--end::Title-->

                                             <!--begin::Price-->
                                             <div class="fw-semibold fs-7">Price: $
                                                 <span data-kt-ecommerce-edit-order-filter="price">{{number_format($product['price'], 2)}}</span>
                                             </div>
                                             <!--end::Price-->
                                             <!--begin::SKU-->
                                             <div class="text-muted fs-7">ASIN: {{$product['asin']}}</div>
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
                                 <!--begin::Qty=-->
                                 <td class="text-end pe-5">
                                     <span class="fw-bold text-warning ms-3">{{$product['qty']}}</span>
                                 </td>
                                 <!--end::Qty=-->
                             </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
         <!--end::Card header-->
     </div>
     <!--end::Product details-->
     @endif
     @if($currentStep == 2 || $currentStep == 3)
     <!--begin::Carrier details-->
     <div class="card card-flush py-4 mb-5">
         <!--begin::Card header-->
         <div class="card-header">
             <div class="card-title">
                 <h2>Select Your Carrier</h2>
             </div>
         </div>
         <!--end::Card header-->
         <!--begin::Card body-->
         <div class="card-body pt-0">
             <div class="d-flex flex-column gap-10">
                 <div class="carrier-list">
                     <form action="#" id="validate_carrier_form">
                         @foreach($carriers as $carrier_id=>$carrier)
                         <div class="align-items-center border border-dashed rounded p-3 bg-body mb-5">
                             <div class="row">
                                 <div class="col-12">
                                     <!--begin:Option-->
                                     <label class="d-flex flex-stack mb-5 cursor-pointer">
                                         <!--begin:Label-->
                                         <span class="d-flex align-items-center me-2">
                                             <!--begin:Icon-->
                                             <div class="symbol symbol-45px me-4">
                                                 @if($carrier['logo'])
                                                 <img src="{{Storage::disk('s3')->url($carrier['logo'])}}" alt="carrier logo" class="img-fluid">
                                                 @else
                                                 <span class="symbol-label bg-primary">
                                                     <i class="text-inverse-primary fs-1 lh-0 fonticon-delivery"></i>
                                                 </span>
                                                 @endif
                                             </div>
                                             <!--end:Icon-->
                                             <!--begin:Info-->
                                             <span class="d-flex flex-column">
                                                 <b>{{$carrier['name']}}</b>
                                             </span>
                                             <!--end:Info-->
                                         </span>
                                         <!--end:Label-->
                                         <!--begin:Input-->
                                         <span class="fv-row form-check form-check-custom form-check-solid">
                                             <input class="form-check-input carrier_radio d-block" type="radio" name="carrier" value="{{$carrier_id}}" wire:model="carrier_selected" wire:change="updateServices()" />
                                         </span>
                                         <!--end:Input-->
                                     </label>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-12">
                                     <table class="table table-row-dashed">
                                         <tr>
                                             <td class="table-summary-label">Shipping time</td>
                                             <td class="table-summary-data">1-6 days</td>
                                         </tr>
                                         <tr>
                                             <td class="table-summary-label">Import fee</td>
                                             <td class="table-summary-data">$
                                                 {{number_format($carrier['import_fee'], 2)}}
                                             </td>
                                         </tr>
                                         <tr>
                                             <td class="table-summary-label">Shipment fee</td>
                                             <td class="table-summary-data">$
                                                 {{number_format($carrier['shipping_fee'], 2)}}
                                             </td>
                                         </tr>
                                         <tr>
                                             <td class="table-summary-label">Total</td>
                                             <td class="table-summary-data">$
                                                 {{number_format($carrier['total_fee'], 2)}}
                                             </td>
                                         </tr>
                                     </table>
                                 </div>
                             </div>
                         </div>
                         <!--end::Option-->
                         @endforeach
                     </form>

                 </div>
             </div>
         </div>
         <!--end::Card header-->
     </div>
     <!--end::Carrier details-->
     @endif
     @if($currentStep >= 4)
     <!--begin::Selected carrier-->
     <div class="card card-flush py-4 mb-5">
         <!--begin::Card header-->
         <div class="card-header">
             <div class="card-title">
                 <h2>Carrier Details</h2>
             </div>
             @if($currentStep == 6)
             <div class="card-actions pt-5">
                 <button type="button" wire:click="setCurrentStep(2)" class="float-right btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                     <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                     <span class="svg-icon svg-icon-3">
                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                             <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                         </svg>
                     </span>
                     <!--end::Svg Icon-->
                 </button>
             </div>
             @endif
         </div>
         <!--end::Card header-->
         <!--begin::Card body-->
         <div class="card-body pt-0">
             <div class="d-flex flex-column gap-10">
                 <div class="carrier-list">
                     <div class="align-items-center border border-dashed rounded p-3 bg-body mb-5">
                         <div class="row">
                             <div class="col-12">
                                 <!--begin:Option-->
                                 <label class="d-flex flex-stack mb-5 cursor-pointer">
                                     <!--begin:Label-->
                                     <span class="d-flex align-items-center me-2">
                                         <!--begin:Icon-->
                                         <div class="symbol symbol-45px me-4">
                                             @if($carriers[$carrier_selected]['logo'])
                                             <img src="{{Storage::disk('s3')->url($carriers[$carrier_selected]['logo'])}}" alt="carrier logo" class="img-fluid">
                                             @else
                                             <span class="symbol-label bg-primary">
                                                 <i class="text-inverse-primary fs-1 lh-0 fonticon-delivery"></i>
                                             </span>
                                             @endif
                                         </div>
                                         <!--end:Icon-->
                                         <!--begin:Info-->
                                         <span class="d-flex flex-column">
                                             <b>{{$carriers[$carrier_selected]['name']}}</b>
                                         </span>
                                         <!--end:Info-->
                                     </span>
                                     <!--end:Label-->
                                 </label>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-12">
                                 <table class="table table-row-dashed">
                                     <tr>
                                         <td class="table-summary-label">Shipping time</td>
                                         <td class="table-summary-data">1-6 days</td>
                                     </tr>
                                     <tr>
                                         <td class="table-summary-label">Import fee</td>
                                         <td class="table-summary-data">$
                                             {{number_format($carriers[$carrier_selected]['import_fee'], 2)}}
                                         </td>
                                     </tr>
                                     <tr>
                                         <td class="table-summary-label">Shipment fee</td>
                                         <td class="table-summary-data">$
                                             {{number_format($carriers[$carrier_selected]['shipping_fee'], 2)}}
                                         </td>
                                     </tr>
                                     <tr>
                                         <td class="table-summary-label">Total</td>
                                         <td class="table-summary-data">$
                                             {{number_format($carriers[$carrier_selected]['total_fee'], 2)}}
                                         </td>
                                     </tr>
                                 </table>
                             </div>
                         </div>
                     </div>
                     <!--end::Option-->
                 </div>
             </div>
         </div>
         <!--end::Card header-->
     </div>
     <!--end::Selected carrier-->
     @endif
     <!--begin::Label details-->
     @if($currentStep >= 5)
     <div class="card card-flush py-4 mb-5">
         <!--begin::Card header-->
         <div class="card-header">
             <div class="card-title">
                 <h2>Labels</h2>
             </div>
             @if($currentStep == 6)
             <div class="card-actions pt-5">
                 <button type="button" wire:click="setCurrentStep(4)" class="float-right btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                     <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                     <span class="svg-icon svg-icon-3">
                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                             <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                         </svg>
                     </span>
                     <!--end::Svg Icon-->
                 </button>
             </div>
             @endif
         </div>
         <!--end::Card header-->
         <!--begin::Card body-->
         <div class="card-body pt-0">
             <div class="d-flex flex-column gap-10">
                 <div class="row">
                     <div class="col-12">
                         <table class="table table-row-dashed">
                             <tr>
                                 <td class="table-summary-label">Product FNSKU Labels</td>
                                 <td class="table-summary-data">
                                     {{ $sku_label_count }}
                                 </td>
                             </tr>
                             <tr>
                                 <td class="table-summary-label">Combined FNSKU Labels</td>
                                 <td class="table-summary-data">{{isset($fnsku_labels) ? count($fnsku_labels) : 0}}</td>
                             </tr>
                             <tr>
                                 <td class="table-summary-label">FBA and Shipping Labels</td>
                                 <td class="table-summary-data">{{isset($fba_labels) ? count($fba_labels) : 0}}</td>
                             </tr>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
         <!--end::Card header-->
     </div>
     @endif
     <!--end::Label details-->
     <!--begin::Shipping details-->
     @if($currentStep == 6 && $shipping_address)
     <div class="card card-flush py-4 mb-5">
         <!--begin::Card header-->
         <div class="card-header">
             <div class="card-title">
                 <h2>Shipping Address</h2>
             </div>
             @if($currentStep == 6)
             <div class="card-actions pt-5">
                 <button type="button" wire:click="setCurrentStep(5)" class="float-right btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                     <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                     <span class="svg-icon svg-icon-3">
                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                             <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                         </svg>
                     </span>
                     <!--end::Svg Icon-->
                 </button>
             </div>
             @endif
         </div>
         <!--end::Card header-->
         <!--begin::Card body-->
         <div class="card-body pt-0">
             <div class="d-flex flex-column gap-10">
                 <p>
                     <b>{{ $shipping_address['name'] . ", " . $shipping_address['company'] }}</b>
                     <br>
                     <br>{{ $shipping_address['phone'] }},
                     <br>{{ $shipping_address['email'] }},
                     <br>
                     <br>{{ $shipping_address['address_1'] }},
                     @if($shipping_address['address_2'])
                     <br>{{ $shipping_address['address_2'] }},
                     @endif
                     <br>{{ $shipping_address['city'] }},
                     <br>{{ $shipping_address['state'] . ", " . $shipping_address['zip'] }}.
                     <br>{{ $shipping_address['country'] }}.
                 </p>
             </div>
         </div>
         <!--end::Card body-->
     </div>
     @endif
     <!--end::Shipping details-->
 </div>
 <!--end::Aside column-->