/**
 * Created by Jair on 30/05/2018.
 */

$(function() {
	let month = $('select[name=month] option:selected').val();
	let year = $('select[name=year] option:selected').val();

	let supervisorAssignment = new SupervisorAssignmentHandler();
	supervisorAssignment.loadDistribution(month, year);
	supervisorAssignment.loadEventHandlers();
});
