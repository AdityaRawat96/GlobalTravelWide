$(document).ready(function () {
  $('#kt_modal_new_card #card_number').keyup(function () {
    var cardType = detectCardType($(this).val().split(' ').join(''));
    $('#kt_modal_new_card .card-logo-input').addClass('d-none');
    $('#kt_modal_new_card .card-logo-' + cardType).removeClass('d-none');
    $('#kt_modal_new_card #card_type').val(cardType);
  });

  $('#kt_modal_update_card #card_number').keyup(function () {
    var cardType = detectCardType($(this).val().split(' ').join(''));
    $('#kt_modal_update_card .card-logo-input').addClass('d-none');
    $('#kt_modal_update_card .card-logo-' + cardType).removeClass('d-none');
    $('#kt_modal_update_card #card_type').val(cardType);
  });
});

function editCard(card) {
  $('#kt_modal_update_card .card-logo-input').addClass('d-none');
  $("#kt_modal_update_card input[name='id']").val(card.id);
  $("#kt_modal_update_card input[name='card_name']").val(card.card_name);
  $("#kt_modal_update_card input[name='card_number']").val(card.card_number);
  $("#kt_modal_update_card input[name='card_type']").val(card.card_type);
  $("select[name='card_expiry_month']")
    .select2()
    .val(card.card_expiry_month)
    .trigger('change');
  $("select[name='card_expiry_year']")
    .select2()
    .val(card.card_expiry_year)
    .trigger('change');
  $("#kt_modal_update_card input[name='card_cvv']").val(card.card_cvv);
  $("#kt_modal_update_card input[name='default']").attr(
    'checked',
    card.default ? true : false
  );
  $('#kt_modal_update_card .card-logo-' + card.card_type).removeClass('d-none');
}

function deleteCard(cardId, url) {
  var t = document.getElementById('kt_modal_update_card_submit');
  t.setAttribute('data-kt-indicator', 'on'),
    (t.disabled = !0),
    $.ajax({
      url: url,
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function (result) {
        t.removeAttribute('data-kt-indicator');
        t.disabled = !1;
        Swal.fire({
          text: result.response,
          icon: result.success ? 'success' : 'error',
          buttonsStyling: !1,
          confirmButtonText: 'Ok, got it!',
          customClass: { confirmButton: 'btn btn-primary' },
        }).then(function (e) {
          e.isConfirmed &&
            result.success &&
            ($('#kt_modal_update_card').hide(),
            $('.saved-card-' + cardId).remove());
        });
      },
    });
}

function editAddress(address) {
  $("#kt_modal_update_address input[name='id']").val(address.id);
  $("#kt_modal_update_address input[name='first_name']").val(
    address.first_name
  );
  $("#kt_modal_update_address input[name='last_name']").val(address.last_name);
  $("#kt_modal_update_address input[name='company']").val(address.company);
  $("#kt_modal_update_address input[name='email']").val(address.email);
  $("#kt_modal_update_address input[name='phone']").val(address.phone);
  $("select[name='country']").select2().val(address.country).trigger('change');
  $("#kt_modal_update_address input[name='address1']").val(address.address1);
  $("#kt_modal_update_address input[name='address2']").val(address.address2);
  $("#kt_modal_update_address input[name='city']").val(address.city);
  $("#kt_modal_update_address input[name='state']").val(address.state);
  $("#kt_modal_update_address input[name='postcode']").val(address.postcode);
  $("#kt_modal_update_address input[name='default']").attr(
    'checked',
    address.default ? true : false
  );
}

function deleteAddress(addressId, url) {
  var t = document.getElementById('kt_modal_update_address_submit');
  t.setAttribute('data-kt-indicator', 'on'),
    (t.disabled = !0),
    $.ajax({
      url: url,
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function (result) {
        t.removeAttribute('data-kt-indicator');
        t.disabled = !1;
        Swal.fire({
          text: result.response,
          icon: result.success ? 'success' : 'error',
          buttonsStyling: !1,
          confirmButtonText: 'Ok, got it!',
          customClass: { confirmButton: 'btn btn-primary' },
        }).then(function (e) {
          e.isConfirmed &&
            result.success &&
            $('.saved-address-' + addressId).remove();
        });
      },
    });
}

function detectCardType(number) {
  var re = {
    visa: /^4[0-9]{6,}$/,
    mastercard:
      /^5[1-5][0-9]{5,}|222[1-9][0-9]{3,}|22[3-9][0-9]{4,}|2[3-6][0-9]{5,}|27[01][0-9]{4,}|2720[0-9]{3,}$/,
    'american-express': /^3[47][0-9]{5,}$/,
  };

  for (var key in re) {
    if (re[key].test(number)) {
      return key;
    }
  }
}
