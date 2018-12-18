/**
 * Created by Jair on 30/05/2018.
 */

$(document).ready(function() {
    launchPieChart();
});

function launchPieChart()
{
    // Themes begin
    //am4core.useTheme(am4themes_animated);
    // Themes end

    var chart = am4core.create("chartdiv", am4charts.PieChart3D);
    chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

    chart.legend = new am4charts.Legend();

    chart.data = [
        {
            title: "Listo para diseño",
            quantity: 501.9
        },
        {
            title: "Diseño",
            quantity: 301.9
        },
        {
            title: "Aprobacion",
            quantity: 201.1
        },
        {
            title: "Construccion",
            quantity: 165.8
        },
        {
            title: "Cierre",
            quantity: 139.9
        },
        {
            title: "Cerrado",
            quantity: 128.3
        }
    ];

    var series = chart.series.push(new am4charts.PieSeries3D());
        series.dataFields.value = "quantity";
    series.dataFields.category = "title";

    chart.exporting.menu = new am4core.ExportMenu();
}

function blockArea(content)
{
    content.block({
        message: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>',
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8,
            cursor: 'wait'
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'transparent'
        }
    });
}