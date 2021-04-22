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

	public function add()
	{
//		$this->_validateFeature('material_add');
		$ci = &get_instance();
		$ci->load->database();

		/** Server Side Validations **/
		$this->form_validation->set_rules('code', "C&oacute;digo", 'trim|required|is_unique[mat_materials.code_mat]', array('required' => "El %s es obligatorio.", 'is_unique' => 'Ya existe un material con el codigo que intenta registrar.'));
		$this->form_validation->set_rules('unit-of-measurement', 'Unidad de medida', 'trim|required|in_list[Pza,M]', array('required' => "La unidad de medida es requirida.", 'in_list' => 'Las unidades de medida aceptadas son Pza y M'));
		$this->form_validation->set_rules('description', "Descripci&oacute;n", 'trim|required', array('required' => 'Se requiere una descripcion para el nuevo material.'));

		if($this->form_validation->run() === FALSE)
		{
			$validationErrors = validation_errors();
			$validationErrors = str_replace("<p>","",$validationErrors);
			$validationErrors = str_replace("</p>","<br>",$validationErrors);
			$response = array("success" => 0, "message" => $validationErrors);
			$success = $validationErrors != ""?0:1;
			$response["success"] = $success;
			$response["message"] = $validationErrors;
			$response["template"] = $this->loadView("panel/content/material/ht-modal-add", array(),true);
			$response["material"] = array();
		}
		else
		{
			$formData = $this->input->post();
			$code = $formData["code"];
			$unitOfMeasurement = $formData["unit-of-measurement"];
			$description = $formData["description"];
			$material = new Model_material($code, "", $description, $unitOfMeasurement);
			$material->save();
			$response["success"] = 1;
			$response["message"] = "Se agrego un nuevo material";
		}
		echo json_encode($response);exit;
	}
}
