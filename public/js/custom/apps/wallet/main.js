let $form = $('#kt_wallet_topup_form');

let table = $('#kt-transcations-table').DataTable({
  info: !1,
  order: [],
  responsive: true,
});

$(document).ready(function () {
  initValues();

  $('[kt-transcations-table-filter="search"]').on('keyup', function (e) {
    table.search(e.target.value).draw();
  });

  $('.nav-link-wallet-tab').click(function (e) {
    e.preventDefault();
    $('.nav-link-wallet-tab').removeClass('active');
    $(this).addClass('active');
    $('.wallet-sections-tab-container').addClass('d-none');
    $($(this).data('target')).removeClass('d-none');
    table.draw();
    table.columns.adjust().responsive.recalc();
  });

  $('.nav-link-billing-tab').click(function (e) {
    e.preventDefault();
    $('.nav-link-billing-tab').removeClass('active');
    $(this).addClass('active');
    $('.billing-sections-tab-container').addClass('d-none');
    $($(this).data('target')).removeClass('d-none');
  });

  $('.amount-tag').click(function () {
    let currentAmount = +$("input[name='card_amount']").val();
    currentAmount += $(this).find('.counted').data('kt-countup-value');
    $("input[name='card_amount']").val(currentAmount);
  });

  $('#kt_wallet_topup_form_submit').on('click', function (e) {
    e.preventDefault();
    let payment_type = $('.nav-link-billing-tab.active').data('type');
    if (payment_type == 'card') {
      validate.validate().then(function (t) {
        'Valid' == t
          ? ($('#kt_wallet_topup_form_submit').attr('disabled', true),
            $('#kt_wallet_topup_form_submit .indicator-progress').css(
              'display',
              'block'
            ),
            $('#kt_wallet_topup_form_submit .indicator-label').css(
              'display',
              'none'
            ),
            Stripe.setPublishableKey($form.data('stripe-publishable-key')),
            Stripe.createToken(
              {
                number: $(
                  "#add-new-card-container input[name='card_number']"
                ).val(),
                cvc: $("#add-new-card-container input[name='card_cvv']").val(),
                exp_month: $(
                  "#add-new-card-container select[name='card_expiry_month']"
                ).val(),
                exp_year: $(
                  "#add-new-card-container select[name='card_expiry_year']"
                ).val(),
              },
              stripeResponseHandler
            ))
          : Swal.fire({
              text: 'Sorry, looks like there are some errors detected, please try again.',
              icon: 'error',
              buttonsStyling: !1,
              confirmButtonText: 'Ok, got it!',
              customClass: {
                confirmButton: 'btn btn-light',
              },
            }).then(function () {});
      });
    } else if (payment_type == 'bank') {
      validate_bank.validate().then(function (t) {
        'Valid' == t
          ? ($('#kt_wallet_topup_form_submit').attr('disabled', true),
            $('#kt_wallet_topup_form_submit .indicator-progress').css(
              'display',
              'block'
            ),
            $('#kt_wallet_topup_form_submit .indicator-label').css(
              'display',
              'none'
            ),
            stripeResponseHandler(true, { id: 'bank' }, payment_type))
          : Swal.fire({
              text: 'Sorry, looks like there are some errors detected, please try again.',
              icon: 'error',
              buttonsStyling: !1,
              confirmButtonText: 'Ok, got it!',
              customClass: {
                confirmButton: 'btn btn-light',
              },
            }).then(function () {});
      });
    } else if (payment_type == 'payoneer') {
      validate_payoneer.validate().then(function (t) {
        'Valid' == t
          ? ($('#kt_wallet_topup_form_submit').attr('disabled', true),
            $('#kt_wallet_topup_form_submit .indicator-progress').css(
              'display',
              'block'
            ),
            $('#kt_wallet_topup_form_submit .indicator-label').css(
              'display',
              'none'
            ),
            stripeResponseHandler(true, { id: 'payoneer' }, payment_type))
          : Swal.fire({
              text: 'Sorry, looks like there are some errors detected, please try again.',
              icon: 'error',
              buttonsStyling: !1,
              confirmButtonText: 'Ok, got it!',
              customClass: {
                confirmButton: 'btn btn-light',
              },
            }).then(function () {});
      });
    }
  });

  $form.on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url: $form.attr('action'),
      type: $form.attr('method'),
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      enctype: 'multipart/form-data',
      success: function (result) {
        $('#kt_wallet_topup_form_submit').attr('disabled', false);
        $('#kt_wallet_topup_form_submit .indicator-progress').css(
          'display',
          'none'
        );
        $('#kt_wallet_topup_form_submit .indicator-label').css(
          'display',
          'block'
        );
        if (result.success) {
          $('#kt_wallet_topup_form').addClass('d-none');
          $('#payment-success-container').removeClass('d-none');
          $('.order_id_container').html(
            'Transaction ID:</b> ' + result.payment_id.toUpperCase()
          );
          $('.wallet_balance_label').html(
            '$ ' + result.balance.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
          );
          Swal.fire({
            title: 'Success!',
            text: result.response,
            icon: 'success',
            buttonsStyling: !1,
            confirmButtonText: 'Ok, got it!',
            customClass: {
              confirmButton: 'btn btn-light',
            },
          }).then(function () {});
        } else {
          Swal.fire({
            title: 'Transaction failed!',
            text: result.response,
            icon: 'error',
            buttonsStyling: !1,
            confirmButtonText: 'Ok, got it!',
            customClass: {
              confirmButton: 'btn btn-light',
            },
          }).then(function () {});
        }
      },
    });
  });
});

