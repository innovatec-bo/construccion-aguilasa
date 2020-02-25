$(function() {
	window['moment-range'].extendMoment(moment);
	// var date = new Date();
 //    $('.date-time').datetimepicker({
 //        ignoreReadonly: true,
 //        defaultDate: date,
 //        format: 'YYYY-MM'
 //    });
	let workPlanHandler = new WorkPlanHandler();
	workPlanHandler.edit();
	workPlanHandler.loadEventHandlers();
	
});