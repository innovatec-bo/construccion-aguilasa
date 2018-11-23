/**
 * Created by Jair on 30/05/2018.
 */

$(document).ready(function() {
    getUsersQuantity();
    getRolesQuantity();
    getProjectsQuantity();
    getProjectTotalsTable();
    getProjectNetBuilding();
    getCurrentStatusSummary();
    var date = new Date();
    $('.date-time').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'YYYY'
    });
    $('input[name=report-year]').on("dp.change",function(e){
        var date = new Date(e.date);
        getProjectTotalsTable(date.getFullYear());
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
        var projectSystem = $('select[name=project-system] option:selected').val();
        var managementBy = $('select[name=management-by] option:selected').val();
        getCurrentStatusSummary(projectSystem, managementBy);
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
        console.log(keyword, rowKey, month, year);
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

function getProjectTotalsTable(year)
{
    year = typeof year !== 'undefined' ? year : (new Date()).getFullYear();
    var $content = $("#report-project-totals-table");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getProjectTotalsTable',
        dataType  :"json",
        type : "POST",
        data:{year:year},
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

function getCurrentStatusSummary(system, management)
{
    var system = typeof system !== 'undefined' ? system : "";
    var management = typeof management !== 'undefined' ? management : "";
    var $content = $("#current-status-summary-report");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getCurrentStatusSummary',
        dataType  :"json",
        type : "POST",
        data:{system:system, management:management},
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