/**
 * Created by Jair on 12/06/2018.
 */
$(document).ready(function() {
    var status = $("ul.wizard li.active a").prop("id");
    getProjectLog();
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
    $(document).on("click", ".check-stakes-team",function(e){
        e.preventDefault();
        getStakesLeaderProjects();
    });

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
                case "rd_stakes":
                case "stakes":
                    saveStakesTeam(statusId,statusKeyword);
                    break;
                case "returned":
                    saveReturned(statusId,statusKeyword);
                    break;
                case "ri_digitization":
                case "rd_digitization":
                case "digitization":
                    saveDigitization(statusId,statusKeyword,$button);
                    break;
                case "ri_drawing":
                case "rd_drawing":
                case "drawing":
                    saveDrawing(statusId,statusKeyword,$button);
                    break;
                case "schedule":
                    saveSchedule(statusId,statusKeyword);
                    break;
                case "already_sent":
                    saveAlreadySent(statusId,statusKeyword);
                    break;
                case "rectify_design":
                    saveRectifyDesign(statusId,statusKeyword);
                    break;
                case "rectify_illustration":
                    saveRectifyIllustration(statusId,statusKeyword);
                    break;
                case "approved":
                    saveApproved(statusId,statusKeyword);
                    break;
                case "canceled":
                    saveCanceled(statusId,statusKeyword);
                    break;
                case "warehouse":
                    saveWarehouse(statusId,statusKeyword);
                    break;
                case "record_building_materials":
                    saveRecordBuildingMaterials(statusId,statusKeyword);
                    break;
                case "get_materials":
                    savePickUpMaterials(statusId,statusKeyword);
                    break;
                case "deliver_materials":
                    saveDeliverMaterials(statusId,statusKeyword);
                    break;
                case "return_materials":
                    saveReturnMaterials(statusId, statusKeyword);
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
                    var entryDate = $("input[name=modify-manual-entry-date]").val();
                    updateManualEntry(logId, entryDate);
                }
            }
        });

        var date = new Date();
        $('input[name=modify-manual-entry-date]').datetimepicker({
            ignoreReadonly: true,
            // defaultDate: date,
            format: 'DD-MM-YYYY HH:mm:ss'
        });
    })
});

function getStakesLeaderProjects()
{
    $.ajax({
        url : base_url + 'panel/AjaxProject/getStakesLeaderProjects',
        dataType  :"json",
        type : "POST",
        success:function(response){
            var stakesProject = [];

            $.each(response,function(index,value){
                stakesProject.push(value);
            });
            var partial = $("#ht-stakes-project-item").html();
            Handlebars.registerPartial("ht-stakes-project-item", partial);

            var htmlSource   = $("#ht-stakes-project").html();
            var template = Handlebars.compile(htmlSource);
            var data = {stakesProject: stakesProject};
            var html = template(data);
            // $(".status-content").html(html);
            bootbox.alert({
                title:"Equipos y Proyectos",
                message:html
            });
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function saveStakesTeam(statusId, statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });
    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-team-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var stakes = {
        projectId: projectId,
        entryDate:entryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList: responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveStakesTeam',
        dataType  :"json",
        type : "POST",
        data : stakes,
        success:function(response){
            loadStatusSavedView(statusKeyword);
            getProjectLog();
        }
    });
}

function saveReturned(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });
    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var dataToSend = {
        projectId: projectId,
        entryDate:entryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveReturned',
        dataType  :"json",
        type : "POST",
        data : dataToSend,
        success:function(response){
            window.location.reload();
        }
    });
}

