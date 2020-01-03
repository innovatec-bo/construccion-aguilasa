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

//photo swipe
var initPhotoSwipeFromDOM = function(gallerySelector) {

    // parse slide data (url, title, size ...) from DOM elements 
    // (children of gallerySelector)
    var parseThumbnailElements = function(el) {
        var thumbElements = el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item;

        for(var i = 0; i < numNodes; i++) {

            figureEl = thumbElements[i]; // <figure> element

            // include only element nodes 
            if(figureEl.nodeType !== 1) {
                continue;
            }

            linkEl = figureEl.children[0]; // <a> element

            size = linkEl.getAttribute('data-size').split('x');

            // create slide object
            item = {
                src: linkEl.getAttribute('href'),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)
            };



            if(figureEl.children.length > 1) {
                // <figcaption> content
                item.title = figureEl.children[1].innerHTML; 
            }

            if(linkEl.children.length > 0) {
                // <img> thumbnail element, retrieving thumbnail url
                item.msrc = linkEl.children[0].getAttribute('src');
            } 

            item.el = figureEl; // save link to element for getThumbBoundsFn
            items.push(item);
        }

        return items;
    };

    // find nearest parent element
    var closest = function closest(el, fn) {
        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
    };

    // triggers when user clicks on thumbnail
    var onThumbnailsClick = function(e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;

        var eTarget = e.target || e.srcElement;

        // find root element of slide
        var clickedListItem = closest(eTarget, function(el) {
            return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
        });

        if(!clickedListItem) {
            return;
        }

        // find index of clicked item by looping through all child nodes
        // alternatively, you may define index via data- attribute
        var clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;

        for (var i = 0; i < numChildNodes; i++) {
            if(childNodes[i].nodeType !== 1) { 
                continue; 
            }

            if(childNodes[i] === clickedListItem) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }



        if(index >= 0) {
            // open PhotoSwipe if valid index found
            openPhotoSwipe( index, clickedGallery );
        }
        return false;
    };

    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
        params = {};

        if(hash.length < 5) {
            return params;
        }

        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if(!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');  
            if(pair.length < 2) {
                continue;
            }           
            params[pair[0]] = pair[1];
        }

        if(params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        return params;
    };

    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
        var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;

        items = parseThumbnailElements(galleryElement);

        // define options (if needed)
        options = {

            // define gallery index (for URL)
            galleryUID: galleryElement.getAttribute('data-pswp-uid'),

            getThumbBoundsFn: function(index) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect(); 

                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
            }

        };

        // PhotoSwipe opened from URL
        if(fromURL) {
            if(options.galleryPIDs) {
                // parse real index when custom PIDs are used 
                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                for(var j = 0; j < items.length; j++) {
                    if(items[j].pid == index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                // in URL indexes start from 1
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }

        // exit if index not found
        if( isNaN(options.index) ) {
            return;
        }

        if(disableAnimation) {
            options.showAnimationDuration = 0;
        }

        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    };

    // loop through all gallery elements and bind events
    var galleryElements = document.querySelectorAll( gallerySelector );

    for(var i = 0, l = galleryElements.length; i < l; i++) {
        galleryElements[i].setAttribute('data-pswp-uid', i+1);
        galleryElements[i].onclick = onThumbnailsClick;
    }

    // Parse URL and open gallery if it contains #&pid=3&gid=1
    var hashData = photoswipeParseHash();
    if(hashData.pid && hashData.gid) {
        openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
    }
};
Handlebars.registerHelper("slides", function( input ){
    // var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
    //     commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
    
    let $template = $("#ht-image-slide");
    let htmlSource   = $template.html();
    let template = Handlebars.compile(htmlSource);    
    let imageList = JSON.parse(input);
    let html = "";
    $.each(imageList, function(index, value){        
        html += template(value);
    });
    
    return html;
});
Handlebars.registerHelper("document_list", function( input ){
    // var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
    //     commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
    
    let $template = $("#ht-document-slide");
    let htmlSource   = $template.html();
    let template = Handlebars.compile(htmlSource);    
    let imageList = JSON.parse(input);
    let html = "";
    $.each(imageList, function(index, value){        
        html += template(value);
    });
    
    return html;
});