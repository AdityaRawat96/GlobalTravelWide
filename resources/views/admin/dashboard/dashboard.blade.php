@extends('layouts.master')

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Default</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Dashboards</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">

            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <!--begin::Col-->
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-3">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-5">
                            <!--begin::Card widget 20-->
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end mb-5 mb-xl-10" style="background-color: #F1416C;background-image:url({{asset('media/patterns/vector-1.png')}}); height: 100% !important;">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Amount-->
                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{$data['active_shipments']}}</span>
                                        <!--end::Amount-->
                                        <!--begin::Subtitle-->
                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Active
                                            Shipments</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex align-items-end pt-0">
                                    <!--begin::Progress-->
                                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                            <span>{{$data['processing_shipments']}} Processing</span>
                                            <span>{{$data['active_shipments'] ? (($data['processing_shipments'] / $data['active_shipments']) * 100) : 0}}%</span>
                                        </div>
                                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                            <div class="bg-white rounded h-8px" role="progressbar" style="width: <?= $data['active_shipments'] ? (($data['processing_shipments'] / $data['active_shipments']) * 100) : 0 ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end::Progress-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 20-->
                        </div>
                        <div class="col-xxl-12 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-5">
                            <!--begin::Card widget 17-->
                            <div class="card card-flush mb-5 mb-xl-10" style="height: 100% !important;">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Currency-->
                                            <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">$</span>
                                            <!--end::Currency-->
                                            <!--begin::Amount-->
                                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{number_format($data['wallet_balance'], 2, '.', ',')}}</span>
                                            <!--end::Amount-->
                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Subtitle-->
                                        <span class="text-gray-400 pt-1 fw-semibold fs-6">Current Balance</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
                                    <!--begin::Chart-->
                                    <div class="d-flex flex-center me-5 pt-2">
                                        <div id="kt_card_widget_17_chart" style="min-width: 70px; min-height: 70px" data-kt-size="70" data-kt-line="11"></div>
                                    </div>
                                    <!--end::Chart-->
                                    <!--begin::Labels-->
                                    <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">FBA</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">
                                                ${{number_format($data['order_total'], 2, '.', ',')}}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Labels-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 17-->
                        </div>
                    </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xxl-9">
                    <!--begin::Table widget 14-->
                    <div class="card card-flush h-md-100">
                        <!--begin::Header-->
                        <div class="card-header pt-7">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Recent Orders</span>
                            </h3>
                            <!--end::Title-->
                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                                <a href="{{route('user.order.index')}}" class="btn btn-sm btn-light">View All</a>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-6">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0" id="kt-orders-table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Order ID</th>
                                            <th class="min-w-125px">Order Date</th>
                                            <th class="min-w-125px">Amount</th>
                                            <th class="min-w-125px">Status</th>
                                            <th class="min-w-125px">
                                                <span><b>Units expected</b></span><br>
                                                <span class="text-primary">Units located</span>
                                            </th>
                                            <th class="text-end min-w-70px">Details</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach($data["orders"] as $index=>$order)
                                        <tr>
                                            <td>
                                                <span class="text-gray-800 text-hover-primary fw-bold">
                                                    FBA{{ str_pad($order->id, 5, "0", STR_PAD_LEFT) }}
                                                </span>
                                            </td>
                                            <td>{{date("d, M Y", strtotime($order->created_at))}}</td>
                                            <td>$ {{number_format($order->total, 2)}}</td>
                                            <td>
                                                <span class="badge badge-light status-badge-{{strtolower($order->status)}} fw-bold px-4 py-3">{{$order->status}}</span>
                                            </td>
                                            <td>
                                                <span><b>{{$order->product_count}}</b></span><br>
                                                <span class="text-primary">{{$order->received_product_count}}</span>
                                            </td>
                                            <!--begin::Action=-->
                                            <td class="text-end">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="{{route('admin.order.view', $order->order_id)}}" class="menu-link px-3">View</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="{{route('admin.order.edit', $order->order_id)}}" class="menu-link px-3">Edit</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3" onclick="deleteTableRow(`{{route('admin.order.delete', $order->order_id)}}`, `{{$index}}`)" data-kt-ecommerce-product-filter="delete_row">Delete</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu-->
                                            </td>
                                            <!--end::Action=-->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end: Card Body-->
                    </div>
                    <!--end::Table widget 14-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row gx-5 gx-xl-10">
                <!--begin::Col-->
                <div class="col-xl-4">
                    <!--begin::Chart widget 31-->
                    <div class="card card-flush h-xl-100">
                        <!--begin::Header-->
                        <div class="card-header pt-7 mb-7">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Warehouse
                                    Stats</span>
                            </h3>
                            <!--end::Title-->
                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body d-flex align-items-end pt-0">
                            <!--begin::Chart-->
                            <div id="kt_amcharts_3" class="w-100 h-300px"></div>
                            <!--end::Chart-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Chart widget 31-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xl-8">
                    <!--begin::Chart widget 24-->
                    <div class="card card-flush overflow-hidden h-xl-100">
                        <!--begin::Header-->
                        <div class="card-header py-5">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">Country Specific Orders</span>
                                <span class="text-gray-400 mt-1 fw-semibold fs-6">Click on a country to view the
                                    details</span>
                            </h3>
                            <!--end::Title-->
                            <!--begin::Toolbar-->
                            <div class="card-toolbar">

                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Chart-->
                            <!-- <div id="kt_charts_widget_24" class="min-h-auto" style="height: 300px">
                            </div> -->
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <br>
                                    <h4 class="text-primary" id="chart_country_name"></h4>
                                    <br>
                                    <!--begin::Labels-->
                                    <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">Orders</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end" id="chart_order_count">
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">Shipments</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end" id="chart_shipment_count">
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Labels-->
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    <div id="kt_charts_world_map" class="min-h-auto" style="height: 300px"></div>
                                </div>
                            </div>
                            <!--end::Chart-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Chart widget 24-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->
