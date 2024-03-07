let table = $("#kt-orders-table").DataTable({
    info: !1,
    order: [],
    responsive: true,
    columnDefs: [
        {
            orderable: !1,
            targets: 4,
        },
    ],
});

$(document).ready(function () {
    $('[data-kt-order-table-filter="search"]').on("keyup", function (e) {
        table.search(e.target.value).draw();
    });
});

function deleteTableRow(url, index) {
    let tableRow = $("#datatable-row-" + index);
    Swal.fire({
        text: "Are you sure you want to delete this order?",
        icon: "warning",
        showCancelButton: !0,
        buttonsStyling: !1,
        confirmButtonText: "Yes, delete!",
        cancelButtonText: "No, cancel",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary",
        },
    }).then(function (e) {
        e.value
            ? $.ajax({
                  url: url,
                  success: function (result) {
                      console.log(result);
                      Swal.fire({
                          text: "Order deleted!",
                          icon: "success",
                          buttonsStyling: !1,
                          confirmButtonText: "Ok, got it!",
                          customClass: {
                              confirmButton: "btn fw-bold btn-primary",
                          },
                      }).then(function () {
                          table.row(tableRow).remove().draw();
                      });
                  },
              })
            : "cancel" === e.dismiss &&
              Swal.fire({
                  text: "Order was not deleted.",
                  icon: "error",
                  buttonsStyling: !1,
                  confirmButtonText: "Ok, got it!",
                  customClass: {
                      confirmButton: "btn fw-bold btn-primary",
                  },
              });
    });
}
