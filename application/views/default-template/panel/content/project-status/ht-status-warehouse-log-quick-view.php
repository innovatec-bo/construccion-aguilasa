<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/08/2018
 * Time: 11:39 AM
 */
?>
<script id="ht-status-warehouse-log-quick-view" type="text/x-handlebars-template">
    {{#each projectLog}}
        {{var "className" ""}}
        {{#ifCond ../allowUpdateHistory "==" 1}}
            {{var "className" ""}}
        {{/ifCond}}
        <h6 class="quick-log-status-name">{{status_name_pst}} <span class="pull-right {{className}}" data-log-id="{{id_wsl}}" data-status-name="{{status_name_pst}}">{{formatDate manual_entry_date_wsl "short"}}</span></h6>
        <blockquote>
            <dl>
                {{#ifCond log_detail_wsl "!=" ""}}
                    <dt>Observaciones</dt>
                    <dd>{{log_detail_wsl}}</dd>
                {{/ifCond}}
            </dl>
        </blockquote>
    {{/each}}
</script>