@endsection

@section('pagespecificdrawers')
@stop

@section('pagespecificmodals')
@stop


@section('pagespecificstyles')
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{asset('css/order.css')}}" />
<!--end::Vendor Stylesheets-->
@stop

@section('pagespecificscripts')
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('js/widgets.bundle.js')}}"></script>
<script src="{{asset('js/custom/apps/orders/index.js')}}"></script>
<script>
    let country_data = <?= $data['country_group'] ?>;

    am5.ready(function() {
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("kt_amcharts_3");

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        // Create chart
        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
        var chart = root.container.children.push(am5percent.PieChart.new(root, {
            layout: root.verticalLayout
        }));

        // Create series
        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
        var series = chart.series.push(am5percent.PieSeries.new(root, {
            alignLabels: true,
            calculateAggregates: true,
            valueField: "value",
            categoryField: "category",
            legendLabelText: "[{fill}]{category}[/]",
            legendValueText: "[bold {fill}]{value}[/]"
        }));


        series.slices.template.setAll({
            strokeWidth: 3,
            stroke: am5.color(0xffffff)
        });

        series.labelsContainer.set("paddingTop", 30)

        // Set up adapters for variable slice radius
        // https://www.amcharts.com/docs/v5/concepts/settings/adapters/
        series.slices.template.adapters.add("radius", function(radius, target) {
            var dataItem = target.dataItem;
            var high = series.getPrivate("valueHigh");

            if (dataItem) {
                var value = target.dataItem.get("valueWorking", 0);
                return radius * value / high
            }
            return radius;
        });

        // Set data
        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
        series.data.setAll(<?= $data['order_group'] ?>);

        // Create legend
        // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
        var legend = chart.children.push(am5.Legend.new(root, {
            centerX: am5.p50,
            x: am5.p50,
            marginTop: 15,
            marginBottom: 15
        }));

        legend.data.setAll(series.dataItems);

        // Play initial series animation
        // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
        series.appear(1000, 100);

    }); // end am5.ready()


    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("kt_charts_world_map");

        // Set themes
        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        var chart = root.container.children.push(
            am5map.MapChart.new(root, {
                panX: "rotateX",
                projection: am5map.geoNaturalEarth1()
            })
        );

        chart.set("zoomControl", am5map.ZoomControl.new(root, {}));

        // Create polygon series
        var polygonSeries = chart.series.push(
            am5map.MapPolygonSeries.new(root, {
                geoJSON: am5geodata_worldLow,
                exclude: ["AQ"]
            })
        );

        polygonSeries.mapPolygons.template.setAll({
            tooltipText: "{name}",
            interactive: true
        });

        polygonSeries.mapPolygons.template.states.create("hover", {
            fill: am5.color(0x677935)
        });

        polygonSeries.mapPolygons.template.events.on("click", function(ev) {
            // get object info
            setCountryDetails(ev.target.dataItem.dataContext.name);
        });

        setCountryDetails("Canada")
    }); // end am5.ready()

    function setCountryDetails(country_name) {
        let selected_country = country_name;
        let country_orders = country_data.find(function(item) {
            return item.country == selected_country;
        });
        if (country_orders != undefined) {
            $('#chart_country_name').html(country_orders.country);
            $('#chart_order_count').html(country_orders.orders);
            $('#chart_shipment_count').html(country_orders.items_shipped);
        } else {
            $('#chart_country_name').html(country_name);
            $('#chart_order_count').html('0');
            $('#chart_shipment_count').html('0');
        }
    }
</script>
<!--end::Custom Javascript-->
@stop