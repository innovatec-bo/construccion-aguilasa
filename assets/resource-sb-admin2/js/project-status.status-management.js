/**
 * Created by Jair on 12/06/2018.
 */

 Dropzone.autoDiscover = false;
$(function() {
    let url = $(location).attr('href').split("/");
    let statusSet = url[url.length - 2];
    let projectId = url[url.length - 1];
    let statusManagementHandler = new StatusManagementHandler(statusSet, projectId);
    statusManagementHandler.loadView();
    statusManagementHandler.loadEventHandler();

    $(document).on("click",".show-detail", function(e){
       e.preventDefault();
       $("#basic-data").animate({width:'toggle'}, 350);
       $("#history-content").slideUp();
       $("#help-content").slideUp();
    });
    $(document).on("click",".show-history", function(e){
        e.preventDefault();
        $("#basic-data").slideUp();
        $("#history-content").animate({width:'toggle'}, 350);
        $("#help-content").slideUp();
    });
    $(document).on("click",".show-help", function(e){
        e.preventDefault();
        $("#basic-data").slideUp();
        $("#history-content").slideUp();
        $("#help-content").animate({width:'toggle'}, 350);
    });

    // let myDropzone = new Dropzone("#dropzone",{
    //     url: base_url + "panel/Settings/mainSlider",
    //     paramName: "file",
    //     maxFilesize: 30,
    //     acceptedFiles: "image/*",
    //     autoProcessQueue:false
    //     });

    // myDropzone.on("addedfile", function(file) {
    //     /* Maybe display some more file information on your page */
    //     let removeButton = Dropzone.createElement('<a class="btn btn-danger btn-xs dropzone-remove" href="#" title="" data-original-title="ELIMINAR" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a>');
    //     let _this = this;
    //     removeButton.addEventListener("click", function (e) {
    //         // Make sure the button click doesn't submit the form:
    //         e.preventDefault();
    //         e.stopPropagation();
    //         // Remove the file preview.
    //         _this.removeFile(file);
    //     });
    //     // Now attach this new element some where in your page
    //     $("#dropzone").append(file.previewElement);
    //     // Add the button to the file preview element.
    //     file.previewElement.appendChild(removeButton);
    // });
    // myDropzone.on("success", function(file, responseText) {
    //     let item = jQuery.parseJSON(responseText);
    //     addItem(item);
    //     this.removeFile(file);
    // });
    // getImages();

    // $(document).on("click",".dropzone-process-queue",function(e){
    //     e.preventDefault();
    //     Dropzone.instances[0].processQueue();
    // });

    // $(document).on("click",".btn-delete",function(e){
    //     e.preventDefault();
    //     var mainSliderItemId = $(this).closest("[data-main-slider-item-id]").data("main-slider-item-id");
    //     console.log(mainSliderItemId);
    // });
});

function addItem(item, replace)
{
    var htmlSource   = $("#ht-main-slider-item").html();
    var template = Handlebars.compile(htmlSource);
    var data = {item: item};
    var html    = template(data);
    if(replace)
    {
        $(".list-group").find("div[data-main-slider-image-id="+item.idFile+"]").closest("div.image-item").replaceWith(html);
    }
    else
    {
        $(".list-group").append(html);
    }
    // loadEventListener(item.proy_fot_id);
    // startImageThumbnailComponent(item.proy_fot_id);
}

function getImages()
{
    $.ajax({
        url : base_url + 'panel/AjaxMainSlider/getMainSliderImages',
        dataType:"json",
        type : "POST",
        data : {},
        success:function(response){
            var list = response;
            $(".list-group").html("");
            $.each(list,function(index,value){
                addItem(value);
            });
            // bootbox.hideAll();
            // validateButtonToDeleteImage();
            console.log(response);
        }
    });
}

function validateButtonToDeleteImage()
{
    var itemsRemain = $(".list-group").children().length;
    if(itemsRemain === 1)
    {
        $(".list-group").find("a[class*=property-image-delete-]").addClass("hide");
    }
    else if(itemsRemain > 1)
    {
        $(".list-group").find("a[class*=property-image-delete-]").removeClass("hide");
    }
}
