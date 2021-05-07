<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 09/08/2018
 * Time: 10:34 AM
 */


class Warehouse extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

	private function _index($metaData) : void
	{

		$materialSummary = NULL;
		if(isset($_GET['request-id']))
		{
			$materialsRequestId = $_GET['request-id'];
			$method = debug_backtrace()[1]['function'];
			$redirectTo = "panel/Warehouse/".$method;
			/** @var Model_material_summary $materialSummary */
			$materialSummary = $this->_validateObjectToEdit($materialsRequestId,Model_material_summary::class, $redirectTo, "No se encuentra la lista de solicitud.");
			$requests = Model_material_summary_type::getByMovementType(['request']);
			if(!isset($requests[$materialSummary->getSummaryType()]))
			{
				$this->session->set_flashdata("errorMessage", "Debe ingresar un c&oacute;digo de una lista de solcitud.");
			}
		}
		/** View complements */
		$this->complementHandler->addViewComplement("jquery.datatables");
		$this->complementHandler->addViewComplement("jquery.datatables.bootstrap");
		$this->complementHandler->addViewComplement('select2');
		$this->complementHandler->addViewComplement("parsley");
		$this->complementHandler->addViewComplement("parsley.spanish");
		$this->complementHandler->addViewComplement("moment-with-locales");
		$this->complementHandler->addViewComplement("date-time-picker");
		$this->complementHandler->addProjectJs('DTAdditionalParameterHandler', TRUE);
		$this->complementHandler->addProjectCss('warehouse.entry', TRUE);
		$this->complementHandler->addProjectJs('WarehouseHandler', TRUE);
		$this->complementHandler->addProjectJs('warehouse.entry', TRUE);

		/** Server Side Validations **/
		$this->form_validation->set_rules('summary-type', 'Tipo de movimiento', 'trim|required');
		$data = array();
		$fiscals = Model_user::getByRoleKeyword('fiscal');
		$builders = Model_user::getByRoleKeyword('builder');

		/*** data from request list - begin*/
		$data['materialSummary'] = [];
		$data['materialList'] = [];
		$data['summaryTypeId'] = [];
		if($materialSummary instanceof Model_material_summary)
		{
			$outList = [
				14 => "materials_delivered_to_builder",
				15 => "materials_delivered_to_builder_loan"
			];
			$data['materialSummary'] = Model_material_summary::getMasterDetailByListId($materialSummary->getId());
			$data['materialList'] = Model_project_material::getBySummaryId($materialSummary->getId());
			$summaryType = Model_material_summary_type::getByKeyword([$outList[$materialSummary->getSummaryType()]]);
			$summaryType = array_values($summaryType);
			$data['summaryTypeId'] = $summaryType[0]->getId();
		}
		/*** data from request list - end*/
		$projects = Model_project::getByStatusKeywordList(['approved','in_progress','stopped','paused','completed','as_built','conciliation_reception','conciliation_shipment','cre_return_order','project_return_materials','project_energized']);
		$data['projects'] = $projects;
		$data['fiscals'] = $fiscals;
		$data['builders'] = $builders;
		$data = array_merge($data,$metaData);

		if($this->form_validation->run() === FALSE)
		{
			$this->_loadPanelView("warehouse/entry",$data);
		}
		else
		{
			$formData = $this->input->post();
//			echo"<pre>";var_dump($formData);exit;
			$projectId = $formData['project'];
			$reservationNumber = $formData['reservation-number'];
			$summaryType = $formData['summary-type'];
			$builder = $formData['builder'];
			$fiscal = $formData['fiscal'];
			$entryDate = $formData['entry-date'];
			$entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
			$entryDate = date_format($entryDate, 'Y-m-d');
			$entryDate = $entryDate." ".date("H:i:s");
			$materials = array_values($formData['summary']);
			$summaryWithBuilderAndFiscal = array(4,10,11,14,15);
			$summaryWithReservationNumber = array(3,8);
			$currentUser = PrivateController::getSessionUser();
			$currentUserId = isset($currentUser) ? $currentUser->id:NULL;

			$newMaterialSummary = new Model_material_summary(NULL,'TODOS',$projectId,$projectId,'','',$entryDate,'',$currentUserId,$summaryType, NULL);

			$newMaterialSummary->setBuilderResponsible(NULL);
			$newMaterialSummary->setFiscalResponsible(NULL);
			if(array_search($summaryType, $summaryWithBuilderAndFiscal) !== FALSE)
			{
				$newMaterialSummary->setBuilderResponsible($builder);
				$newMaterialSummary->setFiscalResponsible($fiscal);
			}
			if(isset($_GET['request-id']))
			{
				$newMaterialSummary->setParentSummaryId($_GET['request-id']);
			}
			if(array_search($summaryType, $summaryWithReservationNumber) !== FALSE)
			{
				$newMaterialSummary->setReservationNumber($reservationNumber);
			}

			$summariesByProjectAndType = Model_material_summary::getSummariesByProjectAndType($newMaterialSummary->getProjectId(),$summaryType);
			$correlativeCounter = count($summariesByProjectAndType) + 1;
			$newMaterialSummary->setCorrelativeCounter($correlativeCounter);
			$newMaterialSummary->setFiscalResponsible($fiscal);
			$newMaterialSummary->save();
			$newMaterialSummary->saveMaterials($materials);
			$requestID = "";
			if($newMaterialSummary->getSummaryType() == 14 || $newMaterialSummary->getSummaryType() == 15)
				$requestID = "<strong>Su c&oacute;digo de solicitud es : ".$newMaterialSummary->getId()."</strong>";
			$this->session->set_flashdata("successMessage", "La lista se creo correctamente.".$requestID);
			$method = debug_backtrace()[1]['function'];
			redirect(base_url("panel/Warehouse/".$method));
		}
	}

	public function registerMovement()
	{
		$summaryTypes = Model_material_summary_type::getByMovementType(['in','out']);
		$metaData = [
			'viewTitle' => 'Registrar movimiento de materiales',
			'summaryTypeTitle' => 'Tipo de movimiento',
			'summaryTypes' => $summaryTypes,
			'showSearchBox' => 1,
			'materialsTitle' => 'Lista general',
			'showAssignedMaterialsOnly' => 0
		];
		$this->_index($metaData);
	}

	public function requestMaterials()
	{
		$summaryTypes = Model_material_summary_type::getByMovementType(['request']);
		$metaData = [
			'viewTitle' => 'Solicitar materiales',
			'summaryTypeTitle' => 'Tipo de solicitud',
			'summaryTypes' => $summaryTypes,
			'showSearchBox' => 0,
			'materialsTitle' => 'Materiales asignados',
			'showAssignedMaterialsOnly' => 1
		];
		$this->_index($metaData);
	}
}
