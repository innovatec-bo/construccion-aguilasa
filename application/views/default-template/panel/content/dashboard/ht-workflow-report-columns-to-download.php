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
        <div class="col-md-6">
            <div class="form-group text-left">
                <div class="form-group input-group">
                    <select name="tags" id="column-groups-name" class="form-control">
                    </select>
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-sm" type="button" data-original-title="ACTUALIZAR" data-toggle="tooltip" data-placement="top"><i class="fa fa-save"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" type="button" data-original-title="ELIMINAR" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash"></i>
                        </button>
                    </span>
                </div>

            </div>
            <div class="form-group text-left">
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