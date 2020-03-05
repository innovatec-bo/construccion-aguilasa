/**
 * Created by Jair on 30/05/2018.
 */

$(function() {
    window['moment-range'].extendMoment(moment);
    let incidentHandler = new IncidentHandler();
    incidentHandler.getAllIncidents();
    $("#days-without-incidents").text(incidentHandler.daysWithoutIncidents);
    let workPlanHandler = new WorkPlanHandler();
    workPlanHandler.printWorkPlanSummary("2020-03-01","2020-03-25");
    workPlanHandler.loadEventHandlers();
    // $("#incident-content").perfectScrollbar({
    //     wheelPropagation: true
    // });
    // daysWithoutIncidents();
    
});

// function daysWithoutIncidents()
// {
//     let lastIncidentDate = $($("#incident-content a")[0]).data("incident-date");
//     let days = "";
//     $("#days-without-incidents").text(days);
// }