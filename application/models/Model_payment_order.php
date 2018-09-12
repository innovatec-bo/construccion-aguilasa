<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 05/09/2018
 * Time: 11:52 AM
 */

class Model_payment_order extends Model_payment_order_base
{
    const PAYMENT_ORDER_CREATED = 1;
    const PAYMENT_ORDER_INVOICED_AND_SEND = 2;
    const PAYMENT_ORDER_HAS_BEEN_SETTLED = 3;

    public function __construct($orderNumber = "", $status = 1, $invoiceNumber = NULL, $entryDate = "", $detail = "")
    {
        parent::__construct($orderNumber, $status, $invoiceNumber, $entryDate, $detail);
    }

    public function saveProjects($projectList = array())
    {
        $arrayToInsert = array();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;

        $projectIds = array_column($projectList, "projectId");
        $projectObjectList = Model_project::getAllInArrayIds($projectIds, 200, 0);

        //Adding projects to payment order
        foreach ($projectList as $project)
        {
            if($project["paymentOrderId"] == "")
            {
                $projectId = $project["projectId"];
                $designBudget = $project["designBudget"];
                $transportationBudget = $project["transportationBudget"];
                $buildingBudget = $project["buildingBudget"];
                $liveLineBudget = $project["liveLineBudget"];
                $rightOfWayBudget = $project["rightOfWayBudget"];

                $arrayToInsert[] = array(
                    "order_id_pop" => $this->_id,
                    "project_id_pop" => $projectId,
                    "design_budget_pop" => str_replace(",", "", $designBudget),
                    "transportation_budget_pop" => str_replace(",","",$transportationBudget),
                    "building_budget_pop" => str_replace(",","",$buildingBudget),
                    "live_line_budget_pop" => str_replace(",", "",$liveLineBudget),
                    "right_of_way_budget_pop" => str_replace(",","",$rightOfWayBudget),
                    "deleted_pop" => 0,
                    "createdon_pop" => date("Y-m-d H:i:s"),
                    "createdby_pop" => $currentUserId
                );
                //Getting the object form list using the projectId
                $projectObject = $projectObjectList[$projectId];
                //Save the real budget and status
                $projectObject->setStatus(40);//defined real budget
                $projectObject->save();
                //Getting responsible list
                $responsibleList =  Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "assign_to");
                $responsibleList = json_decode("[".$responsibleList[0]["jsonResponsible"]."]",TRUE);
                $responsibleList = array_column($responsibleList, "id");
                //Saving real budget
                $projectObject->saveRealBudget($designBudget, $buildingBudget, $transportationBudget, $liveLineBudget, $rightOfWayBudget, 40, "Se definieron los importes reales", $this->_entryDate, $responsibleList);
            }
        }
        if(count($arrayToInsert) > 0)
            Model_payment_order_project::insertBatch($arrayToInsert);
    }
}