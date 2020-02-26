$(function() {
	window['moment-range'].extendMoment(moment);
	let workPlanHandler = new WorkPlanHandler();
	
	workPlanHandler.loadEventHandlers();
	
	var buttonAdd = {
        text: "Nuevo",
        action: function ( e, dt, node, config ) {
            workPlanHandler.add();
        }
    };
    //Horizontal Icons dataTable
    var oTable = $('#work-plan-index').dataTable({
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
            url : base_url + 'panel/AjaxWorkPlan/ajaxDtAllWorkPlans',
            type : 'POST'
        },
        "language": {
                processing: '<h1><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h1>'
        },
        "dom": "<'row'<'col-sm-6'Bl><'col-sm-6 text-right'f>>rt<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
        "bFilter":false,
        "lengthMenu": [ [10, 25, 50, 100, 100000], [10, 25, 50,100, 100000] ],
        "columns" : [{
            "data" : "id_wpl"
        }, {
            "data" : "fiscal_full_name",
            "searchable" : false
        }, {
            "data" : "builder_full_name",
            "searchable" : false
        }, {
            "data" : "project_list",
            "searchable" : false
        }, {
            "defaultContent" : " ",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var html = ' <a class="btn btn-primary btn-xs edit-work-plan" data-work-plan-id="'+row.id_wpl+'" href="#" title="" data-original-title="EDITAR"  data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil"></i></a> ';
                    html += ' <a class="btn btn-danger btn-xs delete-work-plan" href="#" data-work-plan-id="'+row.id_wpl+'" title="" data-original-title="BORRAR"  data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a> ';
                return html;
            }
        }],
        "drawCallback" : function(object) {
            $('[data-toggle="tooltip"]').tooltip();
            this.api().column(0).visible(false);
        },
        "buttons": ['excel', 'csv','pdf','print',buttonAdd]
    });
    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');
    $('.dataTables_length select').addClass('form-control');
    oTable.fnSetFilteringDelay(1000);
});