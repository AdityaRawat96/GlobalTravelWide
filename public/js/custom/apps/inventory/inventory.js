let table;
let data_table;

$(document).ready(function () {
  data_table = document.querySelector('#kt_products_table');
  table = $(data_table).DataTable({
    info: !1,
    order: [],
    pageLength: 10,
    columnDefs: [
      { render: DataTable.render.number(',', '.', 2), targets: 5 },
      { orderable: !1, targets: 0 },
      { orderable: !1, targets: 1 },
      { orderable: !1, targets: 6 },
    ],
  });

  document
    .querySelector('[data-kt-product-table-filter="search"]')
    .addEventListener('keyup', function (t) {
      table.search(t.target.value).draw();
    });

  const t = document.querySelector(
    '[data-kt-ecommerce-product-filter="status"]'
  );
  $(t).on('change', (t) => {
    let n = t.target.value;
    'all' === n && (n = ''), table.column(6).search(n).draw();
  });

  const r = document.querySelector(
    '[data-kt-ecommerce-product-filter="stock"]'
  );
  $(r).on('change', (r) => {
    let n = r.target.value;
    if('all' === n){
      $(".product-out-of-stock").each(function () {
        $(this).removeClass('d-none');
      });
      $(".product-in-stock").each(function () {
        $(this).removeClass('d-none');
      });
    }else if('in-stock' === n){
      $(".product-out-of-stock").each(function () {
        $(this).addClass('d-none');
      });
      $(".product-in-stock").each(function () {
        $(this).removeClass('d-none');
      });
    }else if('out-of-stock' === n){
      $(".product-out-of-stock").each(function () {
        $(this).removeClass('d-none');
      });
      $(".product-in-stock").each(function () {
        $(this).addClass('d-none');
      });
    }
  });

  $('#create_order_form').on('keyup', '.outgoing_asin_input', function (e) {
    let old_value = $(this).val();
    let index = $(this).data('index');
    if (!$('#outgoing-product-asin-error-' + index).hasClass('d-none')) {
      $('#outgoing-product-asin-error-' + index).addClass('d-none');
    }
    if (!$('#outgoing-product-container-' + index).hasClass('d-none')) {
      $('#outgoing-product-container-' + index).addClass('d-none');
    }
    setTimeout(function () {
      if (
        old_value == $('#outgoing-product-asin-' + index).val() &&
        $('#outgoing-product-asin-' + index).val().length == 10
      ) {
        searchOutgoingProduct(index, old_value);
      }
    }, 500);
  });
});

function deleteTableRow(url, index) {
  let tableRow = $('#datatable-row-' + index);
  Swal.fire({
    text: 'Are you sure you want to delete this product?',
    icon: 'warning',
    showCancelButton: !0,
    buttonsStyling: !1,
    confirmButtonText: 'Yes, delete!',
    cancelButtonText: 'No, cancel',
    customClass: {
      confirmButton: 'btn fw-bold btn-danger',
      cancelButton: 'btn fw-bold btn-active-light-primary',
    },
  }).then(function (e) {
    e.value
      ? $.ajax({
          url: url,
          success: function (result) {
            console.log(result);
            Swal.fire({
              text: 'Product deleted!',
              icon: 'success',
              buttonsStyling: !1,
              confirmButtonText: 'Ok, got it!',
              customClass: {
                confirmButton: 'btn fw-bold btn-primary',
              },
            }).then(function () {
              table.row(tableRow).remove().draw();
            });
          },
        })
      : 'cancel' === e.dismiss &&
        Swal.fire({
          text: 'Product was not deleted.',
          icon: 'error',
          buttonsStyling: !1,
          confirmButtonText: 'Ok, got it!',
          customClass: {
            confirmButton: 'btn fw-bold btn-primary',
          },
        });
  });
}

