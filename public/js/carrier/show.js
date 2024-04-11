"use strict";
var KTCustomerSettings = (function () {
    return {
        init: function () {
            $(document).ready(function (e) {
                $(".reset").on("click", function (e) {
                    window.history.length > 2
                        ? window.history.back()
                        : (window.location.href = `/${siteUserRole}/customer`);
                });
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTCustomerSettings.init();
});
