/**
 * Created by Jair on 12/06/2018.
 */
$(document).ready(function() {
    var status = $("ul.wizard li.active a").prop("id");
    getWarehouseLog();
    loadStatusForm(status);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        if(!$(this).parent().hasClass("disabled"))
        {
            status = $(e.target).attr("id");
            loadStatusForm(status);
        }
        else {
            return false;
        }
    });
    $(document).on("click","#next-step",function(e){
        e.preventDefault();
        $("ul.wizard li.active").next().find("a").trigger("click");
    });
    // $(document).on("click", ".check-stakes-team",function(e){
    //     e.preventDefault();
    //     getStakesLeaderProjects();
    // });

    $(document).on("click",".save-status",function(e){
        e.preventDefault();
        var $form = $("form[name=status-management]");
        var statusKeyword = $(this).data("status-keyword");
        var statusId = $(this).data("status-id");
        var $button = $(this);

        if($form.parsley().isValid({group: statusKeyword}))
        {
            var $content = $("#status-form-content");
            blockArea($content);
            switch(statusKeyword)
            {
                case "warehouse":
                    saveBasicLog(statusId,statusKeyword);
                    // saveWarehouse(statusId,statusKeyword);
                    break;
                case "record_building_materials":
                    saveBasicLog(statusId,statusKeyword);
                    // saveRecordBuildingMaterials(statusId,statusKeyword);
                    break;
                case "get_materials":
                    saveBasicLog(statusId,statusKeyword);
                    // savePickUpMaterials(statusId,statusKeyword);
                    break;
                case "deliver_materials":
                    saveBasicLog(statusId,statusKeyword);
                    // saveDeliverMaterials(statusId,statusKeyword);
                    break;
                case "materials_reception":
                    saveBasicLog(statusId,statusKeyword);
                    break;
                case "return_materials":
                    saveBasicLog(statusId,statusKeyword);
                    // saveReturnMaterials(statusId, statusKeyword);
                    break;
                default:
                    bootbox.alert("Disculpe las molestias, aun no se ha programado la logica para el guardado de los datos en esta etapa");
                    break;
            }
        }
        else
        {
            $form.parsley().validate({group: statusKeyword});
        }

    });

    $(document).on("click",".send-to-rectify",function(e){
        e.preventDefault();
        var statusKeyword = $(this).data("status-keyword");
        loadStatusForm(statusKeyword,1);
    });

    $("#add-incident").on("click",function(e){
       e.preventDefault();
        var currentPercentage = $("#incident-content .list-group").data("last-project-percentage");
        currentPercentage =  currentPercentage == undefined?0:currentPercentage;
        var htmlSource   = $("#ht-modal-incident-form").html();
        var template = Handlebars.compile(htmlSource);
        var data = {currentPercentage:currentPercentage};
        var html = template(data);
        bootbox.confirm({
            title:"Detalle de la incidencia",
            message: html,
            buttons: {
                confirm: {
                    label: 'Agregar incidente',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result)
                {
                    addIncident();
                }
            }
        });
        var date = new Date();
        $('input[name=incident-manual-entry-date]').datetimepicker({
            ignoreReadonly: true,
            defaultDate: date,
            format: 'DD-MM-YYYY'
        });
    })

    $(document).on("click",".check-incidents",function(e){
        e.preventDefault();

    });
});

// function saveWarehouse(statusId, statusKeyword)
// {
//     var select2Data = $('#ajax-get-responsible-list').select2("data");
//     var responsibleList = [];
//     $.each(select2Data, function(index, value){
//         responsibleList.push(value.id);
//     });
//
//     var warehouseId = $("input[name=warehouse-id]").val();
//     var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
//     var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
//     var data = {
//         warehouseId: warehouseId,
//         entryDate:entryDate,
//         statusId: statusId,
//         statusDetail: statusDetail,
//         responsibleList:responsibleList
//     };
//
//     $.ajax({
//         url : base_url + 'panel/AjaxProjectStatus/saveWarehouse',
//         dataType  :"json",
//         type : "POST",
//         data : data,
//         success:function(response){
//             // loadStatusSavedView(statusKeyword);
//             // getWarehouseLog();
//             window.location = base_url + "panel/Approvement/approved";
//         }
//     });
// }

function saveRecordBuildingMaterials(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });

    var warehouseId = $("input[name=warehouse-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var drawing = {
        warehouseId: warehouseId,
        entryDate:entryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveRecordBuildingMaterials',
        dataType  :"json",
        type : "POST",
        data : drawing,
        success:function(response){
            loadStatusSavedView(statusKeyword);
            getWarehouseLog();
        }
    });
}

function savePickUpMaterials(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });

    var warehouseId = $("input[name=warehouse-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var drawing = {
        warehouseId: warehouseId,
        entryDate:entryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/savePickUpMaterials',
        dataType  :"json",
        type : "POST",
        data : drawing,
        success:function(response){
            loadStatusSavedView(statusKeyword);
            getWarehouseLog();
        }
    });
}

function saveDeliverMaterials(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });

    var warehouseId = $("input[name=warehouse-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var drawing = {
        warehouseId: warehouseId,
        entryDate:entryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveDeliverMaterials',
        dataType  :"json",
        type : "POST",
        data : drawing,
        success:function(response){
            loadStatusSavedView(statusKeyword);
            getWarehouseLog();
        }
    });
}

function saveReturnMaterials(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });

    var warehouseId = $("input[name=warehouse-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var data = {
        warehouseId: warehouseId,
        entryDate:entryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveReturnMaterials',
        dataType  :"json",
        type : "POST",
        data : data,
        success:function(response){
            loadStatusSavedView(statusKeyword);
            getWarehouseLog();
        }
    });
}

