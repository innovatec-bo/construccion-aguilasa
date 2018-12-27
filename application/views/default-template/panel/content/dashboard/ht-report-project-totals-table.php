<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
?>
<script id="ht-report-project-totals-table" type="text/x-handlebars-template">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped table-minimum-padding">
            <thead>
            <tr>
                <th>CRITERIO</th>
                <th>ENERO</th>
                <th>FEBRERO</th>
                <th>MARZO</th>
                <th>ABRIL</th>
                <th>MAYO</th>
                <th>JUNIO</th>
                <th>JULIO</th>
                <th>AGOSTO</th>
                <th>SEPTIEMBRE</th>
                <th>OCTUBRE</th>
                <th>NOVIEMBRE</th>
                <th>DICIEMBRE</th>
                <th>TOTAL</th>
            </tr>
            </thead>
            <tbody>
            {{#each projectTotalsList}}
                <tr>
                    <th>{{criteria}}</th>
                    <td class="text-center">{{numberFormat january}}</td>
                    <td class="text-center">{{numberFormat february}}</td>
                    <td class="text-center">{{numberFormat march}}</td>
                    <td class="text-center">{{numberFormat april}}</td>
                    <td class="text-center">{{numberFormat may}}</td>
                    <td class="text-center">{{numberFormat june}}</td>
                    <td class="text-center">{{numberFormat july}}</td>
                    <td class="text-center">{{numberFormat august}}</td>
                    <td class="text-center">{{numberFormat september}}</td>
                    <td class="text-center">{{numberFormat october}}</td>
                    <td class="text-center">{{numberFormat november}}</td>
                    <td class="text-center">{{numberFormat december}}</td>
                    <td class="text-center">{{numberFormat total}}</td>
                </tr>
            {{/each}}
            </tbody>
        </table>
    </div>
</script>