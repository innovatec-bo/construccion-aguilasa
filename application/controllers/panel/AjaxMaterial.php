<?php

class AjaxMaterial extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function ajaxDtAllMaterial()
	{
		$additionalParameters = $this->input->post('additionalParameters')??array();
		$dt = new JqdtHandler($this->input->post());
		$paginationHandler = new MaterialPaginationHandler($dt->getLength(), $dt->getStart(),$dt->getOrderName(0), $dt->getOrderDir(0),$dt->getSearchValue(),$dt->getSearchableColumnDefs());
		$paginationHandler->setAdditionalParameters($additionalParameters);
		$response = $paginationHandler->getResponseForDataTable();
		echo $dt->getJsonResponse($response['recordsTotal'], $response['recordsFiltered'], $response['resultArray']);exit;
	}

	public function select2()
	{
		$term = $this->input->post("term");
		$limit = $this->input->post("limit");
		$page = $this->input->post("page");
		$offset = ($page-1)*$limit;
		$additionalParameters = $this->input->post('additionalParameters')??array();
		$teamPaginationHandler = new MaterialPaginationHandler($limit,$offset,'material_description','asc',$term,array('material_description','material_code'));
		$teamPaginationHandler->setAdditionalParameters($additionalParameters);
		$result = $teamPaginationHandler->getResponseForSelect2($page);
		echo json_encode($result);exit;
	}
}