function saveBasicLog(statusId,statusKeyword)
{
    var warehouseId = $("input[name=warehouse-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var data = {
        warehouseId: warehouseId,
        entryDate:entryDate,
        statusId: statusId,
        statusDetail: statusDetail
    };

    $.ajax({
        url : base_url + 'panel/AjaxWarehouse/saveBasicLog',
        dataType  :"json",
        type : "POST",
        data : data,
        success:function(response){
            loadStatusSavedView(statusKeyword);
            getWarehouseLog();
        }
    });
}

function loadStatusForm(statusKeyword, addMoreInfo)
{
    var warehouseId = $("input[name=warehouse-id]").val();
    var statusSet = $("input[name=status-set]").val();
    $.ajax({
        url : base_url + 'panel/AjaxWarehouse/verifyPreviousEntry',
        dataType  :"json",
        type : "POST",
        data : {warehouseId:warehouseId, statusKeyword:statusKeyword, statusSet:statusSet},
        success:function(response){
            if(response.assignmentEntry.length <= 0 && statusKeyword == "deliver_materials")
            {
                var htmlSource = $("#ht-status-"+statusKeyword+"-form-not-available").html();
                var template = Handlebars.compile(htmlSource);
                var data = {statusKeyword:statusKeyword,statusSet:statusSet};
                var html = template(data);
                $("#status-form-content").html(html);
            }
            else if(response.previousEntry[0] === undefined || addMoreInfo ==  1)
            {
                var htmlSource   = $("#ht-status-not-created-view-form").html();
                if($("#ht-status-"+statusKeyword+"-form").length === 1)
                    htmlSource  = $("#ht-status-"+statusKeyword+"-form").html();

                var template = Handlebars.compile(htmlSource);
                var assignmentResponsible = response.assignmentEntry.length > 0?jQuery.parseJSON("["+response.assignmentEntry[0].jsonResponsible+"]"):[];
                var data = {
                    previousEntry:response.previousEntry[0],
                    statusKeyword:statusKeyword,
                    assignmentResponsible:assignmentResponsible
                };
                var html = template(data);
                $("#status-form-content").html(html);
                var date = new Date();
                $('.date-time-picker').datetimepicker({
                    ignoreReadonly: true,
                    defaultDate: date,
                    format: 'DD-MM-YYYY'
                });
                $("#ajax-get-responsible-list").select2({
                    placeholder: 'Asigne uno o mas responsables',
                    allowClear: true
                });
                $(".input-masked").inputmask();
            }
            else
            {
                var htmlSource = $("#ht-status-"+statusKeyword+"-form-completed").html();
                var template = Handlebars.compile(htmlSource);
                var data = {statusKeyword:statusKeyword,statusSet:statusSet};
                var html = template(data);
                $("#status-form-content").html(html);
            }
            checkIncidents();
        }
    });
}

function loadStatusSavedView(keyword)
{
    var htmlSource   = $("#ht-status-"+keyword+"-form-completed").html();
    var template = Handlebars.compile(htmlSource);
    var data = {statusKeyword:keyword};
    var html = template(data);
    $("#status-form-content").html(html);
}

function getWarehouseLog()
{
    var warehouseId = $("input[name=warehouse-id]").val();
    var $logContent = $("#status-project-log-content");

    blockArea($logContent);
    $.ajax({
        url : base_url + 'panel/AjaxWarehouse/getWarehouseLog',
        dataType  :"json",
        type : "POST",
        data : {warehouseId:warehouseId},
        success:function(response){
            var allowUpdateHistory = $logContent.data("allow-update-history");
            var htmlSource   = $("#ht-status-warehouse-log-quick-view").html();
            var template = Handlebars.compile(htmlSource);
            var data = {projectLog:response,allowUpdateHistory:allowUpdateHistory};
            var html = template(data);
            $logContent.html(html);
        }
    });
}

function blockArea(content)
{
    content.block({
        message: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>',
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8,
            cursor: 'wait'
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'transparent'
        }
    });
}

function addIncident()
{
    var warehouseId = $("input[name=warehouse-id]").val();
    var statusLogId = $(".active a").data("status-id");
    var detail = $('textarea[name=incident-detail]').val();
    var percentage = $('input[name=incident-percentage]').val();
    var entryDate = $('input[name=incident-manual-entry-date]').val();
    var data = {
        warehouseId:warehouseId,
        statusLogId:statusLogId,
        detail:detail,
        percentage:percentage,
        entryDate:entryDate
    };
    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/addIncident',
        dataType  :"json",
        type : "POST",
        data:data,
        success:function(response){
            console.log(response);
        }
    });
}

function checkIncidents()
{
    var warehouseId = $("input[name=warehouse-id]").val();
    var statusId = $(".active a").data("status-id");
    var statusText = $(".active a").text();
    var data = {
        warehouseId: warehouseId,
        statusId: statusId
    };
    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/checkIncidents',
        dataType  :"json",
        type : "POST",
        data:data,
        success:function(response){
            var currentProjectPercentage = 0;
            if(response.allIncidents.length > 0)
            {
                currentProjectPercentage = response.allIncidents[0].percentage_inc;
            }

            var htmlSource   = $("#ht-modal-incident-list").html();
            var template = Handlebars.compile(htmlSource);
            var data = {incidentList:response.incidentList, currentProjectPercentage:currentProjectPercentage};
            var html = template(data);
            $("#incident-content").html(html);
            console.log(response);
            // bootbox.alert({
            //     title:"Incidentes en "+statusText,
            //     message: html
            // });
        }
    });
}
