<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 08/04/2019
 * Time: 12:17 PM
 */
?>
<script id="ht-report-executive-summary-differential" type="text/x-handlebars-template">
    <div class="table-responsive">
        <table class="table table-striped table-hover executive-summary-differential">
            <thead>
                <tr>
                    <th>ETAPA</th>
                    <th>TOTAL</th>
                    <th>%</th>
                    <th>MONTO APROBADO</th>
                    <th>% APROBADO</th>
                    <th>% CONTRATO</th>
                </tr>
            </thead>
            <tbody>
            {{#each log}}
                <tr>
                    <td>{{stage}}</td>
                    <td>{{projectsQuantity}}</td>
                    <td>{{projectPercentage}}</td>
                    <td>{{approvedBudget}}</td>
                    <td>{{approvedBudgetPercentage}}</td>
                    <td>{{contractPercentage}}</td>
                </tr>
            {{/each}}
            </tbody>
        </table>
    </div>
</script>