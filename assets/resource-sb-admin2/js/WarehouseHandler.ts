// export {};
declare let toastr: any;
declare let Date: any;
declare let Handlebars: any;
declare let FullCalendar: any;
declare let blockArea: any;
declare let base_url: any;
declare let $: any;
declare let swal: any;
declare let window: any;
declare let moment: any;
declare let google: any;
declare let timbthumbImage : any;

class WarehouseHandler
{
	private _projectMaterialSummary: any[];
	public static columnsDefinition = [];
    constructor()
    {
    	this._projectMaterialSummary = [];
		WarehouseHandler.columnsDefinition['material_code'] = 1;
		WarehouseHandler.columnsDefinition['material_description'] = 2;
		WarehouseHandler.columnsDefinition['quantity_assigned_materials'] = 3;
		WarehouseHandler.columnsDefinition['quantity_picked_up_from_cre'] = 4;
		WarehouseHandler.columnsDefinition['pending_material_in_cre'] = 5;
		WarehouseHandler.columnsDefinition['quantity_materials_delivered_to_builder'] = 6;
		WarehouseHandler.columnsDefinition['request_materials_quantity'] = 7;
		WarehouseHandler.columnsDefinition['quantity_in_warehouse'] = 8;
		WarehouseHandler.columnsDefinition['all_quantity_in_warehouse'] = 9;
		WarehouseHandler.columnsDefinition['movement'] = 10;
		WarehouseHandler.columnsDefinition['tension'] = 11;
		WarehouseHandler.columnsDefinition['status'] = 12;
		WarehouseHandler.columnsDefinition['delivered_to_builder_detail'] = 13;
    }

	private _addRow(rowData)
	{
		//Search summary from next array by code added to table
		let rowDataSummary = this._projectMaterialSummary.filter((p: { material_code: any; }) => p.material_code == rowData.material_code);
		let htmlSource   = $('#table-row').html();
		let template = Handlebars.compile(htmlSource);
		console.log('rowData', rowData);
		let data = {data:rowData, rowId: Date.now()};
		if(rowDataSummary.length > 0)
			data.data = rowDataSummary[0];
		let html = template(data);

		//Add new row: let's get the last row to append the new row after it
		let lastRow = $("td:nth-child(1)").filter(function(){
			return $(this).text() == rowData.material_code;
		}).last().parent();
		//If there is at least one row.
		if(lastRow.length > 0)
			lastRow.after(html);
		//If the tbody is empty.
		else
			$('#table-body').append(html);

		
		//Get rows using the first column
		let rows = $("td:nth-child(1)").filter(function(){
			return $(this).text() == rowData.material_code;
		}).parent();
		WarehouseHandler._applyRowspan(rows, rowData, rowDataSummary);
		WarehouseHandler.columnsVisibility();
		WarehouseHandler._initInputMask();
	}

	private static _initInputMask()
	{
		$(".input-masked").inputmask();
	}

	private _quitRow(btn: any)
	{
		let materialCode = $(btn).closest('tr').find("td:eq(0)").text();
		//Removing entire row
		$(btn).closest('tr').remove();
		//Get rows using the first cell from tr deleted
		let rows = $("td:nth-child(1)").filter(function(){
			return $(this).text() == materialCode;
		}).parent();
		WarehouseHandler._applyRowspan(rows);
		WarehouseHandler.columnsVisibility();
	}

