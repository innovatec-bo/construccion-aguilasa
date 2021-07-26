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
	evalDownloadExcelFormat();
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

function evalDownloadExcelFormat()
{
	let summaryId = $('input[name=summary-id]').val();
	if(summaryId !== "")
	{
		$('form[name=download-excel-format]').trigger('submit');
	}
}