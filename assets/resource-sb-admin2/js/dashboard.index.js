/**
 * Created by Jair on 30/05/2018.
 */

$(document).ready(function() {
    getUsersQuantity();
    getRolesQuantity();
    getProjectTotalsTable();
    var date = new Date();
    $('input[name=report-year]').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'YYYY'
    });
    $('input[name=report-year]').on("dp.change",function(e){
        var date = new Date(e.date);
        getProjectTotalsTable(date.getFullYear());
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