"use strict";

// Class definition
var KTDatatablesServerSide = (function () {
    // Shared variables
    var table;
    var dt;

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[1, "asc"]],
            stateSave: false,
            select: {
                style: "multi",
                selector: 'td:first-child input[type="checkbox"]',
                className: "row-selected",
            },
            ajax: {
                url: "/admin/user",
            },
            columns: [
                { data: null },
                { data: "id" },
                { data: "full_name" },
                { data: "role" },
                { data: "email" },
                { data: "phone" },
                { data: "status" },
                { data: null },
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="${data}" />
                            </div>`;
                    },
                },
                {
                    targets: 2,
                    orderable: false,
                    searchable: false,
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-end",
                    render: function (data, type, row) {
                        return `
                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm d-flex gap-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                Actions
                                <span class="svg-icon fs-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-docs-table-filter="edit_row">
                                        Edit
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-docs-table-filter="delete_row">
                                        Delete
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        `;
                    },
                },
            ],
        });

        table = dt.$;

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on("draw", function () {
            initToggleToolbar();
            toggleToolbars();
            handleDeleteRows();
            KTMenu.createInstances();
        });
    };

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector(
            '[data-kt-docs-table-filter="search"]'
        );
        filterSearch.addEventListener("keyup", function (e) {
            dt.search(e.target.value).draw();
        });
    };

    // Delete record
    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = document.querySelectorAll(
            '[data-kt-docs-table-filter="delete_row"]'
        );

        deleteButtons.forEach((d) => {
            // Delete button on click
            d.addEventListener("click", function (e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest("tr");

                // Get record name
                const recordName = parent.querySelectorAll("td")[1].innerText;

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to delete " + recordName + "?",
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
                        // Simulate delete request -- for demo purpose only
                        Swal.fire({
                            text: "Deleting " + recordName,
                            icon: "info",
                            buttonsStyling: false,
                            showConfirmButton: false,
                            timer: 2000,
                        }).then(function () {
                            Swal.fire({
                                text: "You have deleted " + recordName + "!.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            }).then(function () {
                                // delete row data from server and re-draw datatable
                                dt.draw();
                            });
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
        });
    };

    // Init toggle toolbar
    var initToggleToolbar = function () {
        // Toggle selected action toolbar
        // Select all checkboxes
        const container = document.querySelector("#kt_datatable");
        const checkboxes = container.querySelectorAll('[type="checkbox"]');
        // Select elements
        const deleteSelected = document.querySelector(
            '[data-kt-docs-table-select="selected_count"]'
        );
        // Toggle delete selected toolbar
        checkboxes.forEach((c) => {
            // Checkbox on click event
            c.addEventListener("click", function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });
        // Deleted selected rows
        deleteSelected.addEventListener("click", function () {
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                text: "Are you sure you want to delete selected records?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                showLoaderOnConfirm: true,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary",
                },
            }).then(function (result) {
                if (result.value) {
                    // Simulate delete request -- for demo purpose only
                    Swal.fire({
                        text: "Deleting selected records",
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false,
                        timer: 2000,
                    }).then(function () {
                        Swal.fire({
                            text: "You have deleted all selected records!.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            },
                        }).then(function () {
                            // delete row data from server and re-draw datatable
                            dt.draw();
                        });
                        // Remove header checked box
                        const headerCheckbox =
                            container.querySelectorAll('[type="checkbox"]')[0];
                        headerCheckbox.checked = false;
                    });
                } else if (result.dismiss === "cancel") {
                    Swal.fire({
                        text: "Selected records was not deleted.",
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
    };

    // Toggle toolbars
    var toggleToolbars = function () {
        // Define variables
        const container = document.querySelector("#kt_datatable");
        const toolbarBase = document.querySelector(
            '[data-kt-docs-table-toolbar="base"]'
        );
        const toolbarSelected = document.querySelector(
            '[data-kt-docs-table-toolbar="selected"]'
        );
        const selectedCount = document.querySelector(
            '[data-kt-docs-table-select="selected_count"]'
        );

        // Select refreshed checkbox DOM elements
        const allCheckboxes = container.querySelectorAll(
            'tbody [type="checkbox"]'
        );

        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach((c) => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        // Toggle toolbars
        if (checkedState) {
            selectedCount.innerHTML = count;
            toolbarBase.classList.add("d-none");
            toolbarSelected.classList.remove("d-none");
        } else {
            toolbarBase.classList.remove("d-none");
            toolbarSelected.classList.add("d-none");
        }
    };

    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            initToggleToolbar();
            handleDeleteRows();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});