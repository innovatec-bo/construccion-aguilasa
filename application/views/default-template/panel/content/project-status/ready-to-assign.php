<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
$startDate = "";
$endDate = "";
$estimatedTime = "";
$liveLine = "";
$powerDown = "";
$maneuver = "";
$detail = "";
$previousEntry = $previousEntry[0];
if(count($previousEntry) > 0)
{
    $startDate = $previousEntry["start_date_cas"];
    $endDate = $previousEntry["end_date_cas"];
    $estimatedTime = $previousEntry["estimated_time_cas"];
    $liveLine = $previousEntry["live_line_cas"];
    $powerDown = $previousEntry["power_down_cas"];
    $maneuver = $previousEntry["maneuver_cas"];
    $detail = $previousEntry["log_detail_psl"];
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Asignacion del proyecto<em class="subtext"><?=$project["code_pro"]?></em></h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Definir parametro iniciales
                </div>
                <div class="panel-body">
                    <form role="form" method="post" name="assign-project-form" data-parsley-validate>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Fecha de Asignacion</label>
                                        <div class="input-group date date-time-picker">
                                            <input name="entry-date" readonly="" class="form-control input-date" required="" data-parsley-errors-container="#error-entry-date">
                                            <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                        </div>
                                        <div id="error-entry-date"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <label>Responsable(s) <a href="#" class="check-stakes-team"><i class="fa fa-question-circle"></i></a></label>
                                    <div class="form-group">
                                        <select class="form-control" multiple="multiple" data-parsley-required="" parsley-trigger="change" id="ajax-get-responsible-list">
                                            <?php
                                            $html = "";
                                            foreach($responsibleList as $responsible)
                                            {
                                                if($responsible['keyword_pst'] == "assign_to")
                                                {
                                                    $html .= '
                                                        <option value="'.$responsible['id_sre'].'">'.$responsible['firstname_usr'].' '.$responsible['lastname_usr'].'</option>    
                                                    ';
                                                }
                                            }
                                            echo $html;
                                            ?>
                                        </select>
                                        <input type="hidden" name="responsible-list" value="">
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Fecha de Inicio</label>
                                        <div class="input-group date date-time-picker">
                                            <input name="start-date" readonly="" class="form-control input-date" required="" data-parsley-errors-container="#error-start-date">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        <div id="error-start-date"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Fecha de Fin</label>
                                        <div class="input-group date date-time-picker">
                                            <input name="end-date" readonly="" class="form-control input-date" required="" data-parsley-errors-container="#error-end-date">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        <div id="error-end-date"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tiempo(días)</label>
                                    <input type="text" class="form-control" required name="estimated-time" placeholder="Días de trabajo" data-parsley-type="integer">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Adicionales</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="live-line" value="1">Linea viva
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="power-down" value="1">Corte
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="maneuver" value="1">Maniobra
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" name="status-detail" rows="2"><?=$detail?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    <!-- /.row (nested) -->
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
