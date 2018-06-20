/**
 * Created by Jair on 12/06/2018.
 */
$(document).ready(function() {
    // getStakesLeaderProjects();
    startSelect2Companies();

    $(document).on("click",".save-stakes",function(e){
        addTeamLeaderToProject();
    });
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

function startSelect2Companies()
{
    //select2 ajax for companies in bonus modal form
    $('#ajax-get-stakes-leader').select2({
        placeholder: "Elija un equipo",
        tags:true,
        multiple:true,
        allowClear : true,
        ajax : {
            url : base_url + 'panel/AjaxProjectStatus/getAllStakesTeamLeader',
            dataType : "json",
            type : "post",
            delay : 600,
            data : function(params) {
                return {
                    term : params.term || "", //search term
                    limit : 5, // page size
                    page: params.page || 1
                };
            },

            processResults: function (data) {
                return {
                    results: data.list,
                    pagination: data.pagination
                };
            }
        },
        width : "100%"
    });

    // create the default options and append to Select2
    var teamLeaderList = $("#ajax-get-stakes-leader").data("default");
    var list = [];
    var option = {};
    $.each(teamLeaderList,function(index, value){
        option = new Option(value.leader, value.id, true, true);
        list.push(option);

    });
    $('#ajax-get-stakes-leader').append(list).trigger('change');
}

function addTeamLeaderToProject()
{
    var teamLeaderIdList = $('#ajax-get-stakes-leader').select2("data");
    console.log(teamLeaderIdList);
}