function exportProductsToOrder() {
  const o = data_table.querySelectorAll('[type="checkbox"]');
  let n = document.querySelector(
    '[data-kt-product-table-select="create_order"]'
  );
  let m = document.querySelector(
    '[data-kt-product-table-select="create_shipment"]'
  );
  o.forEach((t) => {
    t.addEventListener('click', function () {
      setTimeout(function () {
        toggleMultipleActions();
      }, 50);
    });
  });
  n.addEventListener('click', function () {
    addProductsToOrderModal('create_order_table_body');
  });
  m.addEventListener('click', function () {
    addProductsToShipmentModal('create_shipment_table_body');
  });
}

function addProductsToShipmentModal(elem, asin = null) {
  let selected_products = data_table.querySelectorAll(
    'tbody [type="checkbox"]:checked'
  );
  if (asin) {
    selected_products = data_table.querySelectorAll(
      '#checkbox_product_' + asin
    );
  }
  $('.' + elem).html('');
  selected_products.forEach((product_input, index) => {
    $('.' + elem).append(`
       <tr>
          <!--begin::Product=-->
          <td>
              <div class="d-flex align-items-center mt-2"
                  data-kt-ecommerce-edit-order-filter="product">
                  <!--begin::Thumbnail-->
                  <a href="#" class="symbol symbol-50px">
                      <span class="symbol-label border border-dashed border-primary rounded"
                          style="background-image:url('${
                            product_input.dataset.image
                          }')">
                      </span>
                  </a>
                  <!--end::Thumbnail-->
                  <div class="ms-5">
                      <!--begin::Title-->
                      <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">
                      Product ${index + 1}
                      </a>
                      <!--end::Title-->

                      <!--begin::Price-->
                      <div class="fw-semibold fs-7">Price: $
                          <span data-kt-ecommerce-edit-order-filter="price">
                              ${product_input.dataset.price}
                          </span>
                      </div>
                      <!--end::Price-->
                      <!--begin::SKU-->
                      <div class="text-muted fs-7">ASIN:
                          ${product_input.value}</div>
                      <!--end::SKU-->
                      <input type="text" name="asin[${index}]" 
                          value="${product_input.value}"
                          hidden>
                  </div>
              </div>
          </td>
         <td class="pe-5">
              <!-- begin::Input group-->
              <div class="fv-row">
                  <!--begin::Input-->
                  <small class="required mb-2">Quantity</small>
                  <input type="number" class="form-control form-control-solid" placeholder=""
                      style="max-width: 200px" value="${
                        product_input.dataset.stock
                      }" disabled />
                  <!--end::Input-->
              </div>
              <!-- end::Input group-->
          </td>
          <!--end::Product=-->
          <td class="pe-5">
              <!-- begin::Input group-->
              <div class="fv-row" id="product_qty_${index}">
                  <!--begin::Input-->
                  <small class="required mb-2" for="product_qty[${index}]">Quantity</small>
                  <input type="number" class="form-control form-control-solid" placeholder=""
                      name="product_qty[${index}]" style="max-width: 200px" />
                  <!--end::Input-->
              </div>
              <!-- end::Input group-->
          </td>
      </tr>
      `);
  });
}

