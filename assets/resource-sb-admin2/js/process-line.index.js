/**
 * Created by Jair on 10/01/2018.
 */

$(document).ready(function() {

	select2ProjectGeneralList();
    $(document).on("submit","form[name=external-observations-form]",function(e){
        e.preventDefault();
        let formData = $(this).serialize();
        addExternalObservation(formData);
    });

	$(document).on("submit","form[name=fix-external-observation]",function(e){
		e.preventDefault();
		let formData = $("form[name=fix-external-observation]").serialize();
		markAsFixed(formData);
	});

	$(document).on("click",".mark-as-fixed",function(e){
		e.preventDefault();
		let $button = $(this);
		launchPopover($button);
	});

	$(document).on("click",".close-popover",function(e){
		e.preventDefault();
		$('.popover').popover('destroy');
	});

	let date = new Date();
	$('.date-time-picker').datetimepicker({
		ignoreReadonly: true,
		defaultDate: date,
		format: 'DD-MM-YYYY',
		maxDate: moment(),
		locale:'es'
	});

	$(document).on('select2:select','.select2.project', function(e){
		$(this).parsley().validate();
	});

    //Horizontal Icons dataTable
    var oTable = $('#external-observation-index').dataTable({
		"order": [[ 9, "asc" ], [ 4, "desc" ]],
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
            url : base_url + 'panel/AjaxExternalObservation/ajaxDtAllExternalObservations',
            type : 'POST'
        },
        "language": {
                processing: '<h1><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h1>'
        },
        "dom": "<'row'<'col-sm-6'Bl><'col-sm-6 text-right'f>>rt<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
        "lengthMenu": [ [10, 25, 50, 100, 100000], [10, 25, 50,100, 100000] ],
        "columns" : [{
            "data" : "id_efo"
        }, {
            "data" : "code_pro"
        }, {
            "data" : "status_name_pst"
        }, {
            "data" : "observation_efo"
        }, {
            "data" : "entry_date_efo",
			"render" : function(data, type, row, meta) {
            	let render = "";
            	if(row.entry_date_efo !== null)
				{
					render = moment(row.entry_date_efo,"YYYY-MM-DD").format('DD-MM-YYYY');
				}
				return render;
			}
        }, {
            "data" : "fiscal_fullname"
        }, {
            "data" : "created_by_fullname"
        }, {
            "data" : "fixed_by_fullname"
        }, {
            "data" : "fix_detail_efo"
        }, {
            "data" : "fixed_efo"
        }, {
            "data" : "fixed_date_efo",
			"render" : function(data, type, row, meta) {
				let render = "";
				if(row.fixed_date_efo !== null)
				{
					render = moment(row.fixed_date_efo,"YYYY-MM-DD").format('DD-MM-YYYY');
				}
				return render;
			}
        }, {
            "defaultContent" : " ",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
            	var html = '<span class="label label-success">Resuelto</span>';
            	if(row.fixed_efo != 1)
				{
					html = '<button type="button" data-original-title="Marcar como resuelto"  data-toggle="tooltip" data-placement="top" class="btn btn-primary mark-as-fixed btn-xs" data-entry-date="'+row.entry_date_efo+'" data-external-observation-id="'+row.id_efo+'">' +
							' <i class="fa fa-check"></i> ' +
							'</button>';
				}
                return html;
            }
        }],
        "drawCallback" : function(object) {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
            this.api().column(0).visible(false);
            this.api().column(9).visible(false);
        },
        "buttons": ['excel', 'csv','pdf','print']
    });
    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');
    $('.dataTables_length select').addClass('form-control');
    oTable.fnSetFilteringDelay(1000);
});

function addExternalObservation(formData)
{
    $.ajax({
        url : base_url + 'panel/AjaxExternalObservation/add',
        dataType  :"json",
        type : "POST",
        data:formData,
        success:function(response){
            if(response.success === 1)
            {
                sendFormResponse();
				toastr.success(response.message, '', {'progressBar':true});
            }
            else
            {
				toastr.error(response.message, '', {'progressBar':true,"timeOut":15000});
            }
        }
    });
}

function markAsFixed(formData)
{
    $.ajax({
        url : base_url + 'panel/AjaxExternalObservation/edit',
        dataType  :"json",
        type : "POST",
        data:formData,
        success:function(response){
            if(response.success === 1)
            {
				$('.popover').popover('destroy');
				sendFormResponse(response);
				toastr.success(response.message, '', {'progressBar':true});
            }
            else
            {
				toastr.error(response.message, '', {'progressBar':true,"timeOut":15000});
            }
        }
    });
}

function launchPopover(DOMObject)
{
	let htmlSource = $("#ht-fix-external-observation").html();
	let template = Handlebars.compile(htmlSource);
	let entryDate = DOMObject.data('entry-date');
	let externalObservationId = DOMObject.data('external-observation-id');
	let html = template({externalObservationId:externalObservationId});
	DOMObject.popover({
		title: "Cerrar observaci&oacute;n",
		content: html,
		placement: 'left',
		html: true,
		trigger: 'click',
		animation: true,
		container: 'body',
		template:'<div class="popover box-shadow-3 no-border" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
	}).popover('show');
	let date = new Date();
	$('.date-time-picker-popover').datetimepicker({
		ignoreReadonly: true,
		defaultDate: date,
		format: 'DD-MM-YYYY',
		maxDate: moment(),
		minDate: moment(entryDate).format('YYYY-MM-DD'),
		locale:'es'
	});
	$('form[name=fix-external-observation]').parsley();
}
function sendFormResponse()
{
    $("#external-observation-index").DataTable().ajax.reload();
}
