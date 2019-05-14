/**
 * Created by Jair on 07/02/2019.
 */

function IncidentHandler() {

    let id = Date.now();
    let buttonAdd = ".add-incident";
    let serverResponse = "";
    let htmlTemplate = "";
    this.daysWithoutIncidents = 0;

    this.add = function(formData, statusId, projectId)
    {
        let method = !formData?"GET":"POST";
        projectId = projectId === undefined?null:projectId;
        let _this = this;
        $.ajax({
            url : base_url + 'panel/AjaxIncident/add/' + statusId + '/' + projectId,
            dataType  :"json",
            method : method,
            data:formData,
            success:function(response){
                if(response.success === 1 && !formData)
                {
                    _this.launchForm(response)
                }
                else if(response.success === 1 && formData)
                {
                    let $tableProject = $("#project-index");
                    if($tableProject.length <= 0)
                    {
                        if(formData.pauseProject == 1 || formData.stopProject == 1)
                        {
                            window.location.reload();
                        }
                        else
                        {
                            // checkIncidents();
                        }
                    }
                    console.log("success: "+response.message);
                }
                else
                {
                    console.log("error: "+response.message);
                }
            }
        });
    };

    this.launchForm = function(response)
    {
        let _this = this;
        let queue = {};
        let list = [];
        let steps = [];
        serverResponse = response;
        htmlTemplate = response.template;
        let $template = $("<div>"+htmlTemplate+"</div>");
        let htmlSource   = $template.find("#ht-modal-incident-form").html();
        let template = Handlebars.compile(htmlSource);

        $.each(response.projectList, function(index, value){
            let data = {projectData:value};
            let html = template(data);
            list.push({"title":value.code_pro + " - " + value.status_name_pst, "html":html});
            steps.push(index + 1);
        });
        queue.list = list;
        if(response.projectList.length > 1)
        {
            queue.steps = steps;
        }

        Swal.mixin({
            confirmButtonText: 'Guardar incidencia &rarr;',
            showCancelButton: false,
            focusConfirm: true,
            customClass:"incident-modal-form",
            progressSteps: queue.steps,
            preConfirm: () => {
                let $form = $("form[name=incident-form]");
                let incidentType = $("select[name=incident-type] option:selected").val();
                let noneIncidentGroup = {};
                if(incidentType == 9)
                {
                    noneIncidentGroup = {group: "none-incident"};
                }
                if($form.parsley().isValid(noneIncidentGroup))
                {
                    let projectId = $("input[name=project-id]").val();
                    let statusId = $("input[name=status-id]").val();
                    let detail = $('textarea[name=incident-detail]').val();
                    let percentage = $('input[name=incident-percentage]').val();
                    let entryDate = $('input[name=incident-manual-entry-date]').val();
                    let pauseProject = $("input[name=pause-project]").is(":checked")?1:0;
                    let stopProject = $("input[name=stop-project]").is(":checked")?1:0;

                    let formData = {
                        projectId:projectId,
                        statusId:statusId,
                        detail:detail,
                        percentage:percentage,
                        entryDate:entryDate,
                        pauseProject:pauseProject,
                        stopProject:stopProject,
                        incidentType:incidentType
                    };
                    _this.add(formData, statusId, projectId);
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
        }).queue(queue.list).then((result) => {
            if (result.value) {
                // Swal.fire({
                //     title: 'Guardando incidencias...',
                //     showConfirmButton: TRUE,
                // });
            }
        });
    };

    this.getAllIncidents = function()
    {
        let $content = $("#incident-content");
        let _this = this;
        blockArea($content);
        $.ajax({
            url : base_url + 'panel/AjaxIncident/getIncidentLog',
            dataType  :"json",
            method : "GET",
            data:{},
            success:function(response)
            {
                let $template = $("<div>"+response.data.template+"</div>");
                let htmlSource   = $template.find(response.data.templateName).html();
                let template = Handlebars.compile(htmlSource);
                let data = {incidentList:response.data.incidentList};
                let html = template(data);
                $content.html(html);
                // console.log(response);
                _this.setDaysWithoutIncidents(response.data.incidentList);
            }
        });
    };

    this.setDaysWithoutIncidents = function(incidentList)
    {
        let lastIncident = incidentList[0];
        let momentLastDate = moment(lastIncident.manual_entry_date);
        let momentCurrentDate = moment();
        this.daysWithoutIncidents = momentCurrentDate.diff(momentLastDate, 'days');
        let text = this.daysWithoutIncidents > 1? this.daysWithoutIncidents+" dias ": this.daysWithoutIncidents+" dia ";
        $("#days-without-incidents").text(text);
    };

    this.loadEventHandlers = function()
    {
        let _this = this;
        $(document).on("click", buttonAdd,function(e){
            e.preventDefault();
            let statusId = $(this).data("status-id");
            let projectId = $(this).data("project-id");
            _this.add(undefined, statusId, projectId);
            $('.popover').popover('destroy');
        });
    };
}