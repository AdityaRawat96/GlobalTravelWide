let table = $('#kt_boxes_table').DataTable({
  info: !1,
  order: [],
  responsive: true,
  columnDefs: [
    {
      orderable: !1,
      targets: 6,
    },
  ],
});

function editTableRow(index) {
  let tableRow = $('#datatable-row-' + index);
  let boxName = tableRow.find('.datatable-td-name').html().trim();
  let boxPrice = tableRow.find('.datatable-td-price').html().trim();
  let boxLength = tableRow.find('.datatable-td-length').html().trim();
  let boxWidth = tableRow.find('.datatable-td-width').html().trim();
  let boxHeight = tableRow.find('.datatable-td-height').html().trim();
  let boxWeight = tableRow.find('.datatable-td-weight').html().trim();

  let updateModal = $('#kt_modal_update_box');
  let boxNameInput = updateModal.find('input[name="box-name"]');
  let boxPriceInput = updateModal.find('input[name="box-price"]');
  let boxLengthInput = updateModal.find('input[name="box-length"]');
  let boxWidthInput = updateModal.find('input[name="box-width"]');
  let boxHeightInput = updateModal.find('input[name="box-height"]');
  let boxWeightInput = updateModal.find('input[name="box-weight"]');

  boxNameInput.val(boxName);
  boxPriceInput.val(boxPrice);
  boxLengthInput.val(boxLength);
  boxWidthInput.val(boxWidth);
  boxHeightInput.val(boxHeight);
  boxWeightInput.val(boxWeight);

  let formAction = $('#kt_modal_update_box_form').attr('action');
  formAction = formAction.split('/');
  formAction.pop();
  formAction.push(index);
  formAction = formAction.join('/');
  console.log(formAction);
  $('#kt_modal_update_box_form').attr('action', formAction);
}

function deleteTableRow(url, index) {
  let tableRow = $('#datatable-row-' + index);
  let boxName = tableRow.find('.datatable-td-name').html().trim();
  Swal.fire({
    text: 'Are you sure you want to delete ' + boxName + '?',
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
              text: 'You have deleted ' + boxName + '!.',
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
          text: boxName + ' was not deleted.',
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
  $('[data-kt-box-table-filter="search"]').keyup(function (e) {
    table.search(e.target.value).draw();
  });
});
