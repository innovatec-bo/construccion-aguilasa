/**
 * Created by Jair on 30/05/2018.
 */

$(document).ready(function() {
    getExecutiveSummary();
});

function getExecutiveSummary(system, management)
{
    var system = typeof system !== 'undefined' ? system : "";
    var management = typeof management !== 'undefined' ? management : "";
    var $content = $("#executive-summary-report");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getExecutiveSummary',
        dataType  :"json",
        type : "POST",
        data:{system:system, management:management},
        success:function(response){
            // if(response.success === 1)
            // {
                var htmlSource   = $("#ht-report-executive-summary").html();
                var template = Handlebars.compile(htmlSource);
                var data = {executiveSummary:response};
                var html = template(data);
            // }
            $content.html(html);
            console.log(response);
        }
    });
}
function blockArea(content)
{
    content.block({
        message: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>',
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8,
            cursor: 'wait'
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'transparent'
        }
    });
}