	/**
	 * Add info to each cell(already in dom) and apply the proper rowspan
	 * @param rows 
	 * @param rowData 
	 * @param rowDataSummary 
	 */
	private static _applyRowspan(rows: { find: (arg0: string) => any; length: any; }, rowData?: { [x: string]: string; hasOwnProperty: (arg0: string) => any; }, rowDataSummary?: string | any[])
	{
		//Add colspan
		let toApplyRowspan = ['material_code','material_description','quantity_assigned_materials','quantity_picked_up_from_cre','pending_material_in_cre','quantity_materials_delivered_to_builder','request_materials_quantity','quantity_in_warehouse','all_quantity_in_warehouse'];
		for (let columnKey in WarehouseHandler.columnsDefinition)
		{
			let columnIndex = WarehouseHandler.columnsDefinition[columnKey];
			if(toApplyRowspan.indexOf(columnKey) >= 0)
			{
				$.each(rows.find("td:eq("+(columnIndex-1)+")"), function(rowIndex: number,value: any){
					if(rowDataSummary && rowDataSummary.length > 0)
					{
						let cellValue = rowDataSummary[0][columnKey];
						$(value).text(cellValue);
					}
					else if(rowData)
					{
						let cellValue = "--";
						if(rowData.hasOwnProperty(columnKey))
						{
							cellValue = rowData[columnKey];
						}
						$(value).text(cellValue);
					}
					if(rowIndex == 0)
					{
						$(value).attr('rowspan', rows.length);
						$(value).removeClass('hide');
					}
					else
						$(value).addClass('hide');
				});
			}
		}
	}

	public static builderSelectionVisibility()
	{
		let optionSelected = parseInt($('select[name=summary-type] option:selected').val());
		let $component = $('#builder-selection');
		switch(optionSelected)
		{
			case 4:
			case 10:
			case 11:
			case 14:
			case 15:
			case 17:
			case 18:
				$component.slideDown();
				break;
			default:
				$component.slideUp();
		}
	}

	public reservationNumberVisibility()
	{
		let optionSelected = parseInt($('select[name=summary-type] option:selected').val());
		let $component = $('#reservation-number-selection');
		switch(optionSelected)
		{
			case 8:
			case 3:
				$component.slideDown();
				break;
			default:
				$component.slideUp();
				let projectId = $('select.project option:selected').val();
				if(projectId != "")
					this.getSummaryByReservationNumber(optionSelected, projectId);
		}
	}

	public getSummaryByReservationNumber(summaryType: string | number, projectId: string, reservationNumber = "")
	{
		let _this = this;
		$.ajax({
			url : base_url + 'panel/AjaxMaterialSummary/getSummaryByReservationNumber/'+summaryType+'/'+projectId+'/'+reservationNumber,
			dataType  :"json",
			type : "GET",
			success:function(response: any)
			{
				_this._projectMaterialSummary = response;
			}
		});
	}

	public fillTable()
	{
		let htmlSource   = $('#table-row').html();
		let template = Handlebars.compile(htmlSource);
		let html = "";
		$.each(this._projectMaterialSummary, function(index: number, value: { pending_material_in_cre: number; quantity_in_warehouse: number; quantity_picked_up_from_cre: number}){
			let optionSelected = parseInt($('select[name=summary-type] option:selected').val());
			//If the option selected is 'material_picked_up_from_cre' or 'request_loans_materials' and the "pending_materials_in_cre" is "0" then let's skip that row.
			if((optionSelected == 3 || optionSelected == 15) && value.pending_material_in_cre == 0)
			{
				return true;
			}
			let data = {data:value, rowId: index+Date.now(), rowClass: "", summaryType:optionSelected};
			if(optionSelected == 14)
			{
				if(value.quantity_picked_up_from_cre > 0)
					data.rowClass = "bg-danger text-white";
			}
			html += template(data);
		});
		let $tableBody = $('#table-body');
		WarehouseHandler.emptyTable($tableBody);
		$tableBody.append(html);

	}

