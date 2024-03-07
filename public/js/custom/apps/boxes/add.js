'use strict';
var KTModalBoxesAdd = (function () {
  var t, e, o, n, r, i;
  return {
    init: function () {
      (i = new bootstrap.Modal(document.querySelector('#kt_modal_add_box'))),
        (r = document.querySelector('#kt_modal_add_box_form')),
        (t = r.querySelector('#kt_modal_add_box_submit')),
        (e = r.querySelector('#kt_modal_add_box_cancel')),
        (o = r.querySelector('#kt_modal_add_box_close')),
        (n = FormValidation.formValidation(r, {
          fields: {
            'box-name': {
              validators: {
                notEmpty: { message: 'Box name is required' },
              },
            },
            'box-price': {
              validators: {
                notEmpty: { message: 'Box price is required' },
                numeric: { message: 'Only numeric values are allowed' },
              },
            },
            'box-length': {
              validators: {
                notEmpty: { message: 'Box length is required' },
                numeric: { message: 'Only numeric values are allowed' },
              },
            },
            'box-width': {
              validators: {
                notEmpty: { message: 'Box width is required' },
                numeric: { message: 'Only numeric values are allowed' },
              },
            },
            'box-height': {
              validators: {
                notEmpty: { message: 'Box height is required' },
                numeric: { message: 'Only numeric values are allowed' },
              },
            },
            'box-weight': {
              validators: {
                notEmpty: { message: 'Box weight is required' },
                numeric: { message: 'Only numeric values are allowed' },
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
                    url: $('#kt_modal_add_box_form').attr('action'),
                    type: $('#kt_modal_add_box_form').attr('method'),
                    data: $('#kt_modal_add_box_form').serialize(),
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
  KTModalBoxesAdd.init();
});
