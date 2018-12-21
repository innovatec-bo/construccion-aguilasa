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
    // getUsersQuantity();
    // getRolesQuantity();
    getProjectsQuantity();
    getProjectProgressBySection();
    getContractTimeProgress();

    $(document).on("change","#panel-serebo-thermometer-chart select",function(){
        var contractNumber = $('#panel-serebo-thermometer-chart select[name=contract-number] option:selected').val();
        var stage = $('#panel-serebo-thermometer-chart select[name=stage] option:selected').val();
        getProjectProgressBySection("","",contractNumber, stage);
    });

    $(document).on("change","#panel-days-progress-chart select",function(){
        var contractNumber = $('#panel-days-progress-chart select[name=contract-number] option:selected').val();
        getContractTimeProgress(contractNumber);
    });
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