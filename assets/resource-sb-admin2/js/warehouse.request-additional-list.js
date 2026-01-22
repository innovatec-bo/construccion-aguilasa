var additionalList = [];
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
		additionalList.push(select2Data);
	});

	// $(document).on('click', '.wh-add-row', function (e) {
	// 	let select2Data = $('.select2-materials').select2('data')[0];
	// 	let materialCode = select2Data.material_code;
		
	// 	// 1. Buscamos si ya existe una fila con ese código de material
	// 	let existingRow = $(`input[value="${materialCode}"].material[name*="[code]"]`).closest('tr');

	// 	if (existingRow.length > 0) {
	// 		// --- LÓGICA DE SUMA (YA EXISTE) ---
			
	// 		let inputQty = existingRow.find('.quantity');
	// 		console.log(inputQty.val());
	// 		// Obtenemos la cantidad actual (quitando máscaras si es necesario) y la nueva
	// 		let currentQty = parseFloat(inputQty.val()) || 0;
	// 		let newQtyToAdd = parseFloat(select2Data.material_quantity) || 0;
			
	// 		// Actualizamos solo el valor de la cantidad
	// 		inputQty.val(currentQty + newQtyToAdd).trigger('input');
			
	// 		// Aplicamos la máscara de nuevo por si acaso
	// 		inputQty.inputmask();

	// 		console.log(`Material ${materialCode} actualizado. Nueva cantidad: ${currentQty + newQtyToAdd}`);

	// 	} else {
	// 		// --- LÓGICA DE INSERCIÓN (ES NUEVO) ---
			
	// 		let htmlSource = $('#table-row-request-materials-to-cre').html();
	// 		let template = Handlebars.compile(htmlSource);
	// 		let data = {data: select2Data, rowId: Date.now()};
	// 		let html = template(data);
			
	// 		$('#table-body').append(html);
	// 		$(".input-masked").inputmask();
	// 		additionalList.push(select2Data);
	// 	}
	// });

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

	$(document).on('change','input[name=radio-by-material]', function(){
		let value = $(this).val();
		if (value == 'radio-by-structure') 
		{
			$('.wh-add-row').hide();
			$('.wh-add-from-structure-id').show();
			$('.select2-materials').next('.select2-container').hide();
			$('.select2-building-structure').next('.select2-container').show();	
			
		}
		else
		{
			$('.wh-add-row').show();
			$('.wh-add-from-structure-id').hide();
			$('.select2-materials').next('.select2-container').show();
			$('.select2-building-structure').next('.select2-container').hide();	
		}
		
	});
	$('input[name=radio-by-material]').eq(0).trigger('change');
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
                let rowData = {
                    id: value.material.id_mat, 
                    text: "("+value.material.code_mat+") "+value.material.description_mat, 
                    material_id: value.material.id_mat,
                    material_code: value.material.code_mat,
                    material_description: value.material.description_mat,
                    material_quantity: value.quantity
                };

                // 1. Intentar localizar una fila existente por el código de material
                let existingRow = $(`input[value="${rowData.material_code}"].material[name*="[code]"]`).closest('tr');

                if (existingRow.length > 0) {
                    // --- SUMAR SI YA EXISTE ---
                    let inputQty = existingRow.find('.quantity');
                    let currentQty = parseFloat(inputQty.val()) || 0;
                    let qtyToAppend = parseFloat(rowData.material_quantity) || 0;
                    
                    inputQty.val(currentQty + qtyToAppend).trigger('input');
                } else {
                    // --- INSERTAR SI ES NUEVO ---
                    additionalList.push(rowData);
                    let htmlSource = $('#table-row-request-materials-to-cre').html();
                    let template = Handlebars.compile(htmlSource);
                    
                    // Usamos Date.now() + index para asegurar IDs únicos en el bucle rápido
                    let data = {data: rowData, rowId: Date.now() + index};
                    let html = template(data);
                    $('#table-body').append(html);
                }
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

function addMaterialsFromStructureId__(structureId)
{
	let _this = this;
	$.blockUI({ message: '<h2>Obteniendo materiales...</h2>' });
	$.ajax({
		url : base_url + 'panel/AjaxBuildingStructure/getByIdFromV2/'+structureId,
		dataType  :"json",
		type : "GET",
		success:function(response){
			$.each(response.data.default_structure_materials, function(index, value){
				let rowData = {
					id: value.material.id_mat, 
					text: "("+value.material.code_mat+") "+value.material.description_mat, 
					material_id: value.material.id_mat,
					material_code: value.material.code_mat,
					material_description: value.material.description_mat,
					material_quantity: value.quantity
				};
				additionalList.push(rowData);
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