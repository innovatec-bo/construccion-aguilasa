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
		/** View complements */
		$this->complementHandler->addViewComplement("jquery.datatables");
		$this->complementHandler->addViewComplement("jquery.datatables.bootstrap");
		$this->complementHandler->addViewComplement('select2');
		$this->complementHandler->addViewComplement("parsley");
		$this->complementHandler->addViewComplement("parsley.spanish");
		$this->complementHandler->addViewComplement("moment-with-locales");
		$this->complementHandler->addViewComplement("date-time-picker");
		$this->complementHandler->addProjectCss('warehouse.entry', TRUE);
		$this->complementHandler->addProjectJs('WarehouseHandler', TRUE);
		$this->complementHandler->addProjectJs('warehouse.entry', TRUE);
		/** Server Side Validations **/
		$this->form_validation->set_rules('summary-type', 'Tipo de movimiento', 'trim|required');
		$data = array();
		$fiscals = Model_user::getByRoleKeyword('fiscal');
		$builders = Model_user::getByRoleKeyword('builder');
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
			$summariesByProjectAndType = Model_material_summary::getSummariesByProjectAndType($newMaterialSummary->getProjectId(),$summaryType);
			$correlativeCounter = count($summariesByProjectAndType) + 1;
			$newMaterialSummary->setCorrelativeCounter($correlativeCounter);
			$newMaterialSummary->setFiscalResponsible($fiscal);
			$newMaterialSummary->save();
			$newMaterialSummary->saveMaterials($materials);
			$this->session->set_flashdata("successMessage", "Registro exitoso de movimiento de materiales.");
			redirect(base_url("panel/Warehouse"));
		}
	}

	public function registerMovement()
	{
		$summaryTypes = Model_material_summary_type::getByMovementType(['in','out']);
		$metaData = [
			'viewTitle' => 'Registrar movimiento de materiales',
			'summaryTypeTitle' => 'Tipo de movimiento',
			'summaryTypes' => $summaryTypes
		];
		$this->_index($metaData);
	}

	public function requestMaterials()
	{
		$summaryTypes = Model_material_summary_type::getByMovementType(['request']);
		$metaData = [
			'viewTitle' => 'Solicitar materiales',
			'summaryTypeTitle' => 'Tipo de solicitud',
			'summaryTypes' => $summaryTypes
		];
		$this->_index($metaData);
	}
}
