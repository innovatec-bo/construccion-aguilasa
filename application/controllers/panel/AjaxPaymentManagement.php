<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 07/09/2018
 * Time: 10:44 AM
 */


class AjaxPaymentManagement extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function ajaxDtAllPaymentOrders()
    {
        $dt = new JqdtHandler($this->input->post());
        $additionalParameters = $this->input->post("additionalParameters");
        $additionalParameters["status"] = isset($additionalParameters["status"])?$additionalParameters["status"]:"";
        $recordsTotal = Model_payment_order::countAllPaymentOrders($additionalParameters["status"]);
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue() && count($additionalParameters) <= 1)
        {
            $resultArray = Model_payment_order::getAllPaymentOrders($additionalParameters["status"],$dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0));
        }
        else
        {
            $resultArray = Model_payment_order::searchPaymentOrders($additionalParameters["status"],$dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs());
            $recordsFiltered = Model_payment_order::searchTotalCountPaymentOrders($additionalParameters["status"],$dt->getSearchValue(),$dt->getSearchableColumnDefs());
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }

    public function add()
    {
        $this->_validateFeature('role_add');
        /** Server Side Validations **/
        $this->form_validation->set_rules('role-name', 'Name', 'trim|required');
        $this->form_validation->set_rules('role-keyword', 'Keyword', 'trim|required');

        if($this->form_validation->run() === FALSE)
        {
            $response["success"] = 1;
            $response["message"] = "";
            $response["template"] = $this->loadView("panel/content/role/ht-modal-add", array(),true);
            $response["role"] = array();
        }
        else
        {
            $formData = $this->input->post();
            $roleName = $formData["role-name"];
            $roleKeyword = $formData["role-keyword"];
            $role = new Model_role($roleName, $roleKeyword);
            $role->save();
            $response["success"] = 1;
            $response["message"] = "User was added successfully";
        }
        echo json_encode($response);exit;
    }

    public function edit($roleId = NULL)
    {
        $this->_validateFeature('role_edit');

        if(!is_numeric($roleId))
        {
            $response["success"] = 0;
            $response["message"] = "Invalid parameter.";
            echo json_encode($response);exit;
        }
        $role = Model_role::getById($roleId);
        if(!$role instanceof Model_role)
        {
            $response["success"] = 0;
            $response["message"] = "Role not found.";
            echo json_encode($response);exit;
        }

        /** Server Side Validations **/
        $this->form_validation->set_rules('role-name', 'Name', 'trim|required');

        if($this->form_validation->run() === FALSE)
        {
            $response["success"] = 1;
            $response["message"] = "";
            $response["template"] = $this->loadView("panel/content/role/ht-modal-edit", array(),true);
            $role = $role->toArray();
            $response["role"]["roleId"] = $role["id_rol"];
            $response["role"]["roleName"] = $role["rolename_rol"];
            $response["role"]["keyword"] = $role["keyword_rol"];
        }
        else
        {
            $formData = $this->input->post();
            $roleName = $formData["role-name"];
            $role->setRoleName($roleName);
            $role->save();
            $response["success"] = 1;
            $response["message"] = "User was added successfully";

        }
        echo json_encode($response);exit;
    }

    public function deletePaymentOrderProject()
    {
        $formData = $this->input->post();
        echo "<pre>";var_dump($formData);exit;
    }

    public function getOriginalBudgets()
    {
        $formData = $this->input->post();
        $projectId = $formData["projectId"];
        $originalBudgets = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "project_return_materials");
        $response = array("design" => 0, "transportation" => 0, "building" => 0, "liveLine" => 0);
        if(count($originalBudgets) > 0)
        {
            $response["design"] = $originalBudgets[0]["design_prb"];
            $response["transportation"] = $originalBudgets[0]["transportation_prb"];
            $response["building"] = $originalBudgets[0]["building_prb"];
            $response["liveLine"] = $originalBudgets[0]["live_line_prb"];
            $response["rightOfWay"] = $originalBudgets[0]["right_of_way_prb"];
            $response["rbDesign"] = $originalBudgets[0]["design_reb"];
            $response["rbTransportation"] = $originalBudgets[0]["transportation_reb"];
            $response["rbBuilding"] = $originalBudgets[0]["building_reb"];
            $response["rbLiveLine"] = $originalBudgets[0]["live_line_reb"];
            $response["rbRightOfWay"] = $originalBudgets[0]["right_of_way_reb"];
        }
        echo json_encode($response);exit;
    }

    public function savePaymentOrder()
    {
        $this->load->library('form_validation');
        /** server validations */
        $this->form_validation->set_rules('orderNumber', 'Numero de orden', 'trim|required|numeric|callback_validate_payment_order');
        $this->form_validation->set_rules('entryDate', 'Fecha de reception de Nro de orden', 'trim|required');
        $this->form_validation->set_rules('detail', 'Detalle', 'trim');
        $this->form_validation->set_rules('projectList', 'Lista de proyectos', 'callback_validate_project_list');

        if ($this->form_validation->run() === FALSE)
        {
            $validationErrors = validation_errors();
            $validationErrors = str_replace("<p>","",$validationErrors);
            $validationErrors = str_replace("</p>","<br>",$validationErrors);
            $response = array("success" => 0, "message" => $validationErrors);
        }
        else
        {
            $formData = $this->input->post();
            $orderNumber = $formData["orderNumber"];
            $entryDate = $formData["entryDate"];
            $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
            $entryDate = date_format($entryDate, 'Y-m-d');
            $entryDate = $entryDate." ".date("H:i:s");
            $detail = $formData["detail"];
            $statusId = 42;//payment_order_registered
            $paymentOrder = new Model_payment_order($orderNumber, $statusId, NULL, $entryDate, $detail);
            $paymentOrder->save();
            $paymentOrder->addStatusToLog($statusId, $detail, $entryDate);
            $paymentOrder->saveProjects($formData["projectList"]);
            $response = array("success" => 1, "message" => "Orden de pago registrada correctamente!","paymentOrderId" => $paymentOrder->getId());
            $this->session->set_flashdata("successMessage", "Orden de pago registrada correctamente!");
        }
        echo json_encode($response);exit;
    }

	public function updatePaymentOrder()
	{
		$this->load->library('form_validation');
		/** server validations */
		$this->form_validation->set_rules('paymentOrderId', 'ID de orden', 'trim|required|numeric|callback_validate_update_payment_order');
		$this->form_validation->set_rules('orderNumber', 'Numero de orden', 'trim|required|numeric');
		$this->form_validation->set_rules('entryDate', 'Fecha de reception de Nro de orden', 'trim|required');
		$this->form_validation->set_rules('detail', 'Detalle', 'trim');
		$this->form_validation->set_rules('projectList', 'Lista de proyectos', 'callback_validate_project_list_to_update');

		if ($this->form_validation->run() === FALSE)
		{
			$validationErrors = validation_errors();
			$validationErrors = str_replace("<p>","",$validationErrors);
			$validationErrors = str_replace("</p>","<br>",$validationErrors);
			$response = array("success" => 0, "message" => $validationErrors);
		}
		else
		{
			$formData = $this->input->post();
			$paymentOrderId = $formData["paymentOrderId"];
			$orderNumber = $formData["orderNumber"];
			$entryDate = $formData["entryDate"];
			$entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
			$entryDate = date_format($entryDate, 'Y-m-d');
			$entryDate = $entryDate." ".date("H:i:s");
			$detail = $formData["detail"];
			$statusId = 42;//payment_order_registered
			$paymentOrder = Model_payment_order::getById($paymentOrderId);
//			$paymentOrder->save();
			$paymentOrder->saveProjects($formData["projectList"]);
			$response = array("success" => 1, "message" => "Orden de pago actualizada correctamente!", "paymentOrderId" => $paymentOrder->getId());
			$this->session->set_flashdata("successMessage", "Orden de pago actualizada correctamente!");
		}
		echo json_encode($response);exit;
	}

	public function validate_payment_order()
	{
		$formData = $this->input->post();
		$paymentOrderId = !isset($formData["paymentOrderId"])?"":$formData["paymentOrderId"];
		$orderNumber = $formData["orderNumber"];

		$alreadyExist = Model_payment_order::orderNumberDuplicated($orderNumber, $paymentOrderId);
		$response = TRUE;
        if($alreadyExist)
        {
            $this->form_validation->set_message('validate_payment_order', 'El numero de orden que intenta registrar ya existe!');
            $response = FALSE;
        }
		return $response;
	}

    public function validate_update_payment_order()
    {
        $formData = $this->input->post();
        $paymentOrderId = !isset($formData["paymentOrderId"])?"":$formData["paymentOrderId"];
        $paymentOrder = Model_payment_order::getById($paymentOrderId);
        $orderNumber = $formData["orderNumber"];
        $alreadyExist = Model_payment_order::orderNumberDuplicated($orderNumber, $paymentOrderId);
        $response = TRUE;
        if($alreadyExist)
        {
            $this->form_validation->set_message('validate_update_payment_order', 'El numero de orden que intenta registrar ya existe!');
            $response = FALSE;
        }
        elseif($paymentOrder->getInvoiceNumber() != "")
        {
            $this->form_validation->set_message('validate_update_payment_order', 'No puedes actualizar esta orden de pago, porque ya ha sido facturada!');
            $response = FALSE;
        }
        return $response;
    }

    public function validate_project_list()
    {
        $formData = $this->input->post();
        $projectArrayList = $formData["projectList"];
        $projectIds = array_column($projectArrayList, "projectId");
        $projectObjectList = Model_project::getAllInArrayIds($projectIds, 200,0);
        $response = TRUE;
        $notReadyToRealBudgets = "";
        foreach ($projectObjectList as $project)
        {
            $projectStatus = $project->getStatus();
            if($projectStatus != 39)
            {
                $notReadyToRealBudgets .= $project->getCode().", ";
            }
        }
        $notReadyToRealBudgets = substr($notReadyToRealBudgets, 0, -2);
        if(count($projectObjectList) <= 0)
        {
            $this->form_validation->set_message('validate_project_list', 'Se envio una lista vacia de proyectos');
            $response = FALSE;
        }
        elseif ($notReadyToRealBudgets != "")
        {
            $this->form_validation->set_message('validate_project_list', 'Estos proyecto no estan en estado de "Materiales devueltos a CRE" ('.$notReadyToRealBudgets.')');
            $response = FALSE;
        }
        return $response;
    }

	public function validate_project_list_to_update()
	{
		$formData = $this->input->post();
		$projectArrayList = $formData["projectList"];
		$projectIds = array_column($projectArrayList, "projectId");
		$projectObjectList = Model_project::getAllInArrayIds($projectIds, 200,0);
		$response = TRUE;
		$notReadyToRealBudgets = "";
		foreach ($projectObjectList as $project)
		{
			$projectStatus = $project->getStatus();
			if($projectStatus != 39)
			{
				$notReadyToRealBudgets .= $project->getCode().", ";
			}
		}
		$notReadyToRealBudgets = substr($notReadyToRealBudgets, 0, -2);
		if(count($projectObjectList) <= 0)
		{
			$this->form_validation->set_message('validate_project_list', 'Se envio una lista vacia de proyectos');
			$response = FALSE;
		}
		return $response;
	}

    public function verifyPreviousEntry()
    {
        $formData = $this->input->post();
        $orderId = $formData["orderId"];
        $statusKeyword = $formData["statusKeyword"];
        $previousEntry = Model_payment_order_status_log::getLogByPaymentOrderIdAndStatusKeyWord($orderId, $statusKeyword);
        $response["previousEntry"] = $previousEntry;
        echo json_encode($response);exit;
    }

    public function saveInvoiceSent()
    {
        $formData = $this->input->post();
        $orderId = $formData["orderId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");

        $invoiceDate = $formData["invoiceDate"];
        $invoiceDate = DateTime::createFromFormat('d-m-Y', $invoiceDate);
        $invoiceDate = date_format($invoiceDate, 'Y-m-d');
        $invoiceDate = $invoiceDate." ".date("H:i:s");

        $invoiceNumber = $formData["invoiceNumber"];


        $statusId = $formData["statusId"];
        $statusDetail = $formData["statusDetail"];
        $paymentOrder = Model_payment_order::getById($orderId);
        $paymentOrder->setStatus($statusId);
        $paymentOrder->setInvoiceNumber($invoiceNumber);
        $paymentOrder->setInvoiceDate($invoiceDate);
//        echo "<pre>";var_dump($paymentOrder->toArray());exit;
        $paymentOrder->save();
        $paymentOrder->addStatusToLog($statusId, $statusDetail, $entryDate);
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function saveBasicLog()
    {
        $formData = $this->input->post();
        $orderId = $formData["orderId"];
        $entryDate = $formData["entryDate"];
        $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
        $entryDate = date_format($entryDate, 'Y-m-d');
        $entryDate = $entryDate." ".date("H:i:s");
        $statusId = $formData["statusId"];
        $statusDetail = $formData["detail"];
        $paymentOrder = Model_payment_order::getById($orderId);
        $paymentOrder->setStatus($statusId);
        $paymentOrder->save();
        $paymentOrder->addStatusToLog($statusId, $statusDetail, $entryDate);
        $response["success"] = 1;
        $response["message"] = "Operacion realizada con exito.";
        echo json_encode($response);exit;
    }

    public function getPaymentOrderLog()
    {
        $formData = $this->input->post();
        $orderId = $formData["orderId"];
        $paymentOrderLog = Model_payment_order_status_log::getLogByPaymentOrderId($orderId);
        echo json_encode($paymentOrderLog);exit;
    }

    public function getPaymentOrdersProjectsDetail()
	{
		$formData = $this->input->post();
		$paymentOrderId = $formData["paymentOrderId"];
		$paymentOrdersProjectsList = Model_payment_order_project::getDetailByPaymentOrderId($paymentOrderId);
		$response = array();
		$i = 0;
		foreach($paymentOrdersProjectsList as $paymentOrderProject)
		{
			$response[] = array(
				"index" => $i+1,
				"design_budget" => $paymentOrderProject["design_budget_pop"],
				"transportation_budget" => $paymentOrderProject["transportation_budget_pop"],
				"building_budget" => $paymentOrderProject["building_budget_pop"],
				"live_line_budget" => $paymentOrderProject["live_line_budget_pop"],
				"right_of_way_budget" => $paymentOrderProject["right_of_way_budget_pop"],
				"projectId" => $paymentOrderProject["id_pro"],
				"projectCode" => $paymentOrderProject["code_pro"]
			);
			$i++;
		}
		echo json_encode($response);exit;
	}
}