$(document).ready(function () {
  $("select[name='country-id']").val(
    $("select[name='country-id']").data('value')
  );
});
