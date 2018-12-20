/**
 * Created by Jair on 18/12/2018.
 */

function ChartHandler(objectContent) {

    var id = Date.now();
    var _am4Core = am4core;
    var _am4Charts = am4charts;
    var $content = $("#"+objectContent);

    this.launchPieChart2 = function(data)
    {
        // Themes begin
        _am4Core.useTheme(am4themes_dark);
        _am4Core.useTheme(am4themes_animated);
        // Themes end
        var pieChart3D = _am4Charts.PieChart3D;
        var chart = _am4Core.create($content.prop("id"), pieChart3D);

        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
        chart.legend = new _am4Charts.Legend();
        chart.legend.align = "right";
        // chart.legend.useDefaultMarker = true;
        chart.legend.fontSize = 10;
        var marker = chart.legend.markers.template.children.getIndex(0);
        marker.cornerRadius(12, 12, 12, 12);

        chart.data = data.list;
        chart.angle = 50;
        chart.depth = 35;
        var series = chart.series.push(new _am4Charts.PieSeries3D());
        series.dataFields.category = data.category;
        series.dataFields.value = data.value;

        series.ticks.template.disabled = true;
        series.alignLabels = false;
        series.labels.template.text = "{value.percent.formatNumber('#.0')}%";
        series.labels.template.radius = _am4Core.percent(-40);
        series.labels.template.fill = _am4Core.color("white");

        series.labels.template.adapter.add("radius", function(radius, target) {
            if (target.dataItem && (target.dataItem.values.value.percent < 10)) {
                return 50;
            }
            return radius;
        });

        series.labels.template.adapter.add("fill", function(color, target) {
            if (target.dataItem && (target.dataItem.values.value.percent < 10)) {
                return am4core.color("#fff");
            }
            return color;
        });

        chart.exporting.menu = new _am4Core.ExportMenu();

    };

    this.launchPieChart = function(data)
    {
        /**
         * ---------------------------------------
         * This demo was created using amCharts 4.
         *
         * For more information visit:
         * https://www.amcharts.com/
         *
         * Documentation is available at:
         * https://www.amcharts.com/docs/v4/
         * ---------------------------------------
         */
        _am4Core.useTheme(am4themes_dark);
        _am4Core.useTheme(am4themes_animated);
        // Create chart instance
        var pieChart3D = _am4Charts.PieChart3D;
        var chart = _am4Core.create($content.prop("id"), pieChart3D);
        chart.angle = 50;
        chart.depth = 35;
        // Add data
        chart.data = data.list;
        chart.legend = new _am4Charts.Legend();
        // Add and configure Series
        var series = chart.series.push(new _am4Charts.PieSeries3D());
        series.dataFields.value = data.value;
        series.dataFields.category = data.category;

        // series.ticks.template.disabled = true;
        // series.alignLabels = false;
        // series.labels.template.text = "{value.percent.formatNumber('#.0')}%";
        series.labels.template.radius = _am4Core.percent(-40);
        series.labels.template.fill = _am4Core.color("white");
        series.labels.template.adapter.add("radius", function(radius, target) {
            if (target.dataItem && (target.dataItem.values.value.percent < 100)) {
                return 20;
            }
            return radius;
        });

        series.labels.template.adapter.add("fill", function(color, target) {
            if (target.dataItem && (target.dataItem.values.value.percent < 10)) {
                return am4core.color("#fff");
            }
            return color;
        });
    };

    this.launchGaugeChart2 = function()
    {
        // Themes begin
        am4core.useTheme(am4themes_animated);
// Themes end

// create chart
        // Create a container
        var container = am4core.create("container", am4core.Container);
        container.width = am4core.percent(100);
        container.height = am4core.percent(100);
        container.layout = "vertical";

        // var chart = am4core.create("dashboard-gauge", am4charts.GaugeChart);
        var chart = container.createChild(am4charts.GaugeChart);
        chart.height = 50;
        chart.hiddenState.properties.opacity = 0; // this makes initial fade in effect
        chart.responsive.enabled = true;
        chart.responsive.useDefault = false;
        chart.innerRadius = -30;

        var axis = chart.xAxes.push(new am4charts.ValueAxis());
        axis.min = 0;
        axis.max = 100;
        axis.strictMinMax = true;
        axis.renderer.grid.template.stroke = new am4core.InterfaceColorSet().getFor("background");
        axis.renderer.grid.template.strokeOpacity = 0.2;

        var colorSet = new am4core.ColorSet();

        var range0 = axis.axisRanges.create();
        range0.value = 0;
        range0.endValue = 50;
        range0.axisFill.fillOpacity = 1;
        range0.axisFill.fill = colorSet.getIndex(0);
        range0.axisFill.zIndex = - 2;

        var range1 = axis.axisRanges.create();
        range1.value = 50;
        range1.endValue = 80;
        range1.axisFill.fillOpacity = 1;
        range1.axisFill.fill = colorSet.getIndex(2);
        range1.axisFill.zIndex = -2;

        var range2 = axis.axisRanges.create();
        range2.value = 80;
        range2.endValue = 100;
        range2.axisFill.fillOpacity = 1;
        range2.axisFill.fill = colorSet.getIndex(4);
        range2.axisFill.zIndex = -2;

        var hand = chart.hands.push(new am4charts.ClockHand());
        hand.showValue(Math.random() * 100, 1000, am4core.ease.cubicOut);

        // using chart.setTimeout method as the timeout will be disposed together with a chart
        // chart.setTimeout(randomValue, 2000);
        // function randomValue() {
        //     hand.showValue(Math.random() * 100, 1000, am4core.ease.cubicOut);
        //     chart.setTimeout(randomValue, 2000);
        // }
    };

    this.launchGaugeChart = function()
    {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var gaugesChart = am4charts.GaugeChart;
        gaugesChart.heigth = 0;
        // create chart
        // Create a container
        var container = am4core.create($content.prop("id"), am4core.Container);
        container.width = am4core.percent(100);
        container.height = am4core.percent(130);
        container.layout = "vertical";

        // var chart = am4core.create("dashboard-gauge", am4charts.GaugeChart);
        var chart = container.createChild(am4charts.GaugeChart);
        chart.innerRadius = am4core.percent(82);

        /**
         * Normal axis
         */

        var axis = chart.xAxes.push(new am4charts.ValueAxis());
        axis.marginTop= 0;
        axis.min = 0;
        axis.max = 100;
        axis.strictMinMax = true;
        axis.renderer.radius = am4core.percent(80);
        axis.renderer.inside = true;
        axis.renderer.line.strokeOpacity = 1;
        axis.renderer.ticks.template.strokeOpacity = 1;
        axis.renderer.ticks.template.length = 5;
        axis.renderer.grid.template.disabled = true;
        axis.renderer.labels.template.radius = 40;
        axis.renderer.labels.template.adapter.add("text", function(text) {
            return "";
        });

        /**
         * Axis for ranges
         */

        var colorSet = new am4core.ColorSet();

        var axis2 = chart.xAxes.push(new am4charts.ValueAxis());
        axis2.min = 0;
        axis2.max = 100;
        axis2.renderer.innerRadius = 10;
        axis2.strictMinMax = true;
        axis2.renderer.labels.template.disabled = true;
        axis2.renderer.ticks.template.disabled = true;
        axis2.renderer.grid.template.disabled = true;

        var range0 = axis2.axisRanges.create();
        range0.value = 0;
        range0.endValue = 50;
        range0.axisFill.fillOpacity = 1;
        range0.axisFill.fill = colorSet.getIndex(0);

        var range1 = axis2.axisRanges.create();
        range1.value = 50;
        range1.endValue = 100;
        range1.axisFill.fillOpacity = 1;
        range1.axisFill.fill = colorSet.getIndex(2);

        /**
         * Label
         */

        this.label = chart.radarContainer.createChild(am4core.Label);
        this.label.isMeasured = false;
        this.label.fontSize = 20;
        this.label.x = am4core.percent(50);
        this.label.y = am4core.percent(100);
        this.label.horizontalCenter = "middle";
        this.label.verticalCenter = "bottom";
        this.label.text = "%";
        this.label.fill = "#fff";

        /**
         * Hand
         */

        this.hand = chart.hands.push(new am4charts.ClockHand());
        this.hand.axis = axis2;
        this.hand.innerRadius = am4core.percent(40);
        this.hand.startWidth = 10;
        this.hand.pin.disabled = true;
        this.hand.value = 50;
        this.hand.fill = "#fff";

        this.hand.events.on("propertychanged", function(ev) {
            range0.endValue = ev.target.value;
            range1.value = ev.target.value;
            axis2.invalidate();
        });


    };

    this.launchGaugeChartUpdate = function(value)
    {
        this.label.text = value + "%";
        var animation = new am4core.Animation(this.hand, {
            property: "value",
            to: value
        }, 2000, am4core.ease.cubicOut).start();
    };

    this.loadEventHandlers = function()
    {

    };
}