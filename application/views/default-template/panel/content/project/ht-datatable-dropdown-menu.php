<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 31/01/2019
 * Time: 2:45 PM
 */
?>
<!-- <div class="btn-group">
        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-cogs"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a href="#" class="dropdown-item clone-team" data-team-id="{{team.id_tea}}"><i class="fa fa-eye fa-fw"></i> Aministracion de estados</a>
            <a href="#" class="dropdown-item clone-team" data-team-id="{{team.id_tea}}"><i class="fa fa-flag-o"></i> Nuevo incidente</a>
            <a href="#" class="dropdown-item clone-team" data-team-id="{{team.id_tea}}"><i class="fa fa-table"></i> Mano de obra</a>
            <a href="#" class="dropdown-item share-team-progress" data-team-id="{{team.id_tea}}"><i class="fa fa-pencil"></i> Editar</a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item delete-team" data-team-id="{{team.id_tea}}"><i class="fa fa-times fa-fw"></i> Eliminar</a>
        </div>
    </div> -->
<script id="ht-datatable-dropdown-menu" type="text/x-handlebars-template">
    
    <div class="dropdown">
        <button class="btn btn-default btn-sm dropdown-toggle py-0" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <i class="fa fa-cogs"></i>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
            {{#ifCond visibility.showStatusManagementWharehouseBtn "==" 1}}
                <li>
                    <a href="{{visibility.statusManagementWharehouseUrl}}" class="pl-1"><i class="fa fa-eye fa-fw"></i> Aministracion de estados</a>
                </li>
            {{/ifCond}}
            {{#ifCond visibility.showStatusManagementProjectBtn "==" 1}}
                <li>
                    <a href="{{visibility.statusManagementProjectUrl}}" class="pl-1"><i class="fa fa-eye fa-fw"></i> Aministracion de estados</a>
                </li>
            {{/ifCond}}
            {{#ifCond visibility.showAddIncidentBtn "==" 1}}
                <li>
                    <a href="#" class="pl-1 add-incident"  data-project-id="{{row.id_pro}}" data-status-id="{{row.status_pro}}" ><i class="fa fa-flag-o fa-fw"></i> Nuevo incidente</a>
                </li>
            {{/ifCond}}
            {{#ifCond visibility.showManpowerBtn "==" 1}}
                <li>
                    <a href="{{base_url}}panel/Project/manpower/{{row.id_pro}}" class="pl-1"><i class="fa fa-table fa-fw"></i> Mano de obra</a>
                </li>
            {{/ifCond}}
            {{#ifCond visibility.showEditProjectBtn "==" 1}}
                <li><a href="{{base_url}}panel/Project/edit/{{row.id_pro}}" class="pl-1"><i class="fa fa-pencil fa-fw"></i> Editar</a></li>
            {{/ifCond}}
            {{#ifCond visibility.showAssignProjectBtn "==" 1}}
                <li>
                    <a href="{{base_url}}panel/ProjectStatus/assignProject/{{row.id_pro}}" class="pl-1"><i class="fa fa-th-list fa-fw"></i> Asignar</a>
                </li>
            {{/ifCond}}
            <li role="separator" class="divider"></li>
            {{#ifCond visibility.showDeleteProjectBtn "==" 1}}
                <li>
                    <a href="#" data-object-id="{{row.id_pro}}" data-url= "{{base_url}}panel/Project/delete/{{row.id_pro}}" class="pl-1 datatable-delete-button"><i class="fa fa-times fa-fw"></i> Eliminar</a>
                </li>
            {{/ifCond}}
        </ul>
    </div>
</script>
