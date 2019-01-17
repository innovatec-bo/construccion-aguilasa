<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 23/10/2018
 * Time: 9:31
 */
?>
<script id="ht-workflow-report-columns-to-download" type="text/x-handlebars-template">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-sm toggle-checkbox-status">Marcar/Desmarcar todos</button>
            </div>
        </div>
    </div>
    <div class="row">
        {{#each columnList}}
            <div class="col-md-3 text-left">
                <div class="checkbox">
                    <label>
                        {{var "readOnlyCheckbox" ""}}
                        {{#ifCond key "==" "code_pro"}}
                            {{var "readOnlyCheckbox" "disabled"}}
                        {{/ifCond}}
                        <input type="checkbox" class="workflow-columns-to-download" checked {{readOnlyCheckbox}} value="{{key}}">{{title}}
                    </label>
                </div>
            </div>
        {{/each}}
    </div>
</script>