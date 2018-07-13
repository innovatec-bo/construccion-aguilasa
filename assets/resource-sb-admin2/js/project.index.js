/**
 * Created by Jair on 10/01/2018.
 */

$(document).ready(function() {

    var additionalParameter = new DTAdditionalParameterHandler("#extra-request-data","#project-index");
    additionalParameter.addParameterObject('status','text');
    additionalParameter.setButtonFilter('#send-filters');
    additionalParameter.setButtonRest('#remove-additional-parameters');
    additionalParameter.loadEventHandlers();

    var buttonAdd = {
        text: "Add",
        action: function ( e, dt, node, config ) {
            window.open(base_url + "panel/Project/add","_blank");
        }
    };
    //Horizontal Icons dataTable
    var oTable = $('#project-index').dataTable({
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
            url : base_url + 'panel/AjaxProject/ajaxDtAllProjects',
            type : 'POST',
            data:function ( data ) {
                data.additionalParameters = additionalParameter.getList();
            }
        },
        "order": [[ 2, "desc" ]],
        "language": {
                processing: '<h1><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h1>'
        },
        "dom": "<'row'<'col-sm-6'Bl><'col-sm-6 text-right'f>>rt<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
        "lengthMenu": [ [10, 25, 50, 100, 100000], [10, 25, 50,100, 100000] ],
        "columns" : [{
            "data" : "id_pro"
        }, {
            "data" : "code_pro"
        }, {
            "data" : "entry_date_pro"
        }, {
            "data" : "status_pro",
            "defaultContent" : "",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var response = "";
                var projectStatus = $("#project-index").data("project-status");
                if(row.status_pro in projectStatus)
                {
                    response = projectStatus[row.status_pro];
                }

                return response;
            }
        }, {
            "data" : "system_pro",
            "defaultContent" : "",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var response = "";
                var projectSystem = $("#project-index").data("project-systems");
                if(row.system_pro in projectSystem)
                {
                    response = projectSystem[row.status_pro];
                }

                return response;
            }
        }, {
            "defaultContent" : "",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var response = "";
                if(row.distance_pro !== null && row.points_pro !== null)
                {
                    response = row.distance_pro+"K / "+row.points_pro+"p";
                }
                return response;
            }
        }, {
            "defaultContent" : "",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var html = ' <a target="_blank" class="btn btn-primary btn-xs" href="'+base_url + 'panel/ProjectStatus/statusManagement/' +row.id_pro+'" title="" data-original-title="ADMINISTRACION DE ESTADOS"  data-toggle="tooltip" data-placement="top"><i class="fa fa-eye"></i></a> ';
                html += ' <a target="_blank" class="btn btn-primary btn-xs" href="'+base_url + 'panel/Project/edit/' +row.id_pro+'" title="" data-original-title="ENVIAR"  data-toggle="tooltip" data-placement="top"><i class="fa fa-send"></i></a> ';
                html += ' <a target="_blank" class="btn btn-primary btn-xs" href="'+base_url + 'panel/Project/edit/' +row.id_pro+'" title="" data-original-title="EDITAR"  data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil"></i></a> ';
                html += ' <a target="_blank" class="btn btn-danger btn-xs datatable-delete-button" href="#" data-object-id="'+row.id_pro+'" data-url= "'+base_url+'panel/Project/delete/'+row.id_pro+'" title="" data-original-title="ELIMINAR"  data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a> ';
                return html;
            }
        }],
        "drawCallback" : function(object) {
            $('[data-toggle="tooltip"]').tooltip();
            this.api().column(0).visible(false);
        },
        "buttons": ['excel', 'csv','pdf','print', buttonAdd]
    });
    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Buscar');
    $('.dataTables_length select').addClass('form-control');
    oTable.fnSetFilteringDelay(1000);
});
