<?php

class AjaxProcessLine extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function ajaxDtAllProcessLines()
    {
        $dt = new JqdtHandler($this->input->post());
        $recordsTotal = Model_process_line::countAll();
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue())
        {
            $resultArray = Model_process_line::getAll($dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0));
        }
        else
        {
            $resultArray = Model_process_line::search($dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs());
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
        $this->form_validation->set_rules('fiscal-id', 'Fiscal', 'trim|required');
        $this->form_validation->set_rules('detail', 'Detalle', 'trim|required');
        $this->form_validation->set_rules('due-date', 'Fecha de expiracion', 'trim|required');

        if($this->input->post())
        {
            $formData = $this->input->post();
            $projectId = $formData["project-id"];
            /** @var Model_project $project */
            $project = Model_project::getById($projectId);
            $fiscalId = $formData["fiscal-id"];
            $detail = $formData['detail'];
			$startDate = date("Y-m-d H:i:s");
			$dueDate = DateTime::createFromFormat("d-m-Y", $formData['due-date']);
			$dueDate = $dueDate->format("Y-m-d 23:59:59");
            $processLine = new Model_process_line($project->getId(), $fiscalId, $startDate, $dueDate, $detail);
			$processLine->save();
            $response["success"] = 1;
            $response["message"] = "Registro guardado correctamente.";
        }
        echo json_encode($response);exit;
    }
}
