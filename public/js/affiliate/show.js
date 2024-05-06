"use strict";
var KTAffiliateSettings = (function () {
    return {
        init: function () {
            $(document).ready(function (e) {
                $(".reset").on("click", function (e) {
                    window.history.length > 2
                        ? window.history.back()
                        : (window.location.href = `${siteURL}/${siteUserRole}/affiliate`);
                });
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAffiliateSettings.init();
});
