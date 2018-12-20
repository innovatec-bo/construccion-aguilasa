/**
 * Created by Jair on 30/05/2018.
 */

$(document).ready(function() {
    // getCurrentStatusSummary();
    getExecutiveSummary();

    $('#panel-executive-summary-chart select').on("change",function(){
        var projectSystem = $('#panel-executive-summary-chart select[name=project-system] option:selected').val();
        var managementBy = $('#panel-executive-summary-chart select[name=management-by] option:selected').val();
        var contractNumber = $('#panel-executive-summary-chart select[name=contract-number] option:selected').val();
        getExecutiveSummary(projectSystem, managementBy, contractNumber);
    });
});

function getCurrentStatusSummary(system, management)
{
    var system = typeof system !== 'undefined' ? system : "";
    var management = typeof management !== 'undefined' ? management : "";
    var $content = $("#status-summary-chart-content");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getCurrentStatusSummary',
        dataType  :"json",
        type : "POST",
        data:{system:system, management:management},
        success:function(response){

            if(response.success === 1)
            {
                var data  = {
                    category: 'statusName',
                    value: 'totalProjects',
                    list:response.data.list
                };
                var chartHandler = new ChartHandler("status-summary-chart-content");
                chartHandler.launchPieChart(data);
                console.log(response);
            }
        }
    });
}

function getExecutiveSummary(system, management, contract)
{
    var system = typeof system !== 'undefined' ? system : "";
    var management = typeof management !== 'undefined' ? management : "";
    var contract = typeof contract !== 'undefined' ? contract : "";
    var $content = $("#executive-summary-chart-content");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getExecutiveSummary',
        dataType  :"json",
        type : "POST",
        data:{system:system, management:management, contract:contract},
        success:function(response){
            var data  = {
                category: 'title',
                value: 'totalProjectsBySection',
                list:response.list
            };
            var chartHandler = new ChartHandler("executive-summary-chart-content");
            chartHandler.launchPieChart(data);
        }
    });
}