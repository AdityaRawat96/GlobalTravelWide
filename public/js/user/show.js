"use strict";
var KTUserSettings = (function () {
    var t, n, r;
    return {
        init: function () {
            $(document).ready(function (e) {
                $(".reset").on("click", function (e) {
                    window.history.length > 2
                        ? window.history.back()
                        : (window.location.href = "/admin/user");
                });
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTUserSettings.init();
});
