<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 6/5/2018
 * Time: 21:06
 */
?>
<script id="ht-manpower-table" type="text/x-handlebars-template">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>ACTIV.</th>
            <th>ESTRUCTURA</th>
            <th>EJEC.</th>
            <th>DESCRIPCION</th>
            <th>UNIDAD</th>
            <th>CANTIDAD</th>
            <?php if($isSuperAdmin == 1){?>
            <th>P/UNITARIO</th>
            <th>P/TOTAL</th>
            <?php }?>
        </tr>
        </thead>
        <tbody>
        {{#each laborCostMasterDetail}}
            <tr>
                <td class="text-center">{{index}}</td>
                <td class="text-center">{{activity}}</td>
                <td>{{structure_code}}</td>
                <td class="text-center">{{execution}}</td>
                <td>{{description}}</td>
                <td class="text-center">{{unit_of_measurement}}</td>
                <td class="text-right">{{quantity}}</td>
                <?php if($isSuperAdmin == 1){?>
                <td class="text-right">{{unit_price}}</td>
                <td class="text-right">{{total_price_by_structure}}</td>
                <?php }?>
            </tr>
        {{/each}}
        </tbody>
    </table>
</script>
<script id="ht-modal-form-add-manpower-progress" type="text/x-handlebars-template">

</script>
