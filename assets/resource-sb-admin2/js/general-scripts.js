/**
 * Created by Jair on 10/01/2018.
 */

$(document).ready(function() {
    $(document).on("click",".datatable-delete-button",function(e){
        e.preventDefault();
        var objectId = $(this).data("object-id");
        var url = $(this).data("url");
        deleteObject(objectId, url);
    });
});
function deleteObject(objectId, url)
{
    bootbox.confirm({
        message: "Eliminar?",
        size:"small",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result)
            {
                window.location = url;
            }
        }
    });
}