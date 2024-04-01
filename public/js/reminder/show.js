"use strict";
var KTReminderSettings = (function () {
    return {
        init: function () {
            $(document).ready(function (e) {
                $(".reset").on("click", function (e) {
                    window.history.length > 2
                        ? window.history.back()
                        : (window.location.href = `/${siteUserRole}/reminder`);
                });
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTReminderSettings.init();
});