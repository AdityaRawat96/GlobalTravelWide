"use strict";
var KTAppEcommerceSaveProduct = (function () {
    const t = () => {
        document
            .querySelectorAll(
                '[data-kt-ecommerce-catalog-add-product="product_option"]'
            )
            .forEach((e) => {
                $(e).hasClass("select2-hidden-accessible") ||
                    $(e).select2({ minimumResultsForSearch: -1 });
            });
    };
    return {
        init: function () {
            var o, a;
            (o = document.querySelector(
                "#kt_ecommerce_add_product_discount_slider"
            )),
                (a = document.querySelector(
                    "#kt_ecommerce_add_product_discount_label"
                )),
                noUiSlider.create(o, {
                    start: [10],
                    connect: !0,
                    range: { min: 1, max: 100 },
                }),
                o.noUiSlider.on("update", function (e, t) {
                    $("input[name='dicsounted_price_percentage']").val(
                        Math.round(e[t])
                    ),
                        (a.innerHTML = Math.round(e[t])),
                        t && (a.innerHTML = Math.round(e[t]));
                }),
                t(),
                (() => {
                    const e = document.getElementById(
                            "kt_ecommerce_add_product_status"
                        ),
                        t = document.getElementById(
                            "kt_ecommerce_add_product_status_select"
                        ),
                        o = ["bg-success", "bg-warning", "bg-danger"];
                    $(t).on("change", function (t) {
                        switch (t.target.value) {
                            case "published":
                                e.classList.remove(...o),
                                    e.classList.add("bg-success"),
                                    c();
                                break;
                            case "scheduled":
                                e.classList.remove(...o),
                                    e.classList.add("bg-warning"),
                                    d();
                                break;
                            case "inactive":
                                e.classList.remove(...o),
                                    e.classList.add("bg-danger"),
                                    c();
                                break;
                            case "draft":
                                e.classList.remove(...o),
                                    e.classList.add("bg-primary"),
                                    c();
                        }
                    });
                    const a = document.getElementById(
                        "kt_ecommerce_add_product_status_datepicker"
                    );
                    $("#kt_ecommerce_add_product_status_datepicker").flatpickr({
                        enableTime: !0,
                        dateFormat: "Y-m-d H:i",
                    });
                    const d = () => {
                            a.parentNode.classList.remove("d-none");
                        },
                        c = () => {
                            a.parentNode.classList.add("d-none");
                        };
                })(),
                (() => {
                    const e = document.querySelectorAll(
                            '[name="method"][type="radio"]'
                        ),
                        t = document.querySelector(
                            '[data-kt-ecommerce-catalog-add-category="auto-options"]'
                        );
                    e.forEach((e) => {
                        e.addEventListener("change", (e) => {
                            "1" === e.target.value
                                ? t.classList.remove("d-none")
                                : t.classList.add("d-none");
                        });
                    });
                })(),
                (() => {
                    const e = document.querySelectorAll(
                            'input[name="discount_option"]'
                        ),
                        t = document.getElementById(
                            "kt_ecommerce_add_product_discount_percentage"
                        ),
                        o = document.getElementById(
                            "kt_ecommerce_add_product_discount_fixed"
                        );
                    e.forEach((e) => {
                        e.addEventListener("change", (e) => {
                            switch (e.target.value) {
                                case "variable":
                                    t.classList.remove("d-none"),
                                        o.classList.add("d-none");
                                    break;
                                case "fixed":
                                    t.classList.add("d-none"),
                                        o.classList.remove("d-none");
                                    break;
                                default:
                                    t.classList.add("d-none"),
                                        o.classList.add("d-none");
                            }
                        });
                    });
                })(),
                (() => {
                    let e;
                    const t = document.getElementById(
                            "kt_ecommerce_edit_product_form"
                        ),
                        o = document.getElementById(
                            "kt_ecommerce_add_product_submit"
                        );
                    (e = FormValidation.formValidation(t, {
                        fields: {
                            product_title: {
                                validators: {
                                    notEmpty: {
                                        message: "Product name is required",
                                    },
                                },
                            },
                            asin: {
                                validators: {
                                    notEmpty: { message: "ASIN is required" },
                                },
                            },
                            price: {
                                validators: {
                                    notEmpty: {
                                        message:
                                            "Product base price is required",
                                    },
                                },
                            },
                            weight: {
                                validators: {
                                    notEmpty: {
                                        message: "Product weight is required",
                                    },
                                },
                            },
                            product_width: {
                                validators: {
                                    notEmpty: {
                                        message: "Product width is required",
                                    },
                                },
                            },
                            product_height: {
                                validators: {
                                    notEmpty: {
                                        message: "Product height is required",
                                    },
                                },
                            },
                            product_length: {
                                validators: {
                                    notEmpty: {
                                        message: "Product length is required",
                                    },
                                },
                            },
                            tax: {
                                validators: {
                                    notEmpty: {
                                        message:
                                            "Product tax class is required",
                                    },
                                },
                            },
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                                eleInvalidClass: "",
                                eleValidClass: "",
                            }),
                        },
                    })),
                        $(document).ready(function (e) {
                            $("#kt_ecommerce_edit_product_form").on(
                                "submit",
                                function (e) {
                                    e.preventDefault();
                                    o.setAttribute("data-kt-indicator", "on");
                                    o.disabled = !0;
                                    var formData = new FormData(this);
                                    $.ajax({
                                        url: $(
                                            "#kt_ecommerce_edit_product_form"
                                        ).attr("action"),
                                        type: $(
                                            "#kt_ecommerce_edit_product_form"
                                        ).attr("method"),
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        enctype: "multipart/form-data",
                                        success: function (result) {
                                            let response = JSON.parse(result);
                                            o.removeAttribute(
                                                "data-kt-indicator"
                                            ),
                                                (o.disabled = !1);
                                            if (response.success) {
                                                Swal.fire({
                                                    text: "Form has been successfully submitted!",
                                                    icon: "success",
                                                    buttonsStyling: !1,
                                                    confirmButtonText:
                                                        "Ok, got it!",
                                                    customClass: {
                                                        confirmButton:
                                                            "btn btn-primary",
                                                    },
                                                }).then(function (e) {
                                                    e.isConfirmed &&
                                                        (window.location =
                                                            t.getAttribute(
                                                                "data-kt-redirect"
                                                            ));
                                                });
                                            } else {
                                                Swal.fire({
                                                    text: response.error,
                                                    icon: "error",
                                                    buttonsStyling: !1,
                                                    confirmButtonText:
                                                        "Ok, got it!",
                                                    customClass: {
                                                        confirmButton:
                                                            "btn btn-primary",
                                                    },
                                                });
                                            }
                                        },
                                    });
                                }
                            );
                        }),
                        o.addEventListener("click", (a) => {
                            a.preventDefault(),
                                e &&
                                    e.validate().then(function (e) {
                                        console.log("validated!"),
                                            "Valid" == e
                                                ? $(
                                                      "#kt_ecommerce_edit_product_form"
                                                  ).submit()
                                                : Swal.fire({
                                                      html: "Sorry, looks like there are some errors detected, please try again. <br/><br/>Please note that there may be errors in the <strong>General</strong> or <strong>Advanced</strong> tabs",
                                                      icon: "error",
                                                      buttonsStyling: !1,
                                                      confirmButtonText:
                                                          "Ok, got it!",
                                                      customClass: {
                                                          confirmButton:
                                                              "btn btn-primary",
                                                      },
                                                  });
                                    });
                        });
                })();
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceSaveProduct.init();
});

