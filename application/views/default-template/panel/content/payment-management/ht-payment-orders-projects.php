<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 07/09/2018
 * Time: 10:11 AM
 */
?>
<script id="ht-payment-orders-projects" type="text/x-handlebars-template">
    <table class="table">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Proyecto</th>
                <th>Importe diseño</th>
                <th>Importe de transporte</th>
                <th>Importe de construccion</th>
                <th>Importe de linea viva</th>
                <th class="text-center"><i class="fa fa-times"></i></th>
            </tr>
        </thead>
        <tbody id="project-list-content">
            {{#each projectList}}
                {{> ht-payment-orders-projects-row}}
            {{/each}}
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6">Total</th>
                <td>
                    <span class="total-earned">0.00</span>
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</script>

<script id="ht-payment-orders-projects-row" type="text/x-handlebars-template">
    <tr data-row-index="{{index}}" data-payment-order-project-id="{{payment_order_project}}">
        <th scope="row"><span class="row-counter">#</span></th>
        <td>
            <select class="form-control input-sm select2 project" data-select-index="{{index}}"></select>
        </td>
        <td>
            <input type="text" size="8" name="design-budget" class="form-control input-sm input-masked" placeholder="0.00" value="{{design_budget}}" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
        </td>
        <td>
            <input type="text" size="6" name="transportation-budget" class="form-control input-sm input-masked" placeholder="0.00" value="{{transportation_budget}}"  data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
        </td>
        <td>
            <input type="text" size="6" name="building-budget" class="form-control input-sm input-masked" placeholder="0.00" value="{{building_budget}}"  data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
        </td>
        <td>
            <input type="text" size="6" name="live-line-budget" class="form-control input-sm input-masked" placeholder="0.00" value="{{live_line_budget}}"  data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm remove-payment-order-project"><i class="fa fa-times"></i></button>
        </td>
    </tr>
</script>