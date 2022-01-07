<script id="ht-show-materials-summary" type="text/x-handlebars-template">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover display pageResize" id="items-summary-list">
            <thead>
            <tr>
                <th style="">#</th>
                <th style="">COD</th>
                <th style="">DESCRIPCION</th>
                <th style="">FISCAL</th>
                <th style="">CANTIDAD<BR>COMPROMETIDA</th>
                <th style="">RETIRADO<BR>DE CRE</th>
                <th style="">PENDIENTE POR<BR>RETIRAR DE CRE</th>
            </tr>
            </thead>
            <tbody id="table-body">
                {{#each list}}
                <tr>
                    <td class="text-center" style="">{{math @index "+" 1}}</td>
                    <td class="text-right" style="">{{material_code}}</td>
                    <td class="text-left" style="">{{material_description}}</td>
                    <td class="text-left" style="">{{fiscal_responsible}}</td>
                    <td class="text-right" style="">{{quantity_assigned_materials}}</td>
                    <td class="text-right" style="">{{quantity_picked_up_from_cre}}</td>
                    <td class="text-right" style="">{{pending_material_in_cre}}</td>
                </tr>
                {{/each}}
            </tbody>
        </table>
    </div>
</script>
