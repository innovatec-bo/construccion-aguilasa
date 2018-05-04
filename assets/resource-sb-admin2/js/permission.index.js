/**
 * Created by Jair on 23/04/2018.
 */
var tree = {};
$(document).ready(function() {
    var treeData = $("input[name=tree-data]").val();
    tree = $('#container').jstree({
        "plugins" : ["checkbox","dnd"],
        'core' : {
            'data' : jQuery.parseJSON(treeData),
            "check_callback" : true
        }
    });

    $('#container').on("changed.jstree", function (e, data) {
        console.log("The selected nodes are:");
        console.log(data.selected);
    });

    $(document).on("change","input[type=radio][name=roles]",function(){
        var roleId = $(this).val();
        getRoles(roleId);
    });

    //get list of current nodes selected
    // $("#container").jstree("get_checked",null,true)

    //get list of current nodes selected
    // $("#container").jstree("get_undetermined",null)

    // var checked_ids = [];
    // $("#container").jstree("get_checked",null,true).each
8    // (function () {
    //     checked_ids.push(this.id);
    // });
    // console.log(checked_ids);
})

function getRoles(roleId)
{
    var nodesToCheck = [];
    $.ajax({
        url : base_url + 'panel/AjaxPermission/getFeaturesByRoleId',
        dataType  :"json",
        type : "POST",
        data : {roleId : roleId},
        success:function(response){
            console.log(response);
            $.each(response.featureByRole,function(index,value){
                //TODO: feature list should contain all feature!!!!!!!!!!
                if(!isParent(response.allFeatures,value.id_fes))
                {
                    nodesToCheck.push(value.id_fes);
                }
            });
            $("#container").jstree("uncheck_all");
            $("#container").jstree("check_node",nodesToCheck);
        }
    });
}

function isParent(featureList, featureId)
{
    var isParent = false;
    for(var i = 0; i < featureList.length; i++)
    {
        if(featureList[i].parent_feature_id_fes == featureId)
        {
            isParent = true;
            break;
        }
    }
    return isParent;
}