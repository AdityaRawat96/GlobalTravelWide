let table = $('#kt_warehouses_table').DataTable({
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

function editTableRow(index, warehouse_data) {
  let warehouse = JSON.parse(warehouse_data);
  let updateModal = $('#kt_modal_update_warehouse');
  updateModal.find('input[name="name"]').val(warehouse.name);
  updateModal.find('input[name="company"]').val(warehouse.company);
  updateModal.find('input[name="phone"]').val(warehouse.phone);
  updateModal.find('input[name="email"]').val(warehouse.email);
  updateModal.find('select[name="country"]').val(warehouse.country).change();
  updateModal.find('input[name="zip"]').val(warehouse.zip);
  updateModal.find('input[name="city"]').val(warehouse.city);
  updateModal.find('input[name="state"]').val(warehouse.state);
  updateModal.find('input[name="address_1"]').val(warehouse.address_1);
  updateModal.find('input[name="address_2"]').val(warehouse.address_2);

  let formAction = $('#kt_modal_update_warehouse_form').attr('action');
  formAction = formAction.split('/');
  formAction.pop();
  formAction.push(index);
  formAction = formAction.join('/');
  console.log(formAction);
  $('#kt_modal_update_warehouse_form').attr('action', formAction);
}

function deleteTableRow(url, index) {
  let tableRow = $('#datatable-row-' + index);
  let warehouseName = tableRow.find('.datatable-td-name').html().trim();
  Swal.fire({
    text: 'Are you sure you want to delete ' + warehouseName + '?',
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
              text: 'You have deleted ' + warehouseName + '!.',
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
          text: warehouseName + ' was not deleted.',
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
  $('[data-kt-warehouse-table-filter="search"]').keyup(function (e) {
    table.search(e.target.value).draw();
  });
});
