/**
 * Created by Jair on 12/06/2018.
 */
$(document).ready(function() {

    $(document).on("click",".edit-date",function(e){
        e.preventDefault();
        var logId = $(this).data("log-id");
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
                        points:points,
                        distance:distance
                    };
                    updateLog(data);
                }
            }
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
            getProjectLog();
            // bootbox.alert(response.message);
        }
    });
}