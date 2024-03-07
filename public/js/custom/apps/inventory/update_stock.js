function updateStock(id, type, qty) {
  var url = '/inventory/update_stock';
  var data = {
    id: id,
    type: type,
    qty: qty,
  };
  $.ajax({
    type: 'POST',
    url: url,
    data: data,
    success: function (data) {
      if (data.status == 'success') {
        alert('Stock Updated');
        location.reload();
      } else {
        alert('Failed to update stock');
      }
    },
    error: function (data) {
      alert('Failed to update stock');
    },
  });
}

function updateStockModal(asin, stock, working) {
  $('#product_asin').val(asin);
  $('#current_stock').val(stock);
  $('#current_working').val(working);
  $('#updated_working').val(working);
}

('use strict');
var KTModalPrice_ratiosAdd = (function () {
  var t, e, o, n, r, i, f;
  return {
    init: function () {
      (i = new bootstrap.Modal(
        document.querySelector('#kt_modal_update_stock')
      )),
        (r = document.querySelector('#kt_modal_update_stock_form')),
        (t = r.querySelector('#kt_modal_update_stock_submit')),
        (e = r.querySelector('#kt_modal_update_stock_cancel')),
        (o = r.querySelector('#kt_modal_update_stock_close')),
        (n = FormValidation.formValidation(r, {
          fields: {
            updated_stock: {
              validators: {
                notEmpty: { message: 'This field is required' },
              },
            },
            updated_working: {
              validators: {
                notEmpty: { message: 'This field is required' },
              },
            },
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
              rowSelector: '.fv-row',
              eleInvalidClass: '',
              eleValidClass: '',
            }),
          },
        })),
        $(document).ready(function (e) {
          $('#kt_modal_update_stock_form').on('submit', function (e) {
            e.preventDefault();
            t.setAttribute('data-kt-indicator', 'on');
            t.disabled = !0;
            var formData = new FormData(this);
            $.ajax({
              url: $('#kt_modal_update_stock_form').attr('action'),
              type: $('#kt_modal_update_stock_form').attr('method'),
              data: formData,
              processData: false,
              contentType: false,
              cache: false,
              enctype: 'multipart/form-data',
              success: function (result) {
                t.removeAttribute('data-kt-indicator'),
                  Swal.fire({
                    text: 'Stock Updated!',
                    icon: 'success',
                    buttonsStyling: !1,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn btn-primary' },
                  }).then(function (e) {
                    e.isConfirmed &&
                      (i.hide(), (t.disabled = !1), window.location.reload());
                  });
              },
            });
          });
        }),
        t.addEventListener('click', async function (e) {
          e.preventDefault(),
            // console.log('validated!'),
            'Valid' == (await n.validate())
              ? $('#kt_modal_update_stock_form').submit()
              : Swal.fire({
                  text: 'Sorry, looks like there are some errors detected, please try again.',
                  icon: 'error',
                  buttonsStyling: !1,
                  confirmButtonText: 'Ok, got it!',
                  customClass: { confirmButton: 'btn btn-primary' },
                });
        }),
        e.addEventListener('click', function (t) {
          t.preventDefault(),
            Swal.fire({
              text: 'Are you sure you would like to cancel?',
              icon: 'warning',
              showCancelButton: !0,
              buttonsStyling: !1,
              confirmButtonText: 'Yes, cancel it!',
              cancelButtonText: 'No, return',
              customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-active-light',
              },
            }).then(function (t) {
              t.value
                ? (r.reset(), i.hide())
                : 'cancel' === t.dismiss &&
                  Swal.fire({
                    text: 'Your form has not been cancelled!.',
                    icon: 'error',
                    buttonsStyling: !1,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn btn-primary' },
                  });
            });
        }),
        o.addEventListener('click', function (t) {
          t.preventDefault(),
            Swal.fire({
              text: 'Are you sure you would like to cancel?',
              icon: 'warning',
              showCancelButton: !0,
              buttonsStyling: !1,
              confirmButtonText: 'Yes, cancel it!',
              cancelButtonText: 'No, return',
              customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-active-light',
              },
            }).then(function (t) {
              t.value
                ? (r.reset(), i.hide())
                : 'cancel' === t.dismiss &&
                  Swal.fire({
                    text: 'Your form has not been cancelled!.',
                    icon: 'error',
                    buttonsStyling: !1,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn btn-primary' },
                  });
            });
        });
    },
  };
})();
KTUtil.onDOMContentLoaded(function () {
  KTModalPrice_ratiosAdd.init();
});
