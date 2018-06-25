<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 19/06/2018
 * Time: 03:53 PM
 */


$htmlStatusView = "";
switch ($status)
{
    case "stakes":
        $htmlStatusView .= '
        <fieldset>
            <label>Equipo <a href="#" class="check-stakes-team"><i class="fa fa-question-circle"></i></a></label>
            <div class="form-group">
                <select class="form-control" data-parsley-required parsley-trigger="change" id="ajax-get-stakes-leader" data-default=\''.$teamLeadersOnProject.'\'></select>
            </div>
        </fieldset>
        ';
        break;
    case "digitization":
        $htmlStatusView .= '
        <div class="row">
            <div class="col-md-3">
            <div class="form-group">
            <label>Fecha de ingreso</label>
            <div class="input-group date date-time-picker">
                <input name="project-entry-date" readonly class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
            </div>
        </div>
        <div class="row form-inline">
            <div class="col-md-6">
                <label>Area del proyecto</label><br>
                <div class="form-group">
                    <em>Puntos</em><br>
                    <input class="form-control" name="project-points" placeholder="Puntos">
                </div>
                <div class="form-group">
                    <em>Distancia Km</em><br>
                    <input class="form-control"  name="project-meters-distance" placeholder="Distancia">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Observaciones</label>
            <textarea class="form-control" name="project-detail" rows="2"></textarea>
        </div>
        <p>ULTIMA ENTRADA</p>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fecha</label>
                    <input class="form-control" disabled name="current-manual-entry-date" value="'.$projectDigitizationStatus['manual_entry_date'].'">
                </div>    
            </div>
        </div>
        <div class="row form-inline">
            <div class="col-md-6">
                <label>Area del proyecto</label><br>
                <div class="form-group">
                    <em>Puntos</em><br>
                    <input class="form-control" disabled name="current-project-points" value="'.$projectDigitizationStatus['points'].'" placeholder="Puntos">
                </div>
                <div class="form-group">
                    <em>Distancia Km</em><br>
                    <input class="form-control" disabled name="current-project-meters-distance" value="'.$projectDigitizationStatus['distance'].'" placeholder="Distancia">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Observaciones</label>
            <textarea class="form-control" name="current-project-detail" disabled rows="2">'.$projectDigitizationStatus['detail'].'</textarea>
        </div>
        ';
        break;
    default:
        $htmlStatusView = "La vista para este estado no esta implementada";
}
echo $htmlStatusView;
