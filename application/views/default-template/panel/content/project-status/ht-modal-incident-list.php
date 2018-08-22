<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 22/08/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-modal-incident-list" type="text/x-handlebars-template">
    <div class="row">
        <div class="col-md-12 hide">
            <ol>
            {{#each incidentList}}
                <li>{{detail_inc}} - {{percentage_inc}}% {{position}}</li>
            {{/each}}
            </ol>
        </div>
        <div class="col-md-12">
            <ul class="timeline">
                {{#each incidentList}}
                    {{var "class" ""}}
                    {{#ifCond position "==" "right"}}
                        {{var "class" "timeline-inverted"}}
                    {{/ifCond}}
                    <li class="{{class}}">
                        <div class="timeline-badge"><i class="fa fa-check"></i>
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">{{percentage_inc}}%</h4>
                                <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{formatDate manual_entry_date_inc "short"}}</small>
                                </p>
                            </div>
                            <div class="timeline-body">
                                <p>{{detail_inc}}</p>
                            </div>
                        </div>
                    </li>
                {{/each}}
            </ul>
        </div>
    </div>
</script>