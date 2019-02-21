// declare let base_url:base_url;
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
                    var htmlSource = $template.find("#ht-status-management").html();
                    var template = Handlebars.compile(htmlSource);
                    var html = template({ viewData: _this.viewData });
                    $(_this.statusManagementContentSelector).html(html);
                }
                else {
                    console.log("error: " + response.message);
                }
            }
        });
    };
    StatusManagementHandler.prototype.prepareViewData = function () {
        var viewProperty = {};
        var project = this.loadViewResponse.data.projectFullDetail;
        var projectSystems = this.loadViewResponse.data.projectSystems;
        var statusList = this.loadViewResponse.data.statusList;
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
        this.viewData.project.system = projectSystems[project.system_pro];
        this.viewData.showBtnEditConstructionAssignments = showBtnEditConstructionAssignments;
        console.log(this.loadViewResponse.data.project);
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
