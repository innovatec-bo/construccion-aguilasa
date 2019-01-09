/**
 * Created by Jair on 30/05/2018.
 */

$(document).ready(function() {
    getExecutiveSummary();
    getProjectTotalsChart();
    getProjectsEvolutionChart();
    getSystemReport();
    var date = new Date();
    $('.date-time').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'YYYY'
        // showClear: true
    });
    $('#panel-executive-summary-chart select').on("change",function(){
        var projectSystem = $('#panel-executive-summary-chart select[name=project-system] option:selected').val();
        var managementBy = $('#panel-executive-summary-chart select[name=management-by] option:selected').val();
        var contractNumber = $('#panel-executive-summary-chart select[name=contract-number] option:selected').val();
        var dataType = $('#panel-executive-summary-chart select[name=data-type] option:selected').val();
        getExecutiveSummary(projectSystem, managementBy, contractNumber, dataType);
    });

    $('#panel-project-totals-chart input[name=report-year]').on("dp.change",function(e){
        var date = new Date(e.date);
        var dataType = $(this).closest("div#panel-project-totals-chart").find("select[name=data-type] option:selected").val();
        getProjectTotalsChart(date.getFullYear(), dataType);
    });
    // $('#panel-project-totals-chart select[name=data-type]').on("change",function(){
    //     var date = $(this).closest("div#panel-project-totals-chart").find("input[name=report-year]").val();
    //     var dataType = $(this).val();
    //     getProjectTotalsChart(date, dataType);
    // });
    $(document).on("change",'#panel-project-totals-chart select[name=data-type], #panel-project-totals-chart select[name=contract-number]',function(){
        var date = $(this).closest("div#panel-project-totals-chart").find("input[name=report-year]").val();
        var dataType = $(this).closest("div#panel-project-totals-chart").find("select[name=data-type] option:selected").val();
        var contractId = $(this).closest("div#panel-project-totals-chart").find("select[name=contract-number] option:selected").val();
        getProjectTotalsChart(date, dataType, contractId);
    });
    $('#panel-projects-evolution-chart input[name=report-year]').on("dp.change",function(e){
        var date = new Date(e.date);
        var dataType = $(this).closest("div#panel-projects-evolution-chart").find("select[name=data-type] option:selected").val();
        var contractId = $(this).closest("div#panel-projects-evolution-chart").find("select[name=contract-number] option:selected").val();
        getProjectsEvolutionChart(date.getFullYear(), dataType, contractId);
    });
    $(document).on("change",'#panel-projects-evolution-chart select[name=data-type], #panel-projects-evolution-chart select[name=contract-number]',function(){
        var date = $(this).closest("div#panel-projects-evolution-chart").find("input[name=report-year]").val();
        var dataType = $(this).closest("div#panel-projects-evolution-chart").find("select[name=data-type] option:selected").val();
        var contractId = $(this).closest("div#panel-projects-evolution-chart").find("select[name=contract-number] option:selected").val();
        getProjectsEvolutionChart(date, dataType, contractId);
    });
    $('#panel-system-chart select').on("change",function(){
        var projectSystem = $('#panel-system-chart select[name=project-system] option:selected').val();
        var managementBy = $('#panel-system-chart select[name=management-by] option:selected').val();
        var contractNumber = $('#panel-system-chart select[name=contract-number] option:selected').val();
        var dataType = $('#panel-system-chart select[name=data-type] option:selected').val();
        getSystemReport(managementBy, contractNumber, dataType);
    });
});

function getExecutiveSummary(system, management, contract, dataType)
{
    var system = typeof system !== 'undefined' ? system : "";
    var management = typeof management !== 'undefined' ? management : "";
    var contract = typeof contract !== 'undefined' ? contract : "";
    var dataType = typeof dataType !== 'undefined' ? dataType : "totalProjectsBySection";
    var $content = $("#executive-summary-chart-content");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getExecutiveSummary',
        dataType  :"json",
        type : "POST",
        data:{system:system, management:management, contract:contract, dataType:dataType},
        success:function(response){
            var data  = {
                category: 'title',
                value: dataType,
                list:response.list
            };
            var chartHandler = new ChartHandler("executive-summary-chart-content");
            chartHandler.launchPieChart(data);
        }
    });
}

function getProjectTotalsChart(year, dataType, contractId)
{
    year = typeof year !== 'undefined' ? year : (new Date()).getFullYear();
    dataType = typeof dataType !== 'undefined' ? dataType : "countId";
    contractId = typeof contractId !== 'undefined' ? contractId : "";
    var $content = $("#project-totals-chart-content");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getProjectTotalsTable',
        dataType  :"json",
        type : "POST",
        data:{year:year,dataType:dataType, contractId:contractId},
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

function getProjectsEvolutionChart(year, dataType, contractId)
{
    year = typeof year !== 'undefined' ? year : (new Date()).getFullYear();
    dataType = typeof dataType !== 'undefined' ? dataType : "countId";
    contractId = typeof contractId !== 'undefined' ? contractId : "";
    var $content = $("#projects-evolution-chart-content");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getProjectTotalsTable',
        dataType  :"json",
        type : "POST",
        data:{year:year, dataType:dataType, contractId:contractId},
        success:function(response){
            var projectTotalsTable = new ChartHandler("projects-evolution-chart-content");
            projectTotalsTable.launchHorizontalBarChart(response.data);
        }
    });
}

function getSystemReport(management, contract, dataType)
{
    var management = typeof management !== 'undefined' ? management : "";
    var contract = typeof contract !== 'undefined' ? contract : "";
    var dataType = typeof dataType !== 'undefined' ? dataType : "total_projects";
    var $content = $("#system-chart-content");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getSystemReport',
        dataType  :"json",
        type : "POST",
        data:{management:management, contract:contract, dataType:dataType},
        success:function(response){

            var data  = {
                category: 'system',
                value: dataType,
                list:response.data
            };
            var chartHandler = new ChartHandler("system-chart-content");
            chartHandler.launchPieChart(data);
            console.log(response);
        }
    });
}