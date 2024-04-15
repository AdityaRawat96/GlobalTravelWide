var RevenueChart = (function () {
    var e = { self: null, rendered: !1 },
        t = function (e) {
            var t = document.getElementById("revenue_chart");
            if (t) {
                var a = KTUtil.getCssVariableValue("--kt-gray-800"),
                    l = KTUtil.getCssVariableValue("--kt-border-dashed-color"),
                    r = {
                        series: [
                            {
                                name: "Amount",
                                data: REVENUE_DATA,
                            },
                        ],
                        chart: {
                            fontFamily: "inherit",
                            type: "bar",
                            height: 350,
                            toolbar: { show: !1 },
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 8,
                                horizontal: !0,
                                distributed: !0,
                                barHeight: 50,
                                dataLabels: { position: "bottom" },
                            },
                        },
                        dataLabels: {
                            enabled: !0,
                            textAnchor: "start",
                            offsetX: 0,
                            formatter: function (e, t) {
                                e *= 1;
                                return "£" + wNumb({ thousand: "," }).to(e);
                            },
                            style: {
                                fontSize: "14px",
                                fontWeight: "600",
                                align: "left",
                            },
                        },
                        legend: { show: !1 },
                        colors: ["#3E97FF", "#7239EA", "#F1416C"],
                        xaxis: {
                            categories: ["Invoices", "Refunds", "Commissions"],
                            labels: {
                                formatter: function (e) {
                                    return "£" + parseFloat(e).toFixed(2);
                                },
                                style: {
                                    colors: a,
                                    fontSize: "14px",
                                    fontWeight: "600",
                                    align: "left",
                                },
                            },
                            axisBorder: { show: !1 },
                        },
                        yaxis: {
                            labels: {
                                formatter: function (e, t) {
                                    return Number.isInteger(e)
                                        ? e +
                                              " - " +
                                              parseInt(
                                                  (100 * e) / 18
                                              ).toString() +
                                              "%"
                                        : e;
                                },
                                style: {
                                    colors: a,
                                    fontSize: "14px",
                                    fontWeight: "600",
                                },
                                offsetY: 2,
                                align: "left",
                            },
                        },
                        grid: {
                            borderColor: l,
                            xaxis: { lines: { show: !0 } },
                            yaxis: { lines: { show: !1 } },
                            strokeDashArray: 4,
                        },
                        tooltip: {
                            style: { fontSize: "12px" },
                            y: {
                                formatter: function (e) {
                                    return e;
                                },
                            },
                        },
                    };
                (e.self = new ApexCharts(t, r)),
                    setTimeout(function () {
                        e.self.render(), (e.rendered = !0);
                    }, 200);
            }
        };
    return {
        init: function () {
            t(e),
                KTThemeMode.on("kt.thememode.change", function () {
                    e.rendered && e.self.destroy(), t(e);
                });
        },
    };
})();

var SalesChart = {
    init: function () {
        !(function () {
            if ("undefined" != typeof am5) {
                var e = document.getElementById("sales_chart");
                if (e) {
                    var t,
                        a = function () {
                            (t = am5.Root.new(e)).setThemes([
                                am5themes_Animated.new(t),
                            ]);
                            var a = t.container.children.push(
                                    am5xy.XYChart.new(t, {
                                        panX: !1,
                                        panY: !1,
                                        layout: t.verticalLayout,
                                    })
                                ),
                                l = (a.get("colors"), SALES_DATA),
                                r = a.xAxes.push(
                                    am5xy.CategoryAxis.new(t, {
                                        categoryField: "month",
                                        renderer: am5xy.AxisRendererX.new(t, {
                                            minGridDistance: 30,
                                        }),
                                        bullet: function (e, t, a) {
                                            return am5xy.AxisBullet.new(e, {
                                                location: 0.5,
                                                sprite: am5.Picture.new(e, {
                                                    width: 24,
                                                    height: 24,
                                                    centerY: am5.p50,
                                                    centerX: am5.p50,
                                                    src: a.dataContext.icon,
                                                }),
                                            });
                                        },
                                    })
                                );
                            r.get("renderer").labels.template.setAll({
                                paddingTop: 20,
                                fontWeight: "400",
                                fontSize: 10,
                                fill: am5.color(
                                    KTUtil.getCssVariableValue("--kt-gray-500")
                                ),
                            }),
                                r.get("renderer").grid.template.setAll({
                                    disabled: !0,
                                    strokeOpacity: 0,
                                }),
                                r.data.setAll(l);
                            var o = a.yAxes.push(
                                am5xy.ValueAxis.new(t, {
                                    renderer: am5xy.AxisRendererY.new(t, {}),
                                })
                            );
                            o.get("renderer").grid.template.setAll({
                                stroke: am5.color(
                                    KTUtil.getCssVariableValue("--kt-gray-300")
                                ),
                                strokeWidth: 1,
                                strokeOpacity: 1,
                                strokeDasharray: [3],
                            }),
                                o.get("renderer").labels.template.setAll({
                                    fontWeight: "400",
                                    fontSize: 10,
                                    fill: am5.color(
                                        KTUtil.getCssVariableValue(
                                            "--kt-gray-500"
                                        )
                                    ),
                                });
                            var i = a.series.push(
                                am5xy.ColumnSeries.new(t, {
                                    xAxis: r,
                                    yAxis: o,
                                    valueYField: "amount",
                                    categoryXField: "month",
                                })
                            );
                            i.columns.template.setAll({
                                tooltipText: "{categoryX}: {valueY}",
                                tooltipY: 0,
                                strokeOpacity: 0,
                                templateField: "columnSettings",
                            }),
                                i.columns.template.setAll({
                                    strokeOpacity: 0,
                                    cornerRadiusBR: 0,
                                    cornerRadiusTR: 6,
                                    cornerRadiusBL: 0,
                                    cornerRadiusTL: 6,
                                }),
                                i.data.setAll(l),
                                i.appear(),
                                a.appear(1e3, 100);
                        };
                    am5.ready(function () {
                        a();
                    }),
                        KTThemeMode.on("kt.thememode.change", function () {
                            t.dispose(), a();
                        });
                }
            }
        })();
    },
};

