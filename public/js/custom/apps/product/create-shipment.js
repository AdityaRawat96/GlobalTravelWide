$(document).ready(function () {
    var modal = new bootstrap.Modal(
        document.querySelector("#kt_modal_create_shipment")
    );
    var t, e, o, n, r;
    r = document.querySelector("#create_shipment_form");
    t = r.querySelector("#kt_modal_create_shipment_submit");
    e = r.querySelector("#kt_modal_create_shipment_cancel");
    o = r.querySelector("#kt_modal_create_shipment_close");

    $("#create_shipment_form").validate();

    t.addEventListener("click", function (e) {
        e.preventDefault(),
            $("#create_shipment_form").valid()
                ? $.ajax({
                      url: $("#create_shipment_form").attr("action"),
                      type: "POST",
                      data: $("#create_shipment_form").serialize(),
                      success: function (result) {
                          console.log(result);
                          if (result) {
                              $("#ship_from_address").html(
                                  $("#ship_from_address")
                                      .html()
                                      .replace(
                                          "XXXXXXXXXX",
                                          "#LOT" +
                                              result.id
                                                  .toString()
                                                  .padStart(5, "0")
                                      )
                              );
                              Swal.fire({
                                  text: "Shipment created successfully!",
                                  html:
                                      $("#ship_from_address_container").html() +
                                      "<br/><br/>Click on the button below to go to the order page.",
                                  icon: "success",
                                  buttonsStyling: !1,
                                  showCancelButton: !0,
                                  cancelButtonText: "Dismiss",
                                  confirmButtonText: "View Shipments",
                                  customClass: {
                                      confirmButton: "btn fw-bold btn-primary",
                                      cancelButton:
                                          "btn fw-bold btn-active-light-primary",
                                  },
                              }).then(function (e) {
                                  e.value
                                      ? (window.location.href = $(
                                            "#create_shipment_form"
                                        ).data("redirect"))
                                      : e.dismiss;
                              });
                          } else {
                              Swal.fire({
                                  text: "Sorry, looks like there are some errors detected, please try again.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "Ok, got it!",
                                  customClass: {
                                      confirmButton: "btn fw-bold btn-primary",
                                  },
                              });
                          }
                      },
                  })
                : Swal.fire({
                      text: "Sorry, looks like there are some errors detected, please try again.",
                      icon: "error",
                      buttonsStyling: !1,
                      confirmButtonText: "Ok, got it!",
                      customClass: {
                          confirmButton: "btn fw-bold btn-primary",
                      },
                  });
    }),
        e.addEventListener("click", function (t) {
            t.preventDefault(), (r.reset(), modal.hide());
        }),
        o.addEventListener("click", function (t) {
            t.preventDefault(), (r.reset(), modal.hide());
        });
});

function validateShipmentForm() {
    $("[name^=product_qty]").each(function () {
        $(this).rules("add", {
            required: true,
            digits: true,
        });
    });
}

function tooltipMouseIn(elem, address = null) {
    let copied_address = "";
    if (!address) {
        copied_address = $("#ship_from_address")
            .text()
            .replace(/\s+/g, " ")
            .trim();
    } else {
        let address_data = JSON.parse(address);
        copied_address += address_data.name ? address_data.name + ", \n" : "";
        copied_address += address_data.company
            ? address_data.company + ", \n"
            : "";
        copied_address += address_data.email ? address_data.email + ", \n" : "";
        copied_address += address_data.phone ? address_data.phone + ", \n" : "";
        copied_address += address_data.address_1
            ? address_data.address_1 + ", \n"
            : "";
        copied_address += address_data.address_2
            ? address_data.address_2 + ", \n"
            : "";
        copied_address += address_data.name ? address_data.city + ", \n" : "";
        copied_address += address_data.name ? address_data.state + ", " : "";
        copied_address += address_data.country
            ? address_data.country + ". \n"
            : "";
        copied_address += address_data.zip ? address_data.zip : "";
    }
    navigator.clipboard.writeText(copied_address);
    $("#" + elem).html("Address coiped to clipboard!");
}

function tooltipMouseOut(elem) {
    $("#" + elem).html("Copy to clipboard");
}
