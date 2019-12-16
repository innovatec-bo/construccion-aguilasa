<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incident extends PublicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
        $this->complementHandler->addViewComplement("perfect-scrollbar");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addProjectCss('cre-incident.index', TRUE);
        $this->complementHandler->addProjectJs('cre-incident.index', TRUE);
        /** Server Side Validations **/
        $this->form_validation->set_rules('incident-manual-entry-date', 'Fecha del incidente', 'trim|required');
        $this->form_validation->set_rules('incident-type', 'Tipo de incidente', 'trim|required|in_list[1,2,3,4,5,6,7,8,9,10]');
        $this->form_validation->set_rules('incident-detail', 'Detalle', 'trim|required|max_length[300]');

        $userEmail = "jair@twiiti.com";
        $projectCode = "RO.19.0277";
        $user = Model_user::getByEmail($userEmail);
        $project = Model_project::getByCode($projectCode);

        // $projectIncidents = Model_incident::getAllByProjectId(674);
        $incidentList = Model_incident::incidentLog();
        $projectIncidents = array();
        foreach ($incidentList as $row) 
        {
            if($row['project_code'] != $projectCode || $row['user_email'] != $userEmail)
                continue;
            $projectIncidents[] = $row;
        }
        // echo"<pre>";var_dump($projectIncidents);exit;
        $data['incidentList'] = $projectIncidents;
        $data['project'] = $project->toArray();
        $data['user'] = $user->toArray();
        if($this->form_validation->run() === FALSE)
        {
            $this->_loadPublicView('incident/index', $data);
        }
        else
        {
            $formData = $this->input->post();
            $projectId = $project->getId();
            $statusId = $project->getStatus();            
            $pauseProject = 0;
            $stopProject = 0;
            $entryDate = $formData["incident-manual-entry-date"];
            $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
            $entryDate = date_format($entryDate, 'Y-m-d');
            $entryDate = $entryDate." ".date("H:i:s");
            $percentage = isset($formData["percentage"])?$formData["percentage"]:NULL;
            //If the UI does not send the percentage then let's search the las incident percentage
            if(is_null($percentage))
            {
                $percentage = 0;
                $incidentList = Model_incident::getAllByProjectId($projectId);
                //if there are not previous incidents then lets assign 0
                if(count($incidentList) > 0)
                {
                    $percentage = $incidentList[0]["percentage_inc"];
                }
            }

            $detail = $formData["incident-detail"];
            $incidentType = $formData["incident-type"];
            $incident = new Model_incident($statusId, $percentage, $detail, $entryDate, $projectId, $pauseProject, $stopProject, $incidentType);
            $incident->save();
            $incident->pauseStopProject($statusId);
            $this->session->set_flashdata("successMessage", "Incidente agregado correctamente.");
            redirect(base_url("Incident"));
        }
	}
}
