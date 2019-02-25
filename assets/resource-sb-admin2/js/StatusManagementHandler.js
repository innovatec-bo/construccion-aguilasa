var StatusManagementHandler = (function () {
    function StatusManagementHandler(projectStatusSet, projectID) {
        this.projectStatusSet = projectStatusSet;
        this.projectID = projectID;
        this.statusSet = projectStatusSet;
        this.projectId = projectID;
        this.buttonAdd = ".add-status";
        this.buttonEdit = ".edit-status";
        this.viewData = {};
        this.statusManagementContentSelector = "div#status-management-content";
    }
    StatusManagementHandler.prototype.loadView = function () {
        var _this = this;
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/statusManagement/' + _this.statusSet + '/' + _this.projectId,
            dataType: "json",
            method: "GET",
            data: {},
            success: function (response) {
                _this.loadViewResponse = response;
                if (response.success === 1) {
                    _this.prepareViewData();
                    _this.loadViewTemplate = response.data.template;
                    var $template = $("<div>" + _this.loadViewTemplate + "</div>");
                    var htWizardStep = $template.find("#ht-wizard-step").html();
                    Handlebars.registerPartial("ht-wizard-step", htWizardStep);
                    var htmlSource = $template.find("#ht-status-management").html();
                    var template = Handlebars.compile(htmlSource);
                    var html = template({ viewData: _this.viewData });
                    $(_this.statusManagementContentSelector).html(html);
                    _this.projectLog();
                }
                else {
                    console.log("error: " + response.message);
                }
            }
        });
    };
    StatusManagementHandler.prototype.prepareViewData = function () {
        var project = this.loadViewResponse.data.projectFullDetail;
        var projectSystems = this.loadViewResponse.data.projectSystems;
        var statusList = this.loadViewResponse.data.statusList;
        var statusSet = this.loadViewResponse.data.statusSet;
        var updateHistory = this.loadViewResponse.data.updateHistory;
        var responsibleList = this.loadViewResponse.data.responsibleList;
        var responsibleListFiscal = this.loadViewResponse.data.responsibleListFiscal;
        var responsibleListBuilder = this.loadViewResponse.data.responsibleListBuilder;
        var statusName = "Este proyecto no esta en esta etapa";
        var projectOnCurrentStage = false;
        var disableStatus = false;
        if (project.status_pro == 20) {
            statusName = "Este proyecto ha sido devuelto a CRE";
            disableStatus = true;
        }
        else if (statusList.hasOwnProperty(project.status_pro)) {
            projectOnCurrentStage = true;
            statusName = statusList[project.status_pro].status_name_pst;
        }
        var showBtnEditConstructionAssignments = false;
        if (this.statusSet == "building" && this.loadViewResponse.data.updateHistory == 1) {
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
    };
    StatusManagementHandler.prototype.stepList = function () {
        var projectLog = this.loadViewResponse.data.projectLog;
        var viewData = this.viewData;
        var stepList = [];
        var previousStatusId = null;
        var statusSetList = this.statusSetList();
        $.each(projectLog, function (index, value) {
            if (previousStatusId != value.status_id_psl && statusSetList.indexOf(value.keyword_pst) >= 0) {
                previousStatusId = value.status_id_psl;
                var stepStatus = value.status_id_psl == viewData.project.status_pro ? " active " : "";
                var step = { stepId: value.status_id_psl, stepName: value.status_name_pst, stepKeyword: value.keyword_pst, stepStatus: stepStatus };
                stepList.push(step);
            }
        });
        return stepList.reverse();
    };
    StatusManagementHandler.prototype.statusSetList = function () {
        var statusSet = [];
        statusSet["design"] = ["project_has_been_created", "design", "stakes", "digitization", "schedule", "returned"];
        return statusSet[this.statusSet];
    };
    StatusManagementHandler.prototype.projectLog = function () {
        var viewData = this.viewData;
        var projectId = $("input[name=project-id]").val();
        var $logContent = $("#status-project-log-content");
        var $template = $("<div>" + this.loadViewTemplate + "</div>");
        blockArea($logContent);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/getProjectLog',
            dataType: "json",
            type: "POST",
            data: { projectId: projectId },
            success: function (response) {
                var allowUpdateHistory = viewData.allowUpdateHistory;
                var htmlSource = $template.find("#ht-status-project-log-quick-view").html();
                var template = Handlebars.compile(htmlSource);
                var data = { projectLog: response, allowUpdateHistory: allowUpdateHistory };
                var html = template(data);
                $logContent.html(html);
            }
        });
    };
    return StatusManagementHandler;
}());
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
