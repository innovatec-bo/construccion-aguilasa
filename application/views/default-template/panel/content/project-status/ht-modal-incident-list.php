<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 22/08/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-modal-incident-list" type="text/x-handlebars-template">
    <div class="list-group" data-last-project-percentage="{{currentProjectPercentage}}">
        {{#each incidentList}}
            {{var "class" ""}}
            {{#ifCond position "==" "right"}}
            {{var "class" "timeline-inverted"}}
            {{/ifCond}}
            <a href="javascript:void(0)" class="list-group-item" data-project-percentage="{{percentage_inc}}">
                <i class="fa fa-info-circle"></i>
                {{#ifCond status_id_inc "==" 29}}
                    ({{percentage_inc}}%)
                {{/ifCond}}
                {{detail_inc}}
                <span class="pull-right text-muted small"><em>{{formatDate manual_entry_date_inc "short"}} - {{full_name}}</em>
                                </span>
            </a>
        {{/each}}

    </div>
</script>