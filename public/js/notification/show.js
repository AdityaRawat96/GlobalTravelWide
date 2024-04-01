"use strict";
var myDropzone;
var KTNotificationSettings = (function () {
    return {
        init: function () {
            $(document).ready(function (e) {
                $(".reset").on("click", function (e) {
                    window.history.length > 2
                        ? window.history.back()
                        : (window.location.href = `/${siteUserRole}/notification`);
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
    KTNotificationSettings.init();
    KTNotificationSettings.initializeDropZone();
});
