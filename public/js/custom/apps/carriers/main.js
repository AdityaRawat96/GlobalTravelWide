let table = $('#kt_carriers_table').DataTable({
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

function editTableRow(index, carrier_data) {
  // First register any plugins
  $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
  $.fn.filepond.registerPlugin(FilePondPluginGetFile);
  // Turn input element into a pond
  $('#attachments_update').filepond();
  // Set allowMultiple property to true
  $('#attachments_update').filepond({
    allowMultiple: true,
    storeAsFile: true,
    name: 'attachment',
    labelButtonDownloadItem: 'custom label', // by default 'Download file'
    allowDownloadByUrl: false, // by default downloading by URL disabled
  });

  let carrier = JSON.parse(carrier_data);
  let updateModal = $('#kt_modal_update_carrier');
  updateModal.find('input[name="name"]').val(carrier.name);
  if (carrier.logo) {
    $('#attachments_update').filepond('addFile', '/storage/' + carrier.logo);
  }

  let formAction = $('#kt_modal_update_carrier_form').attr('action');
  formAction = formAction.split('/');
  formAction.pop();
  formAction.push(index);
  formAction = formAction.join('/');
  $('#kt_modal_update_carrier_form').attr('action', formAction);
}

function deleteTableRow(url, index) {
  let tableRow = $('#datatable-row-' + index);
  Swal.fire({
    text: 'Are you sure you want to delete this carrier?',
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
              text: 'Carrier deleted!',
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
          text: 'Carrier was not deleted.',
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
  $('[data-kt-carrier-table-filter="search"]').keyup(function (e) {
    table.search(e.target.value).draw();
  });

  // First register any plugins
  $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
  $.fn.filepond.registerPlugin(FilePondPluginGetFile);
  // Turn input element into a pond
  $('#attachments_add').filepond();
  // Set allowMultiple property to true
  $('#attachments_add').filepond({
    allowMultiple: false,
    storeAsFile: true,
    name: 'attachment',
    labelButtonDownloadItem: 'custom label', // by default 'Download file'
    allowDownloadByUrl: false, // by default downloading by URL disabled
  });
});
