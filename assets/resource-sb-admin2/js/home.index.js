/**
 * Created by Jair on 30/05/2018.
 */

$(function() {
    window['moment-range'].extendMoment(moment);
    let incidentHandler = new IncidentHandler();
    incidentHandler.getAllIncidents();
    $("#days-without-incidents").text(incidentHandler.daysWithoutIncidents);

    let startMonth = moment().format("YYYY-MM-01");
    let endMonth = moment().endOf('month').format("YYYY-MM-DD");
    let workPlanHandler = new WorkPlanHandler();
    workPlanHandler.printWorkPlanSummary(startMonth, endMonth);
    workPlanHandler.loadEventHandlers();
    // $("#incident-content").perfectScrollbar({
    //     wheelPropagation: true
    // });
    // daysWithoutIncidents();

    $('input[name=work-plan-report-from]').datetimepicker({
        defaultDate: moment().startOf('month').format('YYYY-MM-DD'),
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        locale:'es'
    });

    $('input[name=work-plan-report-to]').datetimepicker({
        ignoreReadonly: true,
        defaultDate:moment().endOf('month').format('YYYY-MM-DD'),
        format: 'DD-MM-YYYY',
        locale:'es',
        useCurrent: false
    });
});

// function daysWithoutIncidents()
// {
//     let lastIncidentDate = $($("#incident-content a")[0]).data("incident-date");
//     let days = "";
//     $("#days-without-incidents").text(days);
// }