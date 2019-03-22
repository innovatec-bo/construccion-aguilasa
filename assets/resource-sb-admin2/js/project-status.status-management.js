/**
 * Created by Jair on 12/06/2018.
 */
$(function() {
    let url = $(location).attr('href').split("/");
    let statusSet = url[url.length - 2];
    let projectId = url[url.length - 1];
    let statusManagementHandler = new StatusManagementHandler(statusSet, projectId);
    statusManagementHandler.loadView();
    statusManagementHandler.loadEventHandler();

    $(document).on("keyup","input[name=design-budget], input[name=building-budget], input[name=transportation-budget], input[name=live-line-budget], input[name=right-of-way-budget]", function(){
       updateTotalOnApprovedForm();
    });

    $(document).on("click",".show-detail", function(e){
       e.preventDefault();
       $("#basic-data").animate({width:'toggle'},350);
       $("#history-content").slideUp();
       $("#help-content").slideUp();
    });
    $(document).on("click",".show-history", function(e){
        e.preventDefault();
        $("#history-content").slideToggle();
        $("#basic-data").slideUp();
        $("#help-content").slideUp();
    });
    $(document).on("click",".show-help", function(e){
        e.preventDefault();
        $("#history-content").slideUp();
        $("#basic-data").slideUp();
        $("#help-content").animate({width:'toggle'},350);
    });

});

function getStakesLeaderProjects_deprecated()
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
        statusKeyword: statusKeyword,
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
    var design = $("input[name=design]").val();
    var statusDetail = $("textarea[name=schedule-detail]").val();
    var schedule = {
        projectId: projectId,
        scheduleEntryDate:scheduleEntryDate,
        projectStart: projectStart,
        projectEnd: projectEnd,
        statusId: statusId,
        design: design,
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
function saveConciliationShipment(statusId,statusKeyword)
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
    var transportation = $("input[name=transportation-budget]").val();
    var liveLine = $("input[name=live-line-budget]").val();
    var rightOfWay = $("input[name=right-of-way-budget]").val();
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var data = {
        projectId: projectId,
        entryDate:entryDate,
        statusId: statusId,
        design: design,
        building: building,
        transportation:transportation,
        liveLine:liveLine,
        rightOfWay:rightOfWay,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };
    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveConciliationShipment',
        dataType  :"json",
        type : "POST",
        data : data,
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

function saveInProgress(statusId,statusKeyword)
{
    var select2Data1 = $('.select2.fiscal').select2("data");
    var select2Data2 = $('.select2.builders').select2("data");
    Array.prototype.push.apply(select2Data1,select2Data2);
    var responsibleList = [];
    $.each(select2Data1, function(index, value){
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

function saveProjectEnergized(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });

    var projectId = $("input[name=project-id]").val();
    var entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
    var projectEnergized = $("input[name=project-energized]").is(":checked")?1:0;
    var statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
    var data = {
        projectId: projectId,
        entryDate:entryDate,
        projectEnergized:projectEnergized,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveProjectEnergized',
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
                var responsibleGroup = getResponsibleGroup(statusKeyword);
                var statusResponsible = responsibleGroup.responsibleList;
                var responsibleListLength = responsibleGroup.responsibleListLength;

                var htmlSource   = $("#ht-status-not-created-view-form").html();
                if($("#ht-status-"+statusKeyword+"-form").length === 1)
                    htmlSource  = $("#ht-status-"+statusKeyword+"-form").html();

                var template = Handlebars.compile(htmlSource);
                var assignmentResponsible = response.assignmentEntry.length > 0?jQuery.parseJSON("["+response.assignmentEntry[0].jsonResponsible+"]"):[];
                var assignmentResponsibleFiscal = [];
                var assignmentResponsibleBuilder = [];
                if(statusKeyword == "in_progress")
                {
                    assignmentResponsibleFiscal.push(assignmentResponsible[0]);
                    assignmentResponsibleBuilder = assignmentResponsible[1] || {id:null, name:""};
                }
                var data = {
                    statusResponsible:statusResponsible,
                    responsibleListLength:responsibleListLength,
                    responsibleGroup:responsibleGroup,
                    points:points,
                    distance:distance,
                    statusKeyword:statusKeyword,
                    statusSet:statusSet,
                    previousEntry:response.previousEntry[0],
                    assignmentResponsible:assignmentResponsible,
                    assignmentResponsibleFiscal: assignmentResponsibleFiscal,
                    assignmentResponsibleBuilder: assignmentResponsibleBuilder
                };
                var html = template(data);
                $("#status-form-content").html(html);
                var date = new Date();
                $('.date-time-picker').datetimepicker({
                    ignoreReadonly: true,
                    defaultDate: date,
                    format: 'DD-MM-YYYY'
                });
                $(".select2").select2({
                    placeholder: 'Asigne uno o mas responsables',
                    allowClear: true
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
                var data = {statusKeyword:statusKeyword,statusSet:statusSet,previousEntry:response.previousEntry[0]};
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

// function addIncident()
// {
//     var projectId = $("input[name=project-id]").val();
//     var statusLogId = $(".active a").data("status-id");
//     var detail = $('textarea[name=incident-detail]').val();
//     var percentage = $('input[name=incident-percentage]').val();
//     var entryDate = $('input[name=incident-manual-entry-date]').val();
//     var pauseProject = $("input[name=pause-project]").is(":checked")?1:0;
//     var stopProject = $("input[name=stop-project]").is(":checked")?1:0;
//     var data = {
//         projectId:projectId,
//         statusLogId:statusLogId,
//         detail:detail,
//         percentage:percentage,
//         entryDate:entryDate,
//         pauseProject:pauseProject,
//         stopProject:stopProject
//     };
//     $.ajax({
//         url : base_url + 'panel/AjaxProjectStatus/addIncident',
//         dataType  :"json",
//         type : "POST",
//         data:data,
//         success:function(response){
//             if(pauseProject || stopProject)
//             {
//                 window.location.reload();
//             }
//             else
//             {
//                 checkIncidents();
//             }
//
//
//         }
//     });
// }

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

function getResponsibleGroup(statusKeyword)
{
    //all responsible by status keyword
    var response = {};
    var responsibleList = $.parseJSON($("input[name=responsible-list]").val());
    var statusResponsible = [];
    $.each(responsibleList,function(index,value){
        if(value.keyword_pst == statusKeyword)
            statusResponsible.push(value);
    });
    var responsibleListLength = statusResponsible.length;
    response.responsibleList = statusResponsible;
    response.responsibleListLength = responsibleListLength;

    //all responsible by status keyword and role fiscal
    var responsibleListFiscal = $.parseJSON($("input[name=responsible-list-fiscal]").val());
    var statusResponsibleFiscal = [];
    $.each(responsibleListFiscal,function(index,value){
            statusResponsibleFiscal.push(value);
    });
    var responsibleListFiscalLength = statusResponsibleFiscal.length;
    response.responsibleListFiscal = statusResponsibleFiscal;
    response.responsibleListFiscalLength = responsibleListFiscalLength;

    //all responsible by status keyword and role builder
    var responsibleListBuilder = $.parseJSON($("input[name=responsible-list-builder]").val());
    var statusResponsibleBuilder = [];
    $.each(responsibleListBuilder,function(index,value){
        statusResponsibleBuilder.push(value);
    });
    var responsibleListBuilderLength = statusResponsibleBuilder.length;
    response.responsibleListBuilder = statusResponsibleBuilder;
    response.responsibleListBuilderLength = responsibleListBuilderLength;

    return response;
}