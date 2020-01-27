/**
 * Created by Jair on 10/01/2018.
 */
var statusSet = [];
statusSet["46"] = "design";
statusSet["1"] = "design";
statusSet["2"] = "design";
statusSet["20"] = "design";
statusSet["3"] = "design";
statusSet["5"] = "design";
statusSet["6"] = "design";

statusSet["9"] = "approvement";
statusSet["10"] = "approvement";
statusSet["11"] = "approvement";
statusSet["12"] = "approvement";

statusSet["13"] = "rectify_design";
statusSet["15"] = "rectify_design";
statusSet["16"] = "rectify_design";
statusSet["17"] = "rectify_design";

statusSet["14"] = "rectify_illustration";
statusSet["18"] = "rectify_illustration";
statusSet["19"] = "rectify_illustration";

// el proyecto en estado 21(asignacion no va a ninguno de los procesos)
// statusSet["21"] = "warehouse";
// statusSet["22"] = "warehouse";
// statusSet["23"] = "warehouse";
// statusSet["24"] = "warehouse";
// statusSet["25"] = "warehouse";

statusSet["21"] = "building";
statusSet["27"] = "building";
statusSet["28"] = "building";
statusSet["29"] = "building";
statusSet["30"] = "building";
statusSet["31"] = "building";
statusSet["32"] = "building";
statusSet["33"] = "building";
statusSet["34"] = "building";
statusSet["35"] = "building";
statusSet["38"] = "building";
statusSet["39"] = "building";
statusSet["47"] = "building";
statusSet["45"] = "building";

$(document).ready(function() {
    let incidentHandler = new IncidentHandler();
    // incidentHandler.add(undefined, 30, 63);
    incidentHandler.loadEventHandlers();
    $(document).on("click",".datatable-delete-button",function(e){
        e.preventDefault();
        let objectId = $(this).data("object-id");
        let url = $(this).data("url");
        deleteObject(objectId, url);
    });
    $("[data-toggle=tooltip]").tooltip();
    $(document).on("submit","#quick-project-search-form",function(e){
        e.preventDefault();
        let codeList = $("#quick-project-search-input").val();
        $.ajax({
            url : base_url + 'panel/ajaxProject/getByCodeList',
            dataType  :"json",
            type : "POST",
            data:{codeList:codeList},
            success:function(response){
                if(response.success === 1)
                {
                    $.each(response.data.projectList, function(index, value){
                        let url = base_url + "panel/ProjectStatus/statusManagement/"+statusSet[value.status]+"/"+value.id;
                        window.open(url, '_blank');
                    });
                    
                }
            }
        });
    });
});
function deleteObject(objectId, url)
{
    bootbox.confirm({
        message: "Eliminar?",
        size:"small",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result)
            {
                window.location = url;
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

// function startSelect2(containerSelector, baseUrl, containerCssClass)
// {
//     containerCssClass = containerCssClass === undefined?"":containerCssClass;
//     var placeholder = $(containerSelector).data("placeholder");
//     $('#ajax-select2-product-services').select2({
//         placeholder: placeholder,
//         allowClear : true,
//         containerCssClass: containerCssClass,
//         ajax : {
//             url : baseUrl,
//             dataType : "json",
//             type : "post",
//             delay : 600,
//             data : function(params) {
//                 return {
//                     term : params.term || "", //search term
//                     limit : 5, // page size
//                     page: params.page || 1
//                 };
//             },
//             processResults: function (data) {
//                 return {
//                     results: data.list,
//                     pagination: data.pagination
//                 };
//             }
//         },
//         width : "100%"
//     });
// }

function incidentInsertBatch()
{
    let htmlSource   = $("#ht-modal-incident-form").html();
    let template = Handlebars.compile(htmlSource);
    let data = {currentPercentage:70,statusKeyword:"in_progress"};
    let html = template(data);
    Swal.mixin({
        confirmButtonText: 'Guardar incidencia &rarr;',
        showCancelButton: false,
        focusConfirm: true,
        html: html,
        width:"50%",
        // progressSteps: ['1', '2', '3','4','5','6','7','8','9','10','11','12','13','14','15']
        progressSteps: ['1', '2', '3'],
        preConfirm: () => {
            let $form = $("form[name=incident-form]");
            if($form.parsley().isValid())
            {
                savingIncidents($form.serialize());
                return [
                    $('textarea[name=incident-detail]').val(),
                    $("input[name=incident-manual-entry-date]").val()
                ]
            }
            else
            {
                $form.parsley().validate();
                return false;
            }
        },
        onBeforeOpen: () => {
            let date = new Date();
            $('input[name=incident-manual-entry-date]').datetimepicker({
                ignoreReadonly: true,
                defaultDate: date,
                format: 'DD-MM-YYYY'
            });
        }
    }).queue([
        {
            title: 'RA.18.3168 - En construccion'
        },
        {
            title: 'RA.18.3167 - En construccion'
        },
        {
            title: 'RD.17.0400 - En construccion'
        }
    ]).then((result) => {
        if (result.value) {
        Swal.fire({
                title: 'Guardando incidencias...',
                // html:
                // 'Your answers: <pre><code>' +
                // JSON.stringify(result.value) +
                // '</code></pre>',
                // confirmButtonText: 'Ok',
                showConfirmButton: false,

            });
        }
    });
}
function savingIncidents(formData)
{
    console.log(formData);
}

function startSelect2LaborCost(containerCssClass, size)
{
    containerCssClass = containerCssClass === undefined?".select2-labor-cost":containerCssClass;
    size = size === undefined?"":size;
    $(containerCssClass).select2({
        placeholder: "Buscar estructura",
        containerCssClass: size,
        dropdownCssClass: "dd-select2-labor-cost",
        dropdownParent: $('.modal-content'),
        // allowClear : true,
        ajax : {
            url : base_url + 'panel/AjaxLaborCost/select2',
            dataType : "json",
            type : "post",
            delay : 600,
            data : function(params) {
                let $selectBudgetaryPosition = $("select[name=project-budgetary-position]");
                let budgetaryPosition = "";
                if($selectBudgetaryPosition.length > 0)
                    budgetaryPosition = $selectBudgetaryPosition.val();

                let $selectManagement = $("select[name=management-by]");
                let management = "";
                if($selectManagement.length > 0)
                    management = $selectManagement.val();                
                return {
                    term : params.term || "",//search term
                    limit : 5,// page size
                    page: params.page || 1,
                    budgetaryPosition:budgetaryPosition,
                    management:management
                };
            },
            processResults: function (data) {
                return {
                    results: data.list,
                    pagination: data.pagination
                };
            }
        },
        "language": {
            "noResults": function(){
                // return '<button type="button" class="btn btn-primary btn-block add-new">Registrar nuevo</button>';
                return 'No se encontraron resultados';
            },
            "searching": function(){
                return 'Buscando..';
            }
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo,
        width : "100%"
    });
}

function formatRepo (response) 
{
    if (response.loading)
        return response.text;

    let htmlSource   = $("#ht-select2-labor-cost-response").html();
    let template = Handlebars.compile(htmlSource);
    let data = {laborCost:response};
    return template(data);
}

function openProyect()
{

}

function timbthumbImage(url, width, height)
{
    width = width == "" || width == undefined?"":"&w="+width;
    height = height == "" || height == undefined ?"":"&w="+height;
    let response = base_url+"/timthumb/timthumb.php?src="+url+width+height;
    return response;
}