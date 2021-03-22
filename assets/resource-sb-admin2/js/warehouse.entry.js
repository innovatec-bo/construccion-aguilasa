$(document).ready(function() {
	startSelect2Materials('select.select2-materials');
	let warehouseHandler = new WarehouseHandler();
	warehouseHandler.loadEventHandlers();
	select2ProjectGeneralList();
	$('.date-time-picker').datetimepicker({
		ignoreReadonly: true,
		// defaultDate: minDate,
		// minDate:minDate,
		locale:"es",
		format: 'DD-MM-YYYY'
	});
});
