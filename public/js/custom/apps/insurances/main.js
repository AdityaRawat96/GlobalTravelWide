let table = $('#kt_insurances_table').DataTable({
  info: !1,
  order: [],
  responsive: true,
  columnDefs: [
    {
      orderable: !1,
      targets: 2,
    },
  ],
});

function editTableRow(index, insurance_data) {
  let insurance = JSON.parse(insurance_data);
  let updateModal = $('#kt_modal_update_insurance');

  updateModal.find('input[name="min_qty"]').val(insurance.min_qty);
  updateModal.find('input[name="max_qty"]').val(insurance.max_qty);
  updateModal.find('input[name="price"]').val(insurance.price);

  let formAction = $('#kt_modal_update_insurance_form').attr('action');
  formAction = formAction.split('/');
  formAction.pop();
  formAction.push(index);
  formAction = formAction.join('/');
  console.log(formAction);
  $('#kt_modal_update_insurance_form').attr('action', formAction);
}

function deleteTableRow(url, index) {
  let tableRow = $('#datatable-row-' + index);
  Swal.fire({
    text: 'Are you sure you want to delete this field?',
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
              text: 'Insurance deleted!.',
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
          text: insuranceName + ' was not deleted.',
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
  $('[data-kt-insurance-table-filter="search"]').keyup(function (e) {
    table.search(e.target.value).draw();
  });
});
