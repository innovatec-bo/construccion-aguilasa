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
                    <td>{{stageLabel}}</td>
                    <td>{{projectsQuantity}}</td>
                    <td class="text-right">{{projectPercentage}}</td>
                    <td class="text-right">{{approvedBudget}}</td>
                    <td class="text-right">{{approvedBudgetPercentage}}</td>
                    <td class="text-right">{{contractPercentage}}</td>
                </tr>
            {{/each}}
            </tbody>
        </table>
    </div>
</script>
<script id="ht-report-executive-summary-differential-result" type="text/x-handlebars-template">
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
                <td>{{stageLabel}}</td>
                <td>
                    {{#ifCond projectsQuantityDiff "<" 0}}
                        <i class="fa fa-arrow-down text-info"></i>
                        ({{projectsQuantityDiff}})
                    {{/ifCond}}
                    {{#ifCond projectsQuantityDiff ">" 0}}
                        <i class="fa fa-arrow-up text-info"></i>
                        ({{projectsQuantityDiff}})
                    {{/ifCond}}
                    {{#ifCond projectsQuantityDiff "==" 0}}
                        <i class="fa fa-arrow-right"></i>
                    {{/ifCond}}
                    {{projectsQuantity}}
                </td>
                <td class="text-right">
                    {{#ifCond projectPercentageDiff "<" 0}}
                        <i class="fa fa-arrow-down text-info"></i>
                    ({{projectPercentageDiff}})
                    {{/ifCond}}
                    {{#ifCond projectPercentageDiff ">" 0}}
                        <i class="fa fa-arrow-up text-info"></i>
                    ({{projectPercentageDiff}})
                    {{/ifCond}}
                    {{#ifCond projectPercentageDiff "==" 0}}
                        <i class="fa fa-arrow-right"></i>
                    {{/ifCond}}
                    {{projectPercentage}}
                </td>
                <td class="text-right">
                    {{#ifCond approvedBudgetDiff "<" 0}}
                        <i class="fa fa-arrow-down text-info"></i>
                    ({{numberFormat approvedBudgetDiff decimalLength="2"}})
                    {{/ifCond}}
                    {{#ifCond approvedBudgetDiff ">" 0}}
                        <i class="fa fa-arrow-up text-info"></i>
                    ({{numberFormat approvedBudgetDiff decimalLength="2"}})
                    {{/ifCond}}
                    {{#ifCond approvedBudgetDiff "==" 0}}
                        <i class="fa fa-arrow-right"></i>
                    {{/ifCond}}
                    {{approvedBudget}}
                </td>
                <td class="text-right">
                    {{#ifCond approvedBudgetPercentageDiff "<" 0}}
                        <i class="fa fa-arrow-down text-info"></i>
                    ({{approvedBudgetPercentageDiff}})
                    {{/ifCond}}
                    {{#ifCond approvedBudgetPercentageDiff ">" 0}}
                        <i class="fa fa-arrow-up text-info"></i>
                    ({{approvedBudgetPercentageDiff}})
                    {{/ifCond}}
                    {{#ifCond approvedBudgetPercentageDiff "==" 0}}
                        <i class="fa fa-arrow-right"></i>
                    {{/ifCond}}
                    {{approvedBudgetPercentage}}
                </td>
                <td class="text-right">
                    {{#ifCond contractPercentageDiff "<" 0}}
                        <i class="fa fa-arrow-down text-info"></i>
                    ({{contractPercentageDiff}})
                    {{/ifCond}}
                    {{#ifCond contractPercentageDiff ">" 0}}
                        <i class="fa fa-arrow-up text-info"></i>
                    ({{contractPercentageDiff}})
                    {{/ifCond}}
                    {{#ifCond contractPercentageDiff "==" 0}}
                        <i class="fa fa-arrow-right"></i>
                    {{/ifCond}}
                    {{contractPercentage}}
                </td>
            </tr>
            {{/each}}
            </tbody>
        </table>
    </div>
</script>