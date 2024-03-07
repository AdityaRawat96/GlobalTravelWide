let table = $('#kt_rate_ratios_table').DataTable({
  info: !1,
  order: [],
  responsive: true,
  columnDefs: [
    {
      orderable: !1,
    },
  ],
});

function editTableRow(index) {
  let tableRow = $('#datatable-row-' + index);
  let rate_ratio_carrier = tableRow.find('.datatable-td-carrier').data('id');
  let rate_ratio_country = tableRow.find('.datatable-td-country').data('id');
  let rate_ratio_price = tableRow.find('.datatable-td-price').html().trim();
  let rate_ratio_weight = tableRow.find('.datatable-td-weight').html().trim();

  let updateModal = $('#kt_modal_update_rate_ratio');
  let rate_ratioCarrierInput = updateModal.find('select[name="carrier_id"]');
  let rate_ratioCountryInput = updateModal.find('select[name="country_id"]');
  let rate_ratioPriceInput = updateModal.find('input[name="price"]');
  let rate_ratioWeightInput = updateModal.find('input[name="weight"]');

  rate_ratioCarrierInput.val(rate_ratio_carrier).change();
  rate_ratioCountryInput.val(rate_ratio_country).change();
  rate_ratioPriceInput.val(rate_ratio_price);
  rate_ratioWeightInput.val(rate_ratio_weight);

  let formAction = $('#kt_modal_update_rate_ratio_form').attr('action');
  formAction = formAction.split('/');
  formAction.pop();
  formAction.push(index);
  formAction = formAction.join('/');
  $('#kt_modal_update_rate_ratio_form').attr('action', formAction);
}

function deleteTableRow(url, index) {
  let tableRow = $('#datatable-row-' + index);
  Swal.fire({
    text: 'Are you sure you want to delete this record?',
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
              text: 'You have deleted the record successfully!.',
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
          text: 'Record was not deleted.',
          icon: 'error',
          buttonsStyling: !1,
          confirmButtonText: 'Ok, got it!',
          customClass: {
            confirmButton: 'btn fw-bold btn-primary',
          },
        });
  });
}

$(document).ready(function () {
  $('[data-kt-rate_ratio-table-filter="search"]').keyup(function (e) {
    table.search(e.target.value).draw();
  });

  let bulkUpdateButton = document.querySelector(
    '#kt_modal_bulk_update_rate_ratio_submit'
  );

  $('#kt_modal_bulk_update_rate_ratio_submit').click(function (e) {
    bulkUpdateButton.setAttribute('data-kt-indicator', 'on');
    bulkUpdateButton.disabled = !0;
    e.preventDefault();
    let form = $('#kt_modal_bulk_update_rate_ratio_form');
    let formData = form.serialize();
    let url = form.attr('action');
    let method = form.attr('method');
    $.ajax({
      url: url,
      method: method,
      data: formData,
      success: function (result) {
        console.log(result);
        bulkUpdateButton.removeAttribute('data-kt-indicator');
        bulkUpdateButton.disabled = !1;
        Swal.fire({
          text: 'You have updated the records successfully!.',
          icon: 'success',
          buttonsStyling: !1,
          confirmButtonText: 'Ok, got it!',
          customClass: {
            confirmButton: 'btn fw-bold btn-primary',
          },
        }).then(function () {
          location.reload();
        });
      },
    });
  });
});
