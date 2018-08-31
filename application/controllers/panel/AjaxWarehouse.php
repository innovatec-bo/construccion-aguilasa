<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/08/2018
 * Time: 10:23 AM
 */

class AjaxWarehouse extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function ajaxDtAllWarehouses()
    {
        $dt = new JqdtHandler($this->input->post());
        $additionalParameters = $this->input->post("additionalParameters");
        $additionalParameters["status"] = isset($additionalParameters["status"])?$additionalParameters["status"]:"";
        $recordsTotal = Model_warehouse::countAll($additionalParameters["status"]);
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue() && count($additionalParameters) <= 1)
        {
            $resultArray = Model_warehouse::getAllProjects($additionalParameters["status"], $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0));
        }
        else
        {
            $resultArray = Model_warehouse::searchProject($additionalParameters["status"], $dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs(), $additionalParameters);
            $recordsFiltered = Model_warehouse::searchTotalCount($additionalParameters["status"], $dt->getSearchValue(),$dt->getSearchableColumnDefs(), $additionalParameters);
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }
    public function saveWarehouse()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        $this->session->set_flashdata("successMessage","El proyecto ".$project->getCode()." se envio a 'Por Grabar'");
        echo json_encode($response);exit;
    }

    public function saveRecordBuildingMaterials()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function savePickUpMaterials()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);

        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveDeliverMaterials()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);


        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveReturnMaterials()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $responsibleList = $formData["responsibleList"];
        $project = Model_project::getById($projectId);
        $project->setStatus($statusId);
        $project->save();
        $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveBasicLog()
    {
        $formData = $this->input->post();
        $warehouseId = $formData["warehouseId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $warehouse = Model_warehouse::getById($warehouseId);
        $warehouse->setStatus($statusId);
        $warehouse->save();
        $warehouse->addStatusToLog($statusId, $statusDetail, $entryDate);
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function verifyPreviousEntry()
    {
        $formData = $this->input->post();
        $warehouseId = $formData["warehouseId"];
        $statusKeyword = $formData["statusKeyword"];
        $warehouse = Model_warehouse::getById($warehouseId);
        $previousEntry = Model_warehouse_status_log::getLogByWarehouseIdAndStatusKeyWord($warehouseId, $statusKeyword);
        $assignmentEntry = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($warehouse->getProjectId(), "assign_to");
        $response["previousEntry"] = $previousEntry;
        $response["assignmentEntry"] = $assignmentEntry;
        echo json_encode($response);exit;
    }

    public function getWarehouseLog()
    {
        $formData = $this->input->post();
        $warehouseId = $formData["warehouseId"];
        $projectLog = Model_warehouse_status_log::getLogByWarehouseId($warehouseId);
        echo json_encode($projectLog);exit;
    }
}