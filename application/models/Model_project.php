<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_project extends Model_project_base
{
    public function __construct($projectCode = "", $projectName = "", $address = "", $entryDate = "", $creFiscal = "", $status = NULL)
    {
        parent::__construct($projectCode, $projectName, $address, $entryDate, $creFiscal, $status);
    }

    public function savePoints($points, $metersDistance)
    {
        $projectPoints = new Model_project_points($this->_id, $points, $metersDistance);
        $projectPoints->save();
    }

    public function addStatusToLog($statusId)
    {
        $getLastProjectStatus = Model_project_status_log::getLastProjectStatusLogByProjectId($this->_id);

        if(!$getLastProjectStatus instanceof Model_project_status_log || $getLastProjectStatus->getProjectStatus() != $this->_status)
        {
            $projectStatus = new Model_project_status_log($this->_id, $statusId);
            $projectStatus->save();
        }
    }
}