<?php

class AjaxSummary extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
        // $this->_validateFeature("warehouse_index");
    }

	public function ajaxDtAllSummaries($type)
	{
		$additionalParameters = $this->input->post('additionalParameters')??[];
		$response = $this->_is("fiscal");
		if($response == 1)
		{
			$additionalParameters["fiscal-id"] = $this->sessionUser->id;
		}
		$additionalParameters['summary-type-keyword'] = $type;
		$dt = new JqdtHandler($this->input->post());
		$paginationHandler = new SummaryPaginationHandler($dt->getLength(), $dt->getStart(),$dt->getOrderName(0), $dt->getOrderDir(0),$dt->getSearchValue(),$dt->getSearchableColumnDefs());
		$paginationHandler->setAdditionalParameters($additionalParameters);
		$response = $paginationHandler->getResponseForDataTable();
		echo $dt->getJsonResponse($response['recordsTotal'], $response['recordsFiltered'], $response['resultArray']);exit;
	}

    public function ajaxDtAllSummaries_old()
	{
		$additionalParameters = $this->input->post('additionalParameters')??array();
		$response = $this->_is("fiscal");
		if($response == 1)
		{
			$additionalParameters["fiscal-responsible-id"] = $this->sessionUser->id;
		}
		$dt = new JqdtHandler($this->input->post());
		$paginationHandler = new ProjectPaginationHandler($dt->getLength(), $dt->getStart(),$dt->getOrderName(0), $dt->getOrderDir(0),$dt->getSearchValue(),$dt->getSearchableColumnDefs());
		$paginationHandler->setAdditionalParameters($additionalParameters);
		$response = $paginationHandler->getResponseForDataTable();
		echo $dt->getJsonResponse($response['recordsTotal'], $response['recordsFiltered'], $response['resultArray']);exit;
	}
}