	public addMaterialsFromStructureId()
	{
		let structureData = $('.select2-labor-cost').select2('data')[0];
		let laborCostId = structureData.labor_cost_id;
		let _this = this;
		$.blockUI({ message: '<h2>Obteniendo materiales...</h2>' });
		$.ajax({
			url : base_url + 'panel/AjaxLaborCost/getByIdFromV2/'+laborCostId,
			dataType  :"json",
			type : "GET",
			success:function(response: any)
			{
				console.log(response.data.custom_structure_materials);
				$.each(response.data.custom_structure_materials, function(index: any, value: { material_id: any; material_code: string; material_description: string; request_materials_quantity: any; material_quantity: any; material_tension_id: any; material_status_id: any; quantity_in_warehouse: any, all_quantity_in_warehouse: any}){
					let $select2Materials = $(".select2-materials");
					let data = { 
						id: value.material.id_mat, 
						text: "("+value.material.code_mat+") "+value.material.description_mat, 
						material_code: value.material.code_mat,
						material_description: value.material.description_mat
					};
					$select2Materials.select2("trigger", "select", {data: data});
					$select2Materials.trigger('change');
					let rowData = $select2Materials.select2('data')[0];
					_this._addRow(rowData);
					//After add a new row, let's assign the default values
					$select2Materials.val(null).trigger('change');
					// let $rowAdded = $('#table-body tr:last');
					// $rowAdded.find('.quantity').val(value.material_quantity);
					// $rowAdded.find('.quantity').data('quantity-requested',value.material_quantity);
					// $rowAdded.find('.tension').val(value.material_tension_id);
					// $rowAdded.find('.status').val(value.material_status_id);
					// $rowAdded.find('.material').val(value.material_id);
				});
				$('.select2-labor-cost').val(null).trigger('change');
				$.unblockUI();
			}
		});
	}

	public static emptyTable(tableBody: { html: (arg0: string) => void; })
	{
		tableBody.html('');
	}

	public static columnsVisibility()
	{
		let visibleColumns = $('select[name=summary-type]').find(':selected').data('columns');
		visibleColumns = visibleColumns.split(',');
		for (let key in WarehouseHandler.columnsDefinition)
		{
			let value = WarehouseHandler.columnsDefinition[key];
			let $currentColumn = $('td:nth-child('+value+'),th:nth-child('+value+')');
			$currentColumn.hide();
			if(visibleColumns.indexOf(key) >= 0)
			{
				$currentColumn.show();
			}
		}
	}

	public getSummaryListByProjectId()
	{
		let projectId = $('select.project option:selected').val();
		$.ajax({
			url : base_url + 'panel/AjaxMaterialSummary/getSummaryListByProjectId/'+projectId,
			dataType  :"json",
			type : "GET",
			success:function(response: any)
			{
				let htmlSource   = $('#reservation-number-options').html();
				let template = Handlebars.compile(htmlSource);
				let data = {options:response};
				let html = template(data);
				$('select[name=reservation-number]').html(html);
			}
		});
	}

	/**
	 * This method is used in warehouse.entry.js as parley validation
	 */
	public static validateQuantityToMove(element: any) : boolean
	{
		let summaryTypeKeyword : string = $('select[name=summary-type] option:selected').data('keyword');
		let inputValue = $(element).val().replace(',', '');
		let $tr : any = $(element).closest('tr');
		let pendingMaterialInCre : number = typeof $tr.data('pending-material-in-cre') == 'string'?parseFloat($tr.data('pending-material-in-cre').replace(',', '')):parseFloat($tr.data('pending-material-in-cre'));
		let quantitInWarehouse : number = typeof $tr.data('quantity-in-warehouse') == 'string'? parseFloat($tr.data('quantity-in-warehouse').replace(',', '')):parseFloat($tr.data('quantity-in-warehouse'));
		let quantityRequested : number = typeof $tr.find('.quantity') == 'string'?parseFloat($tr.find('.quantity').data('quantity-requested').replace(',', '')):parseFloat($tr.find('.quantity').data('quantity-requested'));
		let response : boolean;
		let message : string;
		switch(summaryTypeKeyword)
		{
			case 'materials_picked_up_from_cre':
				response = inputValue <= pendingMaterialInCre;
				message = 'No puede exceder la cantidad pendiente en CRE';
				break;
			case 'materials_delivered_to_builder':
				response = isNaN(quantityRequested)?true: inputValue <= quantityRequested;
				message = 'No puede llevar mas que la cantidad solicitada.';
				break;
			case 'request_materials':
				response = inputValue <= quantitInWarehouse;
				console.log(inputValue, quantitInWarehouse, inputValue <= quantitInWarehouse);
				message = 'No puede solicitar mas materiales de los que tiene disponible el proyecto en almacen.'
				break;
			default:
				message = '';
				response = true;
		}
		window.Parsley.addMessage('es', 'validateQuantityToMove', message);
		
		// let materialCode = $(element.$element).closest('tr').data('material-code');//element
		// var requestedQuantity = 0;
		// $(".quantity-"+materialCode).each(function() {   
		// 	requestedQuantity += +this.value;
		// });
		return response;
	}

