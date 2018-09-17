/**
 * Created by Jair on 07/09/2018.
 */

$(document).ready(function() {
    loadTable();
    var date = new Date();
    $('input[name=entry-date]').datetimepicker({
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
        var projectSelect2 = ".project[data-select-index="+data.index+"]";
        startSelect2Projects(projectSelect2);
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
    $(document).on("change",".select2.project",function(e){
        e.preventDefault();
        var projectId = $(this).val();
        var $row = $(this).closest("tr");
        getOriginalBudgets(projectId, $row);

    });
    $(document).on("keyup","input[name=design-budget], input[name=transportation-budget], input[name=building-budget], input[name=live-line-budget], input[name=right-of-way-budget]",function(){
       updateTotalBudgets();
    });

    $(document).on("click",".save-payment-order-project",function(){
        savePaymentOrder();
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
    startSelect2Projects();
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

function startSelect2Projects(selector)
{
    selector = selector || '.select2.project';
    //select2 ajax for projects
    $(selector).select2({
        placeholder: "Escriba un codigo de proyecto",
        containerCssClass: 'select-xs',
        allowClear : true,
        ajax : {
            url : base_url + 'panel/AjaxProject/select2ProjectsThatReturnedMaterials',
            dataType : "json",
            type : "post",
            delay : 600,
            data : function(params) {
                var currentIds = [];
                $.each($(".select2.project"),function(index, value){
                    currentIds.push($(value).val());
                    // console.log($(value).val())
                });
                return {
                    currentIds:currentIds,
                    term : params.term || "", //search term
                    limit : 5, // page size
                    page: params.page || 1
                };
            },

            processResults: function (data) {
                return {
                    results: data.list,
                    pagination: data.pagination
                };
            }
        },
        width : "100%",
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo
    });
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
    $.ajax({
        url : base_url + 'panel/AjaxPaymentManagement/getOriginalBudgets',
        type : "POST",
        dataType  :"json",
        data : {projectId:projectId},
        success:function(response){
            row.find("input[name=design-budget]").val(response.design);
            row.find("input[name=transportation-budget]").val(response.transportation);
            row.find("input[name=building-budget]").val(response.building);
            row.find("input[name=live-line-budget]").val(response.liveLine);
            row.find("input[name=right-of-way-budget]").val(response.rightOfWay);
            updateTotalBudgets();
        }
    });
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
    var rows = $("tr[data-row-index]");

    $.each(rows,function(index,value){
        var designBudget = $(value).find("input[name=design-budget]").val().replace(",","");
        totalDesign += parseFloat(designBudget);
        var transportationBudget = $(value).find("input[name=transportation-budget]").val().replace(",","");
        totalTransportation += parseFloat(transportationBudget);
        var buildingBudget = $(value).find("input[name=building-budget]").val().replace(",","");
        totalBuilding += parseFloat(buildingBudget);
        var liveLineBudget = $(value).find("input[name=live-line-budget]").val().replace(",","");
        totalLiveLine += parseFloat(liveLineBudget);
        var rightOfWayBudget = $(value).find("input[name=right-of-way-budget]").val().replace(",","");
        totalRightOfWayBudget += parseFloat(rightOfWayBudget);
    });
    var totalBudget = totalDesign + totalTransportation + totalBuilding + totalLiveLine + totalRightOfWayBudget;
    $("span.total-design").text(totalDesign.toFixed(2));
    $("span.total-transportation").text(totalTransportation.toFixed(2));
    $("span.total-building").text(totalBuilding.toFixed(2));
    $("span.total-live-line").text(totalLiveLine.toFixed(2));
    $("span.total-right-of-way").text(totalRightOfWayBudget.toFixed(2));
    $("span.total-budget").text(totalBudget.toFixed(2));
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
            window.location.href = base_url + "panel/PaymentManagement/editPaymentOrder/"+paymentOrderId;
            // if(response.success == 1)
            // {
            //     loadTable();
            //     bootbox.alert({
            //         title: "",
            //         message: "This is the small alert!",
            //         size: 'small'
            //     });
            //     swal({ html:true, title:'Good job', text:response.message,type:"success"});
            // }
            // else
            // {
            //     swal({ html:true, title:'Something went wrong!', text:response.message,type:"error"});
            // }

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