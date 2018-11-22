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
                    <td class="text-center"><a href="#" class="find-th">{{january}}</a></td>
                    <td class="text-center"><a href="#" class="find-th">{{february}}</a></td>
                    <td class="text-center"><a href="#" class="find-th">{{march}}</a></td>
                    <td class="text-center"><a href="#" class="find-th">{{april}}</a></td>
                    <td class="text-center"><a href="#" class="find-th">{{may}}</a></td>
                    <td class="text-center"><a href="#" class="find-th">{{june}}</a></td>
                    <td class="text-center"><a href="#" class="find-th">{{july}}</a></td>
                    <td class="text-center"><a href="#" class="find-th">{{august}}</a></td>
                    <td class="text-center"><a href="#" class="find-th">{{september}}</a></td>
                    <td class="text-center"><a href="#" class="find-th">{{october}}</a></td>
                    <td class="text-center"><a href="#" class="find-th">{{november}}</a></td>
                    <td class="text-center"><a href="#" class="find-th">{{december}}</a></td>
                    <td class="text-center"><a href="#" class="find-th">{{total}}</a></td>
                </tr>
            {{/each}}
            </tbody>
        </table>
    </div>
</script>