/**
 * Created by Jair on 07/09/2018.
 */

$(document).ready(function() {
    loadTable();

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
            live_line_budget:0
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
                // deletePaymentOrderProject($row);
            }
        });
    });
    //reset brand list from select2 after change company
    $(document).on("change",".select2.project",function(e){
        e.preventDefault();
        var projectId = $(this).val();
        getOriginalBudgets(projectId);

        // $('#ajax-get-brands').val(null).trigger("change");
    });
});

function loadTable()
{
    var projectList = [1,2,3,4];
    var teamHourlyRateRow = $("#ht-payment-orders-projects-row").html();
    Handlebars.registerPartial("ht-payment-orders-projects-row", teamHourlyRateRow);
    var htmlSource   = $("#ht-payment-orders-projects").html();
    var template = Handlebars.compile(htmlSource);
    var data = {projectList:projectList};
    var html = template(data);
    $("#table-payment-orders-projects").html(html);
    startSelect2Projects();
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
                return {
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

function getOriginalBudgets(projectId)
{
    $.ajax({
        url : base_url + 'panel/AjaxPaymentManagement/getOriginalBudgets',
        type : "POST",
        dataType  :"json",
        data : {projectId:projectId},
        success:function(response){
            console.log(response);
        }
    });
}