function addProductsToOrderModal(elem, asin = null) {
  let selected_products = data_table.querySelectorAll(
    'tbody [type="checkbox"]:checked'
  );
  if (asin) {
    selected_products = data_table.querySelectorAll(
      '#checkbox_product_' + asin
    );
  }
  $('.' + elem).html('');
  selected_products.forEach((product_input, index) => {
    $('.' + elem).append(`
       <tr>
          <!--begin::Product=-->
          <td>
              <div class="d-flex align-items-center mt-2"
                  data-kt-ecommerce-edit-order-filter="product">
                  <!--begin::Thumbnail-->
                  <a href="#" class="symbol symbol-50px">
                      <span class="symbol-label border border-dashed border-primary rounded"
                          style="background-image:url('${
                            product_input.dataset.image
                          }')">
                      </span>
                  </a>
                  <!--end::Thumbnail-->
                  <div class="ms-5">
                      <!--begin::Title-->
                      <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">
                      Product ${index + 1}
                      </a>
                      <!--end::Title-->

                      <!--begin::Price-->
                      <div class="fw-semibold fs-7">Price: $
                          <span data-kt-ecommerce-edit-order-filter="price">
                              ${product_input.dataset.price}
                          </span>
                      </div>
                      <!--end::Price-->
                      <!--begin::SKU-->
                      <div class="text-muted fs-7">ASIN:
                          ${product_input.value}</div>
                      <!--end::SKU-->
                      <input type="text" name="asin[${index}]" 
                          value="${product_input.value}"
                          hidden>
                  </div>
              </div>
              <div class="mt-5 d-none" id="outgoing-product-container-${index}">
              <div class="d-flex align-items-center mt-5"
                  data-kt-ecommerce-edit-order-filter="product">
                  <!--begin::Thumbnail-->
                  <a href="#" class="symbol symbol-50px">
                      <span class="symbol-label border border-dashed border-primary rounded"
                           id="outgoing-item-image-${index}">
                      </span>
                  </a>
                  <!--end::Thumbnail-->
                  <div class="ms-5">
                      <!--begin::Title-->
                      <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">
                      Outgoing 
                      </a>
                      <!--end::Title-->

                      <!--begin::Price-->
                      <div class="fw-semibold fs-7">Price: $
                          <span data-kt-ecommerce-edit-order-filter="price" id="outgoing-item-price-${index}">
                          </span>
                      </div>
                      <!--end::Price-->
                      <!--begin::SKU-->
                      <div class="text-muted fs-7">ASIN:
                          <span id="outgoing-item-asin-${index}"></span></div>
                      <!--end::SKU-->
                      <input type="text" name="outgoing_asin[${index}]" 
                          value=""
                           id="outgoing-item-asin-input-${index}"
                          hidden>
                  </div>
              </div>
              </div>
          </td>
          <!--end::Product=-->
          <td class="pe-5">
              <!-- begin::Input group-->
              <div class="fv-row">
                  <small class="required mb-2"
                      for="product_bundle[${index}]">Bundling</small>
                  <!--begin::Input-->
                  <select name="product_bundle[${index}]" id="product_bundle"
                      placeholder="Bundling"
                      onchange="if($(this).val() != 'none'){$('.product_bundling_option_${index}').removeClass('d-none');$('#product_qty_${index}').addClass('d-none');}else{$('.product_bundling_option_${index}').addClass('d-none');$('#product_qty_${index}').removeClass('d-none');}"
                      class="form-control form-control-solid">
                      <option value="none" default selected>No Bundle</option>
                      <option value="bundle">Bundle</option>
                      <option value="debundle">De-Bundle</option>
                  </select>
                  <!--end::Input-->
              </div>
              <!-- end::Input group-->
          </td>
          <td class="pe-5">
              <div class="product_bundling_option_${index} d-none">
                  <!-- begin::Input group-->
                  <div class="fv-row">
                      <!--begin::Input-->
                      <small class="required mb-2"
                          for="incoming_packages[${index}]">Packages sending
                          to
                          warehouse</small>
                      <input type="number" class="form-control form-control-solid"
                          placeholder="" name="incoming_packages[${index}]" />
                      <!--end::Input-->
                  </div>
                  <!-- end::Input group-->
                  <div class="form-check form-check-custom form-check-solid mt-5 mb-5">
                      <input class="form-check-input" type="checkbox"
                          id="package_multiple_items[${index}]"
                          name="package_multiple_items[${index}]"
                          onchange="if($(this).prop('checked')){$('#incoming_package_items_${index}').removeClass('d-none')}else{$('#incoming_package_items_${index}').addClass('d-none')}"
                          ${product_input.dataset.units > 1 ? 'checked' : ''} />
                      <small class="form-check-label"
                          for="package_multiple_items[${index}]">
                          Packages contain multiple items
                      </small>
                  </div>
                  <!-- begin::Input group-->
                  <div class="fv-row mt-3 ${
                    product_input.dataset.units > 1 ? '' : 'd-none'
                  }" id="incoming_package_items_${index}">
                      <!--begin::Input-->
                      <small class="required mb-2"
                          for="incoming_package_items[${index}]">Items in each
                          package</small>
                      <input type="number" class="form-control form-control-solid"
                          placeholder="" name="incoming_package_items[${index}]" value="${
      product_input.dataset.units
    }" />
                      <!--end::Input-->
                  </div>
                  <!-- end::Input group-->
              </div>
              <!-- begin::Input group-->
              <div class="fv-row" id="product_qty_${index}">
                  <!--begin::Input-->
                  <small class="required mb-2" for="product_qty[${index}]">Quantity</small>
                  <input type="number" class="form-control form-control-solid" placeholder=""
                      name="product_qty[${index}]" />
                  <!--end::Input-->
              </div>
              <!-- end::Input group-->
          </td>
          <td class="pe-5">
              <!-- begin::Input group-->
              <div class="fv-row product_bundling_option_${index} d-none">
                  <!--begin::Input-->
                  <small class="required mb-2" for="outgoing_package_items[${index}]">Outgoing product ASIN</small>
                  <input id="outgoing-product-asin-${index}" type="text" class="form-control form-control-solid mb-5 outgoing_asin_input" placeholder=""
                      name="outgoing_package_asin[${index}]" data-index="${index}" maxlength="10" />
                  <span class="text-danger d-none" id="outgoing-product-asin-error-${index}">Product not found</span>
                  <!--end::Input-->
              </div>
              <!-- end::Input group-->
              <!-- begin::Input group-->
              <div class="fv-row product_bundling_option_${index} d-none">
                  <!--begin::Input-->
                  <small class="required mb-2 mt-5" for="outgoing_package_items[${index}]">Items
                      to put in
                      bundle
                      package</small>
                  <input id="outgoing-units-${index}" type="number" class="form-control form-control-solid" placeholder=""
                      name="outgoing_package_items[${index}]" />
                  <!--end::Input-->
              </div>
              <!-- end::Input group-->
          </td>
      </tr>
      `);
  });
}

