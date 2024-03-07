function toggleStatusInputs(status) {
  $('.orer-status-sections').css('display', 'none');
  if (status == 'In-transit') {
    $('.section-' + status.replace(' ', '-').toLowerCase()).css(
      'display',
      'block'
    );
  } else if (status == 'Received') {
    $('.section-' + status.replace(' ', '-').toLowerCase()).css(
      'display',
      'block'
    );
  } else if (status == 'Needs Attention') {
    $('.section-' + status.replace(' ', '-').toLowerCase()).css(
      'display',
      'block'
    );
  } else if (status == 'Shipped') {
    $('.section-' + status.replace(' ', '-').toLowerCase()).css(
      'display',
      'block'
    );
  }
}

$(document).ready(function () {
  toggleStatusInputs($('.order_status').val());

  $('.order_status').change(function () {
    $('textarea[name="admin_notes"]').val('');
    toggleStatusInputs($(this).val());
  });

  $('#view_products_filter').change(function () {
    if ($(this).val() == 'all') {
      $('tr.unbundled-item').removeClass('d-none');
    } else {
      $('tr.unbundled-item').addClass('d-none');
    }
  });
});

function setBinProducts(index) {
  $('.bin_products_container').each(function () {
    if (!$(this).hasClass('d-none')) {
      $(this).addClass('d-none');
    }
  });
  $('.bin_products_' + index).removeClass('d-none');
}