function saveDigitization(statusId,statusKeyword, button)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });
    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var projectPoints = $("input[name=project-points]").val();
    var projectDistance = $("input[name=project-meters-distance]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var lastPoints = $("input[name=current-project-points]").val();
    var lastDistance = $("input[name=current-project-meters-distance]").val();
    var sendToApprovement = button.data("send-to-approvement");
    var digitization = {
        projectId: projectId,
        entryDate:entryDate,
        statusId: statusId,
        projectPoints: projectPoints,
        projectDistance: projectDistance,
        statusDetail: statusDetail,
        lastPoints: lastPoints,
        lastDistance: lastDistance,
        responsibleList:responsibleList,
        sendToApprovement:sendToApprovement
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveDigitization',
        dataType  :"json",
        type : "POST",
        data : digitization,
        success:function(response){
            if(sendToApprovement == 1)
            {
                window.location = base_url + "panel/ProjectStatus/statusManagement/approvement/"+projectId;
            }
            else
            {
                loadStatusSavedView(statusKeyword);
                getProjectLog();
            }
        }
    });
}

function saveDrawing(statusId,statusKeyword,button)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });

    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var sendToApprovement = button.data("send-to-approvement");
    var drawing = {
        projectId: projectId,
        entryDate:entryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList,
        sendToApprovement:sendToApprovement
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveDrawing',
        dataType  :"json",
        type : "POST",
        data : drawing,
        success:function(response){
            if(sendToApprovement == 1)
            {
                window.location = base_url + "panel/ProjectStatus/statusManagement/approvement/"+projectId;
            }
            else
            {
                loadStatusSavedView(statusKeyword);
                getProjectLog();
            }

        }
    });
}

function saveSchedule(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });
    var projectId = $("input[name=project-id]").val();
    var scheduleEntryDate = $("input[name=schedule-entry-date]").val();
    var projectStart = $("input[name=project-start]").val();
    var projectEnd = $("input[name=project-end]").val();
    var statusDetail = $("textarea[name=schedule-detail]").val();
    var schedule = {
        projectId: projectId,
        scheduleEntryDate:scheduleEntryDate,
        projectStart: projectStart,
        projectEnd: projectEnd,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveSchedule',
        dataType  :"json",
        type : "POST",
        data : schedule,
        success:function(response){
            loadStatusSavedView(statusKeyword);
            getProjectLog();
        }
    });
}

function saveAlreadySent(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });
    var projectId = $("input[name=project-id]").val();
    var alreadySentEntryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var alreadySent = {
        projectId: projectId,
        alreadySentEntryDate:alreadySentEntryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveAlreadySent',
        dataType  :"json",
        type : "POST",
        data : alreadySent,
        success:function(response){
            loadStatusSavedView(statusKeyword);
            getProjectLog();
        }
    });
}

function saveRectifyDesign(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });
    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var alreadySent = {
        projectId: projectId,
        entryDate:entryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveRectifyDesign',
        dataType  :"json",
        type : "POST",
        data : alreadySent,
        success:function(response){
            window.location = base_url + "panel/ProjectStatus/statusManagement/rectify_design/"+projectId;
        }
    });
}

function saveRectifyIllustration(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });
    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var alreadySent = {
        projectId: projectId,
        entryDate:entryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveRectifyIllustration',
        dataType  :"json",
        type : "POST",
        data : alreadySent,
        success:function(response){
            window.location = base_url + "panel/ProjectStatus/statusManagement/rectify_illustration/"+projectId;
        }
    });
}

function saveApproved(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });
    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var design = $("input[name=design-budget]").val();
    var building = $("input[name=building-budget]").val();
    var graphNumber = $("input[name=graph-number-budget]").val();
    var reservationNumber = $("input[name=reservation-number-budget]").val();
    var transportation = $("input[name=transportation-budget]").val();
    var liveLine = $("input[name=live-line-budget]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var digitization = {
        projectId: projectId,
        entryDate:entryDate,
        statusId: statusId,
        design: design,
        building: building,
        graphNumber: graphNumber,
        reservationNumber: reservationNumber,
        transportation:transportation,
        liveLine:liveLine,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveApproved',
        dataType  :"json",
        type : "POST",
        data : digitization,
        success:function(response){
            loadStatusSavedView(statusKeyword);
            getProjectLog();
        }
    });
}

function saveCanceled(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });
    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var design = $("input[name=design-budget]").val();
    var building = $("input[name=building-budget]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var dataToSend = {
        projectId: projectId,
        entryDate:entryDate,
        statusId: statusId,
        design: design,
        building: building,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveCanceled',
        dataType  :"json",
        type : "POST",
        data : dataToSend,
        success:function(response){
            loadStatusSavedView(statusKeyword);
            getProjectLog();
        }
    });
}

function saveWarehouse(statusId, statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });

    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var data = {
        projectId: projectId,
        entryDate:entryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveWarehouse',
        dataType  :"json",
        type : "POST",
        data : data,
        success:function(response){
            // loadStatusSavedView(statusKeyword);
            // getProjectLog();
            window.location = base_url + "panel/Approvement/approved";
        }
    });
}

function saveRecordBuildingMaterials(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });

    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var drawing = {
        projectId: projectId,
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
            getProjectLog();
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

    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var drawing = {
        projectId: projectId,
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
            getProjectLog();
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

    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var drawing = {
        projectId: projectId,
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
            getProjectLog();
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

    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var data = {
        projectId: projectId,
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
            getProjectLog();
        }
    });
}

function loadStatusForm(statusKeyword, addMoreInfo)
{
    var projectId = $("input[name=project-id]").val();
    var statusSet = $("input[name=status-set]").val();
    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/verifyPreviousEntry',
        dataType  :"json",
        type : "POST",
        data : {projectId:projectId, statusKeyword:statusKeyword, statusSet:statusSet},
        success:function(response){
            if(response.scheduleEntry[0] !== undefined && response.scheduleEntry[0].id_psl !== null)
            {
                var htmlSource   = $("#ht-finished-stage-design").html();
                var template = Handlebars.compile(htmlSource);
                var data = {};
                var html = template(data);
                $("#status-form-content").html(html);
            }
            else if(response.previousEntry[0] === undefined || addMoreInfo ==  1 || statusKeyword == 'unsigned')
            {
                var points = $("#points").text();
                var distance = $("#distance").text();
                var responsibleList = $.parseJSON($("input[name=responsible-list]").val());
                var statusResponsible = [];
                $.each(responsibleList,function(index,value){
                    if(value.keyword_pst == statusKeyword)
                        statusResponsible.push(value);
                });
                var responsibleListLength = statusResponsible.length;
                var htmlSource   = $("#ht-status-not-created-view-form").html();
                if($("#ht-status-"+statusKeyword+"-form").length === 1)
                    htmlSource  = $("#ht-status-"+statusKeyword+"-form").html();

                var template = Handlebars.compile(htmlSource);
                var assignmentResponsible = response.assignmentEntry.length > 0?jQuery.parseJSON("["+response.assignmentEntry[0].jsonResponsible+"]"):[];
                var data = {
                    statusResponsible:statusResponsible,
                    responsibleListLength:responsibleListLength,
                    points:points,
                    distance:distance,
                    statusKeyword:statusKeyword,
                    statusSet:statusSet,
                    previousEntry:response.previousEntry[0],
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
                // var htmlSource = $("#ht-status-already-has-data").html();
                var htmlSource = $("#ht-status-"+statusKeyword+"-form-completed").html();
                var template = Handlebars.compile(htmlSource);
                var data = {statusKeyword:statusKeyword,statusSet:statusSet};
                var html = template(data);
                $("#status-form-content").html(html);
            }
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

function getProjectLog()
{
    var projectId = $("input[name=project-id]").val();
    var $logContent = $("#status-project-log-content");

    blockArea($logContent);
    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/getProjectLog',
        dataType  :"json",
        type : "POST",
        data : {projectId:projectId},
        success:function(response){
            var allowUpdateHistory = $logContent.data("allow-update-history");
            var htmlSource   = $("#ht-status-project-log-quick-view").html();
            var template = Handlebars.compile(htmlSource);
            var data = {projectLog:response,allowUpdateHistory:allowUpdateHistory};
            var html = template(data);
            $logContent.html(html);
        }
    });
}

function updateManualEntry(logId, entryDate)
{
    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/updateManualEntry',
        dataType  :"json",
        type : "POST",
        data : {logId:logId, entryDate:entryDate},
        success:function(response){
            getProjectLog();
            // bootbox.alert(response.message);
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