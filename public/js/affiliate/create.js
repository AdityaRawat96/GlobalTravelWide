"use strict";
var KTAffiliateSettings = (function () {
    var t, n, r;
    return {
        init: function () {
            (r = document.querySelector("#kt_create_form")),
                (t = r.querySelector("#kt_form_submit")),
                (n = FormValidation.formValidation(r, {
                    fields: {
                        name: {
                            validators: {
                                notEmpty: { message: "This field is required" },
                            },
                        },
                        email: {
                            validators: {
                                notEmpty: { message: "This field is required" },
                                emailAddress: {
                                    message:
                                        "The value is not a valid email address",
                                },
                            },
                        },
                        phone: {
                            validators: {
                                notEmpty: { message: "This field is required" },
                            },
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: "",
                        }),
                    },
                })),
                $(document).ready(function (e) {
                    $(".reset").on("click", function (e) {
                        n.resetForm();
                        window.history.length > 2
                            ? window.history.back()
                            : (window.location.href = `${siteURL}/${siteUserRole}/affiliate`);
                    }),
                        $("#kt_create_form").on("submit", function (e) {
                            e.preventDefault();
                            t.setAttribute("data-kt-indicator", "on");
                            t.disabled = !0;
                            var formData = new FormData(this);
                            if ($("#kt_create_form").attr("method") == "PUT") {
                                formData.append("_method", "PUT");
                            }
                            $.ajax({
                                url: $("#kt_create_form").attr("action"),
                                type:
                                    $("#kt_create_form").attr("method") == "PUT"
                                        ? "POST"
                                        : "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                cache: false,
                                enctype: "multipart/form-data",
                                success: function (result) {
                                    (t.disabled = !1),
                                        console.log(result),
                                        t.removeAttribute("data-kt-indicator"),
                                        Swal.fire({
                                            text: result.message,
                                            icon: "success",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton:
                                                    "btn btn-primary",
                                            },
                                        }).then(function (e) {
                                            e.isConfirmed &&
                                                window.location.reload();
                                        });
                                },
                                error: function (err) {
                                    t.disabled = !1;
                                    t.removeAttribute("data-kt-indicator");
                                    if (err.status == 422) {
                                        console.log(err.responseJSON);
                                        // display errors on each form field
                                        $.each(
                                            err.responseJSON.errors,
                                            function (i, error) {
                                                var el = $(
                                                    "#kt_create_form [name='" +
                                                        i +
                                                        "']"
                                                );
                                                el.closest(".fv-row")
                                                    .find(
                                                        ".fv-plugins-message-container"
                                                    )
                                                    .text(error[0]);
                                                el.addClass("is-invalid");

                                                // scroll to the error message
                                                KTUtil.scrollTop();

                                                Swal.fire({
                                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                                    icon: "error",
                                                    buttonsStyling: !1,
                                                    confirmButtonText:
                                                        "Ok, got it!",
                                                    customClass: {
                                                        confirmButton:
                                                            "btn btn-primary",
                                                    },
                                                });
                                            }
                                        );
                                    } else {
                                        Swal.fire({
                                            text: "Sorry, looks like there are some errors detected, please try again.",
                                            icon: "error",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton:
                                                    "btn btn-primary",
                                            },
                                        });
                                    }
                                },
                            });
                        });
                }),
                t.addEventListener("click", async function (e) {
                    e.preventDefault(),
                        "Valid" == (await n.validate())
                            ? $("#kt_create_form").submit()
                            : Swal.fire({
                                  text: "Sorry, looks like there are some errors detected, please try again.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "Ok, got it!",
                                  customClass: {
                                      confirmButton: "btn btn-primary",
                                  },
                              });
                });
        },
        eventChange: function () {
            $("#customer").on("change", function () {
                var e = $(this).val();
                $(".customer_details").addClass("d-none"),
                    $.ajax({
                        url: `${siteURL}/${siteUserRole}/customer/` + e,
                        type: "GET",
                        success: function (e) {
                            $("#affiliate_name").val(e.name);
                            $("#affiliate_email").val(e.email);
                            $("#affiliate_phone").val(e.phone);
                        },
                    });
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAffiliateSettings.init();
    KTAffiliateSettings.eventChange();
});
