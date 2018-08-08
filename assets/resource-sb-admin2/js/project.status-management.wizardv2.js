$('.wizard li').click(function() {
    if(!$(this).hasClass("disabled"))
    {
        $(this).prevAll().addClass("completed");
        $(this).nextAll().removeClass("completed");
    }
    else {
        return false;
    }
});