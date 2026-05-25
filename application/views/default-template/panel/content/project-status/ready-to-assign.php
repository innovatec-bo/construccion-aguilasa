<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
$entryDate = date("d-m-Y");
$startDate = date("d-m-Y");;
$endDate = date("d-m-Y");;
$estimatedTime = "0";
$liveLine = "";
$powerDown = "";
$maneuver = "";
$detail = "";
$currentResponsible = array();
$previousEntry = isset($previousEntry[0]["id_psl"])?$previousEntry[0]:array();
$alreadyPreviousInfoMessage = "";
$textBtnSave = "Asignar";
if(count($previousEntry) > 0)
{
    $entryDate = $previousEntry["manual_entry_date_psl"];
    $entryDate = DateTime::createFromFormat('Y-m-d H:i:s', $entryDate);
    $entryDate = date_format($entryDate, 'd-m-Y');

    $startDate = $previousEntry["start_date_cas"];
    $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $startDate);
    $startDate = date_format($startDate, 'd-m-Y');
    $endDate = $previousEntry["end_date_cas"];
    $endDate = DateTime::createFromFormat('Y-m-d H:i:s', $endDate);
    $endDate = date_format($endDate, 'd-m-Y');
    $estimatedTime = $previousEntry["estimated_time_cas"];
    $liveLine = $previousEntry["live_line_cas"];
    $powerDown = $previousEntry["power_down_cas"];
    $maneuver = $previousEntry["maneuver_cas"];
    $detail = $previousEntry["log_detail_psl"];
    $currentResponsible = json_decode("[".$previousEntry["jsonResponsible"]."]",TRUE);
    $alreadyPreviousInfoMessage = "Este proyecto ya ha sido asignado.";
    $textBtnSave = "Re asignar";
}
$fiscalHtml = "";
$builderHtml = "";
foreach($responsibleListFiscal as $responsible)
{
        $selected = "";
        if(count($currentResponsible))
        {
            $selected = array_search($responsible['id_sre'],array_column($currentResponsible,"id")) === FALSE?"":" selected ";
        }

        $fiscalHtml .= '
            <option data-user-id="'.$responsible['id_usr'].'" value="'.$responsible['id_sre'].'" '.$selected.'>'.$responsible['firstname_usr'].' '.$responsible['lastname_usr'].'</option>    
        ';
}
foreach($responsibleListBuilder as $responsible)
{
        $selected = "";
        if(count($currentResponsible))
        {
            $selected = array_search($responsible['id_sre'],array_column($currentResponsible,"id")) === FALSE?"":" selected ";
        }
        $builderHtml .= '
            <option data-supervising-id="'.$responsible['supervising_user_usr'].'"value="'.$responsible['id_sre'].'" '.$selected.'>'.$responsible['firstname_usr'].' '.$responsible['lastname_usr'].'</option>    
        ';
}
?>
<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Asignacion del proyecto<em class="subtext"><?=$project["code_pro"]?></em></h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            if($alreadyPreviousInfoMessage != "") {
                ?>
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Info!</strong> <?=$alreadyPreviousInfoMessage?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        if(count($allIncidents)>0)
        {
            $incidentHtml = '';
            foreach ($allIncidents as $incident)
            {
                $entryDate = DateTime::createFromFormat('Y-m-d H:i:s', $incident["manual_entry_date_inc"]);
                $entryDate = date_format($entryDate, 'd-m-Y');
                $incidentHtml = '
                <div class="col-md-12" id="incident-content">
                    <div class="list-group" data-last-project-percentage="25">
                        <a href="javascript:void(0)" class="list-group-item" data-project-percentage="25">
                            <i class="fa fa-info-circle"></i> ('.$incident["percentage_inc"].'%) '.$incident["detail_inc"].'
                            <span class="pull-right text-muted small"><em>'.$entryDate.' - '.$incident["full_name"].'</em></span>
                        </a>
                    </div>
                </div>
                ';
                break;
            }
            echo $incidentHtml;
        }
        ?>
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
                                    <label>Encargado del proyecto</label>
                                    <div class="form-group">
                                        <select name="project-manager" class="form-control" parsley-trigger="change" required="">
                                            <option value="">----------</option>
                                            <?php
                                                $options = "";
                                                foreach ($projectManagers as $user) 
                                                {
                                                    $options .= " <option value='".$user->getId()."'>".$user->getFullName()."</option> ";
                                                }
                                                echo $options;
                                            ?>
                                        </select>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <label>Fiscal(es)</label><em>El constructor será asignado por el fiscal.</em>
                                    <div class="form-group">
                                        <select class="form-control ajax-get-responsible-list" multiple="multiple" parsley-trigger="change" id="ajax-get-responsible-list1" required="" data-parsley-errors-container="#error-fiscal-list">
                                            <?php echo $fiscalHtml; ?>
                                        </select>
                                        <div id="error-fiscal-list"></div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <!-- <label>Constructor(s) <a href="#" class="check-stakes-team"><i class="fa fa-question-circle"></i></a></label> -->
                                    <label>Constructor(es)</label><em>El campo "fiscal" se actualiza al elegir un constructor, esto por que cada constructor tiene un fiscal y el sistema trata de emparejarlos, por supuesto, se puede colocar un fiscal distinto al que sugiere el sistema.</em>
                                    <div class="form-group">
                                        <select class="form-control ajax-get-responsible-list" multiple="multiple" parsley-trigger="change" id="ajax-get-responsible-list2" required="" data-parsley-errors-container="#error-builder-list">
                                            <?php echo $builderHtml; ?>
                                        </select>
                                        <div id="error-builder-list"></div>
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
                                            <input name="start-date" value="<?=$startDate?>" readonly="" class="form-control input-date" required="" data-parsley-errors-container="#error-start-date">
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
                                            <input name="end-date" value="<?=$endDate?>" readonly="" class="form-control input-date" required="" data-parsley-errors-container="#error-end-date">
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
                                    <input type="text" class="form-control" value="<?=$estimatedTime?>" required name="estimated-time" readonly placeholder="Días de trabajo" data-parsley-type="integer">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Adicionales</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="power-down" value="1" <?=$powerDown == "1"?"checked":""?>>Corte
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="maneuver" value="1" <?=$maneuver == "1"?"checked":""?>>Maniobra
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
                                    <button type="submit" class="btn btn-primary"><?=$textBtnSave?></button>
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
