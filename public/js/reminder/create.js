"use strict";
var KTReminderSettings = (function () {
    var t, n, r;
    return {
        init: function () {
            (r = document.querySelector("#kt_create_form")),
                (t = r.querySelector("#kt_form_submit")),
                (n = FormValidation.formValidation(r, {
                    fields: {
                        customer_id: {
                            validators: {
                                notEmpty: {
                                    message: "This field is required",
                                },
                            },
                        },
                        date: {
                            validators: {
                                notEmpty: {
                                    message: "This field is required",
                                },
                            },
                        },
                        notes: {
                            validators: {
                                notEmpty: {
                                    message: "This field is required",
                                },
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
                    $("#customer").on("change", function () {
                        var e = $(this).val();
                        $(".customer_details").addClass("d-none"),
                            $.ajax({
                                url: `/${siteUserRole}/customer/` + e,
                                type: "GET",
                                success: function (e) {
                                    $("#customer_email").val(e.email);
                                    $("#customer_phone").val(e.phone);
                                    $(".customer_details").removeClass(
                                        "d-none"
                                    );
                                },
                            });
                    });

                    $("#reminder_date").flatpickr({
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                    });
                    $(".reset").on("click", function (e) {
                        n.resetForm();
                        window.history.length > 2
                            ? window.history.back()
                            : (window.location.href = `/${siteUserRole}/reminder`);
                    }),
                        $("#kt_create_form").on("submit", function (e) {
                            e.preventDefault();
                            t.setAttribute("data-kt-indicator", "on");
                            t.disabled = !0;
                            var formData = new FormData(this);
                            if ($("#kt_create_form").attr("method") == "PUT") {
                                formData.append("_method", "PUT");
                            }

                            // convert date field from Y-m-d H:i to mysql format using moment
                            var reminder_date = formData.get("date");
                            const inputFormat = "YYYY-MM-DD HH:mm"; // Input date format
                            const outputFormat = "YYYY-MM-DD HH:mm:ss"; // Desired output date format
                            const outputDateString = moment(
                                reminder_date,
                                inputFormat
                            ).format(outputFormat);

                            formData.set("date", outputDateString);

                            $.ajax({
                                url: $("#kt_create_form").attr("action"),
                                type: "POST",
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
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTReminderSettings.init();
});
