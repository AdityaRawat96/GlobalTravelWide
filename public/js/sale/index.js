"use strict";

// Class definition
var KTDatatablesServerSide = (function () {
    // Shared variables
    var table;
    var dt;
    var filter = (filter = {
        start_date: moment().startOf("month").format("YYYY-MM-DD"),
        end_date: moment().endOf("month").format("YYYY-MM-DD"),
        sale_calculation: "invoice_date",
    });

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[0, "asc"]],
            stateSave: false,
            ajax: {
                url: `${siteURL}/${siteUserRole}/sale`,
                data: function (d) {
                    d.filter = filter;
                },
                // update input from response
                dataSrc: function (res) {
                    $("#revenueTotal").text(
                        parseFloat(res.revenueTotal)
                            .toFixed(2)
                            .replace(/\d(?=(\d{3})+\.)/g, "$&,")
                    );
                    return res.data;
                },
            },
            columns: [
                { data: "id" },
                { data: "full_name" },
                { data: "cost" },
                { data: "total" },
                { data: "revenue" },
                { data: null },
            ],
            columnDefs: [
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-end",
                    render: function (data) {
                        return `
                            <a href="#" onclick="viewSale('${siteURL}/${siteUserRole}/sale/${parseInt(
                            data.id.substring(2),
                            10
                        )}')" class="btn btn-light btn-active-light-primary btn-sm d-flex gap-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                Expand
                                <span class="svg-icon fs-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)"></path>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                        `;
                    },
                },
                // format total column like 2000 => 2,000.00 and align to right
                {
                    targets: [2, 3, 4],
                    render: function (data) {
                        return parseFloat(data)
                            .toFixed(2)
                            .replace(/\d(?=(\d{3})+\.)/g, "$&,");
                    },
                },
            ],
        });

        table = dt.$;

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on("draw", function () {
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

    var initFilter = () => {
        var startDate = moment().startOf("month").format("DD/MM/YYYY");
        var endDate = moment().endOf("month").format("DD/MM/YYYY");
        $(".datetimepicker-input").daterangepicker({
            timePicker: false,
            startDate: startDate,
            endDate: endDate,
            locale: {
                format: "DD/MM/YYYY",
            },
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [
                    moment().subtract(1, "days"),
                    moment().subtract(1, "days"),
                ],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [
                    moment().startOf("month"),
                    moment().endOf("month"),
                ],
                "Last Month": [
                    moment().subtract(1, "month").startOf("month"),
                    moment().subtract(1, "month").endOf("month"),
                ],
            },
        });
    };

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        const applyFilterButton = document.querySelector("#apply_filter");
        const clearFilterButton = document.querySelector("#reset_filter");

        $(".datetimepicker-input").change(
            "apply.daterangepicker",
            function (ev, picker) {
                // Get filter values
                var date_range = $(".datetimepicker-input").val().split(" - ");
                filter = {
                    start_date: moment(date_range[0], "DD/MM/YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    end_date: moment(date_range[1], "DD/MM/YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    sale_calculation: $(".sale_calculation").val(),
                };
                dt.ajax.reload();
            }
        );

        // Filter datatable on submit
        applyFilterButton.addEventListener("click", function () {
            // Get filter values
            var date_range = $(".datetimepicker-input").val().split(" - ");
            filter = {
                start_date: moment(date_range[0], "DD/MM/YYYY").format(
                    "YYYY-MM-DD"
                ),
                end_date: moment(date_range[1], "DD/MM/YYYY").format(
                    "YYYY-MM-DD"
                ),
                sale_calculation: $(".sale_calculation").val(),
            };
            dt.ajax.reload();
        });

        // Clear filter on reset
        clearFilterButton.addEventListener("click", function () {
            var startDate = moment().startOf("month").format("DD/MM/YYYY");
            var endDate = moment().endOf("month").format("DD/MM/YYYY");
            $(".datetimepicker-input").daterangepicker({
                timePicker: false,
                startDate: startDate,
                endDate: endDate,
                locale: {
                    format: "DD/MM/YYYY",
                },
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [
                        moment().subtract(1, "days"),
                        moment().subtract(1, "days"),
                    ],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [
                        moment().startOf("month"),
                        moment().endOf("month"),
                    ],
                    "Last Month": [
                        moment().subtract(1, "month").startOf("month"),
                        moment().subtract(1, "month").endOf("month"),
                    ],
                },
            });
            $(".sale_calculation").val("invoice_date").trigger("change");
            dt.ajax.reload();
        });
    };

    // Export Datatable
    var handleExportDatatable = () => {
        $(".menu-link-export").click(function (e) {
            e.preventDefault();
            var form_url = $(this).attr("href");

            var date_range = $(".datetimepicker-input").val().split(" - ");

            // create form with data and submit
            var form = document.createElement("form");
            form.setAttribute("method", "get");
            form.setAttribute("action", form_url);

            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "user_id");
            hiddenField.setAttribute("value", null);
            form.appendChild(hiddenField);

            hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "sale_calculation");
            hiddenField.setAttribute("value", $(".sale_calculation").val());
            form.appendChild(hiddenField);

            hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "start_date");
            hiddenField.setAttribute(
                "value",
                moment(date_range[0], "DD/MM/YYYY").format("YYYY-MM-DD")
            );
            form.appendChild(hiddenField);

            hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "end_date");
            hiddenField.setAttribute(
                "value",
                moment(date_range[1], "DD/MM/YYYY").format("YYYY-MM-DD")
            );
            form.appendChild(hiddenField);

            document.body.appendChild(form);
            form.submit();

            // remove form after submit
            document.body.removeChild(form);
        });
    };

    // Public methods
    return {
        init: function () {
            initDatatable();
            initFilter();
            handleSearchDatatable();
            handleFilterDatatable();
            handleExportDatatable();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});

function viewSale(url) {
    var date_range = $(".datetimepicker-input").val().split(" - ");
    $("#view_form").attr("action", url);
    $("#user_id_field").val($("#user_id").val());
    $("#sale_calculation_field").val($(".sale_calculation").val());
    $("#start_date_field").val(
        moment(date_range[0], "DD/MM/YYYY").format("YYYY-MM-DD")
    );
    $("#end_date_field").val(
        moment(date_range[1], "DD/MM/YYYY").format("YYYY-MM-DD")
    );
    $("#view_form").submit();
}