let repeater = null;

function searchProduct(url) {
    showButtonLoader("#search_product_button");
    $.ajax({
        url,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: "POST",
        data: { "product-asin": $("#asin").val().trim() },
        success: function (result) {
            let response = JSON.parse(result);
            if (response.success) {
                $(".image-input-placeholder").css(
                    "background-image",
                    "url(" + response.product.image + ")"
                );
                $('input[name="img_url"]').val(response.product.image);
                $('input[name="product_title"]').val(response.product.title);
                $('textarea[name="product_description"]').val(
                    response.product.description
                );
                $('input[name="price"]').val(response.product.price);
                $('input[name="items"]').val(response.product.items);
                $('input[name="weight"]').val(response.product.a_weight);
                $('input[name="product_width"]').val(response.product.width);
                $('input[name="product_height"]').val(response.product.height);
                $('input[name="product_length"]').val(response.product.length);

                let repeaterList_arr = [];
                if (response.product.size)
                    repeaterList_arr.push({
                        product_option: "size",
                        product_option_value: response.product.size,
                    });
                if (response.product.color)
                    repeaterList_arr.push({
                        product_option: "color",
                        product_option_value: response.product.color,
                    });

                repeater.setList(repeaterList_arr);

                Swal.fire({
                    text: "Success, Product details autofilled from Amazon",
                    icon: "success",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: { confirmButton: "btn btn-light" },
                });
                hideButtonLoader("#search_product_button");
            } else {
                showErrorPopup(
                    "Sorry, We were unable to find any product with the provided ASIN, please check and try again.",
                    "#search_product_button"
                );
            }
        },
    });
}

