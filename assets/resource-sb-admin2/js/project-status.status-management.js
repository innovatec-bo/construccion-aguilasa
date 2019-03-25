/**
 * Created by Jair on 12/06/2018.
 */
$(function() {
    let url = $(location).attr('href').split("/");
    let statusSet = url[url.length - 2];
    let projectId = url[url.length - 1];
    let statusManagementHandler = new StatusManagementHandler(statusSet, projectId);
    statusManagementHandler.loadView();
    statusManagementHandler.loadEventHandler();

    $(document).on("click",".show-detail", function(e){
       e.preventDefault();
       $("#basic-data").animate({width:'toggle'},350);
       $("#history-content").slideUp();
       $("#help-content").slideUp();
    });
    $(document).on("click",".show-history", function(e){
        e.preventDefault();
        $("#basic-data").slideUp();
        $("#history-content").animate({width:'toggle'},350);
        $("#help-content").slideUp();
    });
    $(document).on("click",".show-help", function(e){
        e.preventDefault();
        $("#basic-data").slideUp();
        $("#history-content").slideUp();
        $("#help-content").animate({width:'toggle'},350);
    });
});