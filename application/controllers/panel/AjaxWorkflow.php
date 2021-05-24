<?php

class AjaxWorkflow extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
		$this->_validateFeature('workflow_index');
    }

    public function ajaxDtAll()
    {
		$additionalParameters = $this->input->post('additionalParameters')??array();
		$dt = new JqdtHandler($this->input->post());
		$paginationHandler = new WorkflowPaginationHandler($dt->getLength(), $dt->getStart(),$dt->getOrderName(0), $dt->getOrderDir(0),$dt->getSearchValue(),$dt->getSearchableColumnDefs());
		$paginationHandler->setAdditionalParameters($additionalParameters);
		$response = $paginationHandler->getResponseForDataTable();
		echo $dt->getJsonResponse($response['recordsTotal'], $response['recordsFiltered'], $response['resultArray']);exit;
    }
}