function stripeResponseHandler(status, response, payment_type = 'card') {
  if (response.error) {
    $('#kt_wallet_topup_form_submit').attr('disabled', false);
    $('#kt_wallet_topup_form_submit .indicator-progress').css(
      'display',
      'none'
    );
    $('#kt_wallet_topup_form_submit .indicator-label').css('display', 'block');
    Swal.fire({
      title: 'Transaction failed!',
      text: response.error.message,
      icon: 'error',
      buttonsStyling: !1,
      confirmButtonText: 'Ok, got it!',
      customClass: {
        confirmButton: 'btn btn-light',
      },
    }).then(function () {});
  } else {
    /* token contains id, last4, and card type */
    var token = response['id'];
    $form.find('input[type=text]').empty();
    $form.append(
      "<input type='hidden' name='stripeToken' value='" + token + "'/>"
    );
    $form.append(
      "<input type='hidden' name='payment_type' value='" + payment_type + "'/>"
    );
    $form.submit();
  }
}

let validate = FormValidation.formValidation(
  document.getElementById('kt_wallet_topup_form'),
  {
    fields: {
      card_amount: {
        validators: {
          notEmpty: {
            message: 'Amount is required',
          },
          digits: {
            message: 'Amount must contain only digits',
          },
        },
      },
      receipt: {
        validators: {
          notEmpty: {
            message: 'Transaction receipt is required',
          },
        },
      },
      first_name: {
        validators: {
          notEmpty: {
            message: 'First name is required',
          },
        },
      },
      last_name: {
        validators: {
          notEmpty: {
            message: 'Last name is required',
          },
        },
      },
      company: {
        validators: { notEmpty: { message: 'Company name is required' } },
      },
      email: {
        validators: {
          notEmpty: { message: 'Email address is required' },
          emailAddress: {
            message: 'The value is not a valid email address',
          },
        },
      },
      phone: {
        validators: { notEmpty: { message: 'Phone number is required' } },
      },
      country: {
        validators: {
          notEmpty: {
            message: 'Country is required',
          },
        },
      },
      address1: {
        validators: {
          notEmpty: {
            message: 'Address 1 is required',
          },
        },
      },
      address2: {
        validators: {
          notEmpty: {
            message: 'Address 2 is required',
          },
        },
      },
      city: {
        validators: {
          notEmpty: {
            message: 'City is required',
          },
        },
      },
      state: {
        validators: {
          notEmpty: {
            message: 'State is required',
          },
        },
      },
      postcode: {
        validators: {
          notEmpty: {
            message: 'Postcode is required',
          },
        },
      },
      card_name: {
        validators: {
          notEmpty: {
            message: 'Name on card is required',
          },
        },
      },
      card_number: {
        validators: {
          notEmpty: {
            message: 'Card member is required',
          },
          creditCard: {
            message: 'Card number is not valid',
          },
        },
      },
      card_expiry_month: {
        validators: {
          notEmpty: {
            message: 'Month is required',
          },
        },
      },
      card_expiry_year: {
        validators: {
          notEmpty: {
            message: 'Year is required',
          },
        },
      },
      card_cvv: {
        validators: {
          notEmpty: {
            message: 'CVV is required',
          },
          digits: {
            message: 'CVV must contain only digits',
          },
          stringLength: {
            min: 3,
            max: 4,
            message: 'CVV must contain 3 to 4 digits only',
          },
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
  }
);

let validate_bank = FormValidation.formValidation(
  document.getElementById('kt_wallet_topup_form'),
  {
    fields: {
      receipt_bank: {
        validators: {
          notEmpty: {
            message: 'Transaction receipt is required',
          },
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
  }
);

let validate_payoneer = FormValidation.formValidation(
  document.getElementById('kt_wallet_topup_form'),
  {
    fields: {
      receipt_payoneer: {
        validators: {
          notEmpty: {
            message: 'Transaction receipt is required',
          },
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
  }
);

function initValues() {
  $("select[name='country']")
    .select2()
    .val($("select[name='country']").data('value'))
    .trigger('change');
  $("select[name='card_expiry_month']")
    .select2()
    .val($("select[name='card_expiry_month']").data('value'))
    .trigger('change');
  $("select[name='card_expiry_year']")
    .select2()
    .val($("select[name='card_expiry_year']").data('value'))
    .trigger('change');
}

function selectCard(elem, card) {
  $('.saved-card').removeClass('bg-light-primary');
  $('.saved-card').removeClass('border-primary');
  $('#add-new-card-container').addClass('d-none');
  $('#add-new-card-container .card-logo-input').addClass('d-none');
  $("#add-new-card-container input[name='card_name']").val(card.card_name);
  $("#add-new-card-container input[name='card_number']").val(card.card_number);
  $("#add-new-card-container input[name='card_type']").val(card.card_type);
  $("select[name='card_expiry_month']")
    .select2()
    .val(card.card_expiry_month)
    .trigger('change');
  $("select[name='card_expiry_year']")
    .select2()
    .val(card.card_expiry_year)
    .trigger('change');
  $("#add-new-card-container input[name='card_cvv']").val(card.card_cvv);
  $('#add-new-card-container .card-logo-' + card.card_type).removeClass(
    'd-none'
  );
  elem.addClass('bg-light-primary');
  elem.addClass('border-primary');
}

function addNewCard() {
  $('#add-new-card-container').removeClass('d-none');
  $('.saved-card').removeClass('bg-light-primary');
  $('.saved-card').removeClass('border-primary');
  $("#add-new-card-container input[name='card_name']").val(null);
  $("#add-new-card-container input[name='card_number']").val(null);
  $("select[name='card_expiry_month']").select2().val(null).trigger('change');
  $("select[name='card_expiry_year']").select2().val(null).trigger('change');
  $("#add-new-card-container input[name='card_cvv']").val(null);
}

function selectAddress(elem, address) {
  $('.saved-address').removeClass('bg-light-primary');
  $('.saved-address').removeClass('border-primary');
  $('#add-new-address-container').addClass('d-none');
  $("#add-new-address-container input[name='first_name']").val(
    address.first_name
  );
  $("#add-new-address-container input[name='last_name']").val(
    address.last_name
  );
  $("#add-new-address-container input[name='company']").val(address.company);
  $("#add-new-address-container input[name='email']").val(address.email);
  $("#add-new-address-container input[name='phone']").val(address.phone);
  $("select[name='country']").select2().val(address.country).trigger('change');
  $("#add-new-address-container input[name='address1']").val(address.address1);
  $("#add-new-address-container input[name='address2']").val(address.address2);
  $("#add-new-address-container input[name='city']").val(address.city);
  $("#add-new-address-container input[name='state']").val(address.state);
  $("#add-new-address-container input[name='postcode']").val(address.postcode);

  elem.addClass('bg-light-primary');
  elem.addClass('border-primary');
}

function addNewAddress() {
  $('#add-new-address-container').removeClass('d-none');
  $('.saved-address').removeClass('bg-light-primary');
  $('.saved-address').removeClass('border-primary');
  $("#add-new-address-container input[name='first_name']").val(null);
  $("#add-new-address-container input[name='last_name']").val(null);
  $("#add-new-address-container input[name='company']").val(null);
  $("#add-new-address-container input[name='email']").val(null);
  $("#add-new-address-container input[name='phone']").val(null);
  $("select[name='country']").select2().val(null).trigger('change');
  $("#add-new-address-container input[name='address1']").val(null);
  $("#add-new-address-container input[name='address2']").val(null);
  $("#add-new-address-container input[name='city']").val(null);
  $("#add-new-address-container input[name='state']").val(null);
  $("#add-new-address-container input[name='postcode']").val(null);
}

function viewTransaction(index, transaction_data) {
  let transaction = JSON.parse(transaction_data);
  let viewModal = $('#kt_modal_view_transaction');
  viewModal.find('input[name="transaction_id"]').val(transaction.stripe_id);
  viewModal.find('input[name="amount"]').val(transaction.amount);
  viewModal.find('input[name="type"]').val(transaction.type);
  viewModal.find('input[name="status"]').val(transaction.status);
  viewModal.find('textarea[name="notes"]').val(transaction.notes);
  $('#transaction-receipt-' + index).attr('href');
  viewModal
    .find('#transaction-receipt-modal')
    .attr('href', $('#transaction-receipt-' + index).attr('href'));
  if (transaction.receipt) {
    $('.receipt-download').removeClass('d-none');
  } else {
    $('.receipt-download').addClass('d-none');
  }
  if (transaction.billing_address) {
    $('.billing_address').removeClass('d-none');
    $('.billing_address_field').html(
      transaction.billing_address.replaceAll(',', '<br />')
    );
  } else {
    $('.billing_address').addClass('d-none');
    $('.billing_address_field').html('');
  }
}
