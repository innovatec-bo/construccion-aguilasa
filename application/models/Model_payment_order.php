<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 05/09/2018
 * Time: 11:52 AM
 */

class Model_payment_order extends Model_payment_order_base
{
    public function __construct($orderNumber = "", $status = 1, $invoiceNumber = NULL, $entryDate = "", $detail = "")
    {
        parent::__construct($orderNumber, $status, $invoiceNumber, $entryDate, $detail);
    }

    public function saveProjects($projectList = array())
    {
        $arrayToInsert = array();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;
        foreach ($projectList as $project)
        {
            //new team partners
            if($project["paymentOrderId"] == "")
            {
                $arrayToInsert[] = array(
                    "order_id_pop" => $this->_id,
                    "project_id_pop" => $project["projectId"],
                    "design_budget_pop" => str_replace(",", "",$project["designBudget"]),
                    "transportation_budget_pop" => str_replace(",","",$project["transportationBudget"]),
                    "building_budget_pop" => str_replace(",","",$project["buildingBudget"]),
                    "live_line_budget_pop" => str_replace(",", "",$project["liveLineBudget"]),
                    "right_of_way_budget_pop" => str_replace(",","",$project["rightOfWayBudget"]),
                    "deleted_pop" => 0,
                    "createdon_pop" => date("Y-m-d H:i:s"),
                    "createdby_pop" => $currentUserId
                );
            }
        }
        if(count($arrayToInsert) > 0)
            Model_payment_order::insertBatch($arrayToInsert);
    }
}