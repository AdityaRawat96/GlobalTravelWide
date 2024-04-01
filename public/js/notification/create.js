"use strict";

var myDropzone;
var KTNotificationSettings = (function () {
    var t, n, r;
    return {
        init: function () {
            (r = document.querySelector("#kt_create_form")),
                (t = r.querySelector("#kt_form_submit")),
                (n = FormValidation.formValidation(r, {
                    fields: {
                        date: {
                            validators: {
                                notEmpty: {
                                    message: "This field is required",
                                },
                            },
                        },
                        title: {
                            validators: {
                                notEmpty: {
                                    message: "This field is required",
                                },
                            },
                        },
                        description: {
                            validators: {
                                notEmpty: {
                                    message: "This field is required",
                                },
                            },
                        },
                        // Add file size and number of files validation
                        file: {
                            validators: {
                                file: {
                                    maxSize: "1MB",
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
                    },
                })),
                $(document).ready(function (e) {
                    $("#notification_date").flatpickr({
                        enableTime: false,
                        dateFormat: "d-m-Y",
                    });
                    $(".reset").on("click", function (e) {
                        window.history.length > 2
                            ? window.history.back()
                            : (window.location.href = `/${siteUserRole}/notification`);
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
                            var notification_date = formData.get("date");
                            const inputFormat = "DD-MM-YYYY"; // Input date format
                            const outputFormat = "YYYY-MM-DD"; // Desired output date format
                            const outputDateString = moment(
                                notification_date,
                                inputFormat
                            ).format(outputFormat);

                            formData.set("date", outputDateString);
                            // Append dropzone files to formData
                            if (myDropzone) {
                                myDropzone.files.forEach(function (file) {
                                    formData.append("file[]", file);
                                });
                            }

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
                url: `/${siteUserRole}/notification/upload`,
                parallelUploads: 20,
                autoProcessQueue: false,
                paramName: "file",
                previewTemplate: previewTemplate,
                maxFilesize: 5, // Max filesize in MB
                maxFiles: 5,
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
    KTNotificationSettings.init();
    KTNotificationSettings.initializeDropZone();
});
