let table = $('#kt_tax_ratios_table').DataTable({
  info: !1,
  order: [],
  responsive: true,
  columnDefs: [
    {
      orderable: !1,
      targets: 3,
    },
  ],
});

function editTableRow(index) {
  let tableRow = $('#datatable-row-' + index);
  let tax_ratio_min_price = tableRow
    .find('.datatable-td-min_price')
    .html()
    .trim();
  let tax_ratio_max_price = tableRow
    .find('.datatable-td-max_price')
    .html()
    .trim();
  let tax_ratio_ratio = tableRow.find('.datatable-td-tax_ratio').html().trim();

  let updateModal = $('#kt_modal_update_tax_ratio');
  let tax_ratioMinPriceInput = updateModal.find('input[name="min_price"]');
  let tax_ratioMaxPriceInput = updateModal.find('input[name="max_price"]');
  let tax_ratioTaxRatioInput = updateModal.find('input[name="tax_ratio"]');

  tax_ratioMinPriceInput.val(tax_ratio_min_price);
  tax_ratioMaxPriceInput.val(tax_ratio_max_price);
  tax_ratioTaxRatioInput.val(tax_ratio_ratio);

  let formAction = $('#kt_modal_update_tax_ratio_form').attr('action');
  formAction = formAction.split('/');
  formAction.pop();
  formAction.push(index);
  formAction = formAction.join('/');
  $('#kt_modal_update_tax_ratio_form').attr('action', formAction);
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
  $('[data-kt-tax_ratio-table-filter="search"]').keyup(function (e) {
    table.search(e.target.value).draw();
  });
});
