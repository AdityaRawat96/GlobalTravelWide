let table = $('#kt_services_table').DataTable({
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

function editTableRow(index, service_data) {
  let service = JSON.parse(service_data);
  let updateModal = $('#kt_modal_update_service');
  updateModal.find('input[name="name"]').val(service.name);
  updateModal.find('textarea[name="description"]').val(service.description);
  updateModal.find('select[name="type"]').val(service.type).change();
  updateModal
    .find('select[name="dependency"]')
    .val(service.dependency)
    .change();
  updateModal.find('input[name="price"]').val(service.price);

  if (service.type == 'fixed') {
    $('#update_service_dependency_select_container').fadeOut();
  } else {
    $('#update_service_dependency_select_container').fadeIn();
  }

  let formAction = $('#kt_modal_update_service_form').attr('action');
  formAction = formAction.split('/');
  formAction.pop();
  formAction.push(index);
  formAction = formAction.join('/');
  console.log(formAction);
  $('#kt_modal_update_service_form').attr('action', formAction);
}

function deleteTableRow(url, index) {
  let tableRow = $('#datatable-row-' + index);
  let serviceName = tableRow.find('.datatable-td-name').html().trim();
  Swal.fire({
    text: 'Are you sure you want to delete ' + serviceName + '?',
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
              text: 'You have deleted ' + serviceName + '!.',
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
          text: serviceName + ' was not deleted.',
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
  $('[data-kt-service-table-filter="search"]').keyup(function (e) {
    table.search(e.target.value).draw();
  });

  $('#add_service_type_select').change(function () {
    console.log($(this).val());
    if ($(this).val() == 'fixed') {
      $('#add_service_dependency_select_container').fadeOut();
    } else {
      $('#add_service_dependency_select_container').fadeIn();
    }
  });

  $('#update_service_type_select').change(function () {
    if ($(this).val() == 'fixed') {
      $('#update_service_dependency_select_container').fadeOut();
    } else {
      $('#update_service_dependency_select_container').fadeIn();
    }
  });
});
