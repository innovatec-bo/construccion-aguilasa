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
      $wfColumns = PrivateController::getWorkflowColumns();
      $wfColumns = array_keys($wfColumns);
      // $paginationHandler->setColumnsToShow($wfColumns);
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
        $wokflowPaginationHandler = new WorkflowPaginationHandler($limit,$offset,'code_pro','asc',$term,array('code_pro'));
        $wokflowPaginationHandler->setColumnsToShow(['fiscal_responsible_id','fiscal_responsible','builder_responsible','builder_responsible_id','approved_reservation_number']);
		    $wokflowPaginationHandler->setAdditionalParameters($additionalParameters);
        $result = $wokflowPaginationHandler->getResponseForSelect2($page);
		    echo json_encode($result);exit;
    }
}
