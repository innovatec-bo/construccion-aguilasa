<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 22/08/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-modal-incident-list" type="text/x-handlebars-template">
    <div class="list-group">
        {{#each incidentList}}
            {{var "class" ""}}
            {{#ifCond position "==" "right"}}
            {{var "class" "timeline-inverted"}}
            {{/ifCond}}
            <a href="#" class="list-group-item">
                <i class="fa fa-info-circle"></i> ({{percentage_inc}}%) {{detail_inc}}
                <span class="pull-right text-muted small"><em>{{formatDate manual_entry_date_inc "short"}} - {{full_name}}</em>
                                </span>
            </a>
        {{/each}}

    </div>
</script>