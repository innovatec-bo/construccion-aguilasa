/**
 * Created by Jair on 23/04/2018.
 */
$(document).ready(function() {
    var treeData = $("input[name=tree-data]").val();
    console.log(jQuery.parseJSON(treeData));
    $('#container').jstree({
        "plugins" : ["checkbox","dnd"],
        'core' : {
            'data' : jQuery.parseJSON(treeData),
            "check_callback" : true
        }
    });
});