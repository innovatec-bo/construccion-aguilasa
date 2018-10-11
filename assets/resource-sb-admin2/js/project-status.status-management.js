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
                case "in_progress":
                case "paused":
                case "stopped":
                case "completed":
                    saveBasicLog(statusId, statusKeyword);
                    break;
                case "as_built":
                    saveAsBuilt(statusId, statusKeyword);
                    break;
                case "conciliation_reception":
                case "conciliation_shipment":
                    saveBasicLog(statusId, statusKeyword);
                    break;
                case "cre_return_order":
                    saveCreReturnOrder(statusId,statusKeyword);
                    break;
                case "project_return_materials":
                    saveBasicLog(statusId, statusKeyword);
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
        var status = $("ul.wizard li.active a").prop("id");
        console.log(status);
        var currentPercentage = $("#incident-content .list-group").data("last-project-percentage");
        currentPercentage =  currentPercentage == undefined?0:currentPercentage;
        var htmlSource   = $("#ht-modal-incident-form").html();
        var template = Handlebars.compile(htmlSource);
        var data = {currentPercentage:currentPercentage,statusKeyword:status};
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

    $(document).on("keyup","input[name=design-budget], input[name=building-budget], input[name=transportation-budget], input[name=live-line-budget], input[name=right-of-way-budget]", function(){
       updateTotalOnApprovedForm();
    });

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
function saveAsBuilt(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });

    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var projectPoints = $("input[name=project-points]").val();
    var projectDistance = $("input[name=project-meters-distance]").val();
    var data = {
        projectId: projectId,
        entryDate:entryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList,
        projectPoints: projectPoints,
        projectDistance: projectDistance
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveAsBuilt',
        dataType  :"json",
        type : "POST",
        data : data,
        success:function(response){
            loadStatusSavedView(statusKeyword);
            getProjectLog();
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
    var rightOfWay = $("input[name=right-of-way-budget]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var secondaryCode = $("input[name=secondary-code]").val();
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
        rightOfWay:rightOfWay,
        statusDetail: statusDetail,
        responsibleList:responsibleList,
        secondaryCode:secondaryCode
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
function updateTotalOnApprovedForm()
{
    if($("#total-project-amount").length == 1)
    {
        var design = parseFloat($("input[name=design-budget]").val().replace(",",""));
        design = isNaN(design)?0:design;
        var building = parseFloat($("input[name=building-budget]").val().replace(",",""));
        building = isNaN(building)?0:building;
        var transportation = parseFloat($("input[name=transportation-budget]").val().replace(",",""));
        transportation = isNaN(transportation)?0:transportation;
        var liveLine = parseFloat($("input[name=live-line-budget]").val().replace(",",""));
        liveLine = isNaN(liveLine)?0:liveLine;
        var rightOfWay = parseFloat($("input[name=right-of-way-budget]").val().replace(",",""));
        rightOfWay = isNaN(rightOfWay)?0:rightOfWay;
        var total = design + building + transportation + liveLine + rightOfWay;
        total = total.toFixed(2);
        $("#total-project-amount").text(total);
    }
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

function saveCreReturnOrder(statusId,statusKeyword)
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
        url : base_url + 'panel/AjaxProjectStatus/saveCreReturnOrder',
        dataType  :"json",
        type : "POST",
        data : data,
        success:function(response){
            loadStatusSavedView(statusKeyword);
            getProjectLog();
        }
    });
}

function saveBasicLog(statusId,statusKeyword)
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
        url : base_url + 'panel/AjaxProjectStatus/saveBasicLog',
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
                updateTotalOnApprovedForm();
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
    var projectId = $("input[name=project-id]").val();
    var statusLogId = $(".active a").data("status-id");
    var detail = $('textarea[name=incident-detail]').val();
    var percentage = $('input[name=incident-percentage]').val();
    var entryDate = $('input[name=incident-manual-entry-date]').val();
    var pauseProject = $("input[name=pause-project]").is(":checked")?1:0;
    var stopProject = $("input[name=stop-project]").is(":checked")?1:0;
    var data = {
        projectId:projectId,
        statusLogId:statusLogId,
        detail:detail,
        percentage:percentage,
        entryDate:entryDate,
        pauseProject:pauseProject,
        stopProject:stopProject
    };
    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/addIncident',
        dataType  :"json",
        type : "POST",
        data:data,
        success:function(response){
            if(pauseProject || stopProject)
            {
                window.location.reload();
            }
            else
            {
                checkIncidents();
            }


        }
    });
}

function checkIncidents()
{
    var projectId = $("input[name=project-id]").val();
    var statusId = $(".active a").data("status-id");
    var statusText = $(".active a").text();
    var data = {
        projectId: projectId,
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
            // bootbox.alert({
            //     title:"Incidentes en "+statusText,
            //     message: html
            // });
        }
    });
}