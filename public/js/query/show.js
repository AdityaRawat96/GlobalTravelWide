"use strict";
var KTQueriesettings = (function () {
    return {
        init: function () {
            $(document).ready(function (e) {
                $(".reset").on("click", function (e) {
                    window.history.length > 2
                        ? window.history.back()
                        : (window.location.href = `${siteURL}/${siteUserRole}/query`);
                });
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTQueriesettings.init();
});
