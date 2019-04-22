/**
 * Created by Jair on 07/06/2018.
 */

$(document).ready(function() {
    // Basic date
    $("select[name=project-cre-fiscal]").select2();
    var date = new Date();
    $('.input-group.date').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'DD-MM-YYYY'
    });
    $(".input-masked").inputmask();
    $(document).on("click", ".save-project",function(e){
        e.preventDefault();
        var projectStatus = $(this).data("send-to-design");
        $("input[name=send-to-design]").val(projectStatus);
        $(this).closest("form").submit();

    });
    defineSecondaryButtonVisibility(false);
    $(document).on("change","input[name=instant-approvement]",function(e){
        e.preventDefault();
        var instantApprovement = $(this).is(":checked");
        defineSecondaryButtonVisibility(instantApprovement);
    });
    $(document).on("keyup","input[name=design-budget], input[name=building-budget], input[name=transportation-budget], input[name=live-line-budget], input[name=right-of-way-budget]", function(){
        updateTotalOnApprovedForm();
    });
});

function defineSecondaryButtonVisibility(instantApprovement)
{
    if(instantApprovement)
    {
        // $("[data-send-to-design=1]").addClass("hide");
        $("#approvement-section").removeClass("hide");
        $("#approvement-section").find("input[required]").attr("disabled",false);
    }
    else
    {
        // $("[data-send-to-design=1]").removeClass("hide");
        $("#approvement-section").addClass("hide");
        $("#approvement-section").find("input[required]").attr("disabled",true);
    }
}

function updateTotalOnApprovedForm()
{
    if($("#total-project-amount").length == 1)
    {
        var design = parseFloat($("input[name=design-budget]").val().replace(",",""));
        design = isNaN(design)?0:design;
        var building = parseFloat($("input[name=building-budget]").val().replace(",",""));
        building = isNaN(building)?0:building;
        var transportation = parseFloat($("input[name=transportation-budget]").val().replace(",",""));
        transportation = isNaN(transportation)?0:transportation;
        var liveLine = parseFloat($("input[name=live-line-budget]").val().replace(",",""));
        liveLine = isNaN(liveLine)?0:liveLine;
        var rightOfWay = parseFloat($("input[name=right-of-way-budget]").val().replace(",",""));
        rightOfWay = isNaN(rightOfWay)?0:rightOfWay;
        var total = design + building + transportation + liveLine + rightOfWay;
        total = total.toFixed(2);
        $("#total-project-amount").text(total);
    }
}