<!--begin::Step 4-->
<div class="{{$currentStep == 4 ? 'current' : ''}}" data-kt-stepper-element="content">
    <!--begin::Order details-->
    <div class="card card-flush py-4 w-100">
        @if(isset($services) && count($services))
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Product FNSKU Labels</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">

            <div class="d-flex flex-column gap-10">

                <div class="label-item-container">
                    <form id="validate_label_form">
                        @foreach($products as $key=>$product)
                        <div class="label-item border border-dashed border-gray-300 rounded px-3 py-3 mb-6 mt-6">
                            <div class="row mt-4">
                                <div class="col-4 col-image">
                                    <div class="symbol symbol-50px">
                                        <span class="symbol-label product-image" style="background-image:url({{$product['image'] ?? $product['image']}})"></span>
                                    </div>
                                </div>
                                <div class="col-8 col-title">
                                    <span><b>{{$product['asin']}}</b></span>
                                    <br />
                                    <span>{{$product['title']}}</span>
                                </div>
                            </div>

                            <div class="row mt-8">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2 mt-5">
                                        <span>Quantity</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid buyer_order_id" value="{{$product['qty']}}" disabled>
                                    <!--end::Input-->
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2 mt-5">
                                        <span>Supplier</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select wire:model="products.{{$key}}.supplier" class="form-control form-control-solid supplier_value" name="supplier_{{$key}}[]">
                                        <option value="">Select a supplier</option>
                                        <option value="Amazon">Amazon</option>
                                        <option value="Ebay">Ebay</option>
                                        <option value="Etsy">Etsy</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    @if(isset($products[$key]['supplier']) && $products[$key]['supplier'] == "Others")
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2 mt-5">
                                        <span class="required">Specify other supplier</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid supplier_other_value" wire:model="products.{{$key}}.supplier_other_value" name="supplier_other_value_{{$key}}[]" placeholder="Enter Supplier Name">
                                    <!--end::Input-->
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2 mt-5">
                                        <span>Label Attachment</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid mb-5">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="checkbox_input[]" type="checkbox" wire:model="product_fba_labels_arr.{{$key}}" />
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <label class="form-check-label">
                                            <div class="fw-semibold text-gray-800">This product contains a label.</div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Checkbox-->
                                    @if(isset($product_fba_labels_arr[$key]) && $product_fba_labels_arr[$key] == 1)
                                    <x-input.filepond wire:model="products.{{$key}}.label_file" :inputname="'label_file_{{$key}}[]'" />
                                    @endif
                                    <!--end::Input-->
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    @if(isset($product_fba_labels_arr[$key]) && $product_fba_labels_arr[$key] == 1)
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2 mt-5">
                                        <span>FNSKU Number</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid fnsku_number" wire:model="products.{{$key}}.fnsku_number" name="fnsku_number{{$key}}[]" placeholder="Enter FNSKU Number">
                                    <!--end::Input-->
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </form>
                </div>



                <h2>Combined FNSKU Labels</h2>
                <hr>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-semibold">
                                    <div class="fs-6 text-gray-700">
                                        You can upload up to 10 files.
                                    </div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <br>

                        <x-input.filepond wire:model="fnsku_labels" :inputname="'fnsku_labels'" multiple />

                    </div>
                </div>

                <h2>FBA and Shipping Labels</h2>
                <hr>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-semibold">
                                    <div class="fs-6 text-gray-700">
                                        You can upload up to 10 files.
                                    </div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <br>

                        <x-input.filepond wire:model="fba_labels" :inputname="'fba_labels'" multiple />

                    </div>
                </div>



            </div>
        </div>
        <!--end::Card header-->
        @endif
    </div>
    <!--end::Order details-->
</div>
<!--end::Step 4-->