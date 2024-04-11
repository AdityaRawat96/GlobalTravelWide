  <!--begin::Item template-->
  <table class="table d-none" data-kt-element="item-template">
      <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
          <td class="pe-7">
              <!--begin::Input group-->
              <div class="mb-5 fv-row">
                  <select name="product[]" class="form-select form-select-lg form-select-solid product_select" data-placeholder="Select a product">
                      <option value="">Select a product</option>
                      @foreach($products as $product)
                      <option value="{{$product->id}}">
                          {{str_pad($product->id, 5, '0', STR_PAD_LEFT) . " - " . $product->name}}
                      </option>
                      @endforeach
                  </select>
                  <div class="fv-plugins-message-container invalid-feedback">
                  </div>
              </div>
              <!--end::Input group-->
              <input type="text" class="form-control form-control-solid product_description" placeholder="Description" />
          </td>
          <td class="ps-0">
              <div class="mb-5 fv-row">
                  <input class="form-control form-control-solid" type="number" min="1" name="quantity[]" placeholder="1" value="1" data-kt-element="quantity" />
                  <div class="fv-plugins-message-container invalid-feedback">
                  </div>
              </div>
          </td>
          <td>
              <div class="input-group input-group-solid mb-5 fv-row">
                  <span class="input-group-text elements_alt">£</span>
                  <input type="text" class="form-control text-end" name="cost[]" placeholder="0.00" value="0.00" data-kt-element="cost" />
                  <div class="fv-plugins-message-container invalid-feedback">
                  </div>
              </div>
              <div class="input-group input-group-solid mb-5 fv-row elements_alt">
                  <span class="input-group-text elements_alt">₨</span>
                  <input type="text" class="form-control text-end" name="cost_alt[]" placeholder="0.00" value="0.00" data-kt-element="cost_alt" />
                  <div class="fv-plugins-message-container invalid-feedback">
                  </div>
              </div>
          </td>
          <td>
              <div class="input-group input-group-solid mb-5 fv-row">
                  <span class="input-group-text elements_alt">£</span>
                  <input type="text" class="form-control text-end" name="price[]" placeholder="0.00" value="0.00" data-kt-element="price" />
                  <div class="fv-plugins-message-container invalid-feedback">
                  </div>
              </div>
              <div class="input-group input-group-solid mb-5 fv-row elements_alt">
                  <span class="input-group-text elements_alt">₨</span>
                  <input type="text" class="form-control text-end" name="price_alt[]" placeholder="0.00" value="0.00" data-kt-element="price_alt" />
                  <div class="fv-plugins-message-container invalid-feedback">
                  </div>
              </div>
          </td>
          <td class="pt-5 text-end">
              <button type="button" class="btn btn-icon btn-active-color-primary" data-kt-element="remove-item">
                  <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                  <span class="svg-icon svg-icon-3">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                          <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                          <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                      </svg>
                  </span>
                  <!--end::Svg Icon-->
              </button>
          </td>
      </tr>
  </table>
  <!--end::Item template-->
  <!--begin::Payment template-->
  <table class="table d-none" data-kt-element="payment-template">
      <tr class="border-bottom border-bottom-dashed" data-kt-element="payment">
          <td class="pe-7">
              <!--begin::Input group-->
              <div class="mb-5 fv-row">
                  <select name="payment_mode[]" class="form-select form-select-lg form-select-solid" data-placeholder="Select a payment mode">
                      <option value="">Select a payment mode</option>
                      <option value="bank">Bank Payment</option>
                      <option value="cash">Cash Payment</option>
                      <option value="others">Others</option>
                  </select>
                  <div class="fv-plugins-message-container invalid-feedback">
                  </div>
              </div>
          </td>
          <td class="ps-0">
              <div class="mb-5 fv-row">
                  <input class="form-control form-control-solid" placeholder="Select payment date" name="payment_date[]" data-kt-element="payment_date" />
                  <div class="fv-plugins-message-container invalid-feedback"></div>
              </div>
          </td>
          <td>
              <div class="input-group input-group-solid mb-5 fv-row">
                  <span class="input-group-text elements_alt">£</span>
                  <input type="text" class="form-control form-control-solid text-end" name="payment_amount[]" placeholder="0.00" value="0.00" data-kt-element="payment_amount" />
                  <div class="fv-plugins-message-container invalid-feedback"></div>
              </div>
              <div class="input-group input-group-solid mb-5 fv-row elements_alt">
                  <span class="input-group-text elements_alt">₨</span>
                  <input type="text" class="form-control text-end" name="payment_amount_alt[]" placeholder="0.00" value="0.00" data-kt-element="payment_amount_alt" />
                  <div class="fv-plugins-message-container invalid-feedback">
                  </div>
              </div>
          </td>
          <td class="pt-5 text-end">
              <button type="button" class="btn btn-icon btn-active-color-primary" data-kt-element="remove-payment">
                  <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                  <span class="svg-icon svg-icon-3">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                          <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                          <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                      </svg>
                  </span>
                  <!--end::Svg Icon-->
              </button>
          </td>
      </tr>
  </table>
  <!--end::Payment template-->
  <!--begin::Empty template-->
  <table class="table d-none" data-kt-element="empty-template">
      <tr data-kt-element="empty">
          <th colspan="5" class="text-muted text-center py-10">No items</th>
      </tr>
  </table>
  <!--end::Empty template-->