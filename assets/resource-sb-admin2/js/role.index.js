/**
 * Created by Jair on 10/01/2018.
 */

$(document).ready(function() {
    var buttonAdd = {
        text: "Add",
        action: function ( e, dt, node, config ) {
            addRole();
            // window.open(base_url + "panel/User/add","_blank");
        }
    };
    //Horizontal Icons dataTable
    var oTable = $('#role-index').dataTable({
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
            url : base_url + 'panel/AjaxRole/ajaxDtAllRoles',
            type : 'POST'
        },
        "language": {
                processing: '<h1><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h1>'
        },
        "dom": "<'row'<'col-sm-6'Bl><'col-sm-6 text-right'f>>rt<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
        "lengthMenu": [ [10, 25, 50, 100, 100000], [10, 25, 50,100, 100000] ],
        "columns" : [{
            "data" : "id_rol"
        }, {
            "data" : "rolename_rol"
        }, {
            "data" : "keyword_rol"
        }, {
            "defaultContent" : " ",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var html = ' <a target="_blank" class="btn btn-primary btn-xs" href="'+base_url + 'panel/Role/edit/' +row.id_usr+'" title="" data-original-title="EDIT"  data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil"></i></a> ';
                    // html += ' <a class="btn btn-danger btn-xs" href="'+base_url + 'admin/Project/publication/' +row.proy_id+'" title="" data-original-title="DELETE"  data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a> ';
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

function addRole(formData)
{
    $.ajax({
        url : base_url + 'panel/AjaxRole/add',
        dataType  :"json",
        type : "POST",
        data:formData,
        success:function(response){
            if(response.success === 1 && !formData)
            {
                callFormResponse(response)
            }
            else if(response.success === 1 && formData)
            {
                sendFormResponse(response)
            }
            else
            {
                bootbox.alert({
                    title:"Something went wrong!",
                    message: response.message,
                    size:"medium"
                })
            }
        }
    });
}

function callFormResponse(response)
{
    var htmlSource   = $(response.template).html()
    var template = Handlebars.compile(htmlSource);
    var data = {};
    var html    = template(data);
    bootbox.confirm({
        title:"Add Role",
        message: html,
        buttons: {
            confirm: {
                label: 'Save',
                className: 'btn-success'
            },
            cancel: {
                label: 'Cancel',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result)
            {
                var form = $("form[name=modal-role-add-form]");
                addRole(form.serialize());
            }
        }
    });
}
function sendFormResponse()
{
    window.reload();
}
