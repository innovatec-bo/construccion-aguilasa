<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/08/2019
 * Time: 6:28 PM
 */
?>
<script id="ht-select2-material-response" type="text/x-handlebars-template">
    <div class="" style="padding-left:0px; padding-right:0px;width:100%">
        <ul class="event-list">
            <li style="margin-bottom:3px">
                <div class="info">
                    <h2 class="title">{{data.material_description}}</h2>
<!--                    <p class="desc">{{data.material_description}}</p>-->
                    <ul>
						<li class='col-md-3'><span class="fa fa-clipboard"></span>{{data.quantity_assigned}}</li>
						<li class='col-md-3'><span class="fa fa-folder"></span>{{data.project_code}}</li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</script>
