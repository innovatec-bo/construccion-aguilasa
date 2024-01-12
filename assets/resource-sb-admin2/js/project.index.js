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
    // additionalParameter.addParameterObject('status','select');
    additionalParameter.addParameterObject('all-materials-picked-up-from-cre','checkbox');
    additionalParameter.addParameterObject('none-materials-picked-up-from-cre','checkbox');
    additionalParameter.setButtonFilter('#send-filters');
    additionalParameter.setButtonRest('#remove-additional-parameters');
    additionalParameter.loadEventHandlers();

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
    var buttons = [
            {
                extend: 'excelHtml5',
                filename: 'Lista de proyectos - '+moment().format('DD.MM.YYYY.HH:mm:ss'),
                title: 'Lista de proyectos',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            },
            buttonMainDesignReport
        ];
    if($("input[name=is-super-admin]").val() != 1)
    {
        buttons = [
            {
                extend: 'excelHtml5',
                filename: 'Lista de proyectos - '+moment().format('DD.MM.YYYY.HH:mm:ss'),
                title: 'Lista de proyectos',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            },
            buttonMainDesignReport
        ];
    }
    
    //Horizontal Icons dataTable
    // var statusSet = $("input[name=status-set]").val();
    var oTable = $('#project-index').dataTable({
        "processing" : true,
        "serverSide" : true,
        // "info": false,
        // "pagingType": 'simple',
        "ajax" : {
            url : base_url + 'panel/AjaxProject/ajaxDtAllProjects',
            type : 'POST',
            data:function ( data ) {
                data.additionalParameters = additionalParameter.getList();
            }
        },
        "order": [[ 3, "desc" ]],
        "language": {
                "search": "COD. Proyecto:",
                processing: '<h1><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h1>'
        },
        "dom": "<'row'<'col-sm-7'Bl><'col-sm-5 text-right'f>>rt<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
        "lengthMenu": [ [10, 25, 50, 100, 100000], [10, 25, 50,100, 100000] ],
        "columns" : [
        {
            "data" : "id_pro",
            "searchable" : false
        }, {
            "data" : "order_pst",
            "searchable" : false
        }, {
            "data" : "code_pro",
            "searchable" : true
        }, {
            "data" : "entry_date_pro",
			"className": 'text-center',
            "searchable" : false,
            "render" : function(data, type, row, meta) {
                let date = moment(row.entry_date_pro,'YYYY-MM-DD HH:mm:ss');
                let result = "";
                if(date.isValid())
                {
                    result = date.format('DD-MM-YYYY');
                }
                return result;
            },
        }, {
            "data" : "status_log_manual_entry_date",
			"className": 'text-center',
            "searchable" : false,
            "render" : function(data, type, row, meta) {
                let date = moment(row.status_log_manual_entry_date,'YYYY-MM-DD HH:mm:ss');
                let result = "";
                if(date.isValid())
                {
                    result = date.format('DD-MM-YYYY');
                }
                return result;
            }
        }, {
            "data" : "static_days"
        }, {
            "data" : "status_name_pst",
            "searchable" : false
        }, {
            "data" : "system_pro",
            "searchable" : false,
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
			"data" : "cre_fiscal_pro",
            "searchable" : false
		}/*, {
            "data" : "stake_responsible",
        }, {
            "data" : "assign_to_responsible"
        }*/, {
            "data" : "fiscal_responsible"
        }, {
            "data" : "builder_responsible"
        }, {
            "data" : "address_pro",
            "defaultContent" : "",
            "searchable" : false,
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
			"data" : "project_current_budget",
			"className": 'text-right',
			"orderable" : true,
			"searchable" : false,
            "render": function(data, type, row, meta){
                let amount = new Intl.NumberFormat('en',{minimumFractionDigits:2,maximumFractionDigits:2}).format(row.project_current_budget);
                let html = "<span style='font-weight:bold'>"+amount+"</span>";
                return html;
            }
		}, {
            "defaultContent" : "",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                console.log(row);
                let currentStatusSet = $("input[name=status-set]").val();
                let showStatusManagementProjectBtn = 0;
                let statusManagementProjectUrl = base_url + 'panel/ProjectStatus/statusManagement/' +statusSet[row.project_status_id]+'/'+row.id_pro;
                let showStatusManagementWarehouseBtn = 0;
                let statusManagementWarehouseUrl = base_url + 'panel/Warehouse/statusManagement/'+row.id_war;
                let showAddIncidentBtn = 0;
                let showManpowerBtn = 0;
                let showEditProjectBtn = $('input[name=show-edit-button]').val();
                let showDeleteProjectBtn = $('input[name=show-delete-button]').val();
                let showAssignProjectBtn = 0;
                let showWarehouseOptions = 0;
                let assignProjectUrl = base_url + 'panel/ProjectStatus/assignProject/'+row.id_pro;
                if(currentStatusSet != "")
                {
                    if(statusSet[row.project_status_id] == "warehouse")
                    {
                        showStatusManagementWarehouseBtn = 1;
                    }
                    else
                    {
                        showStatusManagementProjectBtn = 1;
                    }
                    if(statusSet[row.project_status_id] == "building")
                    {
                        showAddIncidentBtn = 1;
                    }
                    if(row.manpower_file_id !== null && !isNaN(row.manpower_file_id))
                    {
                        showManpowerBtn = 1;
                    }
                }
                else
                {
					let parts = window.location.href.split('/');
					let lastSegment = parts.pop() || parts.pop();
					console.log(lastSegment);

					if(lastSegment.toLowerCase() === "warehouse")
					{
						showWarehouseOptions = 1;
					}
					else
					{
						showAssignProjectBtn = 1;
					}

                }

                let visibility = {
                    showStatusManagementProjectBtn:showStatusManagementProjectBtn,
                    statusManagementProjectUrl:statusManagementProjectUrl,
                    showStatusManagementWarehouseBtn:showStatusManagementWarehouseBtn,
                    statusManagementWarehouseUrl:statusManagementWarehouseUrl,
                    showAddIncidentBtn:showAddIncidentBtn,
                    showManpowerBtn:showManpowerBtn,
                    showEditProjectBtn:showEditProjectBtn,
                    showDeleteProjectBtn:showDeleteProjectBtn,
                    showAssignProjectBtn:showAssignProjectBtn,
                    assignProjectUrl:assignProjectUrl,
					showWarehouseOptions:showWarehouseOptions
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
    oTable.fnSetFilteringDelay(1500);
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
    
    // switch(statusSet)
    // {
    //     case "building":
    //         _this.api().column(9).visible(false);
    //         _this.api().column(11).visible(true);
    //         _this.api().column(12).visible(true);
    //         break;
    //     default:
    //         _this.api().column(9).visible(true);
    //         _this.api().column(11).visible(false);
    //         _this.api().column(12).visible(false);
    // }

}

function dateDiff(d1, d2)
{
    var t2 = d2.getTime();
    var t1 = d1.getTime();

    return parseInt((t2-t1)/(24*3600*1000));
}
