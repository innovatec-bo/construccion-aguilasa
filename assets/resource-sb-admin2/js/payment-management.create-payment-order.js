/**
 * Created by Jair on 07/09/2018.
 */

$(document).ready(function() {
    loadTable();
    var date = new Date();
    $('.date-time-picker').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'DD-MM-YYYY'
    });
    $(".add-payment-order-project").on("click",function(e){
        e.preventDefault();
        var index = $("#project-list-content").children().length;
        var htmlSource   = $("#ht-payment-orders-projects-row").html();

        var template = Handlebars.compile(htmlSource);
        var data = {
            index: index +1,
            design_budget:0,
            transportation_budget:0,
            building_budget:0,
            live_line_budget:0,
            right_of_way_budget:0
        };
        var html = template(data);
        $("#project-list-content").append(html);
        evaluateVisibilityBtnRemove();
        var projectSelect2 = ".project-quick-select2[data-select-index="+data.index+"]";
        projectQuickSelect2(projectSelect2);
        $(".input-masked").inputmask();
    });

    $(document).on("click",".remove-payment-order-project",function(e){
        e.preventDefault();
        var $row = $(this).closest("tr");
        bootbox.confirm("Quitar este proyecto de esta lista?",function(result){
            if(result)
            {
                $row.remove();
                evaluateVisibilityBtnRemove();
                updateNumbering();
                // deletePaymentOrderProject($row);
            }
        });
    });
    //reset brand list from select2 after change company
    $(document).on("change",".project-quick-select2", function(e){
        e.preventDefault();
        var projectId = $(this).val();
        var $row = $(this).closest("tr");
        if($.isNumeric(projectId))
        {
            getOriginalBudgets(projectId, $row);
        }
    });
    $(document).on("keyup","input[name=design-budget], input[name=transportation-budget], input[name=building-budget], input[name=live-line-budget], input[name=right-of-way-budget]",function(){
       updateTotalBudgets();
    });

    $(document).on("click",".save-payment-order-project",function(){
        var $form = $("form[name=payment-order-add]");
        if($form .parsley().isValid())
        {
            savePaymentOrder();
        }
        else
        {
            $form.parsley().validate();
        }
    });
});

function loadTable()
{
    var data = {
        index: 1,
        design_budget:0,
        transportation_budget:0,
        building_budget:0,
        live_line_budget:0
    };
    var projectList = [data];
    var teamHourlyRateRow = $("#ht-payment-orders-projects-row").html();
    Handlebars.registerPartial("ht-payment-orders-projects-row", teamHourlyRateRow);
    var htmlSource   = $("#ht-payment-orders-projects").html();
    var template = Handlebars.compile(htmlSource);
    var data = {projectList:projectList};
    var html = template(data);
    $("#table-payment-orders-projects").html(html);
    projectQuickSelect2();
    evaluateVisibilityBtnRemove();
    $(".input-masked").inputmask();
}

function evaluateVisibilityBtnRemove()
{
    var totalPartners = $("#project-list-content").children().length;
    if(totalPartners <= 1)
    {
        $(".remove-payment-order-project").addClass("hidden");
    }
    else
    {
        $(".remove-payment-order-project").removeClass("hidden");
    }
}

function deletePaymentOrderProject(paymentOrderProject)
{
    var paymentOrderProjectId = paymentOrderProject.data("payment-order-project-id");
    if(paymentOrderProjectId != "")
    {
        $.ajax({
            url : base_url + 'panel/AjaxPaymentManagement/deletePaymentOrderProject',
            type : "POST",
            dataType  :"json",
            data : {paymentOrderProjectId:paymentOrderProjectId},
            success:function(response){
                if(response.success == 1)
                {
                    // loadTable();
                }
                else
                {
                    bootbox.alert(response.message);
                }
            }
        });
    }
    else
    {
        // loadTable();
    }
}
function formatRepo (response) {
    if (response.loading)
        return response.text;

    var htmlSource   = $("#ht-select2-project-response").html();
    var template = Handlebars.compile(htmlSource);
    var data = {project:response};
    var html = template(data);
    return html;
}

function getOriginalBudgets(projectId, row)
{
    var currentIds = []; 
    var countProjectId = 0;
    var pos = "";
    $.each($(".project-quick-select2"),function(index, value){
        currentIds.push($(value).val());
        
        if($(value).val() == projectId)
        {
            countProjectId++;
            if(countProjectId == 1)
            {
                pos = (index+1);
            }
        }
    });
    
    if(countProjectId <= 1)
    {
        $.ajax({
            url : base_url + 'panel/AjaxPaymentManagement/getOriginalBudgets',
            type : "POST",
            dataType  :"json",
            data : {projectId:projectId},
            success:function(response){
    
                if(response.status == 39 || response.status == 12 )
                {
                    row.find("input[name=design-budget]").val(response.rbDesign);
                    row.find("input[name=transportation-budget]").val(response.rbTransportation);
                    row.find("input[name=building-budget]").val(response.rbBuilding);
                    row.find("input[name=live-line-budget]").val(response.rbLiveLine);
                    row.find("input[name=right-of-way-budget]").val(response.rbRightOfWay);
                    updateTotalBudgets();
                }
                else
                {
                    row.find('.project-quick-select2').val(null).trigger('change');    
                    bootbox.alert({
                        title:"Algo salio mal!",
                        message: 'El proyecto '+response.projectCode+' no esta en la etapa de Mate. dev. a CRE ni en la etapa de Cancelado',
                        size:"medium"
                    });
                }
            }
        });
    }
    else
    {
        row.find('.project-quick-select2').val(null).trigger('change');    
        bootbox.alert({
            title:"Algo salio mal!",
            message: 'El proyecto que intenta elegir ya esta en la lista en la posicion #'+pos,
            size:"medium"
        });
    } 
}

