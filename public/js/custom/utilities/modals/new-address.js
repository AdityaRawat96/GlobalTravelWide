'use strict';
var KTModalNewAddress = (function () {
  var t, e, n, o, i, r;
  return {
    init: function () {
      (r = document.querySelector('#kt_modal_new_address')) &&
        ((i = new bootstrap.Modal(r)),
        (o = document.querySelector('#kt_modal_new_address_form')),
        (t = document.getElementById('kt_modal_new_address_submit')),
        (e = document.getElementById('kt_modal_new_address_cancel')),
        $(o.querySelector('[name="country"]'))
          .select2()
          .on('change', function () {
            n.revalidateField('country');
          }),
        (n = FormValidation.formValidation(o, {
          fields: {
            first_name: {
              validators: { notEmpty: { message: 'First name is required' } },
            },
            last_name: {
              validators: { notEmpty: { message: 'Last name is required' } },
            },
            company: {
              validators: { notEmpty: { message: 'Company name is required' } },
            },
            email: {
              validators: {
                notEmpty: { message: 'Email address is required' },
                emailAddress: {
                  message: 'The value is not a valid email address',
                },
              },
            },
            phone: {
              validators: { notEmpty: { message: 'Phone number is required' } },
            },
            country: {
              validators: { notEmpty: { message: 'Country is required' } },
            },
            address1: {
              validators: { notEmpty: { message: 'Address 1 is required' } },
            },
            address2: {
              validators: { notEmpty: { message: 'Address 2 is required' } },
            },
            city: { validators: { notEmpty: { message: 'City is required' } } },
            state: {
              validators: { notEmpty: { message: 'State is required' } },
            },
            postcode: {
              validators: { notEmpty: { message: 'Postcode is required' } },
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
            n &&
              n.validate().then(function (e) {
                console.log('validated!'),
                  'Valid' == e
                    ? (t.setAttribute('data-kt-indicator', 'on'),
                      (t.disabled = !0),
                      $.ajax({
                        url: $('#kt_modal_new_address_form').attr('action'),
                        type: $('#kt_modal_new_address_form').attr('method'),
                        data: $('#kt_modal_new_address_form').serialize(),
                        success: function (result) {
                          t.removeAttribute('data-kt-indicator'),
                            (t.disabled = !1),
                            Swal.fire({
                              text: result.response,
                              icon: result.success ? 'success' : 'error',
                              buttonsStyling: !1,
                              confirmButtonText: 'Ok, got it!',
                              customClass: { confirmButton: 'btn btn-primary' },
                            }).then(function (e) {
                              e.isConfirmed &&
                                result.success &&
                                (i.hide(), window.location.reload());
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
                ? (o.reset(), i.hide())
                : 'cancel' === t.dismiss &&
                  Swal.fire({
                    text: 'Your form has not been cancelled!.',
                    icon: 'error',
                    buttonsStyling: !1,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn btn-primary' },
                  });
            });
        }));
    },
  };
})();
KTUtil.onDOMContentLoaded(function () {
  KTModalNewAddress.init();
});
