/**
 * Created by Jair on 12/06/2018.
 */
$(document).ready(function() {
    var status = $("ul.wizard li.active a").prop("id");
    //TODO: this could be the management payment log
    getPaymentOrderLog();
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
                // case "payment_order_registered":
                case "payment_order_invoice_sent":
                    saveInvoiceSent(statusId, statusKeyword);
                    break;
                case "payment_order_has_been_settled":
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

function saveInvoiceSent(statusId,statusKeyword)
{
    var orderId = $("input[name=payment-order-id]").val();
    var entryDate = $("input[name=entry-date]").val();
    var invoiceNumber = $("input[name=invoice-number]").val();
    var invoiceDate = $("input[name=invoice-date]").val();
    var statusDetail = $("textarea[name=detail]").val();
    var schedule = {
        orderId: orderId,
        entryDate:entryDate,
        invoiceNumber:invoiceNumber,
        invoiceDate: invoiceDate,
        statusId: statusId,
        statusDetail: statusDetail
    };

    $.ajax({
        url : base_url + 'panel/AjaxPaymentManagement/saveInvoiceSent',
        dataType  :"json",
        type : "POST",
        data : schedule,
        success:function(response){
			window.location.reload();
            // loadStatusSavedView(statusKeyword);
            // getPaymentOrderLog();
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

function saveBasicLog(statusId,statusKeyword)
{
    var orderId = $("input[name=payment-order-id]").val();
    var entryDate = $("input[name=entry-date]").val();
    var detail = $("textarea[name=detail]").val();
    var data = {
        orderId: orderId,
        entryDate:entryDate,
        statusId: statusId,
        detail: detail
    };

    $.ajax({
        url : base_url + 'panel/AjaxPaymentManagement/saveBasicLog',
        dataType  :"json",
        type : "POST",
        data : data,
        success:function(response){
			window.location.reload();
            // loadStatusSavedView(statusKeyword);
            // getPaymentOrderLog();
        }
    });
}

function loadStatusForm(statusKeyword, addMoreInfo)
{
    var orderId = $("input[name=payment-order-id]").val();
    var statusSet = $("input[name=status-set]").val();
    $.ajax({
        url : base_url + 'panel/AjaxPaymentManagement/verifyPreviousEntry',
        dataType  :"json",
        type : "POST",
        data : {orderId:orderId, statusKeyword:statusKeyword, statusSet:statusSet},
        success:function(response){
            if(response.previousEntry[0] === undefined || addMoreInfo ==  1 || statusKeyword == 'unsigned')
            {
                var htmlSource   = $("#ht-status-not-created-view-form").html();
                if($("#ht-status-"+statusKeyword+"-form").length === 1)
                    htmlSource  = $("#ht-status-"+statusKeyword+"-form").html();

                var template = Handlebars.compile(htmlSource);
                var data = {
                    statusKeyword:statusKeyword,
                    statusSet:statusSet,
                    previousEntry:response.previousEntry[0]
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
            // checkIncidents();
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

function getPaymentOrderLog()
{
    var orderId = $("input[name=payment-order-id]").val();
    var $logContent = $("#status-project-log-content");

    blockArea($logContent);
    $.ajax({
        url : base_url + 'panel/AjaxPaymentManagement/getPaymentOrderLog',
        dataType  :"json",
        type : "POST",
        data : {orderId:orderId},
        success:function(response){
            var allowUpdateHistory = $logContent.data("allow-update-history");
            var htmlSource   = $("#ht-status-payment-management-log-quick-view").html();
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
            getPaymentOrderLog();
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
