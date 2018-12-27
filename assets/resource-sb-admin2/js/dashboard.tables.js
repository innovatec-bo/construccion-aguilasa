/**
 * Created by Jair on 30/05/2018.
 */

$(document).ready(function() {
    getProjectTotalsTable();
    getProjectNetBuilding();
    getCurrentStatusSummary();
    getExecutiveSummary();
    startSelect2TrackingList();
    var date = new Date();
    $('.date-time').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'YYYY'
    });
    $('#panel-report-project-totals-table input[name=report-year]').on("dp.change",function(e){
        var date = new Date(e.date);
        var dataType = $(this).closest("div#panel-report-project-totals-table").find("select[name=data-type] option:selected").val();
        var contractId = $(this).closest("div#panel-report-project-totals-table").find("input[name=contract-number]").val();
        getProjectTotalsTable(date.getFullYear(), dataType, contractId);
    });

    $(document).on("change",'#panel-report-project-totals-table select[name=data-type], #panel-report-project-totals-table select[name=contract-number]',function(){
        var date = $(this).closest("div#panel-report-project-totals-table").find("input[name=report-year]").val();
        var dataType = $(this).closest("div#panel-report-project-totals-table").find("select[name=data-type] option:selected").val();
        var contractId = $(this).closest("div#panel-report-project-totals-table").find("select[name=contract-number] option:selected").val();
        getProjectTotalsTable(date, dataType, contractId);
    });

    $('input[name=building-report-year]').on("dp.change",function(e){
        var date = new Date(e.date);
        var keyword = $('select[name=keyword] option:selected').val();
        getProjectNetBuilding(date.getFullYear(), keyword);
    });

    $('select[name=keyword]').on("change",function(e){
        var year = $('input[name=building-report-year]').val();
        var keyword = $(this).val();
        getProjectNetBuilding(year, keyword);
    });

    $('#panel-current-status-summary-report select').on("change",function(){
        var projectSystem = $('#panel-current-status-summary-report select[name=project-system] option:selected').val();
        var managementBy = $('#panel-current-status-summary-report select[name=management-by] option:selected').val();
        var contractNumber = $('#panel-current-status-summary-report select[name=contract-number] option:selected').val();
        getCurrentStatusSummary(projectSystem, managementBy, contractNumber);
        getExecutiveSummary(projectSystem, managementBy, contractNumber);
    });

    $(document).on("click",".find-th",function(e){
        e.preventDefault();
        var $td = $(this).closest("td");
        var $th = $td.closest('table').find('th').eq($td.index());

        var keyword = $td.closest(".panel.panel-default").find("select[name=keyword] option:selected").val();
        var year = $td.closest(".panel.panel-default").find("input[name=building-report-year]").val();
        var month = $th.data("month");
        var rowKey = $td.closest("tr").attr("class");
        var $form = $("form[name=workflow-with-parameters]");
        $form.find("input[name=keyword]").val(keyword);
        $form.find("input[name=year]").val(year);
        $form.find("input[name=month]").val(month);
        $form.find("input[name=rowKey]").val(rowKey);
        $form.submit();
    });

    $("input[type=radio][name=workflow-additional-actions]").on("change",function(){
       var action = $(this).val();
       switch (action)
       {
           case "1":
                $("input[name=tracking-list-name]").closest("div").slideDown();
               break;
           default:
               $("input[name=tracking-list-name]").closest("div").slideUp();

       }
    });

    $(".select2.tracking-list").on('select2:select', function (e) {
        var data = e.params.data;
        var codeList = data.code_list;
        $("textarea[name=code-list]").val(codeList);
        // console.log(data);
    });

    $("form[name=workflow-report]").on("submit", function(){
        var additionalActions = $("input[name=workflow-additional-actions]:checked").val();
        if(additionalActions !== "3")
        {
            saveTrackingList();
        }
    });
});

