function update_shipment_form_submit(id) {
    var form = $("#update_shipment_form_" + id);
    if (form.data("valid")) {
        form.submit();
    }
}

function validateReceived(id) {
    $("#update_shipment_form_" + id).data("valid", true);
    $("#button_update_shipment_" + id).attr("disabled", false);
    $("#product_received_" + id).removeClass("is-invalid");
    $("#product_received_" + id)
        .next()
        .remove();
    var value = parseInt($("#product_received_" + id).val());
    var total = parseInt($("#product_total_" + id).html());
    var working = parseInt($("#product_working_" + id).html());
    var damaged = parseInt($("#product_damaged_" + id).val());
    if (value + damaged < working) {
        $("#button_update_shipment_" + id).attr("disabled", true);
        $("#update_shipment_form_" + id).data("valid", false);
        $("#product_received_" + id).after(
            '<small class="text-danger">received + damaged should not be less than ' +
                working +
                ".</small>"
        );
        $("#product_received_" + id).addClass("is-invalid");
    } else if (value + damaged > total) {
        $("#button_update_shipment_" + id).attr("disabled", true);
        $("#update_shipment_form_" + id).data("valid", false);
        $("#product_received_" + id).after(
            '<small class="text-danger">received + damaged should not be more than ' +
                total +
                ".</small>"
        );
        $("#product_received_" + id).addClass("is-invalid");
    }
}

function validateDamaged(id) {
    $("#update_shipment_form_" + id).data("valid", true);
    $("#button_update_shipment_" + id).attr("disabled", false);
    $("#product_damaged_" + id).removeClass("is-invalid");
    $("#product_damaged_" + id)
        .next()
        .remove();
    var value = parseInt($("#product_damaged_" + id).val());
    var total = parseInt($("#product_total_" + id).html());
    var working = parseInt($("#product_working_" + id).html());
    var received = parseInt($("#product_received_" + id).val());
    if (value + received < working) {
        $("#button_update_shipment_" + id).attr("disabled", true);
        $("#update_shipment_form_" + id).data("valid", false);
        $("#product_damaged_" + id).after(
            '<small class="text-danger">received + damaged should not be less than ' +
                working +
                ".</small>"
        );
        $("#product_damaged_" + id).addClass("is-invalid");
    } else if (value + received > total) {
        $("#button_update_shipment_" + id).attr("disabled", true);
        $("#update_shipment_form_" + id).data("valid", false);
        $("#product_damaged_" + id).after(
            '<small class="text-danger">received + damaged should not be more than ' +
                total +
                ".</small>"
        );
        $("#product_damaged_" + id).addClass("is-invalid");
    }
}

$(document).ready(function () {
    $(".product_received").on("keyup", function () {
        let id = $(this).data("index");
        validateReceived(id);
        validateDamaged(id);
    });

    $(".product_damaged").on("keyup", function () {
        let id = $(this).data("index");
        validateDamaged(id);
        validateReceived(id);
    });

    $(".update_shipment_form").on("submit", function (e) {
        e.preventDefault();
        let button = $("#button_update_shipment_" + $(this).data("index"));
        button.attr("data-kt-indicator", "on");
        button.attr("disabled", true);
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            enctype: "multipart/form-data",
            success: function (response) {
                button.removeAttr("data-kt-indicator");
                button.attr("disabled", false);
                if (response.success) {
                    Swal.fire({
                        text: response.message,
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: { confirmButton: "btn btn-primary" },
                    }).then(function (e) {
                        e.isConfirmed;
                    });
                } else {
                    Swal.fire({
                        text: response.message,
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: { confirmButton: "btn btn-primary" },
                    });
                }
            },
        });
    });
});
