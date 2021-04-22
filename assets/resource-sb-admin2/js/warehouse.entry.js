$(document).ready(function() {
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


	$('select.select2.project').on('select2:clear', function (e) {
		$('select[name=reservation-number]').html('<option value="">--Elija un Nro. de reserva--</option>');
		$('#table-body').html("");
	});

	$('select[name=reservation-number]').on('change', function (e) {
		let projectId = $('select.select2.project option:selected').val();
		let reservationNumber = $('select[name=reservation-number] option:selected').val();
		warehouse.getSummaryByReservationNumber(projectId, reservationNumber);
	});

	$('.wh-add-new-material').on('click',function(){
		addMaterial();
	});
});


function addMaterial(formData)
{
	let method = formData === undefined?"GET":"POST";
	$.ajax({
		url : base_url + 'panel/AjaxMaterial/add',
		dataType  :"json",
		type : method,
		data:formData,
		success:function(response){
			if(response.success === 1 && !formData)
			{
				launchForm(response,"Form add")
			}
			else if(response.success === 1 && formData)
			{
				toastr.success(response.message, '', {'progressBar':true});
			}
			else
			{
				bootbox.alert({
					title:"Something went wrong!",
					message: response.message,
					size:"medium"
				})
			}
		}
	});
}
function launchForm(response, formTitle)
{
	let htmlSource   = $(response.template).html();
	let template = Handlebars.compile(htmlSource);
	let data = {role:response.role};
	let html    = template(data);
	bootbox.confirm({
		title:formTitle,
		message: html,
		className: "material-modal-form",
		buttons: {
			confirm: {
				label: 'Save',
				className: 'btn-success'
			},
			cancel: {
				label: 'Cancel',
				className: 'btn-danger'
			}
		},
		callback: function (result) {
			if(result)
			{
				let form = $(".material-modal-form form");
				addMaterial(form.serialize());

			}
		}
	});
}
