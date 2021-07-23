/* eslint-env browser */
	/* eslint
	semi: ["error", "always"],
	indent: [2, "tab"],
	no-tabs: 0,
	no-multiple-empty-lines: ["error", {"max": 2, "maxEOF": 1}],
	one-var: ["error", "always"] */
	/* global REDIPS */

	/* enable strict mode */
	// 'use strict';

	// create redips container
	var redips = {};

	// REDIPS.table initialization
	redips.init = function () {
		// define reference to the REDIPS.table object
		var rt = REDIPS.table;
		// activate onmousedown event listener on cells within table with id="mainTable"
		rt.onMouseDown('items-summary-list', true);
		// show cellIndex (it is nice for debugging)
		// rt.cellIndex(true);
		// define background color for marked cell
		rt.color.cell = '#9BB3DA';
	};

	// function merges table cells
	redips.merge = function () {
		// first merge cells horizontally and leave cells marked
		REDIPS.table.merge('h', false);
		// and then merge cells vertically and clear cells (second parameter is true by default)
		REDIPS.table.merge('v');
	};

	// function splits table cells if colspan/rowspan is greater then 1
	// mode is 'h' or 'v' (cells should be marked before)
	redips.split = function (mode) {
		REDIPS.table.split(mode);
	};

	// insert/delete table row
	redips.row = function (type) {
		REDIPS.table.row('items-summary-list', type);
	};

	// insert/delete table column
	redips.column = function (type) {
		REDIPS.table.column('items-summary-list', type);
	};

	// add onload event listener
	if (window.addEventListener) {
		window.addEventListener('load', redips.init, false);
	}
	else if (window.attachEvent) {
		window.attachEvent('onload', redips.init);
	}
$(document).ready(function() {
		
	printView();
	startSelect2Materials('select.select2-materials','');
	select2Workflow();
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
	$(document).on('change','.select2.workflow', function (e) {
		let data = $(this).select2('data')[0];
		$('input[name=fiscal-name]').val(data.fiscal_responsible);
		$('input[name=builder-name]').val(data.builder_responsible);
		$('input[name=reservation-number]').val(data.approved_reservation_number);
	});
	$(document).on('select2:clear','.select2.workflow', function (e) {
		$('input[name=fiscal-name]').val('');
		$('input[name=builder-name]').val('');
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
		console.log(data);
		// $('input[name=fiscal-name]').val(data.fiscal_responsible);
		// $('input[name=builder-name]').val(data.builder_responsible);
		// $('input[name=reservation-number]').val(data.approved_reservation_number);
	});
	$(document).on('click','.wh-quit-row',function(){
		$(this).closest('tr').remove();
	});
	// $(document).on('select2:clear','.select2.workflow', function (e) {
	// 	$('input[name=fiscal-name]').val('');
	// 	$('input[name=builder-name]').val('');
	// 	$('input[name=reservation-number]').val('');
	// 	$('.select2-materials').val(null).trigger('change');
	// });
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
		.addValidator('validateQuantityToRequestToCre', {
			requirementType: 'integer',
			validateNumber: function(value, requirement, element) {
				return true;;
			}
		});
}

function redipsHeader()
{
	/* eslint-env browser */
/* eslint
   semi: ["error", "always"],
   indent: [2, "tab"],
   no-tabs: 0,
   no-multiple-empty-lines: ["error", {"max": 2, "maxEOF": 1}],
   one-var: ["error", "always"],
   no-trailing-spaces: ["error", { "ignoreComments": true }] */

/* enable strict mode */
'use strict';

// global variables
	var redipsURL = redipsURL || '/javascript/table-td-merge-split/', // eslint-disable-line no-use-before-define
	headerInit;

	// header initialization
	headerInit = function () {
		let header = document.createElement('div'),
			title = document.title,
			href = window.location.href.split('/'),
			indexLink = '<a href="..">index</a>';
		// index link is not needed for main page
		if (href[href.length - 2].startsWith('REDIPS')) {
			indexLink = '';
		}
		// add "header" DIV element
		document.body.insertBefore(header, document.body.firstChild);
		// apply inner HTML
		header.innerHTML = '<div style="color:white;background-color:#1e73be;padding:10px;text-align:center;font-size:20px">' + title + '</div>' +
			'<div style="float:left;width:50%;padding-left:10px"><a href="http://www.redips.net' + redipsURL + '">www.redips.net</a></div>' +
			'<div style="text-align:right;padding-right:10px;margin-bottom:10px">' + indexLink + '</div>';
	};

	// add onload event listener
	if (window.addEventListener) {
		window.addEventListener('load', headerInit, false);
	}
	else if (window.attachEvent) {
		window.attachEvent('onload', headerInit);
	}
}

function startRedips()
{
	/* eslint-env browser */
	/* eslint
	semi: ["error", "always"],
	indent: [2, "tab"],
	no-tabs: 0,
	no-multiple-empty-lines: ["error", {"max": 2, "maxEOF": 1}],
	one-var: ["error", "always"] */
	/* global REDIPS */

	/* enable strict mode */
	// 'use strict';

	// create redips container
	var redips = {};

	// REDIPS.table initialization
	redips.init = function () {
		// define reference to the REDIPS.table object
		var rt = REDIPS.table;
		// activate onmousedown event listener on cells within table with id="mainTable"
		rt.onMouseDown('items-summary-list', true);
		// show cellIndex (it is nice for debugging)
		// rt.cellIndex(true);
		// define background color for marked cell
		rt.color.cell = '#9BB3DA';
	};

	// function merges table cells
	redips.merge = function () {
		// first merge cells horizontally and leave cells marked
		REDIPS.table.merge('h', false);
		// and then merge cells vertically and clear cells (second parameter is true by default)
		REDIPS.table.merge('v');
	};

	// function splits table cells if colspan/rowspan is greater then 1
	// mode is 'h' or 'v' (cells should be marked before)
	redips.split = function (mode) {
		REDIPS.table.split(mode);
	};

	// insert/delete table row
	redips.row = function (type) {
		REDIPS.table.row('items-summary-list', type);
	};

	// insert/delete table column
	redips.column = function (type) {
		REDIPS.table.column('items-summary-list', type);
	};

	// add onload event listener
	if (window.addEventListener) {
		window.addEventListener('load', redips.init, false);
	}
	else if (window.attachEvent) {
		window.attachEvent('onload', redips.init);
	}
}

function mergeCell()
{
	$('#table-body tr').each(function () {
		var $firstRow
		   ,colspan = 0
		$(this).find('td').each(function() {
		  	if ($(this).hasClass('merge')) 
		  	{
				// Save the first cell with class in $firstRow, remove the rest
				colspan === 0 ? $firstRow = $(this) : $(this).remove()
				// Count the number of cells
				colspan++
		  	}
			else if (colspan > 0) 
		  	{
				// Assign the colspan and reset the counter
				$firstRow.attr('rowspan', colspan)
				colspan = 0
		  	}
		})
		if (colspan > 0) 
		{
		  $firstRow.attr('rowspan', colspan)
		  colspan = 0
		}
	});
}