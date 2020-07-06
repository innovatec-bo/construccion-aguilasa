/**
 * Created by Jair on 07/07/2019.
 */

$(document).ready(function() {
	window['moment-range'].extendMoment(moment);
    let url = $(location).attr('href').split("/");
    let projectId = parseInt(url[url.length - 1]);
    let pointToPointHandler = new PointToPointHandler(projectId);
    pointToPointHandler.loadBuildingPoints();
    pointToPointHandler.loadManpowerLog();
    pointToPointHandler.loadEventHandler();

    let laborCostLogHandler = new LaborCostLogHandler(projectId);
    laborCostLogHandler.loadEventHandler();

	let pointsLocationHandler = new PointsLocationHandler("maps", projectId);
	pointsLocationHandler.startMap();
	pointsLocationHandler.loadEventHandlers();

	$(document).on('shown.bs.tab', 'a[data-toggle="tab"][href="#point-locations"]', function (e) {
		pointsLocationHandler.startPaginationJs();
	})
});
