"use strict";
var KTAppQuotationsCreate = (function () {
    var e,
        f,
        t = function () {
            var cost = document.querySelector('[data-kt-element="cost"]');
            var price = document.querySelector('[data-kt-element="price"]');
            var n = wNumb({ decimals: 2, thousand: "," });
            var r = n.from(cost.value);
            var s = n.from(price.value);
            r = !r || r < 0 ? 0 : r;
            s = !s || s < 0 ? 0 : s;
            cost.value = n.to(r);
            price.value = n.to(s);
            document.querySelector('[data-kt-element="revenue"]').innerText =
                n.to(s - r);
        },
        a = function () {
            if (
                0 ===
                e.querySelectorAll(
                    '[data-kt-element="airlines"] [data-kt-element="airline"]'
                ).length
            ) {
                var t = document
                    .querySelector('[data-kt-element="empty-template"] div')
                    .cloneNode(!0);
                e.querySelector('[data-kt-element="airlines"]').appendChild(t);
            } else
                KTUtil.remove(
                    e.querySelector(
                        '[data-kt-element="airlines"] [data-kt-element="empty"]'
                    )
                );
        },
        b = function () {
            if (
                0 ===
                e.querySelectorAll(
                    '[data-kt-element="hotels"] [data-kt-element="hotel"]'
                ).length
            ) {
                var t = document
                    .querySelector('[data-kt-element="empty-template"] div')
                    .cloneNode(!0);
                e.querySelector('[data-kt-element="hotels"]').appendChild(t);
            } else
                KTUtil.remove(
                    e.querySelector(
                        '[data-kt-element="hotels"] [data-kt-element="empty"]'
                    )
                );
        };
    return {
        init: function (n) {
            (e = document.querySelector("#kt_create_form"))
                .querySelector('[data-kt-element="add-airline"]')
                .addEventListener("click", function (n) {
                    n.preventDefault();
                    var l = document
                        .querySelector(
                            '[data-kt-element="airline-template"] div'
                        )
                        .cloneNode(!0);
                    e
                        .querySelector('[data-kt-element="airlines"]')
                        .appendChild(l),
                        a();
                }),
                (f = document.querySelector("#kt_create_form"))
                    .querySelector('[data-kt-element="add-hotel"]')
                    .addEventListener("click", function (n) {
                        n.preventDefault();
                        var l = document
                            .querySelector(
                                '[data-kt-element="hotel-template"] div'
                            )
                            .cloneNode(!0);
                        f
                            .querySelector('[data-kt-element="hotels"]')
                            .appendChild(l),
                            b();
                    }),
                KTUtil.on(
                    e,
                    '[data-kt-element="airlines"] [data-kt-element="remove-airline"]',
                    "click",
                    function (e) {
                        e.preventDefault(),
                            KTUtil.remove(
                                this.closest('[data-kt-element="airline"]')
                            ),
                            a();
                    }
                ),
                KTUtil.on(
                    f,
                    '[data-kt-element="hotels"] [data-kt-element="remove-hotel"]',
                    "click",
                    function (e) {
                        e.preventDefault(),
                            KTUtil.remove(
                                this.closest('[data-kt-element="hotel"]')
                            ),
                            b();
                    }
                ),
                document
                    .querySelector('[data-kt-element="price"]')
                    .addEventListener(
                        "change",
                        function (e) {
                            e.preventDefault(), t();
                        },
                        !1
                    ),
                document
                    .querySelector('[data-kt-element="cost"]')
                    .addEventListener(
                        "change",
                        function (e) {
                            e.preventDefault(), t();
                        },
                        !1
                    ),
                t();
        },
        handleDeleteRows: function () {
            // Select all delete buttons
            const deleteButton = document.getElementById("delete-quotation");

            if (!deleteButton) {
                return;
            }

            // Delete button on click
            deleteButton.addEventListener("click", function (e) {
                e.preventDefault();

                Swal.fire({
                    text: "Are you sure you want to delete this quotation?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: e.target.getAttribute("href"),
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                            type: "DELETE", // quotation.destroy
                            success: function (result) {
                                // Do something with the result
                                Swal.fire({
                                    text: result.message,
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                }).then(function (e) {
                                    window.location.href = `${siteURL}/${siteUserRole}/quotation`;
                                });
                            },
                            error: function (err) {
                                // Do something with the error
                                Swal.fire({
                                    text: err.responseJSON.message,
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                });
                            },
                        });
                    } else if (result.dismiss === "cancel") {
                        Swal.fire({
                            text: recordName + " was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            },
                        });
                    }
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
                            $("#customer_email").val(e.email);
                            $("#customer_phone").val(e.phone);
                            $(".customer_details").removeClass("d-none");
                        },
                    });
            });

            $("#kt_create_form").on(
                "click",
                '[data-kt-element="add-airline"]',
                function () {
                    var dateInput = $("#airline_table .airline_time").last();
                    dateInput.daterangepicker({
                        timePicker: true,
                        startDate: moment().startOf("hour"),
                        endDate: moment().startOf("hour").add(32, "hour"),
                        locale: {
                            format: "DD/MM/YYYY hh:mm A",
                        },
                    });
                }
            );

            $("#kt_create_form").on(
                "click",
                '[data-kt-element="add-hotel"]',
                function () {
                    var dateInput = $("#hotel_table .hotel_time").last();
                    dateInput.daterangepicker({
                        timePicker: true,
                        startDate: moment().startOf("hour"),
                        endDate: moment().startOf("hour").add(32, "hour"),
                        locale: {
                            format: "DD/MM/YYYY hh:mm A",
                        },
                    });
                }
            );
        },
        initDateRangePicker: function () {
            $("#airline_table .airline_time").each(function (index, dateInput) {
                var dateInputValue = dateInput.value;
                var startDate = moment().startOf("hour");
                var endDate = moment().startOf("hour").add(32, "hour");
                if (dateInputValue) {
                    startDate = moment(
                        dateInputValue.split(" - ")[0],
                        "DD/MM/YYYY hh:mm A"
                    );
                    endDate = moment(
                        dateInputValue.split(" - ")[1],
                        "DD/MM/YYYY hh:mm A"
                    );
                }
                $(dateInput).daterangepicker({
                    timePicker: true,
                    startDate: startDate,
                    endDate: endDate,
                    locale: {
                        format: "DD/MM/YYYY hh:mm A",
                    },
                });
            });

            $("#hotel_table .hotel_time").each(function (index, dateInput) {
                var dateInputValue = dateInput.value;
                var startDate = moment().startOf("hour");
                var endDate = moment().startOf("hour").add(32, "hour");
                if (dateInputValue) {
                    startDate = moment(
                        dateInputValue.split(" - ")[0],
                        "DD/MM/YYYY hh:mm A"
                    );
                    endDate = moment(
                        dateInputValue.split(" - ")[1],
                        "DD/MM/YYYY hh:mm A"
                    );
                }
                $(dateInput).daterangepicker({
                    timePicker: true,
                    startDate: startDate,
                    endDate: endDate,
                    locale: {
                        format: "DD/MM/YYYY hh:mm A",
                    },
                });
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAppQuotationsCreate.init();
    KTAppQuotationsCreate.eventChange();
    KTAppQuotationsCreate.handleDeleteRows();
    KTAppQuotationsCreate.initDateRangePicker();
});
var myDropzone;
var FormSubmission = (function () {
    var t, n, r;
    return {
        init: function () {
            (r = document.querySelector("#kt_create_form")),
                (t = document.querySelector("#kt_form_submit")),
                (n = FormValidation.formValidation(r, {
                    fields: {
                        quotation_date: {
                            validators: {
                                notEmpty: { message: "This field is required" },
                            },
                        },
                        company: {
                            validators: {
                                notEmpty: { message: "This field is required" },
                            },
                        },
                        customer: {
                            validators: {
                                notEmpty: { message: "This field is required" },
                            },
                        },
                        cost: {
                            validators: {
                                notEmpty: { message: "This field is required" },
                            },
                        },
                        price: {
                            validators: {
                                notEmpty: { message: "This field is required" },
                            },
                        },
                        // Add file size and number of files validation
                        file: {
                            validators: {
                                file: {
                                    maxSize: "5MB",
                                    message: "The selected file is not valid",
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
                        excluded: new FormValidation.plugins.Excluded({
                            excluded: function (field, ele, eles) {
                                // check if field is inside a hidden element
                                var hidden = ele.closest(".d-none");
                                if (hidden) {
                                    return true;
                                }
                            },
                        }),
                    },
                })),
                $(document).ready(function (e) {
                    $(".reset").on("click", function (e) {
                        window.history.length > 2
                            ? window.history.back()
                            : (window.location.href = `${siteURL}/${siteUserRole}/quotation`);
                    }),
                        $("#kt_create_form").on("submit", function (e) {
                            e.preventDefault();
                            t.setAttribute("data-kt-indicator", "on");
                            t.disabled = !0;
                            var formData = FormSubmission.sanitizeFormData(
                                new FormData(this)
                            );

                            if ($("#kt_create_form").attr("method") == "PUT") {
                                formData.append("_method", "PUT");
                            }
                            // Append dropzone files to formData
                            if (myDropzone) {
                                myDropzone.files.forEach(function (file) {
                                    formData.append("file[]", file);
                                });
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
                $("#kt_create_form").on(
                    "click",
                    '[data-kt-element="add-airline"]',
                    function () {
                        FormSubmission.addValidation("airlines", "airline");
                    }
                ),
                $("#kt_create_form").on(
                    "click",
                    '[data-kt-element="add-hotel"]',
                    function () {
                        FormSubmission.addValidation("hotels", "hotel");
                    }
                ),
                t.addEventListener("click", async function (e) {
                    e.preventDefault();
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
        addValidation: function (q1, q2) {
            var item_list = document.querySelectorAll(
                '[data-kt-element="' + q1 + '"] [data-kt-element="' + q2 + '"]'
            );
            var index = item_list.length - 1;
            var last_item = item_list[item_list.length - 1];
            var inputFields = last_item.querySelectorAll('input[name$="[]"]');

            inputFields.forEach(function (field) {
                var originalName = field.getAttribute("name");
                var updatedName = originalName.replace("[]", "[" + index + "]");
                field.setAttribute("name", updatedName);
                if (!field.classList.contains("datetimepicker-input")) {
                    n.addField([field.name], {
                        validators: {
                            notEmpty: {
                                message: "This field is required",
                            },
                        },
                    });
                }
            });
        },
        sanitizeFormData: function (formData) {
            formData.set("quotation_id", $("#quotation_id").val());

            // Parse dates to MySQL format
            var quotation_date = moment(
                formData.get("quotation_date"),
                "DD, MMM YYYY"
            );
            var mysqlDate = quotation_date.format("YYYY-MM-DD");
            formData.set("quotation_date", mysqlDate);

            // Parse payment dates to MySQL format
            for (var pair of formData.entries()) {
                var key = pair[0];
                var value = pair[1];
                if (key.includes("airline_time")) {
                    // 31/03/2024 02:00 AM - 01/04/2024 11:00 AM
                    var index = key.replace("airline_time", "");
                    var dates = value.split(" - ");
                    var departure_time = moment(dates[0], "DD/MM/YYYY hh:mm A");
                    var arrival_time = moment(dates[1], "DD/MM/YYYY hh:mm A");
                    var mysqlArrivalTime = arrival_time.format(
                        "YYYY-MM-DD HH:mm:ss"
                    );
                    var mysqlDepartureTime = departure_time.format(
                        "YYYY-MM-DD HH:mm:ss"
                    );
                    formData.set("arrival_time" + index, mysqlArrivalTime);
                    formData.set("departure_time" + index, mysqlDepartureTime);
                    formData.delete(key);
                } else if (key.includes("hotel_time")) {
                    // 31/03/2024 02:00 AM - 01/04/2024 11:00 AM
                    var index = key.replace("hotel_time", "");
                    var dates = value.split(" - ");
                    var checkin_time = moment(dates[0], "DD/MM/YYYY hh:mm A");
                    var checkout_time = moment(dates[1], "DD/MM/YYYY hh:mm A");
                    var mysqlCheckinTime = checkin_time.format(
                        "YYYY-MM-DD HH:mm:ss"
                    );
                    var mysqlCheckoutTime = checkout_time.format(
                        "YYYY-MM-DD HH:mm:ss"
                    );
                    formData.set("checkin_time" + index, mysqlCheckinTime);
                    formData.set("checkout_time" + index, mysqlCheckoutTime);
                    formData.delete(key);
                } else if (key.includes("cost") || key.includes("price")) {
                    var formattedValue = parseFloat(value.replace(/,/g, ""));
                    formData.set(key, formattedValue);
                }
            }

            return formData;
        },
        initializeDropZone: function () {
            // set the dropzone container id
            const id = "#kt_dropzonejs";
            const dropzone = document.querySelector(id);

            // set the preview element template
            var previewNode = dropzone.querySelector(".dropzone-item");
            previewNode.id = "";
            var previewTemplate = previewNode.parentNode.innerHTML;
            previewNode.parentNode.removeChild(previewNode);

            myDropzone = new Dropzone(id, {
                // Make the whole body a dropzone
                url: `${siteURL}/${siteUserRole}/quotation/upload`,
                parallelUploads: 20,
                autoProcessQueue: false,
                paramName: "file",
                previewTemplate: previewTemplate,
                maxFilesize: 5, // Max filesize in MB
                maxFiles: 10,
                autoQueue: false, // Make sure the files aren't queued until manually added
                previewsContainer: id + " .dropzone-items", // Define the container to display the previews
                clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
            });

            myDropzone.on("addedfile", function (file) {
                // Hookup the start button
                file.previewElement.querySelector(
                    id + " .dropzone-start"
                ).onclick = function () {
                    myDropzone.enqueueFile(file);
                };
                if (file.upload.progress == 100) {
                    file.previewElement.querySelector(
                        id + " .dropzone-filename"
                    ).href = file.dataURL;
                    file.previewElement.querySelector(
                        id + " .dropzone-filename"
                    ).target = "_blank";
                    file.previewElement.querySelector(
                        id + " .dropzone-filename strong"
                    ).innerHTML =
                        "(" +
                        (file.upload.total / Math.pow(1024, 2)).toFixed(2) +
                        " MB)";
                } else {
                    file.previewElement
                        .querySelector(id + " .dropzone-filename")
                        .classList.add("dropzone-local-file");
                }
                const dropzoneItems =
                    dropzone.querySelectorAll(".dropzone-item");
                dropzoneItems.forEach((dropzoneItem) => {
                    dropzoneItem.style.display = "";
                });
                dropzone.querySelector(".dropzone-remove-all").style.display =
                    "inline-block";
            });

            // Update the total progress bar
            myDropzone.on("totaluploadprogress", function (progress) {
                const progressBars = dropzone.querySelectorAll(".progress-bar");
                progressBars.forEach((progressBar) => {
                    progressBar.style.width = progress + "%";
                });
            });

            myDropzone.on("sending", function (file) {
                // Show the total progress bar when upload starts
                const progressBars = dropzone.querySelectorAll(".progress-bar");
                progressBars.forEach((progressBar) => {
                    progressBar.style.opacity = "1";
                });
                // And disable the start button
                file.previewElement
                    .querySelector(id + " .dropzone-start")
                    .setAttribute("disabled", "disabled");
            });

            // Hide the total progress bar when nothing's uploading anymore
            myDropzone.on("complete", function (progress) {
                const progressBars = dropzone.querySelectorAll(".dz-complete");

                setTimeout(function () {
                    progressBars.forEach((progressBar) => {
                        progressBar.querySelector(
                            ".progress-bar"
                        ).style.opacity = "0";
                        progressBar.querySelector(".progress").style.opacity =
                            "0";
                        progressBar.querySelector(
                            ".dropzone-start"
                        ).style.opacity = "0";
                    });
                }, 300);
            });

            // Setup the button for remove all files
            dropzone
                .querySelector(".dropzone-remove-all")
                .addEventListener("click", function () {
                    dropzone.querySelector(
                        ".dropzone-remove-all"
                    ).style.display = "none";
                    myDropzone.removeAllFiles(true);
                });

            // On all files removed
            myDropzone.on("removedfile", function (file) {
                if (myDropzone.files.length < 1) {
                    dropzone.querySelector(
                        ".dropzone-remove-all"
                    ).style.display = "none";
                }
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    FormSubmission.init();
    FormSubmission.initializeDropZone();
});
