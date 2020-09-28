/**
 * Created by Jair on 10/01/2018.
 */

$(document).ready(function() {

	select2ProjectGeneralList();
    $(document).on("submit","form[name=process-line-form]",function(e){
        e.preventDefault();
        let formData = $(this).serialize();
        enableProcessLine(formData);
    });

	$(document).on("click",".close-popover",function(e){
		e.preventDefault();
		$('.popover').popover('destroy');
	});

	$('.date-time-picker').datetimepicker({
		ignoreReadonly: true,
		defaultDate: moment(),
		format: 'DD-MM-YYYY',
		minDate: moment(),
		locale:'es'
	});

	$(document).on('select2:select','.select2.project', function(e){
		$(this).parsley().validate();
	});

    //Horizontal Icons dataTable
    var oTable = $('#process-lines-enabled-index').dataTable({
		// "order": [[ 9, "asc" ], [ 4, "desc" ]],
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
            url : base_url + 'panel/AjaxProcessLine/ajaxDtAllProcessLines',
            type : 'POST'
        },
        "language": {
                processing: '<h1><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h1>'
        },
        "dom": "<'row'<'col-sm-6'Bl><'col-sm-6 text-right'f>>rt<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
        "lengthMenu": [ [10, 25, 50, 100, 100000], [10, 25, 50,100, 100000] ],
        "columns" : [{
            "data" : "id_prl"
        }, {
            "data" : "code_pro"
        }, {
            "data" : "detail_prl"
        }, {
            "data" : "due_date_prl",
			"render" : function(data, type, row, meta) {
            	let render = "";
            	if(row.due_date_prl !== null)
				{
					render = moment(row.due_date_prl,"YYYY-MM-DD").format('DD-MM-YYYY');
				}
				return render;
			}
        }, {
            "data" : "fiscal_fullname"
        }, {
            "data" : "created_by_fullname"
        }, {
            "defaultContent" : " ",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
            	// var html = '<span class="label label-success">Resuelto</span>';
            	// if(row.fixed_efo != 1)
				// {
				// 	html = '<button type="button" data-original-title="Marcar como resuelto"  data-toggle="tooltip" data-placement="top" class="btn btn-primary mark-as-fixed btn-xs" data-entry-date="'+row.entry_date_efo+'" data-external-observation-id="'+row.id_efo+'">' +
				// 			' <i class="fa fa-check"></i> ' +
				// 			'</button>';
				// }
                return "html";
            }
        }],
        "drawCallback" : function(object) {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
            this.api().column(0).visible(false);
            this.api().column(6).visible(false);
        },
        "buttons": ['excel', 'csv','pdf','print']
    });
    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');
    $('.dataTables_length select').addClass('form-control');
    oTable.fnSetFilteringDelay(1000);
});

function enableProcessLine(formData)
{
    $.ajax({
        url : base_url + 'panel/AjaxProcessLine/add',
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

function sendFormResponse()
{
    $("#process-lines-enabled-index").DataTable().ajax.reload();
}
