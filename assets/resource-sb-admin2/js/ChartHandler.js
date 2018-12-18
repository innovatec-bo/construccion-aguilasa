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
        // Themes begin
        _am4Core.useTheme(am4themes_dark);
        _am4Core.useTheme(am4themes_animated);
        // Themes end

        var pieChart3D = _am4Charts.PieChart3D;

        var chart = _am4Core.create($content.prop("id"), pieChart3D);

        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
        chart.legend = new _am4Charts.Legend();

        chart.data = data.list;
        chart.angle = 50;
        chart.depth = 35;
        var series = chart.series.push(new _am4Charts.PieSeries3D());
        series.dataFields.category = data.category;
        series.dataFields.value = data.value;

        chart.exporting.menu = new _am4Core.ExportMenu();
    };

    this.loadEventHandlers = function()
    {

    };
}