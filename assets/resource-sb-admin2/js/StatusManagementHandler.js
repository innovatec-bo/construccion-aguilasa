var StatusManagementHandler = (function () {
    function StatusManagementHandler(projectStatusSet, projectID) {
        this.projectStatusSet = projectStatusSet;
        this.projectID = projectID;
        this.statusSet = projectStatusSet;
        this.projectId = projectID;
        this.buttonAdd = ".add-status";
        this.buttonEdit = ".edit-status";
        this.buttonAddStep = ".add-step";
        this.buttonRemoveStep = ".remove-step";
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
                    // console.log("error: "+response.message);
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
        }
        else if (statusList.hasOwnProperty(project.status_pro)) {
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
                var completed = statusSetList.indexOf(value.keyword_pst) >= 0 ? " completed " : "";
                var stepStatus = value.status_id_psl == viewData.project.status_pro ? " active " : completed;
                var step_1 = { stepId: value.status_id_psl, stepName: value.status_name_pst, stepKeyword: value.keyword_pst, stepStatus: stepStatus };
                stepList.push(step_1);
            }
        });
        stepList.reverse();
        //Button to add more steps
        var step = { stepId: null, stepName: "", stepKeyword: null, stepStatus: "li-add-step" };
        stepList.push(step);
        return stepList;
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
    StatusManagementHandler.prototype.addStep = function (button) {
        this.launchStepSelector(button);
        var currentStepsQuantity = $(".step-list").children().length;
        var nextStep = this.loadViewResponse.data.steps[currentStepsQuantity - 1];
        var statusList = this.loadViewResponse.data.statusList;
        var $template = $("<div>" + this.loadViewTemplate + "</div>");
        var htmlSource = $template.find("#ht-wizard-step").html();
        var template = Handlebars.compile(htmlSource);
        var step = {};
        $.each(statusList, function (index, value) {
            if (value.keyword_pst == nextStep[0]) {
                step = { stepId: value.id_pst, stepName: value.status_name_pst, stepKeyword: value.keyword_pst, stepStatus: "" };
            }
        });
        var html = template(step);
        $(html).insertBefore($(".li-add-step"));
        button.parent().removeClass("li-add-step").addClass("li-remove-step");
        $(".step-list li").removeClass("active").addClass("completed");
        button.parent().prev().removeClass("completed").addClass("active");
        button.removeClass("add-step").addClass("remove-step");
        button.find("i").removeClass("fa-plus").addClass("fa-minus");
        console.log(nextStep);
    };
    StatusManagementHandler.prototype.launchStepSelector = function (button) {
        var currentStepsQuantity = $(".step-list").children().length;
        var nextStep = this.loadViewResponse.data.steps[currentStepsQuantity - 1];
        var $template = $("<div>" + this.loadViewTemplate + "</div>");
        var htmlSource = $template.find("#ht-select-next-step").html();
        var template = Handlebars.compile(htmlSource);
        var html = template({});
        button.parent().popover({
            title: 'Elija el siguiente paso',
            html: true,
            content: html
        });
        button.parent().trigger("click");
    };
    StatusManagementHandler.prototype.loadEventHandler = function () {
        var _this = this;
        $(document).on("click", this.buttonAddStep, function (e) {
            e.preventDefault();
            var $button = $(this);
            _this.addStep($button);
        });
        $(document).on("click", this.buttonRemoveStep, function (e) {
            e.preventDefault();
            $(".step-list li:last-child").prev().remove();
            $(this).removeClass("remove-step").addClass("add-step");
            $(".step-list li").removeClass("active").addClass("completed");
            $(this).parent().prev().removeClass("completed").addClass("active");
            $(this).parent().removeClass("li-remove-step").addClass("li-add-step");
            $(this).parent().prev().removeClass("completed").addClass("active");
            $(this).find("i").removeClass("fa-minus").addClass("fa-plus");
        });
        $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
            e.preventDefault();
            // console.log("toc toc");
            // if(!$(this).parent().hasClass("disabled"))
            // {
            //     status = $(e.target).attr("id");
            //     loadStatusForm(status);
            // }
            // else {
            return false;
            // }
        });
        $(document).on("click", ".cancel-add-step", function (e) {
            e.preventDefault();
            // let $popOver = $('.popover');
            $('.popover').popover('hide');
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