function showButtonLoader(button) {
    $(`${button} .indicator-progress`).css("display", "block");
    $(`${button} .indicator-label`).css("display", "none");
    $(`${button}`).attr("disabled", true);
}

function hideButtonLoader(button) {
    $(`${button} .indicator-progress`).css("display", "none");
    $(`${button} .indicator-label`).css("display", "block");
    $(`${button}`).attr("disabled", false);
}

function showErrorPopup(text = null, button) {
    hideButtonLoader(button);
    Swal.fire({
        text: text
            ? text
            : "Sorry, looks like there are some errors detected, please try again.",
        icon: "error",
        buttonsStyling: !1,
        confirmButtonText: "Ok, got it!",
        customClass: { confirmButton: "btn btn-light" },
    }).then(function () {
        KTUtil.scrollTop();
    });
}

$(document).ready(function () {
    // First register any plugins
    $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
    $.fn.filepond.registerPlugin(FilePondPluginGetFile);
    // Turn input element into a pond
    $("#product_media").filepond();
    // Set allowMultiple property to true
    $("#product_media").filepond({
        allowMultiple: true,
        storeAsFile: true,
        name: "product_media[]",
        labelButtonDownloadItem: "Download file", // by default 'Download file'
        allowDownloadByUrl: false, // by default downloading by URL disabled
    });

    const attachments = JSON.parse($("#product_attachments").val());
    if (attachments.length) {
        attachments.forEach((attachment) => {
            console.log(attachment);
            var myRequest = new Request(attachment);
            fetch(myRequest).then(function (response) {
                response.blob().then(function (myBlob) {
                    $("#product_media").filepond("addFile", myBlob);
                });
            });
        });
    }

    $("input[name='avatar']").change(() => {
        $("input[name='img_url']").val(null);
    });

    let productForm = $("#kt_ecommerce_edit_product_form");
    let statusSelect = productForm.find('select[name="status"]');
    statusSelect.val(statusSelect.data("value")).change();
    let taxSelect = productForm.find('select[name="tax"]');
    taxSelect.val(taxSelect.data("value")).change();

    $(".product_variations").each(function (i, element) {
        let variationSelect = $(element).find(".selected-variation");
        variationSelect.val(variationSelect.data("value")).change();
    });

    repeater = $("#kt_ecommerce_add_product_options").repeater({
        show: function () {
            $(this).slideDown(), selectRepeater();
        },
        hide: function (e) {
            $(this).slideUp(e);
        },
    });
    selectRepeater();
});

const selectRepeater = () => {
    document
        .querySelectorAll(
            '[data-kt-ecommerce-catalog-add-product="product_option"]'
        )
        .forEach((e) => {
            $(e).hasClass("select2-hidden-accessible") ||
                $(e).select2({ minimumResultsForSearch: -1 });
        });
};
