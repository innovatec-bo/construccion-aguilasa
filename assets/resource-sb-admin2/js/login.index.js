/**
 * Created by Jair on 04/04/2019.
 */

$(function() {
    $("form[name=login-form]").on("submit",function(){
        blockArea($(".login-panel"));
    });
});

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