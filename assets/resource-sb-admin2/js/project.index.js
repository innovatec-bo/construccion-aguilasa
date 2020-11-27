/**
 * Created by Jair on 10/01/2018.
 */

$(document).ready(function() {

    var additionalParameter = new DTAdditionalParameterHandler("#extra-request-data","#project-index");
    additionalParameter.addParameterObject('status','text');
    additionalParameter.addParameterObject('work-area','select');
    additionalParameter.addParameterObject('fiscal-responsible-id','select');
    additionalParameter.addParameterObject('builder-responsible-id','select');
    additionalParameter.addParameterObject('manpower-uploaded','select');
    additionalParameter.addParameterObject('status','select');
    additionalParameter.setButtonFilter('#send-filters');
    additionalParameter.setButtonRest('#remove-additional-parameters');
    additionalParameter.loadEventHandlers();

    var buttonProjectsLog = {
        text: "Logs",
        action: function ( e, dt, node, config )
        {
            var rowData = $('#project-index').DataTable().rows().data();
            var codeList = "";
            var $form = $("form[name=all-projects-log]");
            $form.submit();
        }
    };
    var buttonWorkflow = {
        text: "Workflow",
        action: function ( e, dt, node, config )
        {
            var rowData = $('#project-index').DataTable().rows().data();
            var codeList = "";
            var $form = $("form[name=workflow-with-parameters]");
            $.each(rowData, function(index, value){
                codeList += value.code_pro+" ";
            });
            $form.find("input[name=code-list]").val(codeList);
            $form.submit();
        }
    };
    var buttonMainDesignReport = {
        text: "Design Rep.",
        action: function ( e, dt, node, config )
        {
            var $form = $("form[name=workflow-with-parameters]");
            var statusSet = [];
            statusSet.push("code_pro");
            statusSet.push("entry_date_pro");
            statusSet.push("stake_date");
            statusSet.push("digitization_date");
            statusSet.push("drawing_date");
            statusSet.push("already_sent_date");
            statusSet.push("digitization_points_quantity");
            statusSet.push("digitization_distance");
            statusSet.push("stake_responsible");
            statusSet.push("address_pro");
            statusSet.push("cre_fiscal_pro");
            // statusSet.push("design");//costo de estacado
            // statusSet.push("design");//aprobados
            $form.find("input[name=columns-to-download]").val(statusSet);
            $form.submit();
        }
    };
    var buttons= ['excel', 'csv','pdf','print', buttonMainDesignReport, buttonWorkflow, buttonProjectsLog];
    if($("input[name=is-super-admin]").val() != 1)
    {
        buttons= ['excel', 'csv','pdf','print', buttonMainDesignReport];
    }
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
            "data" : "entry_date_pro",
            "render" : function(data, type, row, meta) {
                var result = "";
                if(row.entry_date_pro !== "" && row.entry_date_pro !== null)
                {
                    var dateObject = new Date(row.entry_date_pro);
                    var date = dateObject.getDate() < 10? "0"+dateObject.getDate():dateObject.getDate();
                    var month = (dateObject.getMonth()+1) < 10? "0"+(dateObject.getMonth()+1):(dateObject.getMonth()+1);
                    var year = dateObject.getFullYear();
                    result = date+"-"+month+"-"+year;
                }

                return result;
            }
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
            "defaultContent" : "",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var response = dateDiff(new Date(row.manual_entry_date_psl), new Date());
                return response;
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
            "data" : "fiscal_responsible"
        }, {
            "data" : "builder_responsible"
        }, {
            "data" : "address_pro",
            "defaultContent" : "",
            "searchable" : true,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var address = row.address_pro;
                var response = "";
                if(address.length > 11)
                {
                    address = address.substring(0,9)+"...";
                    response = ' <a class="" href="javascript:void(0)" title="" data-original-title="'+row.address_pro+'"  data-toggle="tooltip" data-placement="top">'+address+'</a> ';
                }
                else
                {
                    response = address;
                }

                return response;
            }
        }, {
            "defaultContent" : "",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var currentStatusSet = $("input[name=status-set]").val();
                var html = '';
                let showStatusManagementProjectBtn = 0;
                let statusManagementProjectUrl = base_url + 'panel/ProjectStatus/statusManagement/' +statusSet[row.status_pro]+'/'+row.id_pro;
                let showStatusManagementWharehouseBtn = 0;
                let statusManagementWharehouseUrl = base_url + 'panel/Warehouse/statusManagement/'+row.id_war;
                let showAddIncidentBtn = 0;
                let showManpowerBtn = 0;
                let showEditProjectBtn = 1;
                let showDeleteProjectBtn = 1;
                let showAssignProjectBtn = 0;
                let assignProjectUrl = base_url + 'panel/ProjectStatus/assignProject/'+row.id_pro;
                if(currentStatusSet != "")
                {
                    if(statusSet[row.status_pro] == "warehouse")
                    {
                        showStatusManagementWharehouseBtn = 1;
                        html += ' <a class="btn btn-primary btn-xs" href="'+base_url + 'panel/Warehouse/statusManagement/'+row.id_war+'" title="" data-original-title="ALMACEN"  data-toggle="tooltip" data-placement="top"><i class="fa fa-eye"></i></a> ';
                    }
                    else
                    {
                        showStatusManagementProjectBtn = 1;
                        html += ' <a class="btn btn-primary btn-xs" href="'+base_url + 'panel/ProjectStatus/statusManagement/' +statusSet[row.status_pro]+'/'+row.id_pro+'" title="" data-original-title="ADMINISTRACION DE ESTADOS"  data-toggle="tooltip" data-placement="top"><i class="fa fa-eye"></i></a> ';
                    }
                    if(statusSet[row.status_pro] == "building")
                    {
                        showAddIncidentBtn = 1;
                        html += ' <a class="btn btn-warning btn-xs add-incident" data-project-id="'+row.id_pro+'" data-status-id="'+row.status_pro+'" href="#" title="" data-original-title="AÑADIR INCIDENTE"  data-toggle="tooltip" data-placement="top"><i class="fa fa-flag-o"></i></a> ';
                    }
                    if(row.manpower_file_id !== null && !isNaN(row.manpower_file_id))
                    {
                        showManpowerBtn = 1;
                        html += ' <a class="btn btn-warning btn-xs" href="'+base_url + 'panel/Project/manpower/'+row.id_pro+'" title="" data-original-title="MANO DE OBRA"  data-toggle="tooltip" data-placement="top"><i class="fa fa-table"></i></a> ';
                    }
                    html += ' <a class="btn btn-primary btn-xs" href="'+base_url + 'panel/Project/edit/' +row.id_pro+'" title="" data-original-title="EDITAR"  data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil"></i></a> ';
                    html += ' <a class="btn btn-danger btn-xs datatable-delete-button" href="#" data-object-id="'+row.id_pro+'" data-url= "'+base_url+'panel/Project/delete/'+row.id_pro+'" title="" data-original-title="ELIMINAR"  data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a> ';
                }
                else
                {
                    showAssignProjectBtn = 1;
                    html += ' <a class="btn btn-primary btn-xs" href="'+base_url + 'panel/ProjectStatus/assignProject/'+row.id_pro+'" title="" data-original-title="ASIGNAR PROYECTO"  data-toggle="tooltip" data-placement="top"><i class="fa fa-th-list"></i></a> ';
                }
                // return html;
                let visibility = {
                    showStatusManagementProjectBtn:showStatusManagementProjectBtn,
                    statusManagementProjectUrl:statusManagementProjectUrl,
                    showStatusManagementWharehouseBtn:showStatusManagementWharehouseBtn,
                    statusManagementWharehouseUrl:statusManagementWharehouseUrl,
                    showAddIncidentBtn:showAddIncidentBtn,
                    showManpowerBtn:showManpowerBtn,
                    showEditProjectBtn:showEditProjectBtn,
                    showDeleteProjectBtn:showDeleteProjectBtn,
                    showAssignProjectBtn:showAssignProjectBtn,
                    assignProjectUrl:assignProjectUrl
                };
                let htmlSource   = $("#ht-datatable-dropdown-menu").html();
                let template = Handlebars.compile(htmlSource);
                let teamData = {row:row, visibility:visibility};
                return template(teamData);
            }
        }],
        "drawCallback" : function(object) {
            $('[data-toggle="tooltip"]').tooltip();
            columnVisibility(this);
        },
        "buttons": buttons
    });
    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Buscar');
    $('.dataTables_length select').addClass('form-control');
    oTable.fnSetFilteringDelay(1000);
});

function columnVisibility(_this)
{
    var method = window.location.pathname.split("/").pop();
    _this.api().column(0).visible(false);
    _this.api().column(1).visible(false);

    switch (method)
    {
        case "stakesTeam":
        case "digitization":
        case "drawing":
            _this.api().column(3).visible(false);
            _this.api().column(6).visible(false);
    }
    let statusSet = $("input[name=status-set]").val();
    
    switch(statusSet)
    {
        case "building":
            _this.api().column(9).visible(false);
            _this.api().column(10).visible(true);
            _this.api().column(11).visible(true);
            break;
        default:
            _this.api().column(9).visible(true);
            _this.api().column(10).visible(false);
            _this.api().column(11).visible(false);
    }

}

function dateDiff(d1, d2)
{
    var t2 = d2.getTime();
    var t1 = d1.getTime();

    return parseInt((t2-t1)/(24*3600*1000));
}
