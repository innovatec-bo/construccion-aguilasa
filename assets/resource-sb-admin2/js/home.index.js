/**
 * Created by Jair on 30/05/2018.
 */

$(function() {
    let incidentHandler = new IncidentHandler();
    incidentHandler.getAllIncidents();
    $("#days-without-incidents").text(incidentHandler.daysWithoutIncidents);
    // daysWithoutIncidents();
});

// function daysWithoutIncidents()
// {
//     let lastIncidentDate = $($("#incident-content a")[0]).data("incident-date");
//     let days = "";
//     $("#days-without-incidents").text(days);
// }