/**
 * Created by Jair on 23/04/2018.
 */
var tree = {};
$(document).ready(function() {
    var treeData = $("input[name=tree-data]").val();
    tree = $('#container')
        .on('select_node.jstree', function(event, data) {
            alert('selecting');
        })
        .jstree({
        "plugins" : ["checkbox","dnd","contextmenu"],
        'core' : {
            'data' : jQuery.parseJSON(treeData),
            "check_callback" : true
        },
        'contextmenu': {
            'select_node': false,
            'items': reportMenu
        }
    });

    // $('#container').on("changed.jstree", function (e, data) {
    //     console.log("The selected nodes are:");
    //     console.log(data.selected);
    // });
    var roleId = $("input[type=radio][name=roles]:checked").val();
    getRoles(roleId);
    $(document).on("change","input[type=radio][name=roles]",function(){
        roleId = $(this).val();
        getRoles(roleId);
    });

    $(document).on("click",".save-permissions",function(){
        var checked = $("#container").jstree("get_checked",null,true);
        var undetermined = $("#container").jstree("get_undetermined",null);
        var permissionsToSave = jQuery.merge(checked, undetermined);
        roleId = $("input[type=radio][name=roles]:checked").val();
        // console.log(roleId, permissionsToSave);
        savePermissions(roleId, permissionsToSave);
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
            // console.log(response);
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

function savePermissions(roleId, featureList)
{
    $.ajax({
        url : base_url + 'panel/AjaxPermission/savePermissions',
        dataType  :"json",
        type : "POST",
        data : {roleId : roleId, featureList: featureList},
        success:function(response){
            console.log(response);
        }
    });
}

function demo_rename() {
    var ref = tree;//$('#jstree_demo').jstree(true),
        sel = ref.get_selected();
    if(!sel.length) { return false; }
    sel = sel[0];
    ref.edit(sel);
}

function demo_create() {
    var ref = $('#container').jstree(true),
    sel = ref.get_selected();
    if(!sel.length) { return false; }
    sel = sel[0];
    sel = ref.create_node(sel, {"type":"file"});
    if(sel)
    {
        ref.edit(sel);
    }
}

function reportMenu(node) {
    alert('Node id ' + node.id);
    // build your menu depending on node id
    return {
        createItem : {
            "label" : "Create feature",
            "action" : function(obj) { this.create(obj); alert(obj.text())},
            "_class" : "class"
        },
        renameItem : {
            "label" : "Rename feature",
            "action" : function(obj) { this.rename(obj);}
        },
        deleteItem : {
            "label" : "Delete feature",
            "action" : function(obj) { this.remove(obj); }
        }
    };
}