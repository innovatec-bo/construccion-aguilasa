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
                <th>ETAPA</th>
                <th>TOTAL</th>
                <th>%</th>
                <th>MONTO APROBADO</th>
                <th>%</th>
                <th>% Contrato</th>
            </tr>
            </thead>
            <tbody>
            {{#each executiveSummary.list}}
                <tr class="{{section}} {{keywordStringList}}">
                    <th>{{title}}</th>
<!--                    <td class="text-center">{{totalProjectsBySection}}</td>-->
                    <td class="text-center"><a href="#" class="executive-summary-selective-download">{{totalProjectsBySection}}</a></td>
                    <td class="text-center">{{totalPercentageProjectsBySection}}</td>
                    <td class="text-center">{{numberFormat totalApprovedBudgetBySection decimalLength="2"}}</td>
                    <td class="text-center">{{totalPercentageApprovedBudgetBySection}}</td>
                    <td class="text-center">{{contractAmountPercentageBySection}}</td>
                </tr>
            {{/each}}
            </tbody>
            <tfoot>
                <tr class="executive-summary-total">
                    <td>TOTAL</td>
                    <td class="text-center">{{executiveSummary.totalProjects}}</td>
                    <td class="text-center">{{executiveSummary.totalPercentageProjects}}</td>
                    <td class="text-center">{{executiveSummary.totalApprovedBudget}}</td>
                    <td class="text-center">{{executiveSummary.totalPercentageApprovedBudget}}</td>
                    <td class="text-center">{{executiveSummary.totalContractAmountPercentage}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</script>