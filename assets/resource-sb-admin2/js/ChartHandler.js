/**
 * Created by Jair on 18/12/2018.
 */

function ChartHandler(objectContent) {

    var id = Date.now();
    var _am4Core = am4core;
    var _am4Charts = am4charts;
    var $content = $("#"+objectContent);

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
        }, 1000, am4core.ease.cubicOut).start();
    };

    this.launchXYChart =function(data, seriesList)
    {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create($content.prop("id"), am4charts.XYChart);


        // Add data
        chart.data = [{
            "year": "2016",
            "europe": 2.5,
            "namerica": 2.5,
            "asia": 2.1,
            "lamerica": 0.3,
            "meast": 0.2,
            "africa": 0.1
        }, {
            "year": "2017",
            "europe": 2.6,
            "namerica": 2.7,
            "asia": 2.2,
            "lamerica": 0.3,
            "meast": 0.3,
            "africa": 0.1
        }, {
            "year": "2018",
            "europe": 2.8,
            "namerica": 2.9,
            "asia": 2.4,
            "lamerica": 0.3,
            "meast": 0.3,
            "africa": 0.1
        }];
        chart.data = data;
        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "month";
        categoryAxis.renderer.grid.template.location = 0;


        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.inside = true;
        valueAxis.renderer.labels.template.disabled = true;
        valueAxis.min = 0;

        // Create series
        function createSeries(field, name) {

            // Set up series
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.name = name;
            series.dataFields.valueY = field;
            series.dataFields.categoryX = "month";
            series.sequencedInterpolation = true;

            // Make it stacked
            series.stacked = true;

            // Configure columns
            series.columns.template.width = am4core.percent(60);
            series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";

            // Add label
            var labelBullet = series.bullets.push(new am4charts.LabelBullet());
            labelBullet.label.text = "{valueY}";
            labelBullet.locationY = 0.5;

            return series;
        }
        $.each(seriesList, function(index, value){
            createSeries(index, value);
        });
        // createSeries("europe", "Europe");
        // createSeries("namerica", "North America");
        // createSeries("asia", "Asia-Pacific");
        // createSeries("lamerica", "Latin America");
        // createSeries("meast", "Middle-East");
        // createSeries("africa", "Africa");

        // Legend
        chart.legend = new am4charts.Legend();
    };

    this.loadEventHandlers = function()
    {

    };
}