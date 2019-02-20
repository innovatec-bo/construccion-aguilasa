/**
 * Created by Jair on 07/02/2019.
 */

function IncidentHandler() {

    let buttonAdd = ".add-status";
    let buttonEdit = ".edit-status";
    let serverResponse = "";
    let htmlTemplate = "";

    this.loadView = function()
    {

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