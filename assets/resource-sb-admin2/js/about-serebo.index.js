/**
 * Created by Jair on 11/09/2018.
 */
$(document).ready(function() {
    getTwiitiCodeLabInfo();
});
function getTwiitiCodeLabInfo()
{
    $.ajax({
        url : base_url + 'panel/AjaxAboutSerebo/getPushEvents',
        type : "POST",
        dataType  :"json",
        data : {},
        success:function(response){
            var list = [1,2,3];
            var timeLineItem = $("#ht-about-panel-time-line-item").html();
            Handlebars.registerPartial("ht-about-panel-time-line-item", timeLineItem);
            var htmlSource   = $("#ht-about-panel-time-line").html();
            var template = Handlebars.compile(htmlSource);
            var data = {eventList:response};
            var html = template(data);
            $("#timeline").html(html);
            console.log(response);
            //something went wrong
            if(response.message !== undefined)
            {

            }
            else
            {

            }
        }
    });
}