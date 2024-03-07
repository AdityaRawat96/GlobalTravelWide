let table = $('#kt_transactions_table').DataTable({
  info: !1,
  order: [],
  responsive: true,
  columnDefs: [
    {
      orderable: !1,
      targets: 7,
    },
  ],
});

function viewTableRow(index, transaction_data) {
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

function editTableRow(index, transaction_data) {
  let transaction = JSON.parse(transaction_data);
  let updateModal = $('#kt_modal_update_transaction');

  updateModal.find('input[name="amount"]').val(transaction.amount);
  updateModal.find('select[name="status"]').val(transaction.status);
  updateModal.find('textarea[name="notes"]').val(transaction.notes);
  $('#transaction-receipt-' + index).attr('href');
  updateModal
    .find('#transaction-receipt-modal')
    .attr('href', $('#transaction-receipt-' + index).attr('href'));
  if (transaction.receipt) {
    $('.receipt-download').removeClass('d-none');
  } else {
    $('.receipt-download').addClass('d-none');
  }

  let formAction = $('#kt_modal_update_transaction_form').attr('action');
  formAction = formAction.split('/');
  formAction.pop();
  formAction.push(index);
  formAction = formAction.join('/');
  $('#kt_modal_update_transaction_form').attr('action', formAction);
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
              text: 'Transaction deleted!.',
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
          text: transactionName + ' was not deleted.',
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
  $('[data-kt-transaction-table-filter="search"]').keyup(function (e) {
    table.search(e.target.value).draw();
  });
});
