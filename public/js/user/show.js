"use strict";
let attendanceLoaded = false;
var KTUserSettings = (function () {
    return {
        init: function () {
            $(document).ready(function (e) {
                $(".reset").on("click", function (e) {
                    window.history.length > 2
                        ? window.history.back()
                        : (window.location.href = `/${siteUserRole}/user`);
                });
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTUserSettings.init();
});

$(document).ready(function () {
    $(".nav-link-profile-tab").click(function (e) {
        e.preventDefault();
        $(".nav-link-profile-tab").removeClass("active");
        $(this).addClass("active");
        $(".profile-sections-tab-container").removeClass("active");
        $($(this).data("target")).addClass("active");
        if (!attendanceLoaded) {
            KTAppCalendar.init();
            attendanceLoaded = true;
        }
    });

    $("#kt_password_cancel").click(function () {
        togglePasswordResetForm();
    });
    $("#kt_signin_password_button").click(function () {
        togglePasswordResetForm();
    });

    var kt_create_form = document.querySelector("#kt_create_form");
    var kt_form_submit = kt_create_form.querySelector("#kt_form_submit");
    $("#kt_create_form").on("submit", function (e) {
        e.preventDefault();
        kt_form_submit.setAttribute("data-kt-indicator", "on");
        kt_form_submit.disabled = !0;
        var formData = new FormData(this);
        if ($("#kt_create_form").attr("method") == "PUT") {
            formData.append("_method", "PUT");
        }
        // calendar_event_name: Attendance record for 03-04-2024
        // calendar_event_start_time: 00:00
        // calendar_event_end_time: 17:05
        // update form data fields to date and date time accepted by mySQL to date, in_time, out_time
        var attendance_date = formData.get("calendar_event_name");
        // extract the date
        var date = attendance_date.split(" ")[3];
        // format the date to mySQL date format
        var formatted_date = date.split("-").reverse().join("-");
        var in_time = formData.get("calendar_event_start_time");
        var out_time = formData.get("calendar_event_end_time");
        // fomat the time to mySQL date time format
        var formatted_in_time = formatted_date + " " + in_time + ":00";
        var formatted_out_time = formatted_date + " " + out_time + ":00";
        formData.delete("calendar_event_name");
        formData.delete("calendar_event_start_time");
        formData.delete("calendar_event_end_time");
        formData.append("date", formatted_date);
        formData.append("in_time", formatted_in_time);
        formData.append("out_time", formatted_out_time);

        $.ajax({
            url: $("#kt_create_form").attr("action"),
            type: $("#kt_create_form").attr("method"),
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            enctype: "multipart/form-data",
            success: function (result) {
                (kt_form_submit.disabled = !1),
                    console.log(result),
                    kt_form_submit.removeAttribute("data-kt-indicator"),
                    Swal.fire({
                        text: result.message,
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    }).then(function (e) {
                        e.isConfirmed && window.location.reload();
                    });
            },
            error: function (err) {
                kt_form_submit.disabled = !1;
                kt_form_submit.removeAttribute("data-kt-indicator");
                if (err.status == 422) {
                    console.log(err.responseJSON);
                    // display errors on each form field
                    $.each(err.responseJSON.errors, function (i, error) {
                        var el = $("#kt_create_form [name='" + i + "']");
                        el.closest(".fv-row")
                            .find(".fv-plugins-message-container")
                            .text(error[0]);
                        el.addClass("is-invalid");

                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    });
                } else {
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                }
            },
        });
    });
});

function togglePasswordResetForm() {
    if ($("#kt_signin_password_edit").hasClass("d-none")) {
        $("#kt_signin_password_edit").removeClass("d-none");
        $("#kt_signin_password").addClass("d-none");
        $("#kt_signin_password_button").addClass("d-none");
    } else {
        $("#kt_signin_password_edit").addClass("d-none");
        $("#kt_signin_password").removeClass("d-none");
        $("#kt_signin_password_button").removeClass("d-none");
    }
}
