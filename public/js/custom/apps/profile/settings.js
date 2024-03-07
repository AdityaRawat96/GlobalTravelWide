'use strict';
var KTUserSettings = (function () {
  var t, n, r;
  return {
    init: function () {
      (r = document.querySelector('#kt_account_profile_details_form')),
        (t = r.querySelector('#kt_account_profile_details_submit')),
        (n = FormValidation.formValidation(r, {
          fields: {
            first_name: {
              validators: {
                notEmpty: { message: 'This field is required' },
              },
            },
            last_name: {
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
          $('#kt_account_profile_details_form').on('submit', function (e) {
            e.preventDefault();
            t.setAttribute('data-kt-indicator', 'on');
            t.disabled = !0;
            var formData = new FormData(this);
            $.ajax({
              url: $('#kt_account_profile_details_form').attr('action'),
              type: $('#kt_account_profile_details_form').attr('method'),
              data: formData,
              processData: false,
              contentType: false,
              cache: false,
              enctype: 'multipart/form-data',
              success: function (result) {
                t.removeAttribute('data-kt-indicator'),
                  Swal.fire({
                    text: 'Profile has been successfully updated!',
                    icon: 'success',
                    buttonsStyling: !1,
                    confirmButtonText: 'Ok, got it!',
                    customClass: { confirmButton: 'btn btn-primary' },
                  }).then(function (e) {
                    e.isConfirmed &&
                      ((t.disabled = !1), window.location.reload());
                  });
              },
            });
          });
        }),
        t.addEventListener('click', async function (e) {
          e.preventDefault(),
            // console.log('validated!'),
            'Valid' == (await n.validate())
              ? $('#kt_account_profile_details_form').submit()
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
  KTUserSettings.init();
});
