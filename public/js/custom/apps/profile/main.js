$(document).ready(function () {
  $('.nav-link-profile-tab').click(function (e) {
    e.preventDefault();
    $('.nav-link-profile-tab').removeClass('active');
    $(this).addClass('active');
    $('.profile-sections-tab-container').removeClass('active');
    $($(this).data('target')).addClass('active');
  });

  $('#kt_signin_email_button').click(function () {
    toggleEmailResetForm();
  });
  $('#kt_signin_cancel').click(function () {
    toggleEmailResetForm();
  });
  $('#kt_password_cancel').click(function () {
    togglePasswordResetForm();
  });
  $('#kt_signin_password_button').click(function () {
    togglePasswordResetForm();
  });

  $("select[name='country']")
    .select2()
    .val($("select[name='country']").data('value'))
    .trigger('change');
});

function toggleEmailResetForm() {
  if ($('#kt_signin_email_edit').hasClass('d-none')) {
    $('#kt_signin_email_edit').removeClass('d-none');
    $('#kt_signin_email').addClass('d-none');
    $('#kt_signin_email_button').addClass('d-none');
  } else {
    $('#kt_signin_email_edit').addClass('d-none');
    $('#kt_signin_email').removeClass('d-none');
    $('#kt_signin_email_button').removeClass('d-none');
  }
}

function togglePasswordResetForm() {
  if ($('#kt_signin_password_edit').hasClass('d-none')) {
    $('#kt_signin_password_edit').removeClass('d-none');
    $('#kt_signin_password').addClass('d-none');
    $('#kt_signin_password_button').addClass('d-none');
  } else {
    $('#kt_signin_password_edit').addClass('d-none');
    $('#kt_signin_password').removeClass('d-none');
    $('#kt_signin_password_button').removeClass('d-none');
  }
}

function initValidation() {
  FormValidation.formValidation(
    document.querySelector('#kt_account_profile_details_form'),
    {
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
    }
  );
}
