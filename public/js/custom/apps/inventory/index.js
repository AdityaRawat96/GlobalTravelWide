let table = $("#kt-customer-table").DataTable({
    info: !1,
    order: [],
    responsive: true,
});

$(document).ready(function () {
    $('[data-kt-customer-table-filter="search"]').on("keyup", function (e) {
        table.search(e.target.value).draw();
    });
});
