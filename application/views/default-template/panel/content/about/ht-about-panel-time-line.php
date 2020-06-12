<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 11/09/2018
 * Time: 2:30 PM
 */
?>
<!----------------------------------------------------------------------------------------- time line-->
<script id="ht-about-panel-time-line" type="text/x-handlebars-template">
    <ul class="timeline">
        {{#each eventList}}
        {{> ht-about-panel-time-line-item}}
        {{/each}}
    </ul>
</script>
<!----------------------------------------------------------------------------------------- time line item-->
<script id="ht-about-panel-time-line-item" type="text/x-handlebars-template">
    <li class="{{class}}">
        <div class="timeline-badge"><i class="fa fa-file-code-o"></i>
        </div>
        <div class="timeline-panel">
            <div class="timeline-heading">
                <h4 class="timeline-title">{{push_data.ref}}</h4>
                <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{time_ago created_at}}</small>
                </p>
            </div>
            <div class="timeline-body">
                <p>{{push_data.commit_title}} <a href="javascript:void(0)">See detail</a></p>
            </div>
        </div>
    </li>
</script>
<script id="ht-to-do-list" type="text/x-handlebars-template">
    {{#each issueList}}
        <a href="#" class="list-group-item">
            {{title}}
        </a>
    {{/each}}
</script>