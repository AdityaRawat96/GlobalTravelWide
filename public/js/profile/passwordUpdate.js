('use strict');
var KTUserPasswordUpdate = (function () {
  var e,
    t,
    a,
    r,
    s = function () {
      return 100 === r.getScore();
    };
  return {
    init: function () {
      (e = document.querySelector('#kt_signin_change_password')),
        (t = document.querySelector('#kt_password_submit')),
        (r = KTPasswordMeter.getInstance(
          e.querySelector('[data-kt-password-meter="true"]')
        )),
        (a = FormValidation.formValidation(e, {
          fields: {
            currentpassword: {
              validators: {
                notEmpty: { message: 'Current Password is required' },
              },
            },
            password: {
              validators: {
                callback: {
                  message: 'Please enter valid password',
                  callback: function (c) {
                    if (c.value.length > 0) return s();
                  },
                },
                notEmpty: { message: 'The password is required' },
              },
            },
            confirmpassword: {
              validators: {
                notEmpty: { message: 'The password confirmation is required' },
                identical: {
                  compare: function () {
                    return e.querySelector('[name="password"]').value;
                  },
                  message: 'The password and its confirm are not the same',
                },
              },
            },
            toc: {
              validators: {
                notEmpty: {
                  message: 'You must accept the terms and conditions',
                },
              },
            },
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger({
              event: { password: !1 },
            }),
            bootstrap: new FormValidation.plugins.Bootstrap5({
              rowSelector: '.fv-row',
              eleInvalidClass: '',
              eleValidClass: '',
            }),
          },
        })),
        $(document).ready(function (e) {
          $('#kt_signin_change_password').on('submit', function (e) {
            e.preventDefault();
            t.setAttribute('data-kt-indicator', 'on');
            t.disabled = !0;
            var formData = new FormData(this);
            $.ajax({
              url: $('#kt_signin_change_password').attr('action'),
              type: $('#kt_signin_change_password').attr('method'),
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
        t.addEventListener('click', function (s) {
          s.preventDefault(),
            a.revalidateField('password'),
            a.validate().then(function (a) {
              'Valid' == a
                ? $('#kt_signin_change_password').submit()
                : Swal.fire({
                    text: 'Sorry, looks like there are some errors detected, please try again.',
                    icon: 'error',
                    buttonsStyling: !1,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn btn-primary' },
                  });
            });
        }),
        e
          .querySelector('input[name="password"]')
          .addEventListener('input', function () {
            this.value.length > 0 &&
              a.updateFieldStatus('password', 'NotValidated');
          });
    },
  };
})();
KTUtil.onDOMContentLoaded(function () {
  KTUserPasswordUpdate.init();
});
