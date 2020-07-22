/**
 * Created by Jair on 07/07/2019.
 */

$(document).ready(function() {
	window['moment-range'].extendMoment(moment);
    let url = $(location).attr('href').split("/");
    let projectId = parseInt(url[url.length - 1]);





    let manpowerHandler = new ManpowerHandler(projectId);
	manpowerHandler.loadEventHandler();

	let structureUsageValidator = new StructureUsageValidator('point-to-point-progress-form');

	let pointToPointHandler = new PointToPointHandler(projectId);
	pointToPointHandler.setStructureUsageValidator(structureUsageValidator);
    pointToPointHandler.loadBuildingPoints();
    pointToPointHandler.loadManpowerLog();
    pointToPointHandler.loadEventHandler();

	let buildingPoint = new BuildingPointHandler(projectId);
	buildingPoint.setPointToPointHandler(pointToPointHandler);
	buildingPoint.loadEventHandlers();

	let structureUsageValidator2 = new StructureUsageValidator('edit-labor-cost-log-form');
    let laborCostLogHandler = new LaborCostLogHandler(projectId);
    laborCostLogHandler.setStructureUsageValidator(structureUsageValidator2);
    laborCostLogHandler.loadEventHandler();

	let pointsLocationHandler = new PointsLocationHandler("maps", projectId);
	pointsLocationHandler.startMap();
	pointsLocationHandler.loadEventHandlers();

	$(document).on('shown.bs.tab', 'a[data-toggle="tab"][href="#point-locations"]', function (e) {
		pointsLocationHandler.startPaginationJs();
	})
});
