/**
 * Created by Jair on 12/06/2018.
 */
$(document).ready(function() {

    $(document).on("click",".edit-schedule-budget",function(e){
        e.preventDefault();
        var logId = $(this).data("log-id");
        var projectId = $("input[name=project-id]").val();
        var statusName = $(this).data("status-name");
        var htmlSource   = $("#ht-modal-modify-schedule-budget").html();
        var template = Handlebars.compile(htmlSource);
        var data = {statusName:statusName};
        var html = template(data);
        bootbox.confirm({
            title: "Modificar importes tentativos",
            message: html,
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Modificar'
                }
            },
            callback: function (result) {
                if(result)
                {
                    var tentativeTotalBudget = $("input[name=tentative-total-budget]").val();
                    var designBudget = $("input[name=design-budget]").val();
                    var data = {
                        logId: logId,
                        projectId: projectId,
                        tentativeTotalBudget: tentativeTotalBudget,
                        designBudget:designBudget
                    };
                    updateLog(data);
                }
            }
        });

        var date = new Date();
        $('.date-time-picker').datetimepicker({
            ignoreReadonly: true,
            // defaultDate: date,
            format: 'DD-MM-YYYY HH:mm:ss'
        });
    });

    $(document).on("click",".edit-date",function(e){
        e.preventDefault();
        var logId = $(this).data("log-id");
        var projectId = $("input[name=project-id]").val();
        var statusName = $(this).data("status-name");
        var htmlSource   = $("#ht-modal-modify-history-manual-entry-date").html();
        var template = Handlebars.compile(htmlSource);
        var data = {statusName:statusName};
        var html = template(data);
        bootbox.confirm({
            title: "Modificar fecha de "+statusName,
            message: html,
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Modificar'
                }
            },
            callback: function (result) {
                if(result)
                {
                    var entryDate = $("input[name=modify-manual-entry-date]").val()
                    var data = {
                        logId: logId,
                        projectId:projectId,
                        entryDate: entryDate
                    };
                    updateLog(data);
                }
            }
        });

        var date = new Date();
        $('.date-time-picker').datetimepicker({
            ignoreReadonly: true,
            // defaultDate: date,
            format: 'DD-MM-YYYY HH:mm:ss'
        });
    });

    $(document).on("click",".edit-points-distance",function(e){
        e.preventDefault();
        var logId = $(this).data("log-id");
        var projectId = $("input[name=project-id]").val();
        var statusName = $(this).data("status-name");
        var htmlSource   = $("#ht-modal-modify-history-points-distance").html();
        var template = Handlebars.compile(htmlSource);
        var data = {statusName:statusName};
        var html = template(data);
        bootbox.confirm({
            title: "Modificar area definida en "+statusName,
            message: html,
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Modificar'
                }
            },
            callback: function (result) {
                if(result)
                {
                    var points = $("input[name=log-project-points]").val();
                    var distance = $("input[name=log-project-distance]").val();
                    var data = {
                        logId: logId,
                        projectId:projectId,
                        points:points,
                        distance:distance
                    };
                    updateLog(data);
                }
            }
        });
    });

    $(document).on("click",".edit-construction-assignments",function(e){
        e.preventDefault();
        var projectId = $("input[name=project-id]").val();
        var responsibleListFiscal = jQuery.parseJSON($("input[name=responsible-list-fiscal]").val());
        var responsibleListBuilder = jQuery.parseJSON($("input[name=responsible-list-builder]").val());
        var htmlSource   = $("#ht-modal-modify-history-construction-responsible").html();
        var template = Handlebars.compile(htmlSource);
        var data = {responsibleListFiscal:responsibleListFiscal, responsibleListBuilder: responsibleListBuilder};
        var html = template(data);
        bootbox.confirm({
            title: "Responsables del proceso de construccion",
            message: html,
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Modificar'
                }
            },
            callback: function (result) {
                if(result)
                {
                    var select2Data1 = $('#ajax-get-responsible-list1').select2("data");
                    var select2Data2 = $('#ajax-get-responsible-list2').select2("data");
                    Array.prototype.push.apply(select2Data1,select2Data2);
                    var responsibleList = [];
                    $.each(select2Data1, function(index, value){
                        responsibleList.push(value.id);
                    });
                    // console.log(responsibleList);
                    var responsibleList = responsibleList;
                    var data = {
                        projectId: projectId,
                        responsibleIds:responsibleList
                    };
                    updateLog(data);
                }
            }
        });
        $(".ajax-get-responsible-list").select2({
            placeholder: 'Responsables',
            allowClear: true,
            width:"60%"
        });
        $(document).on("change","#ajax-get-responsible-list2",function(e){
            e.preventDefault();
            if($(this).select2("data").length > 0){
                var supervisingUser = $($(this).select2("data")[0].element).data("supervising-id");
                var supervisingResponsibleId = $("#ajax-get-responsible-list1 option[data-user-id="+supervisingUser+"]").val();
                // var fiscalResponsibleId = $("#ajax-get-responsible-list1 option");
                $("#ajax-get-responsible-list1").val(supervisingResponsibleId).trigger("change");
            }
        });
        $(document).on("change","#ajax-get-responsible-list2",function(e){
            e.preventDefault();
        });
    });
});

function updateLog(data)
{
    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/updateLog',
        dataType  :"json",
        type : "POST",
        data : data,
        success:function(response){
            // getProjectLog();
            let url = $(location).attr('href').split("/");
            let statusSet = url[url.length - 2];
            let projectId = url[url.length - 1];
            let statusManagementHandler2 = new StatusManagementHandler(statusSet, projectId);
            statusManagementHandler2.loadView();
            bootbox.alert(response.message);
        }
    });
}
