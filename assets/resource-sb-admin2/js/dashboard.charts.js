/**
 * Created by Jair on 30/05/2018.
 */

$(document).ready(function() {
    getExecutiveSummary($("#executive-summary-units-chart-content"), "totalProjectsBySection");
    getExecutiveSummary($("#executive-summary-amounts-chart-content"), "totalApprovedBudgetBySection");
    getExecutiveSummary($("#executive-summary-contract-percentage-chart-content"), "contractAmountPercentageBySection");
    getProjectTotalsChart();
    getProjectsEvolutionChart();
    getSystemReport();

    $(document).on("change",'#panel-project-totals-chart select[name=data-type]',function(){
        var dataType = $(this).closest("div#panel-project-totals-chart").find("select[name=data-type] option:selected").val();
        var inputData = getInputData();
        getProjectTotalsChart(inputData.year, dataType, inputData.contractNumber);
    });

    $(document).on("change",'#panel-projects-evolution-chart select[name=data-type]',function(){
        var dataType = $(this).closest("div#panel-projects-evolution-chart").find("select[name=data-type] option:selected").val();
        var inputData = getInputData();
        getProjectsEvolutionChart(dataType.year, dataType, inputData.contractNumber);
    });

    $(document).on("change","#panel-system-chart select[name=data-type]",function(){
        var dataType = $('#panel-system-chart select[name=data-type] option:selected').val();
        var inputData = getInputData();
        getSystemReport(inputData.managementBy, inputData.contractNumber, dataType);
    });

    $(document).on("click", ".open-table", function(){
        var $panelContent = $("panel-main-report-control-filter");
        var projectSystem = $panelContent.find('select[name=project-system] option:selected').val();
        var managementBy = $panelContent.find('select[name=management-by] option:selected').val();
        var contractNumber = $panelContent.find('select[name=contract-number] option:selected').val();
        getExecutiveAndCurrentStatusSummary(projectSystem, managementBy, contractNumber);
    });

});

function getExecutiveSummary(content, dataType, system, management, contract)
{
    var system = typeof system !== 'undefined' ? system : "";
    var management = typeof management !== 'undefined' ? management : "";
    var contract = typeof contract !== 'undefined' ? contract : "";
    var dataType = typeof dataType !== 'undefined' ? dataType : "totalProjectsBySection";
    // var $content = $("#executive-summary-chart-content");
    blockArea(content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getExecutiveSummary',
        dataType  :"json",
        type : "POST",
        data:{system:system, management:management, contract:contract, dataType:dataType},
        success:function(response){
            var totalRemain = 0;
            var totalRemainPercentage = 0;
            $.each(response.list, function(index, value){
                if(dataType === "totalProjectsBySection")
                {
                    if(value.totalProjectsBySection <= 0)
                        value.hidden = true;
                }
                else if(dataType === "totalApprovedBudgetBySection")
                {
                    totalRemain = response.totalContractAmount - response.totalApprovedBudget.replace(/,/g, "");
                    if(value.totalApprovedBudgetBySection <= 0)
                        value.hidden = true;
                }
                else if(dataType == "contractAmountPercentageBySection")
                {
                    // totalRemainPercentage += value.contractAmountPercentageBySection;

                    if(value.contractAmountPercentageBySection <= 0)
                        value.hidden = true;
                }
            });

            if(dataType == "totalApprovedBudgetBySection")
            {

                response.list.push({"title": "Total restante", "totalApprovedBudgetBySection": totalRemain});
            }
            else if(dataType == "contractAmountPercentageBySection")
            {
                totalRemainPercentage = 100 - response.totalContractAmountPercentage;
                response.list.push({"title": "Total restante", "contractAmountPercentageBySection": totalRemainPercentage});
            }
            var data  = {
                category: 'title',
                value: dataType,
                list:response.list
            };
            var chartHandler = new ChartHandler(content.prop("id"));
            chartHandler.launchPieChart(data);
        }
    });
}

function getProjectTotalsChart(year, dataType, contractId)
{
    year = typeof year !== 'undefined' ? year : "";
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
    year = typeof year !== 'undefined' ? year : "";
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
            var list = [];
            $.each(response.data, function(index, value){
                if(dataType == "sumBudget")
                {
                    if(value.criteriaKeyword != "project_has_been_created" && value.criteriaKeyword != "already_sent")
                    {
                        list.push(value);
                    }
                }
                else
                {
                    list.push(value);
                }

            });

            var projectTotalsTable = new ChartHandler("projects-evolution-chart-content");
            projectTotalsTable.launchHorizontalBarChart(list);
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

            $.each(response.data, function(index, value){
                if(dataType === "total_projects")
                {
                    if(value.total_projects <= 0)
                        value.hidden = true;
                }
                else if(dataType === "approved_budgets")
                {
                    if(value.approved_budgets <= 0)
                        value.hidden = true;
                }

            });

            var data  = {
                category: 'system',
                value: dataType,
                list:response.data
            };
            var chartHandler = new ChartHandler("system-chart-content");
            chartHandler.launchPieChart(data);
        }
    });
}

function getExecutiveAndCurrentStatusSummary(system, management, contract)
{
    var system = typeof system !== 'undefined' ? system : "";
    var management = typeof management !== 'undefined' ? management : "";
    var contract = typeof contract !== 'undefined' ? contract : "";
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getExecutiveSummaryAndCurrentStatusSummary',
        dataType  :"json",
        type : "POST",
        data:{system:system, management:management, contract:contract},
        success:function(response){

            if(response.success === 1)
            {
                //pre compile sub templates
                var reportCurrentStatusSummary = $("#ht-report-current-status-summary").html();
                Handlebars.registerPartial("ht-report-current-status-summary", reportCurrentStatusSummary);
                var reportExecutiveSummary = $("#ht-report-executive-summary").html();
                Handlebars.registerPartial("ht-report-executive-summary", reportExecutiveSummary);

                var htmlSource   = $("#ht-report-executive-summary-and-current-status-summary").html();
                var template = Handlebars.compile(htmlSource);
                var data = {report:response.data};
                var html = template(data);
                swal({
                    title: "Resumen ejecutivo y Resumen de estados",
                    html: html,
                    width:"100%",
                    allowOutsideClick:false
                });
            }
            else
            {
                swal({html:response.message, type:"error"});
            }

        }
    });
}