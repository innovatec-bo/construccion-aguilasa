/**
 * Created by Jair on 10/01/2018.
 */
var statusSet = [];
statusSet["1"] = "design";
statusSet["2"] = "design";
statusSet["20"] = "design";
statusSet["3"] = "design";
statusSet["5"] = "design";
statusSet["6"] = "design";

statusSet["9"] = "approvement";
statusSet["10"] = "approvement";
statusSet["11"] = "approvement";
statusSet["12"] = "approvement";

statusSet["13"] = "rectify_design";
statusSet["15"] = "rectify_design";
statusSet["16"] = "rectify_design";
statusSet["17"] = "rectify_design";

statusSet["14"] = "rectify_illustration";
statusSet["18"] = "rectify_illustration";
statusSet["19"] = "rectify_illustration";

statusSet["22"] = "warehouse";
statusSet["23"] = "warehouse";
statusSet["24"] = "warehouse";
statusSet["25"] = "warehouse";

$(document).ready(function() {

    var additionalParameter = new DTAdditionalParameterHandler("#extra-request-data","#project-index");
    additionalParameter.addParameterObject('status','text');
    additionalParameter.setButtonFilter('#send-filters');
    additionalParameter.setButtonRest('#remove-additional-parameters');
    additionalParameter.loadEventHandlers();

    var buttonAdd = {
        text: "Add",
        action: function ( e, dt, node, config ) {
            window.open(base_url + "panel/Project/add","_self");
        }
    };
    //Horizontal Icons dataTable
    // var statusSet = $("input[name=status-set]").val();
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
        "order": [[ 3, "desc" ]],
        "language": {
                processing: '<h1><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h1>'
        },
        "dom": "<'row'<'col-sm-6'Bl><'col-sm-6 text-right'f>>rt<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
        "lengthMenu": [ [10, 25, 50, 100, 100000], [10, 25, 50,100, 100000] ],
        "columns" : [{
            "data" : "id_pro"
        }, {
            "data" : "order_pst"
        }, {
            "data" : "code_pro"
        }, {
            "data" : "manual_entry_date_psl",
            "render" : function(data, type, row, meta) {
                var result = "";
                if(row.manual_entry_date_psl !== "" && row.manual_entry_date_psl !== null)
                {
                    var dateObject = new Date(row.manual_entry_date_psl);
                    var date = dateObject.getDate() < 10? "0"+dateObject.getDate():dateObject.getDate();
                    var month = (dateObject.getMonth()+1) < 10? "0"+(dateObject.getMonth()+1):(dateObject.getMonth()+1);
                    var year = dateObject.getFullYear();
                    result = date+"-"+month+"-"+year;
                }

                return result;
            }
        }, {
            "data" : "status_pro",
            "defaultContent" : "",
            // "searchable" : false,
            // "orderable" : false,
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
                    response = projectSystem[row.system_pro];
                }

                return response;
            }
        }, {
            "defaultContent" : "",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var response = "Sin asignar";
                if($.isNumeric(row.distance_pro) && $.isNumeric(row.points_pro))
                {
                    response = row.points_pro+"p / "+row.distance_pro+"Km";
                }
                return response;
            }
        }, {
            "data" : "responsible"
        }, {
            "defaultContent" : "",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var currentStatusSet = $("input[name=status-set]").val();
                var html = '';
                if(currentStatusSet != "")
                {
                    html += ' <a class="btn btn-primary btn-xs" href="'+base_url + 'panel/ProjectStatus/statusManagement/' +statusSet[row.status_pro]+'/'+row.id_pro+'" title="" data-original-title="ADMINISTRACION DE ESTADOS"  data-toggle="tooltip" data-placement="top"><i class="fa fa-eye"></i></a> ';
                    html += ' <a class="btn btn-primary btn-xs" href="'+base_url + 'panel/Project/edit/' +row.id_pro+'" title="" data-original-title="EDITAR"  data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil"></i></a> ';
                    html += ' <a class="btn btn-danger btn-xs datatable-delete-button" href="#" data-object-id="'+row.id_pro+'" data-url= "'+base_url+'panel/Project/delete/'+row.id_pro+'" title="" data-original-title="ELIMINAR"  data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a> ';
                }
                else
                {
                    html += ' <a class="btn btn-primary btn-xs" href="'+base_url + 'panel/ProjectStatus/assignProject/'+row.id_pro+'" title="" data-original-title="ASIGNAR PROYECTO"  data-toggle="tooltip" data-placement="top"><i class="fa fa-th-list"></i></a> ';
                }
                return html;
            }
        }],
        "drawCallback" : function(object) {
            $('[data-toggle="tooltip"]').tooltip();
            this.api().column(0).visible(false);
            this.api().column(1).visible(false);
        },
        "buttons": ['excel', 'csv','pdf','print']
    });
    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Buscar');
    $('.dataTables_length select').addClass('form-control');
    oTable.fnSetFilteringDelay(1000);
});

