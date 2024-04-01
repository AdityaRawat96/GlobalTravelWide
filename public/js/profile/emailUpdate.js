'use strict';
var KTUserEmailUpdate = (function () {
  var t, n, r;
  return {
    init: function () {
      (r = document.querySelector('#kt_signin_change_email')),
        (t = r.querySelector('#kt_signin_submit')),
        (n = FormValidation.formValidation(r, {
          fields: {
            emailaddress: {
              validators: {
                regexp: {
                  regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                  message: 'The value is not a valid email address',
                },
                notEmpty: { message: 'Email address is required' },
              },
            },
            confirmemailpassword: {
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
          $('#kt_signin_change_email').on('submit', function (e) {
            e.preventDefault();
            t.setAttribute('data-kt-indicator', 'on');
            t.disabled = !0;
            var formData = new FormData(this);
            $.ajax({
              url: $('#kt_signin_change_email').attr('action'),
              type: $('#kt_signin_change_email').attr('method'),
              data: formData,
              processData: false,
              contentType: false,
              cache: false,
              enctype: 'multipart/form-data',
              success: function (result) {
                t.removeAttribute('data-kt-indicator');
                if (result.success) {
                  Swal.fire({
                    text: result.response,
                    icon: 'success',
                    buttonsStyling: !1,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn btn-primary' },
                  }).then(function (e) {
                    e.isConfirmed &&
                      ((t.disabled = !1), window.location.reload());
                  });
                } else {
                  Swal.fire({
                    text: result.response,
                    icon: 'error',
                    buttonsStyling: !1,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn btn-primary' },
                  }).then(function (e) {
                    e.isConfirmed && (t.disabled = !1);
                  });
                }
              },
            });
          });
        }),
        t.addEventListener('click', async function (e) {
          e.preventDefault(),
            // console.log('validated!'),
            'Valid' == (await n.validate())
              ? $('#kt_signin_change_email').submit()
              : Swal.fire({
                  text: 'Sorry, looks like there are some errors detected, please try again.',
                  icon: 'error',
                  buttonsStyling: !1,
                  confirmButtonText: 'Ok, got it!',
                  customClass: { confirmButton: 'btn btn-primary' },
                });
        });
    },
  };
})();
KTUtil.onDOMContentLoaded(function () {
  KTUserEmailUpdate.init();
});
