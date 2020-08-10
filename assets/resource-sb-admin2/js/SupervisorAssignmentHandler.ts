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
declare let startSelect2LaborCost: any;
declare let PerfectScrollbar : any;
declare let dragula : any;

class SupervisorAssignmentHandler
{
	private _masterTemplate : any;
	private _scrollBarList : any;
    constructor()
    {
    	this._scrollBarList = [];
    }

    public loadDistribution(month, year)
	{
		let _this = this;
		$.ajax({
			url : base_url + 'panel/AjaxSupervisorAssignment/loadDistribution/'+month+'/'+year,
			dataType  :"json",
			method : 'get',
			beforeSend:function(){
				blockArea($('.area-to-block'));
			},
			success:function(response){
				$('.area-to-block').unblock();
				if(response.success === 1)
				{
					_this._masterTemplate = $("<div>"+response.data.template+"</div>");
					//Available builders
					let htmlSource = _this._masterTemplate.find('#ht-available-builders-list').html();
					let template = Handlebars.compile(htmlSource);
					let html = template({data:response.data});
					let $availableBuilderContent = $('#available-builders-content');
					$availableBuilderContent.html(html);

					//Distribution list
					htmlSource = _this._masterTemplate.find('#ht-distribution-list').html();
					template = Handlebars.compile(htmlSource);
					html = template({data:response.data});
					let $distributionContent = $('#distribution-content');
					$distributionContent.html(html);

					_this._applyPerfectScrollBar();
					_this._startDragula();

				}
				else
				{
					toastr.error(response.message, '', {'progressBar':true});
				}
			}
		});
	}

	private _startDragula()
	{
		let $list = $('.perfect-scroll-bar');
		let _this = this;
		let $contentList = [];
		$.each($list, function(index, value){
			$contentList.push(value);
		});
		dragula($contentList, {
			isContainer: function (el) {
				return false; // only elements in drake.containers will be taken into account
			},
			moves: function (el, source, handle, sibling) {
				return true; // elements are always draggable by default
			},
			accepts: function (el, target, source, sibling) {
				return true; // elements can be dropped in any of the `containers` by default
			},
			invalid: function (el, handle) {
				return false; // don't prevent any drags from initiating by default
			}
			// direction: 'vertical',             // Y axis is considered when determining where an element would be dropped
			// copy: false,                       // elements are moved by default, not copied
			// copySortSource: false,             // elements in copy-source containers can be reordered
			// revertOnSpill: false,              // spilling will put the element back where it was dragged from, if this is true
			// removeOnSpill: false,              // spilling will `.remove` the element, if this is true
			// mirrorContainer: document.body,    // set the element that gets mirror elements appended
			// ignoreInputTextSelection: true     // allows users to select input text, see details below
		}).on('drag', function (el) {
			$(el).addClass("draggable-cursor");
			_this._updateScrollBars();
		}).on('drop', function (el) {
			$(el).removeClass("draggable-cursor");
			_this._updateScrollBars();
		}).on('cancel', function (el) {
			$(el).removeClass("draggable-cursor");
		});

	}

	private _applyPerfectScrollBar()
	{
		let $list = $('.perfect-scroll-bar');
		let _this = this;
		$.each($list, function(index, value){
			//Apply perfect scroll bar
			let dataValue = $(value).data('scroll-bar-identifier');
			let ps = new PerfectScrollbar('.perfect-scroll-bar[data-scroll-bar-identifier='+dataValue+']', {
				wheelSpeed: 2,
				wheelPropagation: true,
				minScrollbarLength: 50
			});
			_this._scrollBarList.push(ps);
		});
	}

	private _updateScrollBars()
	{
		$.each(this._scrollBarList, function(index, value){
			value.destroy();
		});
		this._applyPerfectScrollBar();
	}

    public saveDistribution()
    {
        let _this = this;
		let month = $('select[name=month] option:selected').val();
		let year = $('select[name=year] option:selected').val();
        let dataToSave = this._prepareDataToSave();
        $.ajax({
            url : base_url + 'panel/AjaxSupervisorAssignment/saveDistribution/',
            dataType  :"json",
            method : 'post',
            data:{distributionList: dataToSave, month: month, year: year},
            beforeSend:function(){
				blockArea($('.area-to-block'));
            },
            success:function(response){
				$('.area-to-block').unblock();
                if(response.success === 1)
                {
					toastr.success(response.message, '', {'progressBar':true});
                }
                else
                {
                    toastr.error(response.message, '', {'progressBar':true});
                }
            }
        });
    }

    private _prepareDataToSave()
	{
		let $panelList = $('.fiscal-panel');
		let fiscalList = [];
		$.each($panelList, function (index, value) {
			let fiscalId = $(value).data('fiscal-id');
			let $builderListGroup = $(value).find('.builder-list-group').children('.list-group-item');
			let fiscal = {'fiscalId': fiscalId, 'builderList':[]};
			let builderList = [];
			$.each($builderListGroup, function (index, value) {
				let builderId = $(value).data('builder-id');
				let builder = {'builderId': builderId};
				builderList.push(builder);
			});
			fiscal.builderList = builderList;
			fiscalList.push(fiscal);
		});

		return fiscalList;
	}

    public loadEventHandlers()
    {
        let _this    = this;
        $(document).on('click','.load-distribution-list', function(){
			let month = $('select[name=month] option:selected').val();
			let year = $('select[name=year] option:selected').val();
			_this.loadDistribution(month, year);
		});
		$(document).on('click','.save-distribution-list', function(){

			_this.saveDistribution();
		});
    }
}
