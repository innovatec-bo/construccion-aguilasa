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
    
    public function add($projectId)
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
            $project = Model_project::getById($projectId);
            $projectArray = $project->toArray();
            $projectArray['managementBy'] = $this->_projectSystems[$projectArray['management_by_pro']];
            $response["data"]["template"] = $template;
            $response["data"]["templateName"] = "#ht-modal-form-add-labor-cost";
            $response["data"]["project"] = $projectArray;
        } 
        else
        {
            $formData = $this->input->post();
//            echo"<pre>";var_dump($formData);exit;
//            $currentLaborCost = Model_labor_cost::getMasterDetailByProjectId($projectId);
            /** @var Model_labor_detail $laborDetail */
            $laborDetail = Model_labor_detail::getByProjectId($projectId);
            $activity = $formData["activity"];
            $execution = $formData["execution"];
            $quantity = 0;
            $unitPrice = str_replace(",","", $formData["price"]);
            //If the data to create a new structure is settled then this code block will be executed
            if(isset($formData["structure-code"]) && $formData["structure-code"] != "")
            {
                $structureCode = $formData["structure-code"];
                $detail = $formData["structure-detail"];
                $unitOfMeasurement = $formData["structure-unit-of-measurement"];
                //Firstly let's make sure that the structure code passed does not exist
                $structure = Model_building_structure::getByCode($structureCode);
                if(!$structure instanceof Model_building_structure)
                {
                    $structure = new Model_building_structure($structureCode, $detail, $unitOfMeasurement);
                    $structure->save();
                }
            }
            else
            {
                $structureId = $formData["structure-id"];
                $structure = Model_building_structure::getById($structureId);
            }
            $laborCost = new Model_labor_cost($laborDetail->getId(), $structure->getId(), $activity, $execution, $quantity, $unitPrice);
            $laborCost->save();

            $response["success"] = 1;
            $response["message"] = "Estructura registrada correctamente.";
            $response["data"]["laborCost"] = $laborCost->toArray();
            $response["data"]["structure"] = $structure->toArray();
        }
        echo json_encode($response);
        exit;
    }

    public function select2()
    {
        $term = $this->input->post("term");
        $limit = $this->input->post("limit");
        $page = $this->input->post("page");
        $budgetaryPosition = $this->input->post("budgetaryPosition");
        $managementBy = $this->input->post("management");
        $offset = ($page-1)*$limit;
        $records = Model_labor_cost::searchLaborCost($budgetaryPosition, $managementBy, $term, $limit, $offset, NULL, 'desc', array('structure_code_bus','description_bus', 'code_pro'));
        $recordsFiltered = Model_labor_cost::searchTotalCountLaborCost($budgetaryPosition, $managementBy, $term, array('structure_code_bus','description_bus', 'code_pro'));

        $resultArray = array();
        $list = array();

        foreach ($records as $row)
        {
                $list[] = array(
                    "id" => $row->id_bus,
                    "text" => $row->structure_code_bus,
                    "structure_code" => $row->structure_code_bus,
                    "structure_detail" => $row->description_bus,
                    "structure_unit_price" => $row->unit_price_lac,
                    "structure_activity" => $row->activity_lac,
                    "structure_execution" => $row->execution_lac,
                    "structure_quantity" => $row->quantity_lac,
                    "management_by" => $row->management_by_pro,
                    "budgetary_position" => $row->budgetary_position_pro,
                    "project_code" => $row->code_pro

                );
        }
        $moreResults = ($page * $limit) < $recordsFiltered;
        $resultArray['list'] = $list;
        $resultArray['pagination'] = array("more" => $moreResults);
        echo json_encode($resultArray);exit;

    }    
}