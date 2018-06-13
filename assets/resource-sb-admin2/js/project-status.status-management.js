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
            // console.log(response);
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
            // if(response.success === 1 && !formData)
            // {
            //     launchForm(response, "Form edit")
            // }
            // else if(response.success === 1 && formData)
            // {
            //     sendFormResponse(response)
            // }
            // else
            // {
            //     bootbox.alert({
            //         title:"Something went wrong!",
            //         message: response.message,
            //         size:"medium"
            //     })
            // }
        }
    });
}