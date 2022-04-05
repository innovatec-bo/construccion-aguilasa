$(document).ready(function() {
	customValidations();
	printView();
	let additionalParameter = new DTAdditionalParameterHandler("#extra-request-data","");
	additionalParameter.addParameterObject('project','select', 'assigned-to-project');
	let showAssignedMaterialsOnly = $('input[name=show-assigned-materials-only]').val();
	// if(showAssignedMaterialsOnly == 1)
	// 	startSelect2Materials('select.select2-materials','', additionalParameter);
	// else
	// 	startSelect2Materials('select.select2-materials','');
	startSelect2Materials('select.select2-materials','');
	// startSelect2MaterialsSummary('select.select2-materials','');
	$('select[name=project]').select2({allowClear:true,placeholder:'Elija un proyecto'})
	let warehouse = new WarehouseHandler();
	warehouse.loadEventHandlers();
	warehouse.reservationNumberVisibility();
	warehouse.loadRequestedData();
	WarehouseHandler.columnsVisibility();
	WarehouseHandler.builderSelectionVisibility();
	select2ProjectGeneralList();
	$('.date-time-picker').datetimepicker({
		ignoreReadonly: true,
		defaultDate: moment(),
		// minDate:minDate,
		locale:"es",
		format: 'DD-MM-YYYY'
	});

	$('select[name=reservation-number]').on('change', function (e) {
		let summaryType = parseInt($('select[name=summary-type] option:selected').val());
		let projectId = $('select.project option:selected').val();
		let reservationNumber = $('select[name=reservation-number] option:selected').val();
		warehouse.getSummaryByReservationNumber(summaryType, projectId, reservationNumber);
	});

	$('.wh-add-new-material').on('click',function(){
		addMaterial();
	});
	

});


function printView()
{
	let printContents = $("#invoice-template").html();
	if(printContents !== undefined)
	{
		window.print();
	}
}
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

function customValidations()
{
	window.Parsley
		.addValidator('validateQuantityToMove', {
			requirementType: 'integer',
			validateNumber: function(value, requirement, element) {
				return WarehouseHandler.validateQuantityToMove(element.element);
			}
		});

}