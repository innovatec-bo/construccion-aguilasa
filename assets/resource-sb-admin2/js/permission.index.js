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
        url : base_url + 'panel/AjaxPermission/getByRoleId',
        dataType  :"json",
        type : "POST",
        data : {roleId : roleId},
        success:function(response){
            // console.log(response);
            $.each(response,function(index,value){
                nodesToCheck.push(value.featureid_per);
            });
            $("#container").jstree("uncheck_all");
            $("#container").jstree("check_node",nodesToCheck);
        }
    });
}