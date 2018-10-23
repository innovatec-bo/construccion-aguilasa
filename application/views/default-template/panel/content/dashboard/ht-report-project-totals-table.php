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
                    <td class="text-center">{{january}}</td>
                    <td class="text-center">{{february}}</td>
                    <td class="text-center">{{march}}</td>
                    <td class="text-center">{{april}}</td>
                    <td class="text-center">{{may}}</td>
                    <td class="text-center">{{june}}</td>
                    <td class="text-center">{{july}}</td>
                    <td class="text-center">{{august}}</td>
                    <td class="text-center">{{september}}</td>
                    <td class="text-center">{{october}}</td>
                    <td class="text-center">{{november}}</td>
                    <td class="text-center">{{december}}</td>
                    <td class="text-center">{{total}}</td>
                </tr>
            {{/each}}
            </tbody>
        </table>
    </div>
</script>