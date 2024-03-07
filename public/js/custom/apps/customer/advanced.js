'use strict';
var KTModalBoxesAdd = (function () {
  var t, e, o, n, r, i, m;
  return {
    init: function () {
      (i = new bootstrap.Modal(
        document.querySelector('#kt_modal_update_email')
      )),
        (r = document.querySelector('#kt_modal_update_email_form')),
        (m = document.querySelector('#kt_modal_update_email')),
        (t = m.querySelector('#kt_modal_update_email_submit')),
        (e = m.querySelector('#kt_modal_update_email_cancel')),
        (o = m.querySelector('#kt_modal_update_email_close')),
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
                    url: $('#kt_modal_update_email_form').attr('action'),
                    type: $('#kt_modal_update_email_form').attr('method'),
                    data: $('#kt_modal_update_email_form').serialize(),
                    success: function (result) {
                      t.removeAttribute('data-kt-indicator'),
                        Swal.fire({
                          text: result.response,
                          icon: result.success ? 'success' : 'error',
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
  KTModalBoxesAdd.init();
});

('use strict');
var KTUsersUpdatePassword = (function () {
  const t = document.getElementById('kt_modal_update_password'),
    e = t.querySelector('#kt_modal_update_password_form'),
    n = new bootstrap.Modal(
      document.querySelector('#kt_modal_update_password')
    );
  return {
    init: function () {
      (() => {
        var o = FormValidation.formValidation(e, {
          fields: {
            new_password: {
              validators: {
                notEmpty: { message: 'The password is required' },
                callback: {
                  message: 'Please enter valid password',
                  callback: function (t) {
                    if (t.value.length > 0) return validatePassword();
                  },
                },
              },
            },
            confirm_password: {
              validators: {
                notEmpty: { message: 'The password confirmation is required' },
                identical: {
                  compare: function () {
                    return e.querySelector('[name="new_password"]').value;
                  },
                  message: 'The password and its confirm are not the same',
                },
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
        t
          .querySelector('[data-kt-users-modal-action="close"]')
          .addEventListener('click', (t) => {
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
                  ? (e.reset(), n.hide())
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
          t
            .querySelector('[data-kt-users-modal-action="cancel"]')
            .addEventListener('click', (t) => {
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
                    ? (e.reset(), n.hide())
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
        const a = t.querySelector('[data-kt-users-modal-action="submit"]');
        a.addEventListener('click', function (t) {
          t.preventDefault(),
            o &&
              o.validate().then(function (t) {
                console.log('validated!'),
                  'Valid' == t &&
                    (a.setAttribute('data-kt-indicator', 'on'),
                    (a.disabled = !0),
                    $.ajax({
                      url: $('#kt_modal_update_password_form').attr('action'),
                      type: $('#kt_modal_update_password_form').attr('method'),
                      data: $('#kt_modal_update_password_form').serialize(),
                      success: function (result) {
                        a.removeAttribute('data-kt-indicator'),
                          (a.disabled = !1),
                          Swal.fire({
                            text: result.response,
                            icon: result.success ? 'success' : 'error',
                            buttonsStyling: !1,
                            confirmButtonText: 'Ok, got it!',
                            customClass: { confirmButton: 'btn btn-primary' },
                          }).then(function (e) {
                            e.isConfirmed && n.hide();
                          });
                      },
                    }));
              });
        });
      })();
    },
  };
})();
KTUtil.onDOMContentLoaded(function () {
  KTUsersUpdatePassword.init();
});

('use strict');
var KTAddTransaction = (function () {
  const t = document.getElementById('kt_modal_add_transaction'),
    e = t.querySelector('#kt_modal_add_transaction_form'),
    n = new bootstrap.Modal(
      document.querySelector('#kt_modal_add_transaction')
    );
  return {
    init: function () {
      (() => {
        var o = FormValidation.formValidation(e, {
          fields: {
            amount: {
              validators: {
                notEmpty: { message: 'This field is required' },
              },
            },
            type: {
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
        });
        t
          .querySelector('#kt_modal_add_transaction_close')
          .addEventListener('click', (t) => {
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
                  ? (e.reset(), n.hide())
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
          t
            .querySelector('#kt_modal_add_transaction_cancel')
            .addEventListener('click', (t) => {
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
                    ? (e.reset(), n.hide())
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
        const a = t.querySelector('#kt_modal_add_transaction_submit');
        a.addEventListener('click', function (t) {
          t.preventDefault(),
            o &&
              o.validate().then(function (t) {
                console.log('validated!'),
                  'Valid' == t &&
                    (a.setAttribute('data-kt-indicator', 'on'),
                    (a.disabled = !0),
                    $.ajax({
                      url: $('#kt_modal_add_transaction_form').attr('action'),
                      type: $('#kt_modal_add_transaction_form').attr('method'),
                      data: $('#kt_modal_add_transaction_form').serialize(),
                      success: function (result) {
                        a.removeAttribute('data-kt-indicator'),
                          (a.disabled = !1),
                          Swal.fire({
                            text: result.response,
                            icon: result.success ? 'success' : 'error',
                            buttonsStyling: !1,
                            confirmButtonText: 'Ok, got it!',
                            customClass: { confirmButton: 'btn btn-primary' },
                          }).then(function (e) {
                            e.isConfirmed &&
                              (n.hide(), window.location.reload());
                          });
                      },
                    }));
              });
        });
      })();
    },
  };
})();
KTUtil.onDOMContentLoaded(function () {
  KTAddTransaction.init();
});
