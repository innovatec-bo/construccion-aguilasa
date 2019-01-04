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
        {{#each columnList}}
            <div class="col-md-3 text-left">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="workflow-columns-to-download" checked value="{{key}}">{{title}}
                    </label>
                </div>
            </div>
        {{/each}}
    </div>
</script>