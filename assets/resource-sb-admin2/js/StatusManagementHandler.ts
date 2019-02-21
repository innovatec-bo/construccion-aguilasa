declare let $:any;
// declare let base_url:base_url;
class StatusManagementHandler
{
    private statusSet: string;
    private projectId: number;
    buttonAdd: string;
    buttonEdit: string;
    statusManagementContentSelector: string;
    loadViewResponse: string;
    loadViewTemplate: string;
    viewData: object;
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
                    let htmlSource   = $template.find("#ht-status-management").html();
                    let template = Handlebars.compile(htmlSource);
                    let html = template({viewData:_this.viewData});
                    $(_this.statusManagementContentSelector).html(html);

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
        let viewProperty = {};
        let project = this.loadViewResponse.data.projectFullDetail;
        let projectSystems = this.loadViewResponse.data.projectSystems;
        let statusList = this.loadViewResponse.data.statusList;
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
        this.viewData.project.system = projectSystems[project.system_pro];
        this.viewData.showBtnEditConstructionAssignments = showBtnEditConstructionAssignments;

        console.log(this.loadViewResponse.data.project);
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