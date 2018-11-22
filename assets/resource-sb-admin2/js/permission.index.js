/**
 * Created by Jair on 23/04/2018.
 */
$(document).ready(function() {

    $(document).on('dnd_stop.vakata', function () {
        sortFeatures();
    });

    $(document).on("change","input[type=radio][name=roles]",function(){
        var roleId = $(this).val();
        getRoles(roleId);
    });

    $(document).on("click",".launch-add-form",function(){
        launchAddForm();
    });


    $(document).on("click",".save-permissions",function(){
        var checked = $("#container").jstree("get_checked",null,true);
        var undetermined = $("#container").jstree("get_undetermined",null);
        var permissionsToSave = jQuery.merge(checked, undetermined);
        var roleId = $("input[type=radio][name=roles]:checked").val();
        // console.log(roleId, permissionsToSave);

        savePermissions(roleId, permissionsToSave);
    });

    //get list of current nodes selected
    // $("#container").jstree("get_checked",null,true)

    //get list of current nodes selected
    // $("#container").jstree("get_undetermined",null)
    loadTree();
});

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
    blockArea($('#container'));
    $.ajax({
        url : base_url + 'panel/AjaxPermission/savePermissions',
        dataType  :"json",
        type : "POST",
        data : {roleId : roleId, featureList: featureList},
        success:function(response){
            $('#container').unblock();
        }
    });
}

function reportMenu(node) {
    // alert('Node id ' + node.id);
    // build your menu depending on node id
    return {
        createItem : {
            "label" : "Create feature",
            "action" : function() {
                launchAddForm(node);
            },
            "_class" : "class"
        },
        renameItem : {
            "label" : "Edit feature",
            "action" : function() {
                launchEditForm(node);
            }
        },
        deleteItem : {
            "label" : "Delete feature",
            "action" : function(obj) { this.remove(obj); }
        }
    };
}

function loadTree()
{
    $.ajax({
        url : base_url + 'panel/AjaxPermission/getTreeFeatures',
        dataType  :"json",
        type : "POST",
        success:function(response){
            var tree = $('#container')
                .jstree({
                    "plugins" : ["checkbox","dnd","contextmenu"],
                    'core' : {
                        'data' : response,
                        'check_callback' : true
                    },
                    'contextmenu': {
                        'select_node': false,
                        'items': reportMenu
                    }
                })
                .on("model.jstree", function (event, nodes) {
                    if(nodes.nodes.length === 1)
                        console.log(event, nodes);
                })
                .on('ready.jstree', function(event, data) {
                    var roleId = $("input[type=radio][name=roles]:checked").val();
                    getRoles(roleId);
                });
        }
    });
}


function launchAddForm(node)
{
    var parentId = "#";
    if(typeof node === "object")
    {
        parentId = node.id;
    }
    var htmlSource   = $('#ht-modal-add-form').html();
    var template = Handlebars.compile(htmlSource);
    var data = {parentId:parentId};
    var html    = template(data);
    bootbox.confirm({
        title:"Add feature",
        message: html,
        buttons: {
            confirm: {
                label: 'Save',
                className: 'btn-success'
            },
            cancel: {
                label: 'Cancel',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result)
            {
                var form = $("form[name=modal-feature-add-form]");
                addFeature(form.serialize());
            }
        }
    });
}

function launchEditForm(node)
{
    $.ajax({
        url : base_url + 'panel/AjaxFeature/getById',
        dataType  :"json",
        type : "POST",
        data:{node:node},
        success:function(feature){
            var htmlSource   = $('#ht-modal-edit-form').html();
            var template = Handlebars.compile(htmlSource);
            var data = {feature:feature};
            var html    = template(data);
            bootbox.confirm({
                title:"Edit feature",
                // message: JSON.stringify(feature),
                message: html,
                buttons: {
                    confirm: {
                        label: 'Save',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result)
                    {
                        var form = $("form[name=modal-feature-edit-form]");
                        saveFeature(form.serialize());
                    }
                }
            });
        }
    });
}

function saveFeature(featureData)
{
    $.ajax({
        url : base_url + 'panel/AjaxFeature/edit',
        dataType  :"json",
        type : "POST",
        data:featureData,
        success:function(response){
            if(response.success === 1)
            {
                var tree = $('#container').jstree(true);
                tree.destroy();
                loadTree();
            }
            else
            {
                bootbox.alert({
                    title:"Something went wrong!",
                    message: response.message,
                    size:"medium"
                })
            }
        }
    });
}

function list()
{
    var treeData = $('#container').jstree(true).get_json('#', {flat:true});
    var jsonData = JSON.stringify(treeData);
    var jsonList = $.parseJSON(jsonData);
    console.log(jsonList);
}



function sortFeatures()
{
    var treeData = $('#container').jstree(true).get_json('#', {flat:true});
    var jsonData = JSON.stringify(treeData);
    var jsonList = $.parseJSON(jsonData);
    blockArea($('#container'));
    $.ajax({
        url : base_url + 'panel/AjaxFeature/sortFeatures',
        dataType  :"json",
        type : "POST",
        data : {featureList : jsonList},
        success:function(){
            var tree = $('#container').jstree(true);
            tree.destroy();
            loadTree();
            $('#container').unblock();
        }
    });

}

function addFeature(featureData)
{
    $.ajax({
        url : base_url + 'panel/AjaxFeature/add',
        dataType  :"json",
        type : "POST",
        data:featureData,
        success:function(response){
            if(response.status === 1)
            {
                var tree = $('#container').jstree(true);
                tree.destroy();
                loadTree();
            }
            else
            {
                bootbox.alert({
                    title:"Something went wrong!",
                    message: response.message,
                    size:"medium"
                })
            }
        }
    });

}