	public loadRequestedData()
	{
		let _this = this;
		if(materialSummary.summary_id !== undefined)
		{
			let $newOption = $("<option selected='selected'></option>").val(materialSummary.project_id).text(materialSummary.project_code)
			$("select[name=project]").append($newOption).trigger('change');
			$("select[name=summary-type]").val(summaryTypeId).trigger('change');
			$("select[name=fiscal]").val(materialSummary.fiscal_id);
			$("select[name=builder]").val(materialSummary.builder_id);
			setTimeout(function () {
				$.each(materialList, function(index: any, value: { material_id: any; material_code: string; material_description: string; request_materials_quantity: any; material_quantity: any; material_tension_id: any; material_status_id: any; quantity_in_warehouse: any, all_quantity_in_warehouse: any}){
					let $select2Materials = $(".select2-materials");
					let data = { 
						id: value.material_id, 
						text: "("+value.material_code+") "+value.material_description, 
						material_code: value.material_code,
						request_materials_quantity: value.request_materials_quantity,
						quantity_in_warehouse: value.quantity_in_warehouse,
						all_quantity_in_warehouse: value.all_quantity_in_warehouse
					};
					$select2Materials.select2("trigger", "select", {data: data});
					$select2Materials.trigger('change');
					let rowData = $select2Materials.select2('data')[0];
					_this._addRow(rowData);
					//After add a new row, let's assign the default values
					$select2Materials.val(null).trigger('change');
					let $rowAdded = $('#table-body tr:last');
					$rowAdded.find('.quantity').val(value.material_quantity);
					$rowAdded.find('.quantity').data('quantity-requested',value.material_quantity);
					$rowAdded.find('.tension').val(value.material_tension_id);
					$rowAdded.find('.status').val(value.material_status_id);
					$rowAdded.find('.material').val(value.material_id);
				});
			},2000);
		}
	}

