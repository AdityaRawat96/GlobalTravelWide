function viewShipmentHistoryAdmin(url, customer_id) {
    $("#view_shipment_table_body").html("");
    $.ajax({
        url: url,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            customer_id: customer_id,
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
