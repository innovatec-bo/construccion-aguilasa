/**
 * Created by Jair on 07/07/2019.
 */

$(document).ready(function() {
	window['moment-range'].extendMoment(moment);
    let url = $(location).attr('href').split("/");
    let projectId = parseInt(url[url.length - 1]);
	let structureUsageValidator = new StructureUsageValidator('manpower-progress-form');
    let manpowerHandler = new ManpowerHandler(projectId);
    manpowerHandler.setStructureUsageValidator(structureUsageValidator);
    manpowerHandler.loadManpower();
    manpowerHandler.loadManpowerLog();
    manpowerHandler.loadEventHandler();

	let structureUsageValidator2 = new StructureUsageValidator('edit-labor-cost-log-form');
    let laborCostLogHandler = new LaborCostLogHandler(projectId);
    laborCostLogHandler.setStructureUsageValidator(structureUsageValidator2);
    laborCostLogHandler.loadEventHandler();
});
