let table = $('#kt-customer-table').DataTable({
  info: !1,
  order: [],
  responsive: true,
});

let tansaction_table = $('#kt_table_customers_payment').DataTable({
  info: !1,
  order: [],
  responsive: true,
});

$(document).ready(function () {
  $('[data-kt-customer-table-filter="search"]').on('keyup', function (e) {
    table.search(e.target.value).draw();
  });
});

function viewTransaction(index, transaction_data) {
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
