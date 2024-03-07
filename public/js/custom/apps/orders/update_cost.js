$(document).ready(function () {
  var modal = new bootstrap.Modal(
    document.querySelector('#kt_modal_update_package_cost')
  );
  var i, t, e, o, n, r;
  i = new bootstrap.Modal(
    document.querySelector('#kt_modal_update_package_cost')
  );
  r = document.querySelector('#kt_modal_update_package_cost_form');
  t = r.querySelector('#kt_modal_update_package_cost_submit');
  e = r.querySelector('#kt_modal_update_package_cost_cancel');
  o = r.querySelector('#kt_modal_update_package_cost_close');

  n = FormValidation.formValidation(r, {
    fields: {
      modal_import_fee: {
        validators: {
          notEmpty: { message: 'Shipping name is required' },
          digits: { message: 'Please enter a valid number' },
        },
      },
      modal_shipping_fee: {
        validators: {
          notEmpty: { message: 'Shipping name is required' },
          digits: { message: 'Please enter a valid number' },
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
  });

  t.addEventListener('click', function (e) {
    e.preventDefault(),
      n.validate().then(function (e) {
        'Valid' == e
          ? (t.setAttribute('data-kt-indicator', 'on'),
            (t.disabled = !0),
            $.ajax({
              url: $('#kt_modal_update_package_cost_form').attr('action'),
              type: $('#kt_modal_update_package_cost_form').attr('method'),
              data: $('#kt_modal_update_package_cost_form').serialize(),
              success: function (result) {
                t.removeAttribute('data-kt-indicator'),
                  (t.disabled = !1),
                  result.success
                    ? Swal.fire({
                        text: 'Order cost updated!',
                        icon: 'success',
                        buttonsStyling: !1,
                        confirmButtonText: 'Ok, got it!',
                        customClass: { confirmButton: 'btn btn-primary' },
                      }).then(function (e) {
                        e.isConfirmed && (i.hide(), window.location.reload());
                      })
                    : Swal.fire({
                        text: result.response,
                        icon: 'error',
                        buttonsStyling: !1,
                        confirmButtonText: 'Ok, got it!',
                        customClass: { confirmButton: 'btn btn-primary' },
                      });
              },
            }))
          : Swal.fire({
              text: 'Sorry, looks like there are some errors detected, please try again.',
              icon: 'error',
              buttonsStyling: !1,
              confirmButtonText: 'Ok, got it!',
              customClass: { confirmButton: 'btn btn-primary' },
            });
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
            ? (r.reset(), modal.hide())
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
            ? (r.reset(), modal.hide())
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
});

function updateModalCost(import_fee, shipping_fee, bin_id) {
  $('#modal_import_fee').val(import_fee);
  $('#modal_shipping_fee').val(shipping_fee);
  $('#modal_total_fee').val(import_fee + shipping_fee);
  $('#cost_update_bin_id').val(bin_id);
}
