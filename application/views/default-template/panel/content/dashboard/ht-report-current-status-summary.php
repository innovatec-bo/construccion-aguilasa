<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 23/10/2018
 * Time: 9:31
 */
?>
<script id="ht-report-current-status-summary" type="text/x-handlebars-template">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped table-minimum-padding">
            <thead>
            <tr>
                <th>STATUS</th>
                <th>TOTAL</th>
                <th>MONTO APROBADO</th>
                <th>MONTO CONCILIADO</th>
            </tr>
            </thead>
            <tbody>
            {{#each statusSummary.list}}
                <tr class="{{keyword}}">
                    <th>{{statusName}}</th>
<!--                    <td class="text-center"><a href="#" class="status-summary-selective-download">{{totalProjects}}</a></td>-->
                    <td class="text-center">{{totalProjects}}</td>
                    <td class="text-center">{{approvedBudgets}}</td>
                    <td class="text-center">{{realBudgets}}</td>
                </tr>
            {{/each}}
            </tbody>
            <tfoot>
                <tr class="current-status-total">
                    <th>TOTAL</th>
                    <td class="text-center">{{statusSummary.totalProjects}}</td>
                    <td class="text-center">{{statusSummary.totalApprovedBudgets}}</td>
                    <td class="text-center">{{statusSummary.totalRealBudgets}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</script>