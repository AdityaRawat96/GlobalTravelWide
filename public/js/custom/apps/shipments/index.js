let table = $("#kt_products_table").DataTable({
    info: !1,
    order: [],
    responsive: true,
    columnDefs: [
        {
            orderable: !1,
            targets: [0, 1, 6, 7],
        },
    ],
});

$(document).ready(function () {
    $('[data-kt-product-table-filter="search"]').on("keyup", function (e) {
        table.search(e.target.value).draw();
    });
});

function viewShipmentHistory(url) {
    $("#view_shipment_table_body").html("");
    $.ajax({
        url: url,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            response.map((product, index) => {
                $("#view_shipment_table_body").append(`
            <tr>
                <td class="">${product.asin}</td>
                <td class="">${formatDate(product.created_at)}</td>
                <td class="text-end">${product.total}</td>
                <td class="text-end">${product.received}</td>
                <td class="text-end">${product.damaged}</td>
                <td class="">${product.notes ?? ""}</td>
            </tr>
            `);
            });
        },
    });
}

function formatDate(inputDate) {
    const months = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ];

    const date = new Date(inputDate);
    const day = date.getUTCDate();
    const month = months[date.getUTCMonth()];
    const year = date.getUTCFullYear();

    const formattedDate = `${day}, ${month} ${year}`;
    return formattedDate;
}
