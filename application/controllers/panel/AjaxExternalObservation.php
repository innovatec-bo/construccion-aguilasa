<?php

class AjaxExternalObservation extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function ajaxDtAllExternalObservations()
    {
        $dt = new JqdtHandler($this->input->post());
        $recordsTotal = Model_external_fiscal_observations::countAll();
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue())
        {
            $resultArray = Model_external_fiscal_observations::getAll($dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0));
        }
        else
        {
            $resultArray = Model_external_fiscal_observations::search($dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs());
            $recordsFiltered = Model_external_fiscal_observations::searchTotalCount($dt->getSearchValue(),$dt->getSearchableColumnDefs());
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }

    public function add()
    {
//        $this->_validateFeature('role_add');
        /** Server Side Validations **/
        $this->form_validation->set_rules('project-id', 'Proyecto', 'trim|required');
        $this->form_validation->set_rules('cre-fiscal-id', 'Fiscal', 'trim|required');
        $this->form_validation->set_rules('observation', 'Observacion', 'trim|required');
        $this->form_validation->set_rules('entry-date', 'Fecha', 'trim|required');

        if($this->input->post())
        {
            $formData = $this->input->post();
            $projectId = $formData["project-id"];
            /** @var Model_project $project */
            $project = Model_project::getById($projectId);
            $fiscalId = $formData["cre-fiscal-id"];
            $observation = $formData['observation'];
			$entryDate = DateTime::createFromFormat("d-m-Y", $formData['entry-date']);
			$entryDate = $entryDate->format("Y-m-d H:i:s");
            $externalObservations = new Model_external_fiscal_observations($project->getId(), $fiscalId, $observation, NULL, "", NULL, $project->getStatus(), $entryDate);
			$externalObservations->save();
            $response["success"] = 1;
            $response["message"] = "Registro guardado correctamente.";
        }
        echo json_encode($response);exit;
    }

    public function edit()
    {
//        $this->_validateFeature('role_edit');

        /** Server Side Validations **/
        $this->form_validation->set_rules('fixed-date', 'Fecha de correcci&oacute;n', 'trim|required');
        $this->form_validation->set_rules('fix-detail', 'Detalle de correcci&oacute;n', 'trim|required');

		if($this->input->post())
        {
            $formData = $this->input->post();
            $externalObservationId = $formData["external-observation-id"];
            $fixDetail = $formData["fix-detail"];
            $fixedDate = $formData["fixed-date"];
            $fixedDate = DateTime::createFromFormat("d-m-Y", $fixedDate);
            $fixedDate = $fixedDate->format('Y-m-d H:i:s');
            /** @var Model_external_fiscal_observations $externalObservation */
            $externalObservation = Model_external_fiscal_observations::getById($externalObservationId);
            $externalObservation->setFixedDate($fixedDate);
			$currentUser = PrivateController::getSessionUser();
			$currentUserId = isset($currentUser) ? $currentUser->id:NULL;
            $externalObservation->setFixedBy($currentUserId);
            $externalObservation->setFixDetail($fixDetail);
            $externalObservation->setFixed(1);
			$externalObservation->save();
            $response["success"] = 1;
            $response["message"] = "Obsevacion solucionada.";
        }
        echo json_encode($response);exit;
    }

    public function getTotalRoles()
    {
        $recordsTotal = Model_role::countAll();
        $response["total"] = $recordsTotal;
        echo json_encode($response);exit;
    }
}
