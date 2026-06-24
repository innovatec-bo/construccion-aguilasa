<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 07/02/2019
 * Time: 9:36 AM
 */

class AjaxIncident extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function ajaxDtAllIncidents()
    {
        $dt = new JqdtHandler($this->input->post());
        $recordsTotal = Model_incident::countAll();
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue())
        {
            $resultArray = Model_incident::getAll($dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0));
        }
        else
        {
            $resultArray = Model_incident::search($dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs());
            $recordsFiltered = Model_incident::searchTotalCount($dt->getSearchValue(),$dt->getSearchableColumnDefs());
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }

    public function add($statusId = NULL, $projectId = NULL)
    {
        /** Server Side Validations **/
        $this->form_validation->set_rules('projectId', 'ID proyecto', 'trim|required');
        $this->form_validation->set_rules('statusId', 'Estado', 'trim|required');
        $this->form_validation->set_rules('entryDate', 'Fecha', 'trim|required');
        $this->form_validation->set_rules('pauseProject', 'Pausado', 'trim');
        $this->form_validation->set_rules('stopProject', 'Detenido', 'trim');
        $this->form_validation->set_rules('percentage', 'Porcentage', 'trim');
        $this->form_validation->set_rules('detail', 'Detalle', 'trim');
        $this->form_validation->set_rules('incidentType', 'Tipo incidente', 'trim|required');
    
        if ($this->form_validation->run() === FALSE)
        {
            $validationErrors = validation_errors();
            $validationErrors = str_replace("<p>", "", $validationErrors);
            $validationErrors = str_replace("</p>", "<br>", $validationErrors);
            $response = array("success" => 0, "message" => $validationErrors);
            $success = $validationErrors != "" ? 0 : 1;
            $response["success"] = $success;
            $response["message"] = $validationErrors;
            $response["template"] = $this->load->view('default-template/panel/content/project-status/ht-modal-incident-form', [], TRUE);
            $response["incident"] = [];

            if (!is_numeric($projectId))
            {
                // "Add incident to all projects in this status" button —
                // fetch every project currently sitting in $statusId.
                $apiResponse = WorkflowApiClient::getPaginated([
                    'status'   => $statusId,
                    'per_page' => 100,
                ]);
                $projectList = $apiResponse['data'] ?? [];
            }
            else
            {
                // "New incident" button on a single project.
                // $project = Model_project::getById($projectId)->toArray();
    
                $apiResponse = WorkflowApiClient::getPaginated([
                    'id_list' => $projectId,
                    'per_page'  => 1,
                ]);
                $projectList = $apiResponse['data'] ?? [];
                
            }
            $response["projectList"] = $projectList;
        }
        else
        {
            $formData     = $this->input->post();
            $projectId    = $formData["projectId"];
            $statusId     = $formData["statusId"];
            $entryDate    = $formData["entryDate"];
            $pauseProject = $formData["pauseProject"];
            $stopProject  = $formData["stopProject"];
            $entryDate    = DateTime::createFromFormat('d-m-Y', $entryDate);
            $entryDate    = date_format($entryDate, 'Y-m-d');
            $entryDate    = $entryDate . " " . date("H:i:s");
            $percentage   = isset($formData["percentage"]) ? $formData["percentage"] : NULL;
    
            // If the UI does not send the percentage then let's search the last incident percentage
            if (is_null($percentage))
            {
                $percentage = 0;
                $incidentList = Model_incident::getAllByProjectId($projectId);
                // if there are not previous incidents then lets assign 0
                if (count($incidentList) > 0)
                {
                    $percentage = $incidentList[0]["percentage_inc"];
                }
            }
    
            $detail       = $formData["detail"];
            $incidentType = $formData["incidentType"];
            $incident     = new Model_incident($statusId, $percentage, $detail, $entryDate, $projectId, $pauseProject, $stopProject, $incidentType);
            $incident->save();
            $incident->pauseStopProject($statusId);
            WorkflowSyncNotifier::notify($projectId);
            $response = array("success" => 1, "message" => "Incidente añadido correctamente");
        }
        echo json_encode($response);
        exit;
    }


    public function getTotalRoles()
    {
        $recordsTotal = Model_role::countAll();
        $response["total"] = $recordsTotal;
        echo json_encode($response);exit;
    }

    public function getIncidentLog()
    {
        $incidentList = Model_incident::incidentLog();
        $i = 0;
        foreach ($incidentList as $incident)
        {
            $incidentList[$i]["index"] = $i+1;
            $i++;
        }
        $response["success"] = 1;
        $response["message"] = "";
        $response["data"]["template"] = $this->load->view('default-template/panel/content/project-status/ht-incident-log', array(), TRUE);
        $response["data"]["templateName"] = "#ht-incident-log";
        $response["data"]["incidentList"] = $incidentList;

        echo json_encode($response);exit;
    }
}
