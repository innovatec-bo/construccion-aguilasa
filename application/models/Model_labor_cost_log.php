<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
*/

class Model_labor_cost_log extends Model_labor_cost_log_base
{
    public function __construct($userId = NULL, $detail = "", $manualEntryDate = "")
    {
        parent::__construct($userId, $detail, $manualEntryDate);
    }

    public function addWorkedUpStructures($list = array())
    {
        $ci = &get_instance();
        $ci->load->database();
        $dataToSave = array();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        foreach($list as $row)
        {
            $dataToSave[] = array(
                'labor_cost_log_id_wus' => $this->_id,
                'labor_cost_id_wus' => $row['labor-cost-id'],
                'worked_up_wus' => str_replace(",","",$row['quantity']),
                'deleted_wus' => 0,
                'createdon_wus' => date('Y-m-d H:i:s'),
                'createdby_wus' => $currentUserId
            );
        }
        if(count($dataToSave) > 0)
        {
            Model_worked_up_structure::insertBatch($dataToSave);
        }
    }

    public function addBuildersToManpower($list = array())
    {
        $ci = &get_instance();
        $ci->load->database();
        $dataToSave = array();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        foreach($list as $id)
        {
            $dataToSave[] = array(
                'labor_cost_log_id_bim' => $this->_id,
                'user_id_bim' => $id,
                'deleted_bim' => 0,
                'createdon_bim' => date('Y-m-d H:i:s'),
                'createdby_bim' => $currentUserId
            );
        }
        if(count($dataToSave) > 0)
        {
            Model_builder_in_manpower::insertBatch($dataToSave);
        }
    }
}