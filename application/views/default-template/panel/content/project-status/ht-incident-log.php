<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/05/2019
 * Time: 11:50 AM
 */
?>
<script id="ht-incident-log" type="text/x-handlebars-template">
    <div class="list-group" id='incident-list' style="height: 300px !important;position: relative;border: 1px solid #dddddd;">
        {{#each incidentList}}
            <a href="javascript:void(0)" class="list-group-item" data-project-percentage="0"  data-incident-date="{{manual_entry_date}}">
                {{var "incidentType" "Sin Definir"}}
                {{#ifCond incident_type "!=" ""}}
                    {{var "incidentType" incident_type}}
                {{/ifCond}}
                <strong>Projecto: </strong>{{project_code}}<br>
                <strong>Detalle: </strong>{{incident_detail}}<br>
                <strong>Estatus en incidente: </strong>{{status_on_incident}}<br>
                <strong>Estatus actual: </strong>{{current_status}}<br>
                <strong>Tipo de incidente: </strong>{{incidentType}}<br>
                <span class="text-muted small btn-block text-right">
                    <em>
                        {{first_name}} {{last_name}} - {{time_ago manual_entry_date "short"}}
                    </em>
                 </span>
            </a>
        {{/each}}
    </div>
</script>