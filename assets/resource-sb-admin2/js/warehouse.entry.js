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
	// startSelect2LaborCost('select.select2-labor-cost','');
	const select2BuildingStructure = new BuildingStructureSelect2Component().init();
	const selectLaborCost = new LaborCostComponent().init();
	// startSelect2MaterialsSummary('select.select2-materials','');
	$('select[name=project]').select2({allowClear:true, placeholder:'Elija un proyecto'});
	
	// $('select[name=project]').on('change', function() {
	// 	const newProjectId = $(this).val();
	// 	const $laborSelect = $(selectLaborCost.settings.container);
	// 	$(selectLaborCost.settings.container).empty().trigger('change');
	// 	selectLaborCost.settings.extraData.projectId = newProjectId;
		
	// 	selectLaborCost.clear(); // Esto ahora debería incluir el .empty() que vimos antes

	// 	if ($laborSelect.data('select2')) 
	// 	{
	// 		$laborSelect.select2('close');
	// 		$laborSelect.data('select2').results.clear(); 
	// 	}

	// 	if (newProjectId) 
	// 	{
	// 		selectLaborCost.enable();
	// 	} 
	// 	else 
	// 	{
	// 		selectLaborCost.disable();
	// 	}
	// 	$.blockUI({ message: '<h2>Cargando estructuras...</h2>' });
	// 	setTimeout(() => {
	// 		$.unblockUI();
	// 	}, 3000);
	// });
	let warehouse = new WarehouseHandler();
	warehouse.loadEventHandlers();
	warehouse.reservationNumberVisibility();
	warehouse.loadRequestedData();
	WarehouseHandler.columnsVisibility();
	WarehouseHandler.builderSelectionVisibility();
	// select2ProjectGeneralList();
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