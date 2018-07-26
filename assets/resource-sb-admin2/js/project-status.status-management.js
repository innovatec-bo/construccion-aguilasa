/**
 * Created by Jair on 12/06/2018.
 */
$(document).ready(function() {
    var status = $("ul.wizard li.active a").prop("id");
    getProjectLog();
    loadStatusForm(status);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        status = $(e.target).attr("id");
        loadStatusForm(status);
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

        if($form.parsley().isValid({group: statusKeyword}))
        {
            var $content = $("#status-form-content");
            blockArea($content);
            switch(statusKeyword)
            {
                case "stakes":
                    saveStakesTeam(statusId,statusKeyword);
                    break;
                case "digitization":
                    saveDigitization(statusId,statusKeyword);
                    break;
                case "drawing":
                    saveDrawing(statusId,statusKeyword);
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
                default:
                    bootbox.alert("Desculpe las molestias, aun no se ha programado la logica para el guardado de los datos en esta etapa");
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
    var stakesTeamEntryDate = $("input[name=stakes-team-entry-date]").val();
    var statusDetail = $("textarea[name=stakes-detail]").val();
    var stakes = {
        projectId: projectId,
        stakesTeamEntryDate:stakesTeamEntryDate,
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
            loadStatusSavedView();
            getProjectLog();
        }
    });
}

function saveDigitization(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });
    var projectId = $("input[name=project-id]").val();
    var digitizationEntryDate = $("input[name=digitization-entry-date]").val();
    var projectPoints = $("input[name=project-points]").val();
    var projectDistance = $("input[name=project-meters-distance]").val();
    var statusDetail = $("textarea[name=digitization-detail]").val();
    var lastPoints = $("input[name=current-project-points]").val();
    var lastDistance = $("input[name=current-project-meters-distance]").val();
    var digitization = {
        projectId: projectId,
        digitizationEntryDate:digitizationEntryDate,
        statusId: statusId,
        projectPoints: projectPoints,
        projectDistance: projectDistance,
        statusDetail: statusDetail,
        lastPoints: lastPoints,
        lastDistance: lastDistance,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveDigitization',
        dataType  :"json",
        type : "POST",
        data : digitization,
        success:function(response){
            loadStatusSavedView();
            getProjectLog();
        }
    });
}

function saveDrawing(statusId,statusKeyword)
{
    var select2Data = $('#ajax-get-responsible-list').select2("data");
    var responsibleList = [];
    $.each(select2Data, function(index, value){
        responsibleList.push(value.id);
    });

    var projectId = $("input[name=project-id]").val();
    var drawingEntryDate = $("input[name=drawing-entry-date]").val();
    var statusDetail = $("textarea[name=drawing-detail]").val();
    var drawing = {
        projectId: projectId,
        drawingEntryDate:drawingEntryDate,
        statusId: statusId,
        statusDetail: statusDetail,
        responsibleList:responsibleList
    };

    $.ajax({
        url : base_url + 'panel/AjaxProjectStatus/saveDrawing',
        dataType  :"json",
        type : "POST",
        data : drawing,
        success:function(response){
            loadStatusSavedView();
            getProjectLog();
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
            loadStatusSavedView();
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
            loadStatusSavedView();
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
            loadStatusSavedView();
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
            if(response.scheduleEntry.length > 0)
            {
                var htmlSource   = $("#ht-finished-stage-design").html();
                var template = Handlebars.compile(htmlSource);
                var data = {};
                var html = template(data);
                $("#status-form-content").html(html);
            }
            else if(response.previousEntry.length <= 0 || addMoreInfo ==  1 || statusKeyword == 'unsigned')
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
                var data = {statusResponsible:statusResponsible, responsibleListLength:responsibleListLength, points:points, distance:distance,statusKeyword:statusKeyword};
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
            }
            else
            {
                // var htmlSource = $("#ht-status-already-has-data").html();
                var htmlSource = $("#ht-status-"+statusKeyword+"-form-completed").html();
                var template = Handlebars.compile(htmlSource);
                var data = {statusKeyword:statusKeyword};
                var html = template(data);
                $("#status-form-content").html(html);
            }
        }
    });
}

function loadStatusSavedView()
{
    var htmlSource   = $("#ht-status-saved-view").html();
    var template = Handlebars.compile(htmlSource);
    var data = {};
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
            var htmlSource   = $("#ht-status-project-log-quick-view").html();
            var template = Handlebars.compile(htmlSource);
            var data = {projectLog:response};
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