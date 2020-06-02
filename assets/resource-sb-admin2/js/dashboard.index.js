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
    getAmountWorked();

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
        let $content = $("#panel-main-report-control-filter");
        let year = $content.find('input[name=report-year]').val();
        let inputData = getInputData();
        if(typeof getProjectProgressBySection === "function")
            getProjectProgressBySection("","",inputData.contractNumber);
        if(typeof getContractTimeProgress === "function")
            getContractTimeProgress(inputData.contractNumber);
        if(typeof getExecutiveSummary === "function")
        {
            getExecutiveSummary($("#executive-summary-units-chart-content"), "totalProjectsBySection",inputData.projectSystem, inputData.managementBy, inputData.contractNumber);
            getExecutiveSummary($("#executive-summary-amounts-chart-content"), "totalApprovedBudgetBySection", inputData.projectSystem, inputData.managementBy, inputData.contractNumber);
            getExecutiveSummary($("#executive-summary-contract-percentage-chart-content"), "contractAmountPercentageBySection", inputData.projectSystem, inputData.managementBy, inputData.contractNumber);
        }

        let dataType = $("#panel-project-totals-chart").find("select[name=data-type] option:selected").val();
        if(typeof getProjectTotalsChart === "function")
            getProjectTotalsChart(year,dataType,inputData.contractNumber);
        dataType = $("#panel-projects-evolution-chart").find("select[name=data-type] option:selected").val();
        if(typeof getProjectsEvolutionChart === "function")
            getProjectsEvolutionChart(year,dataType,inputData.contractNumber);
        dataType = $("#panel-system-chart").find("select[name=data-type] option:selected").val();
        if(typeof getSystemReport === "function")
            getSystemReport(inputData.managementBy, inputData.contractNumber, dataType);
        // console.log(year, inputData.projectSystem, inputData.managementBy, inputData.contractNumber);
    });

    $("#panel-main-report-control-filter").on("dp.change", "input[name=report-year]", function(e){
        let $content = $("#panel-main-report-control-filter");
        let year = e.date === false?"":new Date(e.date).getFullYear();
        let inputData = getInputData($content);
        if(typeof getProjectTotalsChart === "function")
            getProjectTotalsChart(year,undefined,inputData.contractNumber);
        if(typeof getProjectsEvolutionChart === "function")
            getProjectsEvolutionChart(year,undefined,inputData.contractNumber);
    });
    //end - general filter;
    $(document).on("click",".executive-summary-selective-download",function(e){
        e.preventDefault();
        let $td = $(this).closest("td");
        let keyword = $td.closest("tr").data("keyword-list");
        let contractId = $("#panel-current-status-summary-report").find("select[name=contract-number]").val();
        let $form = $("form[name=workflow-with-parameters]");
        $form.find("input[name=status-keyword]").val(keyword);
        $form.find("input[name=keyword]").val("");
        $form.find("input[name=year]").val("");
        $form.find("input[name=month]").val("");
        $form.find("input[name=rowKey]").val("");
        $form.find("input[name=contract-id]").val(contractId);
        $form.submit();
    });

    $(document).on("click",".status-summary-selective-download",function(e){
        e.preventDefault();
        let $td = $(this).closest("td");
        let keyword = $td.closest("tr").attr("class");
        let contractId = $td.closest(".panel").find("select[name=contract-number]").val();
        let $form = $("form[name=workflow-with-parameters]");
        $form.find("input[name=status-keyword]").val(keyword);
        $form.find("input[name=keyword]").val("");
        $form.find("input[name=year]").val("");
        $form.find("input[name=month]").val("");
        $form.find("input[name=rowKey]").val("");
        $form.find("input[name=contract-id]").val(contractId);
        $form.submit();
    });

    $(document).on("click",".find-th",function(e){
        e.preventDefault();
        let $td = $(this).closest("td");
        let $th = $td.closest('table').find('th').eq($td.index());

        let keyword = $td.closest(".panel.panel-default").find("select[name=keyword] option:selected").val();
        let year = $td.closest(".panel.panel-default").find("input[name=building-report-year]").val();
        let month = $th.data("month");
        let rowKey = $td.closest("tr").attr("class");
        let $form = $("form[name=workflow-with-parameters]");
        $form.find("input[name=status-keyword]").val("");
        $form.find("input[name=keyword]").val(keyword);
        $form.find("input[name=year]").val(year);
        $form.find("input[name=month]").val(month);
        $form.find("input[name=rowKey]").val(rowKey);
        $form.submit();
    });

    $('input[name=stake-report-from]').datetimepicker({
        defaultDate: moment().startOf('month').format('YYYY-MM-DD'),
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        locale:'es'
    });

    $('input[name=stake-report-to]').datetimepicker({
        ignoreReadonly: true,
        defaultDate:moment().endOf('month').format('YYYY-MM-DD'),
        format: 'DD-MM-YYYY',
        locale:'es',
        useCurrent: false
    });

    $('input[name=builder-report-from]').datetimepicker({
        defaultDate: moment().startOf('month').format('YYYY-MM-DD'),
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        locale:'es'
    });

    $('input[name=builder-report-to]').datetimepicker({
        ignoreReadonly: true,
        defaultDate:moment().endOf('month').format('YYYY-MM-DD'),
        format: 'DD-MM-YYYY',
        locale:'es',
        useCurrent: false
    });

    $(document).on("submit","form.builder-manpower-productivity-report", function(e){
        e.preventDefault();
        let builderId = $("select[name=builder-productivity-report-builder] option:selected").val();
        let month = $("select[name=builder-productivity-report-month] option:selected").val();
        let year = $("select[name=builder-productivity-report-year] option:selected").val();
        if(builderId == "" || month == "" || year == "" )
        {
            toastr.error("Debe especificar un constructor, mes y anio para descagar el reporte", '', {'progressBar':true});
        }
        else
        {
            window.location.href = base_url+"panel/Dashboard/productivityReport/"+builderId+"/"+month+"/"+year;
        }
    });

    $(document).on("submit","form.builder-general-report", function(e){
        e.preventDefault();
        let month = $("select[name=builder-general-report-month] option:selected").val();
        let year = $("select[name=builder-general-report-year] option:selected").val();
        if(month == "" || year == "")
        {
            toastr.error("Debe especificar un mes y anio para descargar el reporte", '', {'progressBar':true});
        }
        else
        {
            window.location.href = base_url+"panel/Dashboard/builderGeneralReport/"+month+"/"+year;
        }
        
    });

    $(document).on("submit","form.projects-and-current-production", function(e){
        e.preventDefault();
        window.location.href = base_url+"panel/Dashboard/ProjectBudgets/asd";
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

function getAmountWorked()
{
     $.ajax({
        url : base_url + 'panel/AjaxDashboard/getAmountWorked',
        dataType  :"json",
        type : "POST",
        success:function(response){
            moment.locale('es');
            $("#dashboard-total-amount-worked").text(response.totalWorkedUp);
            $("#dashboard-total-quantity-projects-worked").text(response.totalProjects);
            $("#dashboard-amount-worked-month").text(moment().format('MMMM'));
            console.log(response);
        }
    });
}