/**
 * Created by Jair on 30/05/2018.
 */

$(document).ready(function() {
    getExecutiveSummary();
    getProjectTotalsChart();
    getProjectsEvolutionChart();
    var date = new Date();
    $('.date-time').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'YYYY'
    });
    $('#panel-executive-summary-chart select').on("change",function(){
        var projectSystem = $('#panel-executive-summary-chart select[name=project-system] option:selected').val();
        var managementBy = $('#panel-executive-summary-chart select[name=management-by] option:selected').val();
        var contractNumber = $('#panel-executive-summary-chart select[name=contract-number] option:selected').val();
        getExecutiveSummary(projectSystem, managementBy, contractNumber);
    });

    $('#panel-project-totals-chart input[name=report-year]').on("dp.change",function(e){
        var date = new Date(e.date);
        getProjectTotalsChart(date.getFullYear());
    });

    $('#panel-projects-evolution-chart input[name=report-year]').on("dp.change",function(e){
        var date = new Date(e.date);
        getProjectsEvolutionChart(date.getFullYear());
    });
});

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

function getProjectTotalsChart(year)
{
    year = typeof year !== 'undefined' ? year : (new Date()).getFullYear();
    var $content = $("#project-totals-chart-content");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getProjectTotalsTable',
        dataType  :"json",
        type : "POST",
        data:{year:year},
        success:function(response){
            var monthList = ["january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december"];
            var data = [];
            var singleDataRow = {};
            var seriesList = {};
            $.each(monthList, function(i, month){

                singleDataRow.month = month;
                $.each(response.data, function(j, row){
                    singleDataRow[j+row.criteriaKeyword] = row[singleDataRow.month];
                    seriesList[j+row.criteriaKeyword] = row.criteria;
                });
                data.push(singleDataRow);
                singleDataRow = {};
            });
            // console.log(data, seriesList);
            var projectTotalsTable = new ChartHandler("project-totals-chart-content");
            projectTotalsTable.launchXYChart(data, seriesList);
        }
    });
}

function getProjectsEvolutionChart(year)
{
    year = typeof year !== 'undefined' ? year : (new Date()).getFullYear();
    var $content = $("#projects-evolution-chart-content");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getProjectTotalsTable',
        dataType  :"json",
        type : "POST",
        data:{year:year},
        success:function(response){
            var projectTotalsTable = new ChartHandler("projects-evolution-chart-content");
            projectTotalsTable.launchHorizontalBarChart(response.data);
        }
    });
}