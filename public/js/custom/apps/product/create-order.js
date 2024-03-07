$(document).ready(function () {
    var modal = new bootstrap.Modal(
        document.querySelector("#kt_modal_create_order")
    );
    var t, e, o, n, r;
    r = document.querySelector("#create_order_form");
    t = r.querySelector("#kt_modal_create_order_submit");
    e = r.querySelector("#kt_modal_create_order_cancel");
    o = r.querySelector("#kt_modal_create_order_close");

    $.validator.addMethod("inStock", function (value, element, param) {
        var stockValue = parseInt($("#product-stock-" + param).html());
        return parseInt(value) <= stockValue;
    });

    $("#create_order_form").validate();

    t.addEventListener("click", function (e) {
        e.preventDefault(),
            $("#create_order_form").valid()
                ? $("#create_order_form").submit()
                : Swal.fire({
                      text: "Sorry, looks like there are some errors detected, please try again.",
                      icon: "error",
                      buttonsStyling: !1,
                      confirmButtonText: "Ok, got it!",
                      customClass: { confirmButton: "btn btn-primary" },
                  });
    }),
        e.addEventListener("click", function (t) {
            t.preventDefault(), (r.reset(), modal.hide());
        }),
        o.addEventListener("click", function (t) {
            t.preventDefault(), (r.reset(), modal.hide());
        });
});

function validateOrderForm() {
    $("[name^=incoming_packages]").each(function () {
        $(this).rules("add", {
            required: true,
            digits: true,
        });
    });
    $("[name^=incoming_package_items]").each(function () {
        $(this).rules("add", {
            required: true,
            digits: true,
        });
    });
    $("[name^=product_qty]").each(function (index) {
        $(this).rules("add", {
            required: true,
            digits: true,
            inStock: index,
            messages: {
                inStock: "Value should not be greater than stock.",
            },
        });
    });
    $("[name^=outgoing_package_items]").each(function () {
        $(this).rules("add", {
            required: true,
            digits: true,
        });
    });
    $("[name^=outgoing_package_asin]").each(function () {
        $(this).rules("add", {
            required: true,
        });
    });
}
