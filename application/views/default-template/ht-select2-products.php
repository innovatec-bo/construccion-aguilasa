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
<script id="ht-select2-labor-cost-response" type="text/x-handlebars-template">
    <div class="" style="padding-left:0px; padding-right:0px;width:100%">
        <ul class="event-list">
            <li style="margin-bottom:3px">
                <div class="info">
                    <h2 class="title">CAM2/02/0M</h2>
                    <p class="desc">ENSAMBLE SECUNDARIO 1F Ó 3F PREEN. DOBLE TENSION BT</p>
                    <ul>
                        <li style="width:25%;"><span class="fa fa-globe"></span> Santa cruz</li>
                        <li style="width:25%;"><span class="fa fa-money"></span> $39.99</li>
                        <li style="width:25%;"><span class="fa fa-signal"></span> 18</li>
                        <li style="width:25%;"><span class="fa fa-folder"></span> RD.19.0245</li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</script>