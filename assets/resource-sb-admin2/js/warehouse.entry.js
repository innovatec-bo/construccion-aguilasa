$(document).ready(function() {
	let table = $('#items-summary-list').DataTable({
		scrollY:        '100vh',
		scrollCollapse: true,
		paging:         false,
		columns: [
			{ name: 'material_code'},
			{ name: 'material_description'},
			{ name: 'quantity_assigned'},
			{ name: 'quantity_picked_up_from_cre'},
			{ name: 'pending_material_in_cre'},
			{ name: 'quantity_in_warehouse'},
			{ name: 'movement'},
			{ name: 'status'}
		]
	});
	startSelect2Materials('select.select2-materials');
	let warehouse = new WarehouseHandler();
	warehouse.loadEventHandlers();
	WarehouseHandler.columnsVisibility();
	select2ProjectGeneralList();
	$('.date-time-picker').datetimepicker({
		ignoreReadonly: true,
		// defaultDate: minDate,
		// minDate:minDate,
		locale:"es",
		format: 'DD-MM-YYYY'
	});

	$('select.select2.project').on('change', function (e) {
		let projectId = $('select.select2.project option:selected').val();
		if(projectId != "")
		{
			if(!$("#reservation-number-selection").is(':visible'))
			{
				warehouse.getSummaryByReservationNumber(projectId);
			}
			$('select[name=reservation-number]').html('<option>Cargando..</option>');
			$('#table-body').html("");
			getSummaryListByProjectId();

		}
	});
	$('select.select2.project').on('select2:clear', function (e) {
		$('select[name=reservation-number]').html('<option>--Elija un Nro. de reserva--</option>');
		$('#table-body').html("");
	});

	$('select[name=reservation-number]').on('change', function (e) {
		let projectId = $('select.select2.project option:selected').val();
		let reservationNumber = $('select[name=reservation-number] option:selected').val();
		warehouse.getSummaryByReservationNumber(projectId, reservationNumber);
	});
});

function getSummaryListByProjectId()
{
	let projectId = $('select.select2.project option:selected').val();
	$.ajax({
		url : base_url + 'panel/AjaxMaterialSummary/getSummaryListByProjectId/'+projectId,
		dataType  :"json",
		type : "GET",
		success:function(response)
		{
			console.log(response);
			let htmlSource   = $('#reservation-number-options').html();
			let template = Handlebars.compile(htmlSource);
			let data = {options:response};
			let html = template(data);
			$('select[name=reservation-number]').html(html);
		}
	});
}