var InvoiceChart = (function () {
    var e = { self: null, rendered: !1 },
        t = function (e) {
            var t = document.getElementById("invoice_chart");
            if (t) {
                var a = parseInt(KTUtil.css(t, "height")),
                    l = KTUtil.getCssVariableValue("--kt-gray-500"),
                    r = KTUtil.getCssVariableValue("--kt-border-dashed-color"),
                    o = KTUtil.getCssVariableValue("--kt-warning"),
                    i = {
                        series: [
                            {
                                name: "Position",
                                data: INVOICE_DATA["invoicesTotal"],
                            },
                        ],
                        chart: {
                            fontFamily: "inherit",
                            type: "area",
                            height: a,
                            toolbar: { show: !1 },
                        },
                        legend: { show: !1 },
                        dataLabels: { enabled: !1 },
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.4,
                                opacityTo: 0,
                                stops: [0, 80, 100],
                            },
                        },
                        stroke: {
                            curve: "smooth",
                            show: !0,
                            width: 3,
                            colors: [o],
                        },
                        xaxis: {
                            categories: INVOICE_DATA["invoicesDate"],
                            axisBorder: { show: !1 },
                            axisTicks: { show: !1 },
                            offsetX: 20,
                            tickAmount: 4,
                            labels: {
                                rotate: 0,
                                rotateAlways: !1,
                                style: { colors: l, fontSize: "12px" },
                            },
                            crosshairs: {
                                position: "front",
                                stroke: { color: o, width: 1, dashArray: 3 },
                            },
                            tooltip: {
                                enabled: !0,
                                formatter: void 0,
                                offsetY: 0,
                                style: { fontSize: "12px" },
                            },
                        },
                        yaxis: {
                            tickAmount: 4,
                            max: INVOICE_DATA["invoiceMaxTotal"],
                            min: 0,
                            labels: {
                                style: { colors: l, fontSize: "12px" },
                                formatter: function (e) {
                                    return e;
                                },
                            },
                        },
                        states: {
                            normal: { filter: { type: "none", value: 0 } },
                            hover: { filter: { type: "none", value: 0 } },
                            active: {
                                allowMultipleDataPointsSelection: !1,
                                filter: { type: "none", value: 0 },
                            },
                        },
                        tooltip: {
                            style: { fontSize: "12px" },
                            y: {
                                formatter: function (e) {
                                    return e;
                                },
                            },
                        },
                        colors: [o],
                        grid: {
                            borderColor: r,
                            strokeDashArray: 4,
                            yaxis: { lines: { show: !0 } },
                        },
                        markers: { strokeColor: o, strokeWidth: 3 },
                    };
                (e.self = new ApexCharts(t, i)),
                    setTimeout(function () {
                        e.self.render(), (e.rendered = !0);
                    }, 200);
            }
        };
    return {
        init: function () {
            t(e),
                KTThemeMode.on("kt.thememode.change", function () {
                    e.rendered && e.self.destroy(), t(e);
                });
        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    RevenueChart.init();
    SalesChart.init();
    InvoiceChart.init();
});
