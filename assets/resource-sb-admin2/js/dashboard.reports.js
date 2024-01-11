$(document).ready(function() {

    $(document).on("submit","form.builder-general-report", function(e){
        e.preventDefault();
        let month = $("select[name=builder-general-report-month] option:selected").val();
        let year = $("select[name=builder-general-report-year] option:selected").val();
        if(month == "" || year == "")
        {
            toastr.error("Debe especificar un mes y anio para descargar el reporte", '', {'progressBar':true});
        }
        else
        {
            window.location.href = base_url+"panel/Dashboard/builderGeneralReport/"+month+"/"+year;
        }
    });
    
    $(document).on("submit","form.builder-manpower-productivity-report", function(e){
        e.preventDefault();
        let builderId = $("select[name=builder-productivity-report-builder] option:selected").val();
        let month = $("select[name=builder-productivity-report-month] option:selected").val();
        let year = $("select[name=builder-productivity-report-year] option:selected").val();
        if(builderId == "" || month == "" || year == "" )
        {
            toastr.error("Debe especificar un constructor, mes y anio para descagar el reporte", '', {'progressBar':true});
        }
        else
        {
            window.location.href = base_url+"panel/Dashboard/productivityReport/"+builderId+"/"+month+"/"+year;
        }
    });

    $(document).on("submit","form.projects-and-current-production", function(e){
        e.preventDefault();
        let month = $("select[name=projects-and-current-production-month] option:selected").val();
        let year = $("select[name=projects-and-current-production-year] option:selected").val();
        if(month == "" || year == "")
        {
            toastr.error("Debe especificar un mes y a&ntilde;io para descargar el reporte", '', {'progressBar':true});
        }
        else
        {
            window.location.href = base_url+"panel/Project/projectBudgets/"+month+"/"+year;
        }
    });

    $(document).on("submit","form.daily-production", function(e){
        e.preventDefault();
        let month = $("select[name=daily-production-month] option:selected").val();
        let year = $("select[name=daily-production-year] option:selected").val();
        if(month == "" || year == "")
        {
            toastr.error("Debe especificar un mes y a&ntilde;io para descargar el reporte", '', {'progressBar':true});
        }
        else
        {
            window.location.href = base_url+"panel/Project/dailyProductivityReport/"+month+"/"+year;
        }
    });

    $(document).on("submit","form.executive-report", function(e){
		e.preventDefault();
		let type = $('form.executive-report').find('select[name=executive-report-type] option:selected').val();
		window.location.href = base_url+"panel/Project/executiveReport/"+type;
	});

    $('input[name=stake-report-from]').datetimepicker({
        defaultDate: moment().startOf('month').format('YYYY-MM-DD'),
        ignoreReadonly: true,
        format: 'DD-MM-YYYY',
        locale:'es'
    });

    $('input[name=stake-report-to]').datetimepicker({
        ignoreReadonly: true,
        defaultDate:moment().endOf('month').format('YYYY-MM-DD'),
        format: 'DD-MM-YYYY',
        locale:'es',
        useCurrent: false
    });

    $("form[name=workflow-report]").on("submit", function(){
        var additionalActions = $("input[name=workflow-additional-actions]:checked").val();
        if(additionalActions !== "3")
        {
            saveTrackingList();
        }
    });

    $("form[name=workflow-report] button").on("click", function(e){
        var response = chooseWorkflowColumnsToDownload();
        // console.log(response);
    });

    function saveTrackingList()
    {
        var $formData = $("form[name=workflow-report]");
        blockArea($formData);
        $.ajax({
            url : base_url + 'panel/AjaxTrackingList/saveTrackingList',
            dataType  :"json",
            type : "POST",
            data:$formData.serialize(),
            success:function(response){
                $formData.unblock();
                var messageType = "error";
                if(response.success == 1)
                {
                    messageType = "success";
                    swal({ title:'', text:response.message, type:messageType});
                    $("#workflow-additional-actions3").prop("checked", true);
                    $("input[name=override-list]").val("0");
                    $("input[name=tracking-list-name]").closest("div").slideUp();
                    $('.select2.tracking-list').select2('destroy');
                    startSelect2TrackingList();
                }
                else
                {
                    if(response.overrideExisting !== undefined)
                    {
                        swal({
                            title:'La lista ya existe',
                            html:response.message,
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar',
                            confirmButtonText: 'Sobre escribir!',
                            allowOutsideClick:false
                        }).then((result) => {
                            if (result.value)
                            {
                                $("input[name=override-list]").val("1");
                                saveTrackingList();
                            }
                            else
                            {
                                $("#workflow-additional-actions3").prop("checked", true);
                                $("input[name=override-list]").val("0");
                                $("input[name=tracking-list-name]").closest("div").slideUp();
                                $('.select2.tracking-list').select2('destroy');
                                startSelect2TrackingList();
                            }
                        });
                    }
                    else
                    {
                        messageType = "error";
                        swal({ title:'', text:response.message, type:messageType});
                    }
                }
            
                

            }
        });
    }

    function deleteTrackingList(trackingListId)
    {
        var $formData = $("form[name=workflow-report]");
        blockArea($formData);
        $.ajax({
            url : base_url + 'panel/AjaxTrackingList/deleteTrackingList',
            dataType  :"json",
            type : "POST",
            data:{trackingListId:trackingListId},
            success:function(response){
                $formData.unblock();
                var messageType = "error";
                if(response.success == 1)
                    messageType = "success";

                swal({ title:'', text:response.message, type:messageType});
                $("#workflow-additional-actions3").prop("checked", true);
                $("input[name=tracking-list-name]").closest("div").slideUp();

                $("select[name=tracking-list-id]").val(null).trigger("change");
                $formData.find("textarea[name=code-list]").val("");
                $('.select2.tracking-list').select2('destroy');
                startSelect2TrackingList();
            }
        });
    }

    function chooseWorkflowColumnsToDownload()
    {
        var $form = $("form[workflow-report]");
        var data = $("input[name=workflow-column-list]").val();
        data = jQuery.parseJSON(data);
        var columnList = [];
        $.each(data, function(index, value){
            columnList.push({key:index, title:value});
        });
        var htmlSource   = $("#ht-workflow-report-columns-to-download").html();
        var template = Handlebars.compile(htmlSource);
        var data = {columnList:columnList};
        var html = template(data);
        var columnListToDownload = [];
        swal({
            title:'COLUMNAS A DESCARGAR',
            html:html,
            width:"80%",
            customClass:"columns-to-download",
            showCancelButton: true,
            confirmButtonText: 'Descargar!',
            allowOutsideClick:false,
        }).then((result) => {
            if (result.value)
            {
                var checkboxList = $(".workflow-columns-to-download:checked");
                $.each(checkboxList, function(index, value){
                    columnListToDownload.push($(value).val());
                });
                $("input[name=columns-to-download]").val(columnListToDownload);
                $("form[name=workflow-report]").submit();
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
        enableSelect2ColumnsGroupsName();
    }
});