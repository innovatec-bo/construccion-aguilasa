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

    public function add($statusId, $projectId = NULL)
    {
        /** Server Side Validations **/
        $this->form_validation->set_rules('projectId', 'ID proyecto', 'trim|required');
        $this->form_validation->set_rules('statusId', 'Estado', 'trim|required');
        $this->form_validation->set_rules('entryDate', 'Fecha', 'trim|required');
        $this->form_validation->set_rules('pauseProject', 'Pausado', 'trim');
        $this->form_validation->set_rules('stopProject', 'Detenido', 'trim');
        $this->form_validation->set_rules('percentage', 'Porcentage', 'trim');
        $this->form_validation->set_rules('detail', 'Detalle', 'trim|required');
        $this->form_validation->set_rules('incidentType', 'Tipo incidente', 'trim|required');

        if($this->form_validation->run() === FALSE)
        {
            $validationErrors = validation_errors();
            $validationErrors = str_replace("<p>","",$validationErrors);
            $validationErrors = str_replace("</p>","<br>",$validationErrors);
            $response = array("success" => 0, "message" => $validationErrors);
            $success = $validationErrors != ""?0:1;
            $response["success"] = $success;
            $response["message"] = $validationErrors;
            $response["template"] = $this->load->view('default-template/panel/content/project-status/ht-modal-incident-form', array(), TRUE);
            $response["incident"] = array();
            if(!is_numeric($projectId))
            {
                $projectList = Model_project::getAllProjects($statusId, "", 100, 0,"entry_date_pro","desc");
            }
            else
            {
                $project = Model_project::getById($projectId)->toArray();

                $incident = Model_incident::getAllByProjectId($project["id_pro"]);
                $incident = count($incident) > 0?$incident[0]:array("percentage_inc" => 0);

                $status = Model_project_status::getById($project["status_pro"])->toArray();
                $projectList = array_merge($project, $incident,$status);
                $projectList = array($projectList);
            }
            $response["projectList"] = $projectList;
        }
        else
        {
            $formData = $this->input->post();
            $projectId = $formData["projectId"];
            $statusId = $formData["statusId"];
            $entryDate = $formData["entryDate"];
            $pauseProject = $formData["pauseProject"];
            $stopProject = $formData["stopProject"];
            $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
            $entryDate = date_format($entryDate, 'Y-m-d');
            $entryDate = $entryDate." ".date("H:i:s");
            $percentage = isset($formData["percentage"])?$formData["percentage"]:NULL;
            $detail = $formData["detail"];
            $incidentType = $formData["incidentType"];
            $incident = new Model_incident($statusId, $percentage, $detail, $entryDate, $projectId, $pauseProject, $stopProject, $incidentType);
            $incident->save();
            $incident->pauseStopProject($statusId);
            $response = array("success" => 1, "message" => "Incidente añadido correctamente");
        }
        echo json_encode($response);exit;
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