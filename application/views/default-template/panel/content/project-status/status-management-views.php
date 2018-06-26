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
        $digitizationEntryDate = $projectDigitizationStatus['manual_entry_date'];
        $digitizationEntryDate = DateTime::createFromFormat('Y-m-d H:i:s', $digitizationEntryDate);
        $digitizationEntryDate = date_format($digitizationEntryDate, 'd-m-Y H:i:s');
        $digitizationEntryDate = "";
        if(isset($projectDrawingStatus['manual_entry_date']))
        {
            $digitizationEntryDate = $projectDigitizationStatus['manual_entry_date'];
            $digitizationEntryDate = DateTime::createFromFormat('Y-m-d H:i:s', $digitizationEntryDate);
            $digitizationEntryDate = date_format($digitizationEntryDate, 'd-m-Y H:i:s');
        }
        $detail = isset($projectDigitizationStatus["detail"])?$projectDigitizationStatus["detail"]:"";
        $points = isset($projectDigitizationStatus["points"])?$projectDigitizationStatus["points"]:"";
        $distance = isset($projectDigitizationStatus["distance"])?$projectDigitizationStatus["distance"]:"";
        $htmlStatusView .= '
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fecha de ingreso</label>
                    <div class="input-group date date-time-picker">
                        <input name="digitization-entry-date" readonly class="form-control" />
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
            <textarea class="form-control" name="digitization-detail" rows="2"></textarea>
        </div>
        <p>ULTIMA ENTRADA</p>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fecha</label>
                    <input class="form-control" disabled name="current-manual-entry-date" value="'.$digitizationEntryDate.'">
                </div>    
            </div>
        </div>
        <div class="row form-inline">
            <div class="col-md-6">
                <label>Area del proyecto</label><br>
                <div class="form-group">
                    <em>Puntos</em><br>
                    <input class="form-control" disabled name="current-project-points" value="'.$points.'" placeholder="Puntos">
                </div>
                <div class="form-group">
                    <em>Distancia Km</em><br>
                    <input class="form-control" disabled name="current-project-meters-distance" value="'.$distance.'" placeholder="Distancia">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Observaciones</label>
            <textarea class="form-control" name="current-digitization-detail" disabled rows="2">'.$detail.'</textarea>
        </div>
        ';
        break;
    case 'drawing':
        $drawingEntryDate = "";
        if(isset($projectDrawingStatus['manual_entry_date']))
        {
            $drawingEntryDate = $projectDrawingStatus['manual_entry_date'];
            $drawingEntryDate = DateTime::createFromFormat('Y-m-d H:i:s', $drawingEntryDate);
            $drawingEntryDate = date_format($drawingEntryDate, 'd-m-Y H:i:s');
        }
        $detail = isset($projectDrawingStatus["detail"])?$projectDrawingStatus["detail"]:"";
        $htmlStatusView .= '
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fecha de ingreso</label>
                    <div class="input-group date date-time-picker">
                        <input name="drawing-entry-date" readonly class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Observaciones</label>
            <textarea class="form-control" name="drawing-detail" rows="2"></textarea>
        </div>
        <p>ULTIMA ENTRADA</p>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fecha</label>
                    <input class="form-control" disabled name="current-drawing-manual-entry-date" value="'.$drawingEntryDate.'">
                </div>    
            </div>
        </div>
        <div class="form-group">
            <label>Observaciones</label>
            <textarea class="form-control" name="last-drawing-detail" disabled rows="2">'.$detail.'</textarea>
        </div>
        ';
        break;
    case 'schedule':
        $scheduleEntryDate = "";
        if(isset($projectScheduleStatus['manual_entry_date']))
        {
            $scheduleEntryDate = $projectScheduleStatus['manual_entry_date'];
            $scheduleEntryDate = DateTime::createFromFormat('Y-m-d H:i:s', $scheduleEntryDate);
            $scheduleEntryDate = date_format($scheduleEntryDate, 'd-m-Y H:i:s');
        }
        $projectStart = "";
        if(isset($projectScheduleStatus['project_start']))
        {
            $projectStart = $projectScheduleStatus['project_start'];
            $projectStart = DateTime::createFromFormat('Y-m-d H:i:s', $projectStart);
            $projectStart = date_format($projectStart, 'd-m-Y H:i:s');
        }
        $projectEnd = "";
        if(isset($projectScheduleStatus['project_end']))
        {
            $projectEnd = $projectScheduleStatus['project_end'];
            $projectEnd = DateTime::createFromFormat('Y-m-d H:i:s', $projectEnd);
            $projectEnd = date_format($projectEnd, 'd-m-Y H:i:s');
        }
        $detail = isset($projectScheduleStatus["detail"])?$projectScheduleStatus["detail"]:"";
        $htmlStatusView .= '
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fecha de ingreso</label>
                    <div class="input-group date date-time-picker">
                        <input name="schedule-entry-date" readonly class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fecha inicio</label>
                    <div class="input-group date date-time-picker">
                        <input name="project-start" readonly class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fecha fin</label>
                    <div class="input-group date date-time-picker">
                        <input name="project-end" readonly class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Observaciones</label>
            <textarea class="form-control" name="schedule-detail" rows="2"></textarea>
        </div>
        <p>ULTIMA ENTRADA</p>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fecha</label>
                    <input class="form-control" disabled name="current-schedule-manual-entry-date" value="'.$scheduleEntryDate.'">
                </div>    
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fecha inicio</label>
                    <input class="form-control" disabled name="last-project-start" value="'.$projectStart.'">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Fecha inicio</label>
                    <input class="form-control" disabled name="last-project-end" value="'.$projectEnd.'">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Observaciones</label>
            <textarea class="form-control" name="last-schedule-detail" disabled rows="2">'.$detail.'</textarea>
        </div>
        ';
        break;
    default:
        $htmlStatusView = "La vista para este estado no esta implementada";
}
echo $htmlStatusView;
