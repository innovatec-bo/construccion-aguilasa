/**
 * Created by Jair on 30/05/2018.
 */
var sereboThermometer = new ChartHandler("serebo-thermometer-chart-content");
sereboThermometer.launchGaugeChart();
sereboThermometer.launchGaugeChartUpdate(0);

var daysProgress = new ChartHandler("days-progress-chart-content");
daysProgress.launchGaugeChart();
daysProgress.launchGaugeChartUpdate(0);


$(document).ready(function() {

    $("#panel-main-report-control-filter").closest(".row").sticky({topSpacing:0,zIndex:1, center:true});
    var date = new Date();
    $('.date-time').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'YYYY'
    });

    $('.date-time-default-blank').datetimepicker({
        ignoreReadonly: true,
        format: 'YYYY',
        showClear: true
    });

    // getUsersQuantity();
    // getRolesQuantity();
    getProjectsQuantity();
    getProjectProgressBySection();
    getContractTimeProgress();

    $(document).on("change","#panel-serebo-thermometer-chart select",function(){
        var inputData = getInputData();
        var stage = $('#panel-serebo-thermometer-chart select[name=stage] option:selected').val();
        getProjectProgressBySection("","",inputData.contractNumber, stage);
    });

    $(document).on("change","#panel-days-progress-chart select",function(){
        var inputData = getInputData();
        getContractTimeProgress(inputData.contractNumber);
    });

    //begin - general filter;
    $("#panel-main-report-control-filter").on("change", "select", function(){
        var $content = $("#panel-main-report-control-filter");
        var year = $content.find('input[name=report-year]').val();
        var inputData = getInputData();
        getProjectProgressBySection("","",inputData.contractNumber);
        getContractTimeProgress(inputData.contractNumber);
        getExecutiveSummary($("#executive-summary-units-chart-content"), "totalProjectsBySection",inputData.projectSystem, inputData.managementBy, inputData.contractNumber);
        getExecutiveSummary($("#executive-summary-amounts-chart-content"), "totalApprovedBudgetBySection", inputData.projectSystem, inputData.managementBy, inputData.contractNumber);
        getExecutiveSummary($("#executive-summary-contract-percentage-chart-content"), "contractAmountPercentageBySection", inputData.projectSystem, inputData.managementBy, inputData.contractNumber);
        getProjectTotalsChart(year,undefined,inputData.contractNumber);
        getProjectsEvolutionChart(year,undefined,inputData.contractNumber);
        getSystemReport(inputData.managementBy, inputData.contractNumber);
        // console.log(year, inputData.projectSystem, inputData.managementBy, inputData.contractNumber);
    });

    $("#panel-main-report-control-filter").on("dp.change", "input[name=report-year]", function(e){
        var $content = $("#panel-main-report-control-filter");
        var year = e.date === false?"":new Date(e.date).getFullYear();
        var inputData = getInputData($content);
        getProjectTotalsChart(year,undefined,inputData.contractNumber);
        getProjectsEvolutionChart(year,undefined,inputData.contractNumber);
    });
    //end - general filter;
});

function getUsersQuantity()
{
    $.ajax({
        url : base_url + 'panel/AjaxUser/getTotalUsers',
        dataType  :"json",
        type : "POST",
        success:function(response){
            $("#dashboard-total-users").text(response.total);
        }
    });
}

function getRolesQuantity()
{
    $.ajax({
        url : base_url + 'panel/AjaxRole/getTotalRoles',
        dataType  :"json",
        type : "POST",
        success:function(response){
            $("#dashboard-total-roles").text(response.total);
        }
    });
}

function getProjectsQuantity()
{
    $.ajax({
        url : base_url + 'panel/AjaxProject/getTotalProjects',
        dataType  :"json",
        type : "POST",
        success:function(response){
            $("#dashboard-total-projects").text(response.total);
        }
    });
}
function getProjectProgressBySection(system, management, contract, section)
{
    var system = typeof system !== 'undefined' ? system : "";
    var management = typeof management !== 'undefined' ? management : "";
    var contract = typeof contract !== 'undefined' ? contract : "";
    var section = typeof section !== 'undefined' ? section : "";
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getProjectProgressBySection',
        dataType  :"json",
        type : "POST",
        data:{system:system, management:management, contract:contract, section:section},
        success:function(response){
            sereboThermometer.launchGaugeChartUpdate(parseFloat(response.percentage));
        }
    });
}

function getContractTimeProgress(contract)
{
    contract = typeof contract !== 'undefined' ? contract : "";
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getContractTimeProgress',
        dataType  :"json",
        type : "POST",
        data:{contract:contract},
        success:function(response){
            daysProgress.launchGaugeChartUpdate(parseFloat(response.percentage));
        }
    });
}

function getInputData()
{
    var $content = $("#panel-main-report-control-filter");
    var inputData = {};
    inputData.year = $content.find('input[name=report-year]').val();
    inputData.projectSystem = $content.find('select[name=project-system] option:selected').val();
    inputData.managementBy = $content.find('select[name=management-by] option:selected').val();
    inputData.contractNumber = $content.find('select[name=contract-number] option:selected').val();
    return inputData;
}