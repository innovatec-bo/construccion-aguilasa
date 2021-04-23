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
	private _projectMaterialSummary;
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
		WarehouseHandler.columnsDefinition['quantity_in_warehouse'] = 7;
		WarehouseHandler.columnsDefinition['movement'] = 8;
		WarehouseHandler.columnsDefinition['tension'] = 9;
		WarehouseHandler.columnsDefinition['status'] = 10;
    }

	private _addRow()
	{
		let rowData = $('.select2-materials').select2('data')[0];
		let htmlSource   = $('#table-row').html();
		let template = Handlebars.compile(htmlSource);
		let data = {data:rowData, rowId: Date.now()};
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

		//Search summary from next array by code added to table
		let rowDataSummary = this._projectMaterialSummary.filter(p => p.material_code == rowData.material_code);
		//Get rows using the first column
		let rows = $("td:nth-child(1)").filter(function(){
			return $(this).text() == rowData.material_code;
		}).parent();console.log(rowDataSummary);
		WarehouseHandler._applyRowspan(rows, rowData, rowDataSummary);
		WarehouseHandler.columnsVisibility();
	}

	private _quitRow(btn)
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

	private static _applyRowspan(rows, rowData?, rowDataSummary?)
	{
		//Add colspan
		let toApplyRowspan = ['material_code','material_description','quantity_assigned_materials','quantity_picked_up_from_cre','pending_material_in_cre','quantity_materials_delivered_to_builder','quantity_in_warehouse'];
		for (let columnKey in WarehouseHandler.columnsDefinition)
		{
			let columnIndex = WarehouseHandler.columnsDefinition[columnKey];
			if(toApplyRowspan.indexOf(columnKey) >= 0)
			{
				$.each(rows.find("td:eq("+(columnIndex-1)+")"), function(rowIndex,value){
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
				let projectId = $('select.select2.project option:selected').val();
				if(projectId != "")
					this.getSummaryByReservationNumber(projectId);
		}
	}

	public getSummaryByReservationNumber(projectId, reservationNumber = "")
	{
		let _this = this;
		$.ajax({
			url : base_url + 'panel/AjaxMaterialSummary/getSummaryByReservationNumber/'+projectId+'/'+reservationNumber,
			dataType  :"json",
			type : "GET",
			success:function(response)
			{
				_this._projectMaterialSummary = response;
				// console.log(response);
			}
		});
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
		let projectId = $('select.select2.project option:selected').val();
		$.ajax({
			url : base_url + 'panel/AjaxMaterialSummary/getSummaryListByProjectId/'+projectId,
			dataType  :"json",
			type : "GET",
			success:function(response)
			{
				let htmlSource   = $('#reservation-number-options').html();
				let template = Handlebars.compile(htmlSource);
				let data = {options:response};
				let html = template(data);
				$('select[name=reservation-number]').html(html);
			}
		});
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
						_this._addRow();
					}
				}
			}

		});

		$(document).on('click','.wh-quit-row',function(){
			_this._quitRow(this);
		});

		$('select[name=summary-type]').on('change', function (e) {
			let optionSelected = parseInt($(this).val());
			WarehouseHandler.builderSelectionVisibility();
			_this.reservationNumberVisibility();
			WarehouseHandler.columnsVisibility();
		});

		$('select.select2.project').on('change', function (e) {
			let projectId = $('select.select2.project option:selected').val();
			if(projectId != "")
			{
				//If the reservation number is not
				if(!$("#reservation-number-selection").is(':visible'))
				{
					_this.getSummaryByReservationNumber(projectId);
				}
				$('select[name=reservation-number]').html('<option value="">Cargando..</option>');
				$('#table-body').html("");
				_this.getSummaryListByProjectId();
			}
			console.log('Triggered project select2 change');
		});
	}
}
