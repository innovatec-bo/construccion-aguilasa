<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 23/10/2018
 * Time: 9:31
 */
?>
<script id="ht-report-net-building-table" type="text/x-handlebars-template">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped table-minimum-padding">
            <thead>
            <tr>
                <th>CRITERIO</th>
                <th data-month="01">ENERO</th>
                <th data-month="02">FEBRERO</th>
                <th data-month="03">MARZO</th>
                <th data-month="04">ABRIL</th>
                <th data-month="05">MAYO</th>
                <th data-month="06">JUNIO</th>
                <th data-month="07">JULIO</th>
                <th data-month="08">AGOSTO</th>
                <th data-month="09">SEPTIEMBRE</th>
                <th data-month="10">OCTUBRE</th>
                <th data-month="11">NOVIEMBRE</th>
                <th data-month="12">DICIEMBRE</th>
                <th>TOTAL</th>
            </tr>
            </thead>
            <tbody>
            {{#each projectTotalsList}}
                <tr class="{{rowKey}}">
                    <th>{{criteria}}</th>
                        <td class="text-center">{{> ht-report-net-building-table-row data=january}}</td>
                        <td class="text-center">{{> ht-report-net-building-table-row data=february}}</td>
                        <td class="text-center">{{> ht-report-net-building-table-row data=march}}</td>
                        <td class="text-center">{{> ht-report-net-building-table-row data=april}}</td>
                        <td class="text-center">{{> ht-report-net-building-table-row data=may}}</td>
                        <td class="text-center">{{> ht-report-net-building-table-row data=june}}</td>
                        <td class="text-center">{{> ht-report-net-building-table-row data=july}}</td>
                        <td class="text-center">{{> ht-report-net-building-table-row data=august}}</td>
                        <td class="text-center">{{> ht-report-net-building-table-row data=september}}</td>
                        <td class="text-center">{{> ht-report-net-building-table-row data=october}}</td>
                        <td class="text-center">{{> ht-report-net-building-table-row data=november}}</td>
                        <td class="text-center">{{> ht-report-net-building-table-row data=december}}</td>
                    <td class="text-center">{{> ht-report-net-building-table-row data=total}}</td>
                </tr>
            {{/each}}
            </tbody>
        </table>
    </div>
</script>
<script id="ht-report-net-building-table-row" type="text/x-handlebars-template">
    {{#ifCond downloadable "==" 1}}
        <a href="#" class="find-th"><span class="badge">{{data}} <span class="glyphicon glyphicon-download"></span></span></a>
    {{/ifCond}}
    {{#ifCond downloadable "!=" 1}}
        {{january}}
    {{/ifCond}}
</script>