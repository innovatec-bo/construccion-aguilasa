// export {};
declare let Handlebars: any;
declare let blockArea: any;
declare let base_url: any;
declare let $: any;
declare let Object: any;
declare let window: any;
declare let Swal: any;
declare let bootbox: any;
declare let moment: any;
declare let PerfectScrollbar: any;

class IncidentHandler
{
    private _id: number;
    private _buttonAdd: string;
    private _serverResponse: any;
    private _htmlTemplate: any;
    private _daysWithoutIncident: number;

    public constructor()
    {
        this._buttonAdd = ".add-incident";
        this._serverResponse = {};
        this._htmlTemplate = "";
        this._daysWithoutIncident = 0;
    }

    public add(formData?)
    {
        let _this = this;
        let method = !formData?"GET":"POST";
        $.ajax({
            url : base_url + 'panel/AjaxIncident/add/' + statusId + '/' + projectId,
            dataType  :"json",
            method : method,
            data:formData,
            success:function(response){
                if(response.success === 1 && !formData)
                {
                    _this._launchForm(response)
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
                            let $incidentContent = $("#incident-content");
                            if($incidentContent.length > 0 && $.isNumeric(statusId))
                                IncidentHandler.checkStatusIncidents(projectId, statusId);
                        }
                    }
                }
                else
                {
                    alert("error: "+response.message);
                }
            }
        });
    }

    private _launchForm (response)
    {
        let _this = this;
        let queue = {list:[], steps: []};
        let list = [];
        let steps = [];
        this._serverResponse = response;
        this._htmlTemplate = response.template;
        let $template = $("<div>"+this._htmlTemplate+"</div>");
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
    }

    public getAllIncidents()
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
                _this._setDaysWithoutIncidents(response.data.incidentList);
                new PerfectScrollbar('#incident-list', {
                wheelSpeed: 2,
                wheelPropagation: true,
                minScrollbarLength: 50
                });
            }
        });
    }

    public static checkStatusIncidents(projectId, statusId)
    {
        let _this : any = this;
        let data : any = {
            projectId: projectId,
            statusId: statusId
        };
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/checkIncidents',
            dataType  :"json",
            type : "POST",
            data:data,
            success:function(response){
                let currentProjectPercentage: number = 0;
                if(response.allIncidents.length > 0)
                {
                    currentProjectPercentage = response.allIncidents[0].percentage_inc;
                }
                let data = {incidentList:response.incidentList, currentProjectPercentage:currentProjectPercentage};
                // let html = _this.getHandlebarHtml("#ht-modal-incident-list", data);
                let $template = $("<div>"+response.template+"</div>");
                let htmlSource   = $template.find("#ht-modal-incident-list").html();
                let template = Handlebars.compile(htmlSource);
                let html = template(data);
                $("#incident-content").html(html);
            }
        });
    }

    private _setDaysWithoutIncidents(incidentList)
    {
        let lastIncident = incidentList[0];
        let momentLastDate = moment(lastIncident.manual_entry_date);
        let momentCurrentDate = moment();
        this._daysWithoutIncident = momentCurrentDate.diff(momentLastDate, 'days');
        let text = this._daysWithoutIncident > 1? this._daysWithoutIncident+" dias ": this._daysWithoutIncident+" dia ";
        $("#days-without-incidents").text(text);
    }

    public loadEventHandlers()
    {
        let _this = this;
        $(document).on("click", this._buttonAdd,function(e){
            e.preventDefault();
            let statusId = $(this).data("status-id");
            let projectId = $(this).data("project-id");
            _this.add(undefined, statusId, projectId);
            $('.popover').popover('destroy');
        });
    }
}