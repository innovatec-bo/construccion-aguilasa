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

// function startSelect2(containerSelector, baseUrl, containerCssClass)
// {
//     containerCssClass = containerCssClass === undefined?"":containerCssClass;
//     var placeholder = $(containerSelector).data("placeholder");
//     $('#ajax-select2-product-services').select2({
//         placeholder: placeholder,
//         allowClear : true,
//         containerCssClass: containerCssClass,
//         ajax : {
//             url : baseUrl,
//             dataType : "json",
//             type : "post",
//             delay : 600,
//             data : function(params) {
//                 return {
//                     term : params.term || "", //search term
//                     limit : 5, // page size
//                     page: params.page || 1
//                 };
//             },
//             processResults: function (data) {
//                 return {
//                     results: data.list,
//                     pagination: data.pagination
//                 };
//             }
//         },
//         width : "100%"
//     });
// }