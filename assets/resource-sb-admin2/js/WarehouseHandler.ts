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
			case 5:
			case 6:
			case 7:
				$component.slideDown();
				break;
			default:
				$component.slideUp();
		}
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
		});

	}
}
