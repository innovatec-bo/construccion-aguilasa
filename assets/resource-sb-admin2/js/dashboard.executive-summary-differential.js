/**
 * Created by Jair on 08/04/2019
 */

$(function() {
    let minDate = new Date("2019-04-06 00:00:00");
    let maxDate = moment();
    $('input[name=initial-log]').datetimepicker({
        minDate: minDate,
        maxDate:maxDate,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        locale:'es'
    });

    $('input[name=final-log]').datetimepicker({
        ignoreReadonly: true,
        maxDate:maxDate,
        format: 'DD-MM-YYYY',
        locale:'es',
        useCurrent: false
    });

    $('input[name=initial-log]').on("dp.change", function (e) {
        $('input[name=final-log]').data("DateTimePicker").minDate(e.date);
        // console.log("initial", e.date.getDay());
        let date = moment(e.date, "DD-MM-YYYY").format("YYYY-MM-DD");
        getExecutiveSummaryLog("#differential-initial-table", date);
    });

    $('input[name=final-log]').on("dp.change", function (e) {
        $('input[name=initial-log]').data("DateTimePicker").maxDate(e.date);
        let date = moment(e.date, "DD-MM-YYYY").format("YYYY-MM-DD");
        getExecutiveSummaryLog("#differential-final-table", date);
        console.log("final", e.date);
    });
});

function getExecutiveSummaryLog(content, date)
{
    let $content = $(content);
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getExecutiveSummaryLog/'+date,
        dataType  :"json",
        type : "GET",
        data:{},
        success:function(response){
            let htmlSource   = $("#ht-report-executive-summary-differential").html();
            let template = Handlebars.compile(htmlSource);
            let data = {log:response.log};
            let html = template(data);
            $content.html(html);
            console.log(response);
        }
    });
}

function getExecutiveSummaryDifferential(content, initialDate, finalDate)
{
    let $content = $(content);
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getExecutiveSummaryDifferential/'+initialDate+"/"+finalDate,
        dataType  :"json",
        type : "GET",
        data:{},
        success:function(response){
            let htmlSource   = $("#ht-report-executive-summary-differential").html();
            let template = Handlebars.compile(htmlSource);
            let data = {executiveSummary:response};
            let html = template(data);
            $content.html(html);
        }
    });
}