function toggleMultipleActions() {
  const t = document.querySelector('[data-kt-product-table-toolbar="base"]');
  let o = document.querySelector('[data-kt-product-table-toolbar="selected"]');
  let n = document.querySelector(
    '[data-kt-product-table-select="selected_count"]'
  );
  let c = data_table.querySelectorAll('tbody [type="checkbox"]');
  let r = !1;
  let l = 0;
  c.forEach((t) => {
    t.checked && ((r = !0), l++);
  });
  r
    ? ((n.innerHTML = l), o.classList.remove('d-none'))
    : o.classList.add('d-none');
}

function searchOutgoingProduct(index, product_asin) {
  $.ajax({
    url: $('#create_order_form').data('search'),
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    type: 'POST',
    data: { 'product-asin': product_asin },
    success: function (result) {
      let response = JSON.parse(result);
      if (response.success) {
        $('#outgoing-product-asin-error-' + index).addClass('d-none');
        $('#outgoing-product-container-' + index).removeClass('d-none');
        $('#outgoing-units-' + index).val(response.product.items);
        $('#outgoing-item-price-' + index).html(response.product.price);
        $('#outgoing-item-asin-' + index).html(product_asin);
        $('#outgoing-item-asin-input-' + index).val(product_asin);
        $('#outgoing-item-image-' + index).css(
          'background-image',
          'url(' + response.product.image + ')'
        );
      } else {
        $('#outgoing-product-container-' + index).addClass('d-none');
        $('#outgoing-product-asin-error-' + index).removeClass('d-none');
      }
    },
  });
}
