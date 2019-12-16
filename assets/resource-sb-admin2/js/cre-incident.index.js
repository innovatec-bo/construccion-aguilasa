$(document).ready(function() {
    new PerfectScrollbar('#incident-list', {
    wheelSpeed: 2,
    wheelPropagation: true,
    minScrollbarLength: 50
    });
    let date = new Date();
    $('.date-time-picker').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'DD-MM-YYYY',
        locale:"es"
    });
    var totalCharacters = 300;
    $(document).on("keyup","textarea[name=incident-detail]",function(e){
        let currentCharacters = $(this).val().length;
        $("#textarea-counter").text(totalCharacters-currentCharacters);
    });

    $(document).on("submit","form[name=incident-form]",function(){
        let $element = $('.panel-form-incident');
        blockArea($element);
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