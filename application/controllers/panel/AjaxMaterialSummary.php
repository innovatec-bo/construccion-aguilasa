<?php

class AjaxMaterialSummary extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function add()
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
				$additionalParameters['status'] = $statusId;
				$projectList = Model_project::getAll(100, 0, "entry_date_pro","desc", $additionalParameters);
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

			$detail = $formData["detail"];
			$incidentType = $formData["incidentType"];
			$incident = new Model_incident($statusId, $percentage, $detail, $entryDate, $projectId, $pauseProject, $stopProject, $incidentType);
			$incident->save();
			$incident->pauseStopProject($statusId);
			$response = array("success" => 1, "message" => "Incidente añadido correctamente");
		}
		echo json_encode($response);exit;
	}

	public function edit()
	{

	}

	public function getSummaryListByProjectId($projectId)
	{
		$list = Model_material_summary::getByProjectId($projectId);
		$data = array();
		/** @var Model_material_summary $summaryList */
		foreach ($list as $summaryList)
		{
			if(is_null($summaryList->getReservationNumber()) || $summaryList->getReservationNumber() == "")
			{
				continue;
			}
			$data[] = array(
				'reservation_number' => $summaryList->getReservationNumber()
			);
		}
		echo json_encode($data);exit;
	}

	public function getSummaryByReservationNumber($projectId, $reservationNumber = "")
	{
		$parameters = array('project-id'=>$projectId);
		if($reservationNumber != "")
		{
			$parameters = array('reservation-number'=>$reservationNumber,'project-id'=>$projectId);
		}

		$materialPaginationHandler = new MaterialPaginationHandler(1000,0,'material_description');
		$materialPaginationHandler->setAdditionalParameters($parameters);
		echo json_encode($materialPaginationHandler->getAll());exit;
	}
}
