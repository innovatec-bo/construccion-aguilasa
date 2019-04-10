/**
 * Created by Jair on 08/04/2019
 */

$(function() {
    let minDate = new Date("2019-04-08 00:00:00");
    let maxDate = moment().subtract(1, "days");
    $('input[name=initial-log]').datetimepicker({
        defaultDate:minDate,
        minDate: minDate,
        // maxDate:maxDate,
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        locale:'es'
    });

    $('input[name=final-log]').datetimepicker({
        ignoreReadonly: true,
        defaultDate:maxDate,
        maxDate:maxDate,
        format: 'DD-MM-YYYY',
        locale:'es',
        useCurrent: false
    });
    startDifferential();
    $('input[name=initial-log]').on("dp.show", function () {
        let initialLogMaxDate = moment($('input[name=final-log]').data('DateTimePicker').date()).subtract(1, "days");
        $('input[name=initial-log]').data("DateTimePicker").maxDate(initialLogMaxDate);
    });
    $('input[name=final-log]').on("dp.show", function () {
        let finalLogMinDate = moment($('input[name=initial-log]').data('DateTimePicker').date()).add(1, "days");
        $('input[name=final-log]').data("DateTimePicker").minDate(finalLogMinDate);
    });

    $('input[name=initial-log]').on("dp.change", function () {
        startDifferential();
    });

    $('input[name=final-log]').on("dp.change", function (e) {
        startDifferential();
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
            let htmlSource   = $("#ht-report-executive-summary-differential-result").html();
            let template = Handlebars.compile(htmlSource);
            let data = {log:response.log};
            let html = template(data);
            $content.html(html);
        }
    });
}
function startDifferential()
{
    let initialDateMoment = moment($('input[name=initial-log]').data('DateTimePicker').date(), "DD-MM-YYYY");
    let finalDateMoment = moment($('input[name=final-log]').data('DateTimePicker').date(), "DD-MM-YYYY");

    let initialDateFormatted = initialDateMoment.format("YYYY-MM-DD");
    let finalDateFormatted = finalDateMoment.format("YYYY-MM-DD");
    getExecutiveSummaryLog("#differential-initial-table", initialDateFormatted);
    getExecutiveSummaryLog("#differential-final-table", finalDateFormatted);
    getExecutiveSummaryDifferential("#differential-table", initialDateFormatted, finalDateFormatted);

    let duration = moment.duration(finalDateMoment.diff(initialDateMoment));
    let days = duration.asDays();
    let message = " dias";
    if(days < 2)
        message = " dia";
    message = days + message;
    $("#differential-quantity-days").text(message);
}