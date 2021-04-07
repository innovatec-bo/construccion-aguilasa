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
    constructor()
    {
    }

	private _addRow()
	{
		let rowData = $('.select2-materials').select2('data')[0];
		let htmlSource   = $('#table-row').html();
		let template = Handlebars.compile(htmlSource);
		let data = {data:rowData};
		let html = template(data);
		$('#table-body').append(html);
	}

	private _quitRow(row)
	{
		$(row).closest('tr').remove();
	}

	private static _builderSelectionVisibility(optionSelected?)
	{
		let $component = $('#builder-selection');
		switch(optionSelected)
		{
			case 4:
			case 10:
			case 11:
				$component.slideDown();
				break;
			default:
				$component.slideUp();
		}
	}

	private static _reservationNumberVisibility(optionSelected?)
	{
		let $component = $('#reservation-number-selection');
		switch(optionSelected)
		{
			case 8:
			case 3:
				$component.slideDown();
				break;
			default:
				$component.slideUp();
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
				let htmlSource   = $('#table-row').html();
				let template = Handlebars.compile(htmlSource);
				let html = "";
				console.log(response);
				$.each(response, function(index,value){
					let data = {data:value};
					html += template(data);
				});
				let data = _this._prepareDataTableRow(response);
				let table = $('#items-summary-list').DataTable();
				table.clear().draw();
				table.rows.add(data).draw();
				// $('#table-body').html(html);
				// if ($.fn.DataTable.isDataTable( '#items-summary-list' ) )
				// {
				// 	$('#items-summary-list').DataTable().clear().destroy();
				//
				// }
			}
		});
	}

	private _prepareDataTableRow(list)
	{
		let newData = [];

		$.each(list, function(index, value){

			let statusSelection = '<select class="form-control input-sm" name="summary['+value.material_code+'][status]"><option value="1">NVO</option></select>'
			let row = [
				value.material_code,
				value.material_description,
				value.quantity_assigned,
				value.quantity_picked_up_from_cre,
				value.pending_material_in_cre,
				value.quantity_in_warehouse,
				'<input type="text" name="summary['+value.material_code+'][quantity]" value="0" size="7"><input type="hidden" name="summary['+value.material_code+'][id]" value="'+value.material_id+'" size="7">',
				statusSelection
			];
			newData.push(row);
		});
		return newData;
	}

	public static columnsVisibility()
	{
		let table = $('#items-summary-list').DataTable();
		let columns = $('select[name=summary-type]').find(':selected').data('columns');
		columns = columns.split(',');
		table.columns().visible( false );
		table.columns( columns ).visible( true );
	}

	private static _changeStatusOptionsToChoose()
	{
		let table = $('#items-summary-list').DataTable();
		table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
			let data = this.data();
			let options = '';
			let summaryType = $('select[name=summary-type] option:selected').val();
			switch(summaryType)
			{
				case '1':
					options = '';
					break;
				case '2':
					options = ''
					break;
				case '3':
				case '4':
				case '9':
				case '10':
					options = '<select name="summary['+data[0]+'][status]" class="form-control input-sm"><option value="1">NVO</option></select>'
					break;
				case '8':
				case '12':
					options = '<select name="summary['+data[0]+'][status]" class="form-control input-sm"><option value="1">NVO</option><option value="2">MEO</option><option value="3">RBE</option></select>'
					break;
				case '11':
					options = '<select name="summary['+data[0]+'][status]" class="form-control input-sm"><option value="2">MEO</option><option value="3">RBE</option></select>'
					break;
			}
			data[7] = options;
			this.invalidate();
		} );
	}
	private static _changeStatusOptionsToChoose2()
	{
		let myTable = $('#items-summary-list').DataTable();
		// myTable.column('status:name').nodes().each(function(node){
		let index = 0;
		myTable.column(['material_code:name','status:name']).each(function(node){
			let options = '';
			let summaryType = $('select[name=summary-type] option:selected').val();
			switch(summaryType)
			{
				case '1':
					options = '';
					break;
				case '2':
					options = ''
					break;
				case '3':
				case '4':
				case '9':
				case '10':
					options = '<select name="options" class="form-control input-sm"><option value="1">NVO</option></select>'
					break;
				case '8':
				case '12':
					options = '<select name="options" class="form-control input-sm"><option value="1">NVO</option><option value="2">MEO</option><option value="3">RBE</option></select>'
					break;
				case '11':
					options = '<select name="options" class="form-control input-sm"><option value="2">MEO</option><option value="3">RBE</option></select>'
					break;
			}
			console.log(node);
			// myTable.cell(node).data(options);
			index++;
		});
		console.log(index);

	}

    public loadEventHandlers()
    {
        let _this    = this;
        $(document).on('click','.wh-add-row',function(){
			_this._addRow();
		});

		$(document).on('click','.wh-quit-row',function(){
			_this._quitRow(this);
		});

		$('select[name=summary-type]').on('change', function (e) {
			let optionSelected = parseInt($(this).val());
			WarehouseHandler._builderSelectionVisibility(optionSelected);
			WarehouseHandler._reservationNumberVisibility(optionSelected);
			WarehouseHandler.columnsVisibility();
			WarehouseHandler._changeStatusOptionsToChoose();
		});

		$('form[name=materials-summary]').on('submit',function(e){
			$("#items-summary-list").DataTable().search("").draw();
		});
	}
}