function getProjectTotalsTable(year, dataType, contractId)
{
    year = typeof year !== 'undefined' ? year : (new Date()).getFullYear();
    dataType = typeof dataType !== 'undefined' ? dataType : "countId";
    contractId = typeof contractId !== 'undefined' ? contractId : "";
    var $content = $("#report-project-totals-table");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getProjectTotalsTable',
        dataType  :"json",
        type : "POST",
        data:{year:year, dataType:dataType, contractId:contractId},
        success:function(response){

            if(response.success === 1)
            {
                var htmlSource   = $("#ht-report-project-totals-table").html();
                var template = Handlebars.compile(htmlSource);
                var data = {projectTotalsList:response.data};
                var html = template(data);

            }
            $content.html(html);
        }
    });
}

function getProjectNetBuilding(year, keyword)
{
    year = typeof year !== 'undefined' ? year : (new Date()).getFullYear();
    keyword = typeof keyword !== 'undefined' ? keyword : "project_has_been_created";
    var $content = $("#net-building-report");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getProjectNetBuilding',
        dataType  :"json",
        type : "POST",
        data:{year:year, keyword:keyword},
        success:function(response){

            if(response.success === 1)
            {
                var htmlSource   = $("#ht-report-net-building-table").html();
                var template = Handlebars.compile(htmlSource);
                var data = {projectTotalsList:response.data};
                var html = template(data);
            }
            $content.html(html);
        }
    });
}

function getCurrentStatusSummary(system, management, contract)
{
    var system = typeof system !== 'undefined' ? system : "";
    var management = typeof management !== 'undefined' ? management : "";
    var contract = typeof contract !== 'undefined' ? contract : "";
    var $content = $("#current-status-summary-report");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getCurrentStatusSummary',
        dataType  :"json",
        type : "POST",
        data:{system:system, management:management, contract:contract},
        success:function(response){

            if(response.success === 1)
            {
                var htmlSource   = $("#ht-report-current-status-summary").html();
                var template = Handlebars.compile(htmlSource);
                var data = {statusSummary:response.data};
                var html = template(data);
            }
            $content.html(html);
        }
    });
}

function saveTrackingList()
{
    var $formData = $("form[name=workflow-report]");
    blockArea($formData);
    $.ajax({
        url : base_url + 'panel/AjaxTrackingList/saveTrackingList',
        dataType  :"json",
        type : "POST",
        data:$formData.serialize(),
        success:function(response){
            $formData.unblock();
            var messageType = "error";
            if(response.success == 1)
                messageType = "success";

            swal({ title:'', text:response.message, type:messageType});
            $("#workflow-additional-actions3").prop("checked", true);
            $("input[name=tracking-list-name]").closest("div").slideUp();
            $('.select2.tracking-list').select2('destroy');
            startSelect2TrackingList()

        }
    });
}
function startSelect2TrackingList(selector)
{
    selector = selector || '.select2.tracking-list';
    $(selector).select2({
        placeholder: "Puede seleccionar una lista de seguimiento",
        containerCssClass: 'select-xs',
        allowClear : true,
        ajax : {
            url : base_url + 'panel/AjaxTrackingList/select2',
            dataType : "json",
            type : "post",
            delay : 600,
            data : function(params) {
                return {
                    term : params.term || "", //search term
                    limit : 5, // page size
                    page: params.page || 1
                };
            },

            processResults: function (data) {
                return {
                    results: data.list,
                    pagination: data.pagination
                };
            }
        },
        width : "100%"
    });
}
function getExecutiveSummary(system, management, contract)
{
    var system = typeof system !== 'undefined' ? system : "";
    var management = typeof management !== 'undefined' ? management : "";
    var contract = typeof contract !== 'undefined' ? contract : "";
    var $content = $("#executive-summary-report");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getExecutiveSummary',
        dataType  :"json",
        type : "POST",
        data:{system:system, management:management, contract:contract},
        success:function(response){
            // if(response.success === 1)
            // {
            var htmlSource   = $("#ht-report-executive-summary").html();
            var template = Handlebars.compile(htmlSource);
            var data = {executiveSummary:response};
            var html = template(data);
            // }
            $content.html(html);
        }
    });
}