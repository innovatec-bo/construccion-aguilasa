<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/1/2018
 * Time: 2:01 PM
 */


class AjaxLaborCost extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function ajaxDtAllLaborCost()
    {
        $dt = new JqdtHandler($this->input->post());
        $recordsTotal = Model_role::countAll();
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue())
        {
            $resultArray = Model_role::getAll($dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0));
        }
        else
        {
            $resultArray = Model_role::search($dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs());
            $recordsFiltered = Model_role::searchTotalCount($dt->getSearchValue(),$dt->getSearchableColumnDefs());
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }
    
    public function add()
    {
        //$this->_validateFeature('qb_create_invoice');
        /** Server Side Validations **/
        $this->form_validation->set_rules('cash-remaining', 'Cambio', 'trim');

        if ($this->form_validation->run() === FALSE) 
        {
            $validationErrors = validation_errors();
            $validationErrors = str_replace("<p>", "", $validationErrors);
            $validationErrors = str_replace("</p>", "<br>", $validationErrors);
            $response = array("success" => 0, "message" => $validationErrors);
            $success = $validationErrors != "" ? 0 : 1;
            $response["success"] = $success;
            $response["message"] = $validationErrors;
            $template = $this->loadView('panel/content/project/ManpowerHandler', array(), TRUE);
            $response["data"]["template"] = $template;
            $response["data"]["templateName"] = "#ht-modal-form-add-labor-cost";
        } 
        else
        {
            $formData = $this->input->post();
            echo"<pre>";var_dump($formData);exit;
            // $manualEntryDate = $formData["entry-date"];
            // $manualEntryDate = DateTime::createFromFormat('d-m-Y H:i:s', $manualEntryDate);
            // $manualEntryDate = date_format($manualEntryDate, 'Y-m-d H:i:s');
            // $client = isset($formData["client"])?$formData["client"]:0;
            // $destination = $formData["destination"];
            // $discount = str_replace(",","",$formData["discount"]);
            // $amount = str_replace(",","",$formData["amount"]);
            // $cash = str_replace(",","",$formData["cash"]);
            // $cashRemaining = str_replace(",","",$formData["cash-remaining"]);
            // $additionalRate = str_replace(",","",$formData["additional-rate"]);
            // $toSell = $formData["to-sell"];
            // $customerFistName = $formData["customer-first-name"];
            // $customerLastName = $formData["customer-last-name"];
            // $customerNit = $formData["customer-nit"];
            // $customerEmail = $formData["customer-email"];

            // $client = Model_user::manageSellRequest($client,$customerFistName, $customerLastName, $customerNit, $customerEmail);
            // Model_sale::sell($client, $manualEntryDate, $amount, $discount, $cash, $cashRemaining, $additionalRate, $destination, $toSell);
            // $response["success"] = 1;
            // $response["message"] = "Venta registrada correctamente.";
        }
        echo json_encode($response);
        exit;
    }

    public function select2()
    {
        $term = $this->input->post("term");
        $limit = $this->input->post("limit");
        $page = $this->input->post("page");
        $offset = ($page-1)*$limit;
        $records = Model_labor_cost::search($term, $limit, $offset, NULL, 'desc', array('structure_code_bus'));
        $recordsFiltered = Model_labor_cost::searchTotalCount($term, array('structure_code_bus'));

        $resultArray = array();
        $list = array();

        foreach ($records as $row)
        {
                $list[] = array(
                    "id" => $row->id_lac,
                    "text" => $row->structure_code_bus
                );
        }
        $moreResults = ($page * $limit) < $recordsFiltered;
        $resultArray['list'] = $list;
        $resultArray['pagination'] = array("more" => $moreResults);
        echo json_encode($resultArray);exit;

    }    
}