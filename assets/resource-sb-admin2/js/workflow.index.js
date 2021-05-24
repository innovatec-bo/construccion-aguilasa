
$(document).ready(function() {
	var additionalParameter = new DTAdditionalParameterHandler("#extra-request-data","#workflow-index");
	additionalParameter.addParameterObject('status','text');
	additionalParameter.addParameterObject('work-area','select');
	additionalParameter.addParameterObject('fiscal-responsible-id','select');
	additionalParameter.addParameterObject('builder-responsible-id','select');
	additionalParameter.addParameterObject('manpower-uploaded','select');
	additionalParameter.addParameterObject('status','select');
	additionalParameter.setButtonFilter('#send-filters');
	additionalParameter.setButtonRest('#remove-additional-parameters');
	additionalParameter.loadEventHandlers();
    //Horizontal Icons dataTable
	let dtColumns = [];
	$.each(columns, function(index, value){
		dtColumns.push({"data":index})
	});
    var oTable = $('#workflow-index').dataTable({
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
            url : base_url + 'panel/AjaxWorkflow/ajaxDtAll',
            type : 'POST',
			data:function ( data ) {
				data.additionalParameters = additionalParameter.getList();
			}
        },
        "language": {
                processing: '<h1><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h1>'
        },
        "dom": "<'row'<'col-sm-6'Bl><'col-sm-6 text-right'f>>rt<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
        "lengthMenu": [ [10, 25, 50, 100, 100000], [10, 25, 50,100, 100000] ],
        "columns" : dtColumns,
        "drawCallback" : function(object) {
            $('[data-toggle="tooltip"]').tooltip();
            // this.api().column(0).visible(false);
        },
        "buttons": ['excel', 'csv']
    });
    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');
    $('.dataTables_length select').addClass('form-control');
    oTable.fnSetFilteringDelay(1000);
});
