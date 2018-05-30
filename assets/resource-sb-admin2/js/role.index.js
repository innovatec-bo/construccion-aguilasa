/**
 * Created by Jair on 10/01/2018.
 */

$(document).ready(function() {

    $(document).on("click",".edit-role",function(e){
        e.preventDefault();
        var roleId = $(this).data("role-id");
        editRole(roleId);
    });

    var buttonAdd = {
        text: "Add",
        action: function ( e, dt, node, config ) {
            addRole();
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
                var html = ' <a target="_blank" class="btn btn-primary btn-xs edit-role" data-role-id="'+row.id_rol+'" title="" data-original-title="EDIT"  data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil"></i></a> ';
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
                launchForm(response,"Form add")
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

function editRole(roleId, formData)
{
    $.ajax({
        url : base_url + 'panel/AjaxRole/edit/'+roleId,
        dataType  :"json",
        type : "POST",
        data:formData,
        success:function(response){
            if(response.success === 1 && !formData)
            {
                launchForm(response, "Form edit")
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

function launchForm(response, formTitle)
{
    var htmlSource   = $(response.template).html();
    var template = Handlebars.compile(htmlSource);
    var data = {role:response.role};
    var html    = template(data);
    bootbox.confirm({
        title:formTitle,
        message: html,
        className: "role-modal-form",
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
                var form = $(".role-modal-form form");
                if(response.role.hasOwnProperty('roleId'))
                {
                    editRole(response.role.roleId, form.serialize());
                }
                else
                {
                    addRole(form.serialize());
                }

            }
        }
    });
}
function sendFormResponse()
{
    $("#role-index").DataTable().ajax.reload();
}
