// declare let jquery: any;
declare let Handlebars: any;
declare let blockArea: any;
declare let base_url: any;
class StatusManagementHandler
{

    private statusSet: string;
    private projectId: number;
    buttonAdd: string;
    buttonEdit: string;
    statusManagementContentSelector: string;
    loadViewResponse: any;
    loadViewTemplate: any;
    viewData: any;
    constructor(private projectStatusSet: string, private projectID: number)
    {
        this.statusSet = projectStatusSet;
        this.projectId = projectID;
        this.buttonAdd = ".add-status";
        this.buttonEdit = ".edit-status";
        this.viewData = {};
        this.statusManagementContentSelector = "div#status-management-content";
    }

    loadView()
    {
        let _this = this;
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/statusManagement/' + _this.statusSet + '/' + _this.projectId,
            dataType  :"json",
            method : "GET",
            data:{},
            success:function(response){
                _this.loadViewResponse = response;
                if(response.success === 1)
                {
                    _this.prepareViewData();
                    _this.loadViewTemplate = response.data.template;
                    let $template = $("<div>"+_this.loadViewTemplate+"</div>");

                    let htWizardStep = $template.find("#ht-wizard-step").html();
                    Handlebars.registerPartial("ht-wizard-step", htWizardStep);

                    let htmlSource = $template.find("#ht-status-management").html();
                    let template = Handlebars.compile(htmlSource);
                    let html = template({viewData:_this.viewData});
                    $(_this.statusManagementContentSelector).html(html);
                    _this.projectLog();
                }
                else
                {
                    console.log("error: "+response.message);
                }
            }
        });
    }
    prepareViewData()
    {
        let project = this.loadViewResponse.data.projectFullDetail;
        let projectSystems = this.loadViewResponse.data.projectSystems;
        let statusList = this.loadViewResponse.data.statusList;
        let statusSet = this.loadViewResponse.data.statusSet;
        let updateHistory = this.loadViewResponse.data.updateHistory;
        let responsibleList = this.loadViewResponse.data.responsibleList;
        let responsibleListFiscal = this.loadViewResponse.data.responsibleListFiscal;
        let responsibleListBuilder = this.loadViewResponse.data.responsibleListBuilder;
        let statusName = "Este proyecto no esta en esta etapa";
        let projectOnCurrentStage = false;
        let disableStatus = false;
        if(project.status_pro == 20)
        {
            statusName = "Este proyecto ha sido devuelto a CRE";
            disableStatus = true;
        }
        else if(statusList.hasOwnProperty(project.status_pro))
        {
            projectOnCurrentStage = true;
            statusName = statusList[project.status_pro].status_name_pst
        }

        let showBtnEditConstructionAssignments = false;
        if(this.statusSet == "building" && this.loadViewResponse.data.updateHistory == 1)
        {
            showBtnEditConstructionAssignments = true;
        }

        this.viewData.statusName = statusName;
        this.viewData.project = project;
        this.viewData.statusSet = statusSet;
        this.viewData.updateHistory = updateHistory;
        this.viewData.responsibleList = responsibleList;
        this.viewData.responsibleListFiscal = responsibleListFiscal;
        this.viewData.responsibleListBuilder = responsibleListBuilder;
        this.viewData.project.system = projectSystems[project.system_pro];
        this.viewData.showBtnEditConstructionAssignments = showBtnEditConstructionAssignments;
        this.viewData.stepList = this.stepList();

        console.log(this.loadViewResponse.data.project);
    }

    stepList()
    {
        let projectLog = this.loadViewResponse.data.projectLog;
        let viewData = this.viewData;
        let stepList = [];
        let previousStatusId = null;
        let statusSetList = this.statusSetList();
        $.each(projectLog, function(index, value){
            if(previousStatusId != value.status_id_psl && statusSetList.indexOf(value.keyword_pst) >= 0)
            {
                previousStatusId = value.status_id_psl;
                let stepStatus =  value.status_id_psl == viewData.project.status_pro?" active ":"";
                let step = {stepId:value.status_id_psl, stepName:value.status_name_pst, stepKeyword: value.keyword_pst, stepStatus:stepStatus};
                stepList.push(step);
            }
        });
        return stepList.reverse();

    }
    statusSetList()
    {
        let statusSet = [];
        statusSet["design"] = ["project_has_been_created", "design", "stakes", "digitization", "schedule","returned"];
        return statusSet[this.statusSet];
    }

    projectLog()
    {
        let viewData = this.viewData;
        let projectId = $("input[name=project-id]").val();
        let $logContent = $("#status-project-log-content");
        let $template = $("<div>"+this.loadViewTemplate+"</div>");
        blockArea($logContent);
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/getProjectLog',
            dataType  :"json",
            type : "POST",
            data : {projectId:projectId},
            success:function(response){
                let allowUpdateHistory = viewData.allowUpdateHistory;
                let htmlSource   = $template.find("#ht-status-project-log-quick-view").html();
                let template = Handlebars.compile(htmlSource);
                let data = {projectLog:response,allowUpdateHistory:allowUpdateHistory};
                let html = template(data);
                $logContent.html(html);
            }
        });
    }
}

// interface Person
// {
//     firstName: string;
//     lastName: string;
// }
//
// function greeter(person : Person)
// {
//     return "Hello, " + person.firstName + " " + person.lastName;
// }
//
// let user = new StatusManagementHandler("Jane", "M.", "User");
//
// document.body.innerHTML = greeter(user);