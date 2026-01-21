$(document).ready(function() {
		
	printView();
	startSelect2Materials('select.select2-materials','');
	const select2BuildingStructure = new BuildingStructureSelect2Component().init();
	projectQuickSelect2();
	$('.date-time-picker').datetimepicker({
		ignoreReadonly: true,
		defaultDate: moment(),
		// minDate:minDate,
		locale:"es",
		format: 'DD-MM-YYYY'
	});

	$('.wh-add-new-material').on('click',function(){
		addMaterial();
	});
	$(document).on('change','.project-quick-select2', function (e) {
		let data = $(this).select2('data')[0];
		$.ajax({
			url : base_url + 'panel/AjaxWorkflow/infoForRequestAdditionalToCRE',
			dataType  :"json",
			type : 'post',
			data:{projectId:data.id},
			success:function(response){
				if(response.success === 1)
				{
					$('input[name=fiscal-name]').val(response.data.fiscal_responsible);
					$('select[name=builder-id]').val(response.data.builder_responsible_id);
					$('input[name=reservation-number]').val(response.data.approved_reservation_number);
				}
				else
				{
					bootbox.alert({
						title:"Algo salio mal!",
						message: response.message,
						size:"medium"
					});
				}
			}
		});
		
	});
	$(document).on('select2:clear','.project-quick-select2', function (e) {
		$('input[name=fiscal-name]').val('');
		$('input[name=builder-id]').val('');
		$('input[name=reservation-number]').val('');
		$('.select2-materials').val(null).trigger('change');
	});

	$(document).on('click','.wh-add-row', function (e) {
		let select2Data = $('.select2-materials').select2('data')[0];
		let htmlSource   = $('#table-row-request-materials-to-cre').html();
		let template = Handlebars.compile(htmlSource);
		let data = {data:select2Data, rowId: Date.now()};
		let html = template(data);
		$('#table-body').append(html);
		$(".input-masked").inputmask();
		// $('input[name=fiscal-name]').val(data.fiscal_responsible);
		// $('input[name=builder-id]').val(data.builder_responsible);
		// $('input[name=reservation-number]').val(data.approved_reservation_number);
	});

	$(document).on('click','.wh-add-from-structure-id',function(){
		let project = $('select[name=project]').val();
		let structureData = $('.select2-building-structure').select2('data')[0];
		let structureId = structureData.id;
		if(project == "")
		{
			toastr.error('Debe especificar un proyecto', '', {'progressBar':true});
		}
		else
		{
			if(structureId == "")
			{
				toastr.error('Seleccione una estructura', '', {'progressBar':true});
			}
			else
			{
				addMaterialsFromStructureId(structureId);
			}
		}
	});

	$(document).on('click','.wh-quit-row',function(){
		$(this).closest('tr').remove();
	});
	evalDownloadExcelFormat();

	$('th').click(function(){
		var table = $(this).parents('table').eq(0)
		var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
		this.asc = !this.asc
		if (!this.asc){rows = rows.reverse()}
		for (var i = 0; i < rows.length; i++){table.append(rows[i])}
	});
});

function addMaterialsFromStructureId(structureId)
{
	let _this = this;
	$.blockUI({ message: '<h2>Obteniendo materiales...</h2>' });
	$.ajax({
		url : base_url + 'panel/AjaxBuildingStructure/getByIdFromV2/'+structureId,
		dataType  :"json",
		type : "GET",
		success:function(response){
			$.each(response.data.default_structure_materials, function(index, value){
				let $select2Materials = $(".select2-materials");
				let rowData = { 
					id: value.material.id_mat, 
					text: "("+value.material.code_mat+") "+value.material.description_mat, 
					material_id: value.material.id_mat,
					material_code: value.material.code_mat,
					material_description: value.material.description_mat
				};
				// _this._addRow(rowData);
				// let select2Data = $('.select2-materials').select2('data')[0];
				
				let htmlSource   = $('#table-row-request-materials-to-cre').html();
				let template = Handlebars.compile(htmlSource);
				let data = {data:rowData, rowId: Date.now()+index};
				let html = template(data);
				$('#table-body').append(html);
				
			});
			$(".input-masked").inputmask();
			$('.select2-building-structure').val(null).trigger('change');
		},
		error: function(xhr, status, error) {
			console.error("Error obteniendo materiales:", error);
			toastr.error('No se pudieron obtener los materiales de la estructura', '', {'progressBar':true});
		},
		complete: function() {
			$.unblockUI();
		}
	});
}

function comparer(index) 
{
	return function(a, b) {
		var valA = getCellValue(a, index), valB = getCellValue(b, index)
		return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
	}
}

function getCellValue(row, index)
{ 
	return $(row).children('td').eq(index).text() 
}

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
		.addValidator('validateQuantityToRequestToCre', {
			requirementType: 'integer',
			validateNumber: function(value, requirement, element) {
				return true;;
			}
		});
}

function evalDownloadExcelFormat()
{
	let summaryId = $('input[name=summary-id]').val();
	if(summaryId !== "")
	{
		$('form[name=download-excel-format]').trigger('submit');
	}
}