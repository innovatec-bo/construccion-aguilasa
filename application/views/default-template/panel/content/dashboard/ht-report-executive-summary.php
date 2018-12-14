<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 23/10/2018
 * Time: 9:31
 */
?>
<script id="ht-report-executive-summary" type="text/x-handlebars-template">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped table-minimum-padding">
            <thead>
            <tr>
                <th>CANCHA</th>
                <th>TOTAL</th>
                <th>%</th>
                <th>MONTO APROBADO</th>
                <th>%</th>
            </tr>
            </thead>
            <tbody>
            {{#each executiveSummary}}
                <tr class="{{keyword}}">
                    <th>{{title}}</th>
                    <td class="text-center">{{totalProjectsBySection}}</td>
                    <td class="text-center">{{totalPercentageProjectsBySection}}</td>
                    <td class="text-center">{{totalApprovedBudgetBySection}}</td>
                    <td class="text-center">{{totalPercentageApprovedBudgetBySection}}</td>
                </tr>
            {{/each}}
            </tbody>
        </table>
    </div>
</script>