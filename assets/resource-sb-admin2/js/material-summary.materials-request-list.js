$(document).ready(function() {
    $('select[name=project-id]').select2({allowClear:true,placeholder:'Elija un proyecto'})
    var additionalParameter = new DTAdditionalParameterHandler("#extra-request-data","#material-summary-index");
    additionalParameter.addParameterObject('project-id','select');
    additionalParameter.setButtonFilter('#send-filters');
    additionalParameter.setButtonRest('#remove-additional-parameters');
    additionalParameter.loadEventHandlers();
    
    //Horizontal Icons dataTable
    var oTable = $('#material-summary-index').dataTable({
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
            url : base_url + 'panel/AjaxMaterialSummary/ajaxDtAllMaterialSummary',
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
        "columns" : [{
            "data" : "project_material"
        }, {
            "data" : "material_code"
        }, {
            "data" : "material_description"
        }, {
            "data" : "project_code"
        }, {
            "data" : "quantity_assigned_materials"
        }, {
            "data" : "quantity_picked_up_from_cre"
        }, {
            "data" : "pending_material_in_cre"
        }],
        "drawCallback" : function(object) {
            $('[data-toggle="tooltip"]').tooltip();
            this.api().column(0).visible(false);
        },
        "buttons": [{
            extend: 'excel',
            footer: true,
            exportOptions: {
                 columns: [1,2,3,4,5,6]
             }
        }]
    });
    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');
    $('.dataTables_length select').addClass('form-control');
    oTable.fnSetFilteringDelay(1000);
    var data = oTable.buttons.exportData( {
        columns: ':visible'
    } );
});
