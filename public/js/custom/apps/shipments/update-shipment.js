function update_shipment_form_submit(id) {
    var form = $("#update_shipment_form_" + id);
    if (form.data("valid")) {
        form.submit();
    }
}

$(document).ready(function () {
    $(".product_qty").on("keyup", function () {
        let id = $(this).data("index");
        $("#update_shipment_form_" + id).data("valid", true);
        $("#button_update_shipment_" + id).attr("disabled", false);
        $(this).removeClass("is-invalid");
        $(this).next().remove();
        var value = $(this).val();
        if (/^\d+$/.test(value) == false) {
            $("#button_update_shipment_" + id).attr("disabled", true);
            $("#update_shipment_form_" + id).data("valid", false);
            $(this).after(
                '<small class="text-danger">Value should be a positive number.</small>'
            );
            $(this).addClass("is-invalid");
        }
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
