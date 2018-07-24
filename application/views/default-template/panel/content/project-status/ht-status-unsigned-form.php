<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/06/2018
 * Time: 10:34 AM
 */
?>
<script id="ht-status-unsigned-form" type="text/x-handlebars-template">
    <div class="tab-pane active" role="tabpanel" id="step_unsigned">
        <div class="well">
            <h4>Sin asignar</h4>
            <p>Este proyecto no ha sido asignado a ninguno de los sub estados de diseño.</p>
            <ol>
                <li>Estaqueado</li>
                <li>Digitalizacion</li>
                <li>Dibujo</li>
                <li>Cronograma</li>
            </ol>
        </div>
    </div>
</script>

<script id="ht-status-unsigned-form-completed" type="text/x-handlebars-template">
    <div class="well">
        <h4>Ya ingreso informacion para este estado!</h4>
        <p>Para ingresar nueva informacion haga clic <a href="javascript:void(0)" onclick="loadStatusForm('{{statusKeyword}}',1)">aqui</a></p>
    </div>
</script>