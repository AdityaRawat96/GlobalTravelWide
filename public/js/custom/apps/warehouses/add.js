'use strict';
var KTModalWarehousesAdd = (function () {
  var t, e, o, n, r, i;
  return {
    init: function () {
      (i = new bootstrap.Modal(
        document.querySelector('#kt_modal_add_warehouse')
      )),
        (r = document.querySelector('#kt_modal_add_warehouse_form')),
        (t = r.querySelector('#kt_modal_add_warehouse_submit')),
        (e = r.querySelector('#kt_modal_add_warehouse_cancel')),
        (o = r.querySelector('#kt_modal_add_warehouse_close')),
        (n = FormValidation.formValidation(r, {
          fields: {
            name: {
              validators: {
                notEmpty: { message: 'Warehouse name is required' },
              },
            },
            company: {
              validators: {
                notEmpty: { message: 'Warehouse company is required' },
              },
            },
            phone: {
              validators: {
                notEmpty: { message: 'Warehouse phone is required' },
              },
            },
            email: {
              validators: {
                regexp: {
                  regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                  message: 'The value is not a valid email address',
                },
                notEmpty: { message: 'Warehouse email is required' },
              },
            },
            country: {
              validators: {
                notEmpty: { message: 'Warehouse country is required' },
              },
            },
            zip: {
              validators: {
                notEmpty: { message: 'Warehouse zip is required' },
              },
            },
            city: {
              validators: {
                notEmpty: { message: 'Warehouse city is required' },
              },
            },
            state: {
              validators: {
                notEmpty: { message: 'Warehouse state is required' },
              },
            },
            address_1: {
              validators: {
                notEmpty: { message: 'Warehouse address is required' },
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
        t.addEventListener('click', function (e) {
          e.preventDefault(),
            n.validate().then(function (e) {
              // console.log('validated!'),
              'Valid' == e
                ? (t.setAttribute('data-kt-indicator', 'on'),
                  (t.disabled = !0),
                  $.ajax({
                    url: $('#kt_modal_add_warehouse_form').attr('action'),
                    type: $('#kt_modal_add_warehouse_form').attr('method'),
                    data: $('#kt_modal_add_warehouse_form').serialize(),
                    success: function (result) {
                      t.removeAttribute('data-kt-indicator'),
                        Swal.fire({
                          text: 'Form has been successfully submitted!',
                          icon: 'success',
                          buttonsStyling: !1,
                          confirmButtonText: 'Ok, got it!',
                          customClass: { confirmButton: 'btn btn-primary' },
                        }).then(function (e) {
                          e.isConfirmed &&
                            (i.hide(),
                            (t.disabled = !1),
                            window.location.reload());
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
  KTModalWarehousesAdd.init();
});
