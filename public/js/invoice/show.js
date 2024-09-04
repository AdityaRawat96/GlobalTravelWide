"use strict";
var myDropzone;
var KTInvoiceSettings = (function () {
    return {
        init: function () {
            $(document).ready(function (e) {
                $(".reset").on("click", function (e) {
                    window.history.length > 2
                        ? window.history.back()
                        : (window.location.href = `${siteURL}/${siteUserRole}/invoice`);
                });
            });
        },
        handleDeleteRows: function () {
            // Select all delete buttons
            const deleteButton = document.getElementById("delete-invoice");

            // Delete button on click
            deleteButton.addEventListener("click", function (e) {
                e.preventDefault();

                Swal.fire({
                    text: "Are you sure you want to delete this invoice?",
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
                            type: "DELETE", // invoice.destroy
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
                                    window.location.href = `${siteURL}/${siteUserRole}/invoice`;
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
                url: `${siteURL}/${siteUserRole}/invoice/upload`,
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
                // only if file is an image
                if (file.type.match(/image.*/)) {
                    file.previewElement.querySelector(
                        id + " .dropzone-thumbnail"
                    ).src = file.dataURL;
                } else {
                    // remove thumbnail
                    file.previewElement
                        .querySelector(id + " .dropzone-thumbnail")
                        .remove();
                }

                const dropzoneItems =
                    dropzone.querySelectorAll(".dropzone-item");
                dropzoneItems.forEach((dropzoneItem) => {
                    dropzoneItem.style.display = "";
                });
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTInvoiceSettings.init();
    KTInvoiceSettings.handleDeleteRows();
    KTInvoiceSettings.initializeDropZone();
});
