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
                <label>Equipo '.$status.'</label>
                <div class="form-group">
                    <select class="form-control" data-parsley-required parsley-trigger="change" id="ajax-get-stakes-leader" data-default=\''.$teamLeadersOnProject.'\'></select>
                </div>
            </fieldset>
        ';
        break;
    default:
        $htmlStatusView = "La vista para este estado no esta implementada";
}
echo $htmlStatusView;
