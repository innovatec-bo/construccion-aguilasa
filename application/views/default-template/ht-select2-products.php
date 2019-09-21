<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/08/2019
 * Time: 6:28 PM
 */
?>
<script id="ht-select2-product-response" type="text/x-handlebars-template">
    <a href="#" class="media border-0">
        <div class="media-left pr-1">
            <span class="avatar avatar-md avatar-online"><img class="media-object rounded-circle" src="{{base_url}}timthumb/timthumb.php?src={{base_url}}assets/images/product-default-image.png&h=50" alt="Imagen del producto">
            </span>
        </div>
        <div class="media-body w-100">
            <h6 class="list-group-item-heading">{{product.description}}</h6>
            <p class="list-group-item-text mb-0">
                <span class="badge badge-info">COD. {{product.text}}</span>
                <span class="badge badge-info">{{product.salePrice}} Bs.</span>
                <span class="badge badge-info">{{product.stock}} {{product.unitOfMeasurement}}</span>
            </p>
        </div>
    </a>
</script>