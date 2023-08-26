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
statusSet["12"] = "design";

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

    $(document).on("click","#quick-button-edit-project",function(e){
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
                        let url = base_url + "panel/Project/edit/"+value.id;
                        window.open(url, '_blank');
                    });
                    
                }
            }
        });
    });

    $(document).on("click","#quick-button-add-progress-project",function(e){
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
                        let url = base_url + "panel/Project/manpower/"+value.id;
                        window.open(url, '_blank');
                    });
                    
                }
            }
        });
    });

    $(document).on('click','.show-materials-summary', function(){
        let projectId = $(this).data('project-id');
        showSummaryList(projectId);
    });

    $(document).on('click','button[data-confirm-question]',function(){
		let $form = $(this).closest('form');
		let question = $(this).data('confirm-question');
		confirmSubmit(question, $form);
	  });
});
function confirmSubmit(question, form)
{
  Swal.fire({
      title: question,
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si",
      cancelButtonText: "No",
  }).then(function (result){
      if(result.value === true){
        form.submit();
      }
  });
}
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
	let $content = $(document.body);
    if($('.modal-content').length > 0)
	{
		$content = $('.modal-content');
	}
    else if($('.swal2-content').length > 0)
	{
		$content = $('.swal2-content');
	}

    $(containerCssClass).select2({
        placeholder: "Buscar estructura",
        containerCssClass: size,
        dropdownCssClass: "dd-select2-labor-cost",
        dropdownParent: $content,
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

                let $inputProjectId = $("input[name=project-id]");
				let projectId = "";
				if($inputProjectId.length > 0)
					projectId = $inputProjectId.val();
                return {
                    term : params.term || "",//search term
                    limit : 5,// page size
                    page: params.page || 1,
                    budgetaryPosition:budgetaryPosition,
                    management:management,
                    projectId:projectId
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

function timbthumbImage(url, width, height)
{
    width = width == "" || width == undefined?"":"&w="+width;
    height = height == "" || height == undefined ?"":"&w="+height;
    let response = base_url+"/timthumb/timthumb.php?src="+url+width+height;
    return response;
}

function select2ProjectGeneralList(selector)
{
    selector = selector || '.select2.project';
    //select2 ajax for projects
    $(selector).select2({
        placeholder: "Codigo de proyecto",
        containerCssClass: 'select-xs',
        allowClear : true,
        ajax : {
            url : base_url + 'panel/AjaxProject/select2',
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
        templateResult: select2ProjectGeneralListFormatResponse
    });
}

function select2ProjectGeneralListFormatResponse (response) {
    if (response.loading)
        return response.text;

    var htmlSource   = $("#ht-select2-project-response").html();
    var template = Handlebars.compile(htmlSource);
    var data = {project:response};
    var html = template(data);
    return html;
}

function downloadBuilderProductivityReport(builderId, month, year)
{
    // Swal({
    //   title: 'Reporte de produccion',
    //   text: "Especifique mes y anio",
    //   input:"text",
    //   showCancelButton: true,
    //   confirmButtonColor: '#3085d6',
    //   cancelButtonColor: '#d33',
    //   confirmButtonText: 'Descargar',
    //   cancelButtonText: 'Cancelar',
    //   allowOutsideClick:false
    // }).then((result) => {
    //     if (result.value) 
    //     {
    //         let data = $('.swal2-input').val();
    //         data = data.split("-");
    //         let month = data[0];
    //         let year = data[1];            
    //         window.location.href = base_url+"panel/Home/testProductivityReport/"+builderId+"/"+month+"/"+year;
    //     }
    // });
    window.location.href = base_url+"panel/Home/testProductivityReport/"+builderId+"/"+month+"/"+year;
}
function startSelect2MaterialsSummary(containerCssClass, size)
{
	containerCssClass = containerCssClass === undefined?".select2-labor-cost":containerCssClass;
	size = size === undefined?"":size;
	let $content = $(document.body);
	// if($('.modal-content').length > 0)
	// {
	// 	$content = $('.modal-content');
	// }
	// else if($('.swal2-content').length > 0)
	// {
	// 	$content = $('.swal2-content');
	// }

	$(containerCssClass).select2({
		placeholder: "Buscar material",
		containerCssClass: size,
		dropdownCssClass: "dd-select2-labor-cost",
		dropdownParent: $content,
		allowClear : true,
		ajax : {
			url : base_url + 'panel/AjaxMaterialSummary/select2',
			dataType : "json",
			type : "post",
			delay : 600,
            width:"100%",
			data : function(params) {
				return {
					term : params.term || "",//search term
					limit : 10,// page size
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
		"language": {
			"noResults": function(){
				// return '<button type="button" class="btn btn-primary btn-block add-new">Registrar nuevo</button>';
				return 'No se encontraron resultados';
			},
			"searching": function(){
				return 'Buscando..';
			}
		},
		//escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
		//templateResult: select2MaterialsSummaryResponse,
		width : "100%"
	});
}

function select2MaterialsSummaryResponse (response)
{
	if (response.loading)
		return response.text;

	let htmlSource   = $("#ht-select2-material-summary-response").html();
	let template = Handlebars.compile(htmlSource);
	let data = {data:response};
	return template(data);
}

function startSelect2Materials(containerCssClass, size, additionalParameter)
{
	containerCssClass = containerCssClass === undefined?".select2-labor-cost":containerCssClass;
	size = size === undefined?"":size;
	let $content = $(document.body);
	// if($('.modal-content').length > 0)
	// {
	// 	$content = $('.modal-content');
	// }
	// else if($('.swal2-content').length > 0)
	// {
	// 	$content = $('.swal2-content');
	// }

	$(containerCssClass).select2({
		placeholder: "Buscar material",
		containerCssClass: size,
		debug: true,
		dropdownCssClass: "dd-select2-labor-cost",
		dropdownParent: $content,
		// allowClear : true,
		ajax : {
			url : base_url + 'panel/AjaxMaterial/select2',
			dataType : "json",
			type : "post",
			delay : 600,
			cache: false,
			data : function(params) {
				let data = {
					term : params.term || "",//search term
					limit : 10,// page size
					page: params.page || 1
				};
				if(additionalParameter)
				{
					data.additionalParameters = additionalParameter.getList();
				}
				return data;
			},
			processResults: function (data) {
				return {
					results: data.list,
					// pagination: data.pagination
					pagination: {more:true}
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
		// escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
		// templateResult: select2MaterialsResponse,
		width : "100%"
	});
}

function select2MaterialsResponse (response)
{
	if (response.loading)
		return response.text;

	let htmlSource   = $("#ht-select2-material-response").html();
	let template = Handlebars.compile(htmlSource);
	let data = {data:response};
	return template(data);
}

function select2Workflow(selector)
{
    selector = selector || '.select2.workflow';
    //select2 ajax for projects
    $(selector).select2({
        placeholder: "Codigo de proyecto",
        containerCssClass: 'select-xs',
        allowClear : true,
        ajax : {
            url : base_url + 'panel/AjaxWorkflow/select2',
            dataType : "json",
            type : "post",
            delay : 600,
            data : function(params) {
                
                return {
                    term : params.term || "", //search term
                    limit : 10, // page size
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
        width : "100%"
        //escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        //templateResult: select2ProjectGeneralListFormatResponse
    });
}

function showSummaryList(projectId)
{
    $.ajax({
        url : base_url + 'panel/ajaxMaterialSummary/show/'+projectId,
        dataType  :"json",
        type : "get",
        data:{},
        success:function(response){

            if(response.success === 1 && response.data.list.length > 0)
            {
                let htmlSource   = $("#ht-show-materials-summary").html();
                let template = Handlebars.compile(htmlSource);
                let data = {'list':response.data.list};
                let html = template(data);
                Swal.fire({
                    title: '<strong>Resumen de materiales '+response.data.list[0].project_code+'</strong>',
                    width: '100%',
                    html: html,
                    showConfirmButton: false,
                    showCancelButton: true,
                    focusConfirm: false,
                    cancelButtonText:'Cerrar'
                });
            }
            else if(response.success === 1 && response.data.list.length <= 0)
            {
                Swal.fire({
                    type: 'error',
                    title: 'No se encontro un resumen de materiales',
                    text: 'Es probable que no se haya cargado una lista de materiales para este proyecto.',
                });
            }
        }
    });
}