/**
 * Created by Jair on 12/09/2018.
 */
var statusSet = [];
statusSet["42"] = "payment_management";
statusSet["43"] = "payment_management";
statusSet["44"] = "payment_management";

$(document).ready(function() {

    var additionalParameter = new DTAdditionalParameterHandler("#extra-request-data","#project-index");
    additionalParameter.addParameterObject('status','text');
    additionalParameter.setButtonFilter('#send-filters');
    additionalParameter.setButtonRest('#remove-additional-parameters');
    additionalParameter.loadEventHandlers();

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
            "data" : "id_pao"
        }, {
            "data" : "order_number_pao"
        }, {
            "data" : "status_pao",
            "defaultContent" : "",
            // "searchable" : false,
            // "orderable" : false,
            "render" : function(data, type, row, meta) {
                var response = "";
                var projectStatus = $("#project-index").data("project-status");
                if(row.status_pao in projectStatus)
                {
                    response = projectStatus[row.status_pao];
                }

                return response;
            }
        }, {
            "data" : "invoice_number_pao"
        }, {
            "data" : "entry_date_pao",
            "render" : function(data, type, row, meta) {
                var result = "";
                if(row.entry_date_pao !== "" && row.entry_date_pao !== null)
                {
                    var dateObject = new Date(row.entry_date_pao);
                    var date = dateObject.getDate() < 10? "0"+dateObject.getDate():dateObject.getDate();
                    var month = (dateObject.getMonth()+1) < 10? "0"+(dateObject.getMonth()+1):(dateObject.getMonth()+1);
                    var year = dateObject.getFullYear();
                    result = date+"-"+month+"-"+year;
                }

                return result;
            }
        }, {
            "defaultContent" : "",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var currentStatusSet = $("input[name=status-set]").val();
                var html = '';
                if(currentStatusSet != "")
                {
                    if(statusSet[row.status_pro] == "warehouse")
                    {
                        html += ' <a class="btn btn-primary btn-xs" href="'+base_url + 'panel/Warehouse/statusManagement/'+row.id_war+'" title="" data-original-title="ALMACEN"  data-toggle="tooltip" data-placement="top"><i class="fa fa-eye"></i></a> ';
                    }
                    else
                    {
                        html += ' <a class="btn btn-primary btn-xs" href="'+base_url + 'panel/ProjectStatus/statusManagement/' +statusSet[row.status_pro]+'/'+row.id_pro+'" title="" data-original-title="ADMINISTRACION DE ESTADOS"  data-toggle="tooltip" data-placement="top"><i class="fa fa-eye"></i></a> ';
                    }

                    html += ' <a class="btn btn-primary btn-xs" href="'+base_url + 'panel/Project/edit/' +row.id_pro+'" title="" data-original-title="EDITAR"  data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil"></i></a> ';
                    html += ' <a class="btn btn-danger btn-xs datatable-delete-button" href="#" data-object-id="'+row.id_pro+'" data-url= "'+base_url+'panel/Project/delete/'+row.id_pro+'" title="" data-original-title="ELIMINAR"  data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a> ';
                }
                else
                {
                    html += ' <a class="btn btn-primary btn-xs" href="'+base_url + 'panel/ProjectStatus/assignProject/'+row.id_pro+'" title="" data-original-title="ASIGNAR PROYECTO"  data-toggle="tooltip" data-placement="top"><i class="fa fa-th-list"></i></a> ';
                }
                html = '';
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

