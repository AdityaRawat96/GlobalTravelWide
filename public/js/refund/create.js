"use strict";
var defaultCurrency = "gbp";
var KTAppRefundsCreate = (function () {
    var e,
        f,
        t = function () {
            var t = [].slice.call(
                    e.querySelectorAll(
                        '[data-kt-element="items"] [data-kt-element="item"]'
                    )
                ),
                p = [].slice.call(
                    e.querySelectorAll(
                        '[data-kt-element="payments"] [data-kt-element="payment"]'
                    )
                ),
                a = 0,
                b = 0,
                c = 0,
                d = 0,
                n = wNumb({ decimals: 2, thousand: "," });
            t.map(function (e) {
                var t = e.querySelector('[data-kt-element="quantity"]'),
                    l = e.querySelector('[data-kt-element="price"]'),
                    m = e.querySelector('[data-kt-element="cost"]'),
                    r = n.from(l.value),
                    s = n.from(m.value);
                r = !r || r < 0 ? 0 : r;
                s = !s || s < 0 ? 0 : s;
                var i = parseInt(t.value);
                (i = !i || i < 0 ? 1 : i),
                    (l.value = n.to(r)),
                    (m.value = n.to(s)),
                    (t.value = i),
                    (a += r);
                console.log(defaultCurrency);
                if (defaultCurrency == "pkr") {
                    console.log("pkr");
                    var t = e.querySelector('[data-kt-element="quantity"]'),
                        l = e.querySelector('[data-kt-element="price_alt"]'),
                        m = e.querySelector('[data-kt-element="cost_alt"]'),
                        r = n.from(l.value),
                        s = n.from(m.value);
                    r = !r || r < 0 ? 0 : r;
                    s = !s || s < 0 ? 0 : s;
                    var i = parseInt(t.value);
                    (i = !i || i < 0 ? 1 : i),
                        (l.value = n.to(r)),
                        (m.value = n.to(s)),
                        (t.value = i),
                        (c += r);
                }
            }),
                p.map(function (e) {
                    var l = e.querySelector(
                            '[data-kt-element="payment_amount"]'
                        ),
                        r = n.from(l.value);
                    r = !r || r < 0 ? 0 : r;
                    (l.value = n.to(r)), (b += r);
                    if (defaultCurrency == "pkr") {
                        var l = e.querySelector(
                                '[data-kt-element="payment_amount_alt"]'
                            ),
                            r = n.from(l.value);
                        r = !r || r < 0 ? 0 : r;
                        (l.value = n.to(r)), (d += r);
                    }
                }),
                (e.querySelector('[data-kt-element="sub-total"]').innerText =
                    n.to(a)),
                (e.querySelector('[data-kt-element="paid-total"]').innerText =
                    n.to(b)),
                (e.querySelector('[data-kt-element="grand-total"]').innerText =
                    n.to(a - b));
            if (defaultCurrency == "pkr") {
                (e.querySelector(
                    '[data-kt-element="sub-total-alt"]'
                ).innerText = n.to(c)),
                    (e.querySelector(
                        '[data-kt-element="paid-total-alt"]'
                    ).innerText = n.to(d)),
                    (e.querySelector(
                        '[data-kt-element="grand-total-alt"]'
                    ).innerText = n.to(c - d));
            }
        },
        a = function () {
            if (
                0 ===
                e.querySelectorAll(
                    '[data-kt-element="items"] [data-kt-element="item"]'
                ).length
            ) {
                var t = document
                    .querySelector('[data-kt-element="empty-template"] tr')
                    .cloneNode(!0);
                e.querySelector('[data-kt-element="items"] tbody').appendChild(
                    t
                );
            } else
                KTUtil.remove(
                    e.querySelector(
                        '[data-kt-element="items"] [data-kt-element="empty"]'
                    )
                );
        },
        b = function () {
            if (
                0 ===
                e.querySelectorAll(
                    '[data-kt-element="payments"] [data-kt-element="payment"]'
                ).length
            ) {
                var t = document
                    .querySelector('[data-kt-element="empty-template"] tr')
                    .cloneNode(!0);
                e.querySelector(
                    '[data-kt-element="payments"] tbody'
                ).appendChild(t);
            } else
                KTUtil.remove(
                    e.querySelector(
                        '[data-kt-element="payments"] [data-kt-element="empty"]'
                    )
                );
        };
    return {
        init: function (n) {
            (e = document.querySelector("#kt_create_form"))
                .querySelector(
                    '[data-kt-element="items"] [data-kt-element="add-item"]'
                )
                .addEventListener("click", function (n) {
                    n.preventDefault();
                    var l = document
                        .querySelector('[data-kt-element="item-template"] tr')
                        .cloneNode(!0);
                    e
                        .querySelector('[data-kt-element="items"] tbody')
                        .appendChild(l),
                        a(),
                        t();
                }),
                (f = document.querySelector("#kt_create_form"))
                    .querySelector(
                        '[data-kt-element="payments"] [data-kt-element="add-payment"]'
                    )
                    .addEventListener("click", function (n) {
                        n.preventDefault();
                        var l = document
                            .querySelector(
                                '[data-kt-element="payment-template"] tr'
                            )
                            .cloneNode(!0);
                        f
                            .querySelector('[data-kt-element="payments"] tbody')
                            .appendChild(l),
                            b(),
                            t();
                    }),
                KTUtil.on(
                    e,
                    '[data-kt-element="items"] [data-kt-element="remove-item"]',
                    "click",
                    function (e) {
                        e.preventDefault(),
                            KTUtil.remove(
                                this.closest('[data-kt-element="item"]')
                            ),
                            a(),
                            t();
                    }
                ),
                KTUtil.on(
                    f,
                    '[data-kt-element="payments"] [data-kt-element="remove-payment"]',
                    "click",
                    function (e) {
                        e.preventDefault(),
                            KTUtil.remove(
                                this.closest('[data-kt-element="payment"]')
                            ),
                            b(),
                            t();
                    }
                ),
                KTUtil.on(
                    e,
                    '[data-kt-element="items"] [data-kt-element="quantity"], [data-kt-element="items"] [data-kt-element="cost"], [data-kt-element="items"] [data-kt-element="cost_alt"], [data-kt-element="items"] [data-kt-element="price"], [data-kt-element="items"] [data-kt-element="price_alt"]',
                    "change",
                    function (e) {
                        e.preventDefault(), t();
                    }
                ),
                KTUtil.on(
                    f,
                    '[data-kt-element="payments"] [data-kt-element="payment_amount"], [data-kt-element="payments"] [data-kt-element="payment_amount_alt"]',
                    "change",
                    function (e) {
                        e.preventDefault(), t();
                    }
                ),
                $(e.querySelector('[name="refund_date"]')).flatpickr({
                    enableTime: !1,
                    dateFormat: "d, M Y",
                }),
                $(e.querySelector('[name="due_date"]')).flatpickr({
                    enableTime: !1,
                    dateFormat: "d, M Y",
                }),
                $(e.querySelector('[name="payment_date[]"]')).flatpickr({
                    enableTime: !1,
                    dateFormat: "d, M Y",
                });
            $(document).ready(function () {
                defaultCurrency = $("#currency").val();
                if (defaultCurrency == "gbp") {
                    $(".elements_alt").addClass("d-none");
                } else {
                    $(".elements_alt").removeClass("d-none");
                }
                t();
            });
        },
        handleDeleteRows: function () {
            // Select all delete buttons
            const deleteButton = document.getElementById("delete-refund");

            if (!deleteButton) {
                return;
            }

            // Delete button on click
            deleteButton.addEventListener("click", function (e) {
                e.preventDefault();

                Swal.fire({
                    text: "Are you sure you want to delete this refund?",
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
                            type: "DELETE", // refund.destroy
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
                                    window.location.href = `${siteURL}/${siteUserRole}/refund`;
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
            $("#currency").on("change", function () {
                defaultCurrency = $(this).val();
                if (defaultCurrency == "gbp") {
                    $(".elements_alt").addClass("d-none");
                } else {
                    $(".elements_alt").removeClass("d-none");
                }
            });

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
                "change",
                ".product_select",
                function (event) {
                    var e = event.target.value;
                    $.ajax({
                        url: `${siteURL}/${siteUserRole}/catalogue/` + e,
                        type: "GET",
                        success: function (response) {
                            // set closest .details element
                            var details = $(event.target).parent().parent();
                            details
                                .find(".product_description")
                                .val(response.description);
                        },
                    });
                }
            );

            $("#kt_create_form").on(
                "click",
                '[data-kt-element="add-item"]',
                function () {
                    var newSelect = $(this)
                        .closest('[data-kt-element="items"]')
                        .find('[name="product[]"]')
                        .last();
                    newSelect.select2();
                }
            );

            $("#kt_create_form").on(
                "click",
                '[data-kt-element="add-payment"]',
                function () {
                    var newSelect = $(this)
                        .closest('[data-kt-element="payments"]')
                        .find('[name="payment_mode[]"]')
                        .last();
                    newSelect.select2();

                    var newDatepicker = $(this)
                        .closest('[data-kt-element="payments"]')
                        .find('[name="payment_date[]"]')
                        .last();
                    newDatepicker.flatpickr({
                        enableTime: !1,
                        dateFormat: "d, M Y",
                    });
                }
            );
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAppRefundsCreate.init();
    KTAppRefundsCreate.eventChange();
    KTAppRefundsCreate.handleDeleteRows();
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
                        refund_date: {
                            validators: {
                                notEmpty: { message: "This field is required" },
                            },
                        },
                        refund_due_date: {
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
                        // Add file size and number of files validation
                        // file: {
                        //     validators: {
                        //         file: {
                        //             maxSize: "5MB",
                        //             message: "The selected file is not valid",
                        //         },
                        //     },
                        // },
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
                            : (window.location.href = `${siteURL}/${siteUserRole}/refund`);
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
                    '[data-kt-element="add-item"]',
                    function () {
                        FormSubmission.addValidation("items", "item");
                    }
                ),
                $("#kt_create_form").on(
                    "click",
                    '[data-kt-element="add-payment"]',
                    function () {
                        FormSubmission.addValidation("payments", "payment");
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
            var last_product = document.querySelectorAll(
                '[data-kt-element="' + q1 + '"] [data-kt-element="' + q2 + '"]'
            );
            var index = last_product.length - 1;
            var last_product = last_product[last_product.length - 1];
            var dynamicFields =
                last_product.querySelectorAll('input[name$="[]"]');
            // add select fields to dynamic fields
            var selectFields =
                last_product.querySelectorAll('select[name$="[]"]');
            // Loop through each dynamically created field
            dynamicFields.forEach(function (field) {
                var originalName = field.getAttribute("name");
                var updatedName = originalName.replace("[]", "[" + index + "]");
                field.setAttribute("name", updatedName);
                n.addField([field.name], {
                    validators: {
                        notEmpty: {
                            message: "This field is required",
                        },
                    },
                });
            });
            selectFields.forEach(function (field) {
                var originalName = field.getAttribute("name");
                var updatedName = originalName.replace("[]", "[" + index + "]");
                field.setAttribute("name", updatedName);
                n.addField([field.name], {
                    validators: {
                        notEmpty: {
                            message: "This field is required",
                        },
                    },
                });
            });
        },
        sanitizeFormData: function (formData) {
            formData.set("refund_id", $("#refund_id").val());

            // Parse dates to MySQL format
            var refund_date = moment(
                formData.get("refund_date"),
                "DD, MMM YYYY"
            );
            var mysqlDate = refund_date.format("YYYY-MM-DD");
            formData.set("refund_date", mysqlDate);

            var due_date = moment(formData.get("due_date"), "DD, MMM YYYY");
            var mysqlDueDate = due_date.format("YYYY-MM-DD");
            formData.set("due_date", mysqlDueDate);

            // Parse payment dates to MySQL format
            for (var pair of formData.entries()) {
                var key = pair[0];
                var date = pair[1];
                if (key.includes("payment_date")) {
                    var payment_date = moment(date, "DD, MMM YYYY");
                    var mysqlPaymentDate = payment_date.format("YYYY-MM-DD");
                    formData.set(key, mysqlPaymentDate);
                }
                if (
                    key.includes("payment_amount") ||
                    key.includes("price") ||
                    key.includes("cost") ||
                    key.includes("price_alt") ||
                    key.includes("cost_alt") ||
                    key.includes("payment_amount_alt")
                ) {
                    var price = parseFloat(date.replace(/,/g, ""));
                    formData.set(key, price);
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
                url: `${siteURL}/${siteUserRole}/refund/upload`,
                parallelUploads: 20,
                autoProcessQueue: false,
                paramName: "file",
                previewTemplate: previewTemplate,
                // maxFilesize: 5, // Max filesize in MB
                // maxFiles: 10,
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
    FormSubmission.addValidation("items", "item");
});
