/**
 * Created by Jair on 23/04/2018.
 */
$(document).ready(function() {
    $(document).on("submit","form[name=signup-form]",function(e){
       e.preventDefault();
        signUp();
    });
});

function signUp()
{
    var $form = $("form[name=signup-form]");
    $.ajax({
        type:"post",
        dataType:"json",
        url:base_url+"AjaxSignUp/signUp",
        data:$form.serialize(),
        beforeSend:function()
        {
        },
        success:function(response)
        {
            console.log(response);
            if(response.success === 1)
            {
                window.location = base_url + response.url;
            }
            else
            {
                var htmlSource   = $("#ht-error-message").html();
                var template = Handlebars.compile(htmlSource);
                var templateData = {message:response.message};
                var message = template(templateData);
                $("#flash-data-basic-message div").html(message);
            }
        }
    });
}