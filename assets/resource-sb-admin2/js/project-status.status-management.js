/**
 * Created by Jair on 12/06/2018.
 */
$(document).ready(function() {
    getStakesLeaderProjects();


});

function getStakesLeaderProjects()
{
    $.ajax({
        url : base_url + 'panel/AjaxProject/getStakesLeaderProjects',
        dataType  :"json",
        type : "POST",
        success:function(response){
            var stakesProject = [];

            $.each(response,function(index,value){
                stakesProject.push(value);
            });
            var partial = $("#ht-stakes-project-item").html();
            Handlebars.registerPartial("ht-stakes-project-item", partial);

            var htmlSource   = $("#ht-stakes-project").html();
            var template = Handlebars.compile(htmlSource);
            var data = {stakesProject: stakesProject};
            var html = template(data);
            $(".status-content").html(html);
            $('[data-toggle="tooltip"]').tooltip();
            $(".sortable-list").sortable({
                connectWith: ".sortable-list",
                placeholder: "ui-state-highlight",
                items: "span:not(.success)",
                update: function( event, ui ) {
                    if (this === ui.item.parent()[0])
                    {
                        var leaderId = $(ui.item).parent().data("leader-id");
                        var projectId = $(ui.item).data("project-id");
                        updateProjectAssignment(leaderId, projectId);
                    }

                }
            }).disableSelection();
        }
    });
}

function updateProjectAssignment(leaderId, projectId)
{
    $.ajax({
        url : base_url + 'panel/AjaxProject/updateStakesLeaderProjects',
        dataType  :"json",
        type : "POST",
        data:{leaderId:leaderId, projectId:projectId},
        success:function(response){
            console.log(response);
        }
    });
}