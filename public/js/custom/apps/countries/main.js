let table = $('#kt_countries_table').DataTable({
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

function editTableRow(index) {
  let tableRow = $('#datatable-row-' + index);
  let countryName = tableRow.find('.datatable-td-name').html().trim();

  let updateModal = $('#kt_modal_update_country');
  let countryNameInput = updateModal.find('input[name="name"]');

  countryNameInput.val(countryName);

  let formAction = $('#kt_modal_update_country_form').attr('action');
  formAction = formAction.split('/');
  formAction.pop();
  formAction.push(index);
  formAction = formAction.join('/');
  console.log(formAction);
  $('#kt_modal_update_country_form').attr('action', formAction);
}

function deleteTableRow(url, index) {
  let tableRow = $('#datatable-row-' + index);
  let countryName = tableRow.find('.datatable-td-name').html().trim();
  Swal.fire({
    text: 'Are you sure you want to delete ' + countryName + '?',
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
              text: 'You have deleted ' + countryName + '!.',
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
          text: countryName + ' was not deleted.',
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
  $('[data-kt-country-table-filter="search"]').keyup(function (e) {
    table.search(e.target.value).draw();
  });
});
