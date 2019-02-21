/**
 * Created by Jair on 21/02/2019.
 */

function StatusManagementHandler_deprecated(projectId, statusSet) {

    let buttonAdd = ".add-status";
    let buttonEdit = ".edit-status";
    let statusManagementContentSelector = "div#status-management-content";
    this.loadViewResponse = "";
    this.loadViewTemplate = "";
    // this.projectId = null;
    // this.statusSet = null;

    this.loadView = function()
    {
        let _this = this;
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/statusManagement/' + statusSet + '/' + projectId,
            dataType  :"json",
            method : "GET",
            data:{},
            success:function(response){
                _this.loadViewResponse = response;
                if(response.success === 1)
                {
                    _this.loadViewTemplate = response.data.template;
                    let $template = $("<div>"+_this.loadViewTemplate+"</div>");
                    let htmlSource   = $template.find("#ht-status-management").html();
                    let template = Handlebars.compile(htmlSource);
                    let html = template({});
                    $(statusManagementContentSelector).html(html);
                }
                else
                {
                    console.log("error: "+response.message);
                }
            }
        });
    };

    this.loadCards = function()
    {

    };

    this.loadSteps = function()
    {

    };

    this.loadHistory = function()
    {

    };

    this.loadIncidents = function()
    {

    };

    this.add = function(formData, statusId, projectId)
    {

    };

    this.edit = function(formData, statusId, projectId)
    {

    };

    this.launchForm = function(response)
    {

    };

    this.loadEventHandlers = function()
    {
        let _this = this;
        $(document).on("click", buttonAdd,function(e){
            e.preventDefault();
            let statusId = $(this).data("status-id");
            let projectId = $(this).data("project-id");
            _this.add(undefined, statusId, projectId);
        });
        $(document).on("click", buttonEdit,function(e){
            e.preventDefault();
            let statusId = $(this).data("status-id");
            let projectId = $(this).data("project-id");
            _this.add(undefined, statusId, projectId);
        });
    };
}