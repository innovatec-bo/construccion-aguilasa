/**
 * Created by Jair on 07/07/2019.
 */

$(document).ready(function() {
    let url = $(location).attr('href').split("/");
    let projectId = parseInt(url[url.length - 1]);
    let manpowerHandler = new ManpowerHandler(projectId);
    manpowerHandler.loadBuildingPoints();
    manpowerHandler.loadManpowerLog();
    manpowerHandler.loadEventHandler();
});