function updateNumbering()
{
    var objectivesNumber = $(".row-counter");
    $.each(objectivesNumber,function(index, value){
        $(value).text(index+1);
    });
}
function updateTotalBudgets()
{
    var totalDesign = 0;
    var totalTransportation = 0;
    var totalBuilding = 0;
    var totalLiveLine = 0;
    var totalRightOfWayBudget = 0;
    var subTotal = 0;
    var rows = $("tr[data-row-index]");

    $.each(rows,function(index,value){
        var designBudget = $(value).find("input[name=design-budget]").val().replaceAll(",","");
        totalDesign += parseFloat(designBudget);
        subTotal += parseFloat(designBudget);
        var transportationBudget = $(value).find("input[name=transportation-budget]").val().replaceAll(",","");
        totalTransportation += parseFloat(transportationBudget);
        subTotal += parseFloat(transportationBudget);
        var buildingBudget = $(value).find("input[name=building-budget]").val().replaceAll(",","");
        totalBuilding += parseFloat(buildingBudget);
        subTotal += parseFloat(buildingBudget);
        var liveLineBudget = $(value).find("input[name=live-line-budget]").val().replaceAll(",","");
        totalLiveLine += parseFloat(liveLineBudget);
        subTotal += parseFloat(liveLineBudget);
        var rightOfWayBudget = $(value).find("input[name=right-of-way-budget]").val().replaceAll(",","");
        totalRightOfWayBudget += parseFloat(rightOfWayBudget);
        subTotal += parseFloat(rightOfWayBudget);
        $(value).find(".sub-total").text(parseFloat(subTotal).toLocaleString('en'));
        subTotal = 0;
    });
    var totalBudget = totalDesign + totalTransportation + totalBuilding + totalLiveLine + totalRightOfWayBudget;

    totalBudget = totalBudget.toFixed(2);
    totalBudget = parseFloat(totalBudget).toLocaleString('en');
    totalDesign = totalDesign.toFixed(2);
    totalDesign = parseFloat(totalDesign).toLocaleString('en');
    totalTransportation = totalTransportation.toFixed(2);
    totalTransportation = parseFloat(totalTransportation).toLocaleString('en');
    totalBuilding = totalBuilding.toFixed(2);
    totalBuilding = parseFloat(totalBuilding).toLocaleString('en');
    totalLiveLine = totalLiveLine.toFixed(2);
    totalLiveLine = parseFloat(totalLiveLine).toLocaleString('en');
    totalRightOfWayBudget = totalRightOfWayBudget.toFixed(2);
    totalRightOfWayBudget = parseFloat(totalRightOfWayBudget).toLocaleString('en');
    $("span.total-design").text(totalDesign);
    $("span.total-transportation").text(totalTransportation);
    $("span.total-building").text(totalBuilding);
    $("span.total-live-line").text(totalLiveLine);
    $("span.total-right-of-way").text(totalRightOfWayBudget);
    $("span.total-budget").text(totalBudget);
}

function savePaymentOrder()
{
    var $formContent = $("#payment-order-form-content");
    var projectList = $("#project-list-content").children();
    var projectArrayObject = [];
    var paymentOrderProjects = {};
    var data = {
        orderNumber: $("input[name=order-number]").val(),
        entryDate: $("input[name=entry-date]").val(),
		endContractId: $("select[name=end-contract-id] option:selected").val(),
        detail: $("textarea[name=detail]").val()
    };
    $.each(projectList,function(index, value){
        var $row = $(value);
        //TODO: include detail
        paymentOrderProjects = {
            index:index+1,
            paymentOrderId: $row.data("payment-order-project-id"),
            projectId: $row.find("select.project").val(),
            designBudget: $row.find("input[name=design-budget]").val(),
            transportationBudget: $row.find("input[name=transportation-budget]").val(),
            buildingBudget: $row.find("input[name=building-budget]").val(),
            liveLineBudget: $row.find("input[name=live-line-budget]").val(),
            rightOfWayBudget: $row.find("input[name=right-of-way-budget]").val() || 0
        };
        projectArrayObject.push(paymentOrderProjects);
    });
    data.projectList = projectArrayObject;

    blockArea($formContent);
    $.ajax({
        url : base_url + 'panel/AjaxPaymentManagement/savePaymentOrder',
        type : "POST",
        dataType  :"json",
        data : data,
        success:function(response){
            var paymentOrderId = response.paymentOrderId;
            if(response.success == 1)
            {
                // loadTable();
                // bootbox.alert({
                //     title: "",
                //     message: "This is the small alert!",
                //     size: 'small'
                // });
				window.location.href = base_url + "panel/PaymentManagement/editPaymentOrder/"+paymentOrderId;
                // swal({ html:true, title:'Good job', text:response.message,type:"success"});
            }
            else
            {
                swal({ html:response.message, title:'Error!', type:"error"});
				$formContent.unblock();
            }

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
