'use strict';
var KTUserServices = (function () {
  var t, n, r;
  return {
    init: function () {
      (r = document.querySelector('#kt_ecommerce_customer_services_form')),
        (t = r.querySelector('#kt_ecommerce_customer_services_submit')),
        (n = FormValidation.formValidation(r, {
          fields: {
            service: {
              validators: {
                notEmpty: { message: 'This field is required' },
                digits: { message: 'The value must be a number' },
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
          $('#kt_ecommerce_customer_services_form').on('submit', function (e) {
            e.preventDefault();
            t.setAttribute('data-kt-indicator', 'on');
            t.disabled = !0;
            var formData = new FormData(this);
            $.ajax({
              url: $('#kt_ecommerce_customer_services_form').attr('action'),
              type: $('#kt_ecommerce_customer_services_form').attr('method'),
              data: formData,
              processData: false,
              contentType: false,
              cache: false,
              enctype: 'multipart/form-data',
              success: function (result) {
                t.removeAttribute('data-kt-indicator'),
                  Swal.fire({
                    text: 'Service pricing has been successfully updated!',
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
              ? $('#kt_ecommerce_customer_services_form').submit()
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
  KTUserServices.init();
});
