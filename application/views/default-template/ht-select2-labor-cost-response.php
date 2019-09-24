<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/08/2019
 * Time: 6:28 PM
 */
?>
<script id="ht-select2-labor-cost-response" type="text/x-handlebars-template">
    <div class="" style="padding-left:0px; padding-right:0px;width:100%">
        <ul class="event-list">
            <li style="margin-bottom:3px">
                <div class="info">
                    <h2 class="title">{{laborCost.structure_code}}</h2>
                    <p class="desc">{{laborCost.structure_detail}}</p>
                    <ul>
                        <li class='col-md-5'><span class="fa fa-user"></span> {{laborCost.management_by}}</li>
                        <li class='col-md-2'><span class="fa fa-money"></span> {{laborCost.structure_unit_price}}</li>
                        <li class='col-md-2'><span class="fa fa-long-arrow-up"></span> {{laborCost.budgetary_position}}</li>
                        <li class='col-md-3'><span class="fa fa-folder"></span> {{laborCost.project_code}}</li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</script>