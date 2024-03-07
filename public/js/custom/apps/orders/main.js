let CURRENT_STEP = 0;

/* Validators */
var country_validation;
var product_validation;
var carrier_validation;
var label_validation;
var address_validation;
var tracking_validation;

var filePond_init = false;

function validateCountry() {
  var form = document.querySelector('#validate_country_form');
  country_validation = FormValidation.formValidation(form, {
    fields: {
      'country-id': {
        validators: {
          notEmpty: { message: 'Please select a country to proceed.' },
        },
      },
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap: new FormValidation.plugins.Bootstrap5({
        rowSelector: '.fv-row',
        eleInvalidClass: '',
        eleValidClass: '',
      }),
    },
  });
}

function validateProduct() {
  $('#search_product_form').validate({
    rules: {
      'product-asin': { required: true },
      'product-qty': { required: true, digits: true },
      incoming_packages: { required: true, digits: true },
      incoming_package_items: { required: true, digits: true },
      outgoing_package_items: { required: true, digits: true },
    },
  });
}

function validateTracking() {
  var form = document.querySelector('#tracking_info_form');
  tracking_validation = FormValidation.formValidation(form, {
    fields: {
      tracking_carrier: {
        validators: {
          notEmpty: { message: 'This filed is required' },
        },
      },
      tracking_id: {
        validators: {
          notEmpty: { message: 'This filed is required' },
        },
      },
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap: new FormValidation.plugins.Bootstrap5({
        rowSelector: '.fv-row',
        eleInvalidClass: '',
        eleValidClass: '',
      }),
    },
  });
}

function validateCarrier() {
  var form = document.querySelector('#validate_carrier_form');
  carrier_validation = FormValidation.formValidation(form, {
    fields: {
      carrier: {
        validators: {
          notEmpty: { message: 'This field is required.' },
        },
      },
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap: new FormValidation.plugins.Bootstrap5({
        rowSelector: '.fv-row',
        eleInvalidClass: '',
        eleValidClass: '',
      }),
    },
  });
}

function validateLabel() {
  resetFormValidator('#validate_label_form');
  $('#validate_label_form').validate();
  $('#validate_label_form')
    .find('.supplier_other_value')
    .each(function () {
      $(this).rules('add', {
        required: true,
        maxlength: 100,
      });
    });
}

function validateAddress() {
  $('#validate_address_form').validate({
    rules: {
      warehouses: 'required',
      name: 'required',
      warehouses: 'required',
      company: 'required',
      email: 'required',
      country: 'required',
      zip: 'required',
      city: 'required',
      state: 'required',
      address_1: 'required',
    },
  });
}

function showButtonLoader(button = '.order-continue-button') {
  $(`${button} .indicator-progress`).css('display', 'block');
  $(`${button} .indicator-label`).css('display', 'none');
  $(`${button}`).attr('disabled', true);
}

function hideButtonLoader(button = '.order-continue-button') {
  $(`${button} .indicator-progress`).css('display', 'none');
  $(`${button} .indicator-label`).css('display', 'block');
  $(`${button}`).attr('disabled', false);
}

function validAndContinue() {
  window.livewire.emit('incrementStepCounter');
}

function showErrorPopup(text = null, button = '.order-continue-button') {
  hideButtonLoader(button);
  Swal.fire({
    text: text
      ? text
      : 'Sorry, looks like there are some errors detected, please try again.',
    icon: 'error',
    buttonsStyling: !1,
    confirmButtonText: 'Ok, got it!',
    customClass: { confirmButton: 'btn btn-light' },
  }).then(function () {
    KTUtil.scrollTop();
  });
}

$(document).ready(function () {
  validateCountry();
  validateProduct();
  validateAddress();

  window.livewire.on('setCounterChanged', (step) => {
    CURRENT_STEP = step;
    hideButtonLoader();
    KTUtil.scrollTop();
  });

  window.livewire.on('setCurrentProduct', (product) => {
    current_product = product;
  });

  $('#product-asin').keyup(function (e) {
    let old_value = $(this).val();
    setTimeout(function () {
      if (
        old_value == $('#product-asin').val() &&
        $('#product-asin').val().length == 10
      ) {
        window.livewire.emit('searchProduct');
      }
    }, 500);
  });

  $('#search_product_form').on('keyup', '#outgoing-product-asin', function (e) {
    let old_value = $(this).val();
    setTimeout(function () {
      if (
        old_value == $('#outgoing-product-asin').val() &&
        $('#outgoing-product-asin').val().length == 10
      ) {
        window.livewire.emit('searchOutgoingProduct');
      }
    }, 500);
  });

  $('.order-continue-button').click(function (e) {
    e.preventDefault();
    showButtonLoader();

    switch (CURRENT_STEP) {
      case 0: {
        country_validation.validate().then(function (e) {
          if (e == 'Valid') {
            validAndContinue();
          } else {
            showErrorPopup();
          }
        });
        break;
      }
      case 1: {
        if ($('.shipping-product').length == 0) {
          showErrorPopup('Plese select a product to proceed further.');
        } else {
          validAndContinue();
        }
        break;
      }
      case 2: {
        if (!carrier_validation) {
          validateCarrier();
        }
        carrier_validation.validate().then(function (e) {
          if (e == 'Valid') {
            validAndContinue();
          } else {
            showErrorPopup('Plese select a carrier to proceed further.');
          }
        });
        break;
      }
      case 4: {
        validateLabel();
        if ($('#validate_label_form').valid()) {
          validAndContinue();
        } else {
          showErrorPopup();
        }
        break;
      }
      case 5: {
        if ($('#validate_address_form').valid()) {
          validAndContinue();
        } else {
          showErrorPopup();
        }
        break;
      }
      default: {
        validAndContinue();
        break;
      }
    }
  });

  $('.order-back-button').click(function () {
    if (CURRENT_STEP >= 1) {
      window.livewire.emit('decrementStepCounter');
    }
  });
});

function resetFormValidator(formId) {
  $(formId).removeData('validator');
  $(formId).removeData('unobtrusiveValidation');
  $.validator.unobtrusive.parse(formId);
}

function addProduct() {
  showButtonLoader('#search_product_submit');
  if ($('#search_product_form').valid()) {
    if (current_product && current_product.isValid) {
      window.livewire.emit('addProduct');
    } else {
      showErrorPopup(
        'Sorry, we couldn’t find the product you were looking for. Please try again.',
        '#search_product_submit'
      );
    }
  } else {
    showErrorPopup(null, '#search_product_submit');
  }
}

function deleteProduct(index) {
  Swal.fire({
    text: 'Are you sure you want to remove this product?',
    icon: 'warning',
    showCancelButton: !0,
    buttonsStyling: !1,
    confirmButtonText: 'Yes, remove!',
    cancelButtonText: 'No, cancel',
    customClass: {
      confirmButton: 'btn fw-bold btn-danger',
      cancelButton: 'btn fw-bold btn-active-light-primary',
    },
  }).then(function (e) {
    e.value
      ? window.livewire.emit('removeProduct', index)
      : 'cancel' === e.dismiss &&
        Swal.fire({
          text: 'Product was not removed.',
          icon: 'error',
          buttonsStyling: !1,
          confirmButtonText: 'Ok, got it!',
          customClass: {
            confirmButton: 'btn fw-bold btn-primary',
          },
        });
  });
}

function binPackingError(error) {
  Swal.fire({
    text:
      'An unexpected error ocurred! Please try again <br><small>' +
      error +
      '</small>',
    icon: 'error',
    buttonsStyling: !1,
    confirmButtonText: 'Ok, got it!',
    customClass: {
      confirmButton: 'btn fw-bold btn-primary',
    },
  });
  hideButtonLoader('.order-continue-button');
}

function setTrackingInfo() {
  showButtonLoader('#set_tracking_submit');
  if (!tracking_validation) {
    validateTracking();
  }
  tracking_validation.validate().then(function (e) {
    if (e == 'Valid') {
      window.livewire.emit(
        'setTrackingInfo',
        $('#tracking_carrier option:selected').text()
      );
    } else {
      showErrorPopup(null, '#set_tracking_submit');
    }
  });
}

function tooltipMouseIn(elem, address = null) {
  let copied_address = '';
  if (!address) {
    copied_address = $('#ship_from_address').text().replace(/\s+/g, ' ').trim();
  } else {
    let address_data = JSON.parse(address);
    copied_address += address_data.name ? address_data.name + ', \n' : '';
    copied_address += address_data.company ? address_data.company + ', \n' : '';
    copied_address += address_data.email ? address_data.email + ', \n' : '';
    copied_address += address_data.phone ? address_data.phone + ', \n' : '';
    copied_address += address_data.address_1
      ? address_data.address_1 + ', \n'
      : '';
    copied_address += address_data.address_2
      ? address_data.address_2 + ', \n'
      : '';
    copied_address += address_data.name ? address_data.city + ', \n' : '';
    copied_address += address_data.name ? address_data.state + ', ' : '';
    copied_address += address_data.country ? address_data.country + '. \n' : '';
    copied_address += address_data.zip ? address_data.zip : '';
  }
  navigator.clipboard.writeText(copied_address);
  $('#' + elem).html('Address coiped to clipboard!');
}

function tooltipMouseOut(elem) {
  $('#' + elem).html('Copy to clipboard');
}