    public loadEventHandlers()
    {
        let _this    = this;
        $(document).on('click','.wh-add-row',function(){
			let reservationNumberVisible = $("#reservation-number-selection").is(':visible');
			let reservationNumber = $('select[name=reservation-number]').val();
			let project = $('select[name=project]').val();
			let material = $('select[name=materials]').val();
			if(project == "")
			{
				toastr.error('Debe especificar un proyecto', '', {'progressBar':true});
			}
			else
			{
				if(reservationNumberVisible && reservationNumber == "")
				{
					toastr.error('Seleccione un Nro. de reserva', '', {'progressBar':true});
				}
				else
				{
					if(material == "")
					{
						toastr.error('Seleccione un material', '', {'progressBar':true});
					}
					else
					{
						let rowData = $('.select2-materials').select2('data')[0];
						_this._addRow(rowData);
					}
				}
			}

		});

		$(document).on('click','.wh-quit-row',function(){
			_this._quitRow(this);
		});

		$('select[name=summary-type]').on('change', function (e: any) {
			WarehouseHandler.builderSelectionVisibility();
			_this.reservationNumberVisibility();
			WarehouseHandler.columnsVisibility();
		});

		$('select.project').on('select2:clear', function (e: any) {
			$('select[name=reservation-number]').html('<option value="">--Elija un Nro. de reserva--</option>');
			$('#table-body').html("");
			$('.select2-materials').val(null).trigger('change');
		});

		$('select.project').on('change', function (e: any) {
			let projectId = $('select.project option:selected').val();
			let summaryType = parseInt($('select[name=summary-type] option:selected').val());
			if(projectId != "")
			{
				//If the reservation number is not
				if(!$("#reservation-number-selection").is(':visible'))
				{
					_this.getSummaryByReservationNumber(summaryType, projectId);
				}
				$('select[name=reservation-number]').html('<option value="">Cargando..</option>');
				$('#table-body').html("");
				_this.getSummaryListByProjectId();
			}
			$('.select2-materials').val(null).trigger('change');
		});

		$(document).on('click','.wh-show-all-in-table',function(){
			let reservationNumberVisible = $("#reservation-number-selection").is(':visible');
			let reservationNumber = $('select[name=reservation-number]').val();
			let project = $('select[name=project]').val();
			if(project == "")
			{
				toastr.error('Debe especificar un proyecto', '', {'progressBar':true});
			}
			else
			{
				if(reservationNumberVisible && reservationNumber == "")
				{
					toastr.error('Seleccione un Nro. de reserva', '', {'progressBar':true});
				}
				else
				{
					_this.fillTable();
					WarehouseHandler.columnsVisibility();
				}
			}
		});

		$(document).on('click','.wh-add-from-structure-id',function(){
			let reservationNumberVisible = $("#reservation-number-selection").is(':visible');
			let reservationNumber = $('select[name=reservation-number]').val();
			let project = $('select[name=project]').val();
			if(project == "")
			{
				toastr.error('Debe especificar un proyecto', '', {'progressBar':true});
			}
			else
			{
				if(reservationNumberVisible && reservationNumber == "")
				{
					toastr.error('Seleccione un Nro. de reserva', '', {'progressBar':true});
				}
				else
				{
					_this.addMaterialsFromStructureId();
					WarehouseHandler.columnsVisibility();
				}
			}
		});

		$(document).on('select2:opening', '.select2-materials',function(){
			let reservationNumberVisible = $("#reservation-number-selection").is(':visible');
			let reservationNumber = $('select[name=reservation-number]').val();
			let project = $('select[name=project]').val();
			if(project == "")
			{
				toastr.error('Debe especificar un proyecto', '', {'progressBar':true});
				return false;
			}
			else
			{
				if(reservationNumberVisible && reservationNumber == "")
				{
					toastr.error('Seleccione un Nro. de reserva', '', {'progressBar':true});
					return false;
				}
			}
		});

		$(document).on('select2:opening', '.select2-labor-cost',function(){
			let project = $('select[name=project]').val();
			if(project == "")
			{
				toastr.error('Debe especificar un proyecto', '', {'progressBar':true});
				return false;
			}
		});
		$(document).on('click','.wh-clear-table',function(){
			let $tableBody = $('#table-body');
			WarehouseHandler.emptyTable($tableBody);
		});

		$(document).on('click','.wh-set-cero-as-movement', function(){
			$("input.quantity").val("0.00");
		});

		$(document).on('change','input[name=radio-by-material]', function(){
			let value = $(this).val();
			if (value == 'radio-by-structure') 
			{
				$('.wh-add-row').hide();
				$('.wh-add-from-structure-id').show();
				$('.select2-materials').next('.select2-container').hide();
				$('.select2-labor-cost').next('.select2-container').show();	
				
			}
			else
			{
				$('.wh-add-row').show();
				$('.wh-add-from-structure-id').hide();
				$('.select2-materials').next('.select2-container').show();
				$('.select2-labor-cost').next('.select2-container').hide();	
			}
			
		});
		$('input[name=radio-by-material]').eq(0).trigger('change');
	}
}