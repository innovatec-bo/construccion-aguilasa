<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 */
use Assert\Assertion;
use Assert\Assert;
use Assert\LazyAssertionException;
use Assert\AssertionFailedException;

class Test extends PublicController
{
    public function __construct()
    {
        parent::__construct();
        if(!is_cli())
		{
			show_404();
		}
    }

    public function codegen()
    {
   	// $codeGen = new CodeGenHandler('mat_internal_warehouse_operation_types', 'internal_warehouse_operation_type');
   	// $codeGen->generateModelFiles();
    }

	public function resetdb()
	{
		$dropSchema = "vendor/bin/doctrine orm:schema-tool:drop --force;";
		$createSchema = "vendor/bin/doctrine orm:schema-tool:create;";
		// $loadData = "mysql -u admin -p123456 serebo_doctrine < /var/www/html/serebo/serebo_20210716";
		$loadData = "mysql -u admin -p123456 serebo_doctrine < application/models/serebo_doctrine.sql";
		$output = shell_exec($dropSchema.$createSchema.$loadData);
		print_r($output);

	}
	
	public function asserts()
	{
		// try
		// {
		// 	Assertion::digit('ab');
		// }
		// catch(AssertionFailedException $e)
		// {
		// 	$e->getValue();
    	// 	$e->getConstraints();
		// 	dd($e->getMessage(), $e->getValue(),$e->getConstraints());
		// }

		try
		{
			Assert::lazy()
					->that(['first'], 'Batch')->keyExists('first_name')
					->that(['last'], 'Batch')->keyExists('last_name')
		
					->that(['c'], 'Batch')->keyExists('ci', 'no existe')
					->that(['cell'], 'Batch')->keyExists('cellphone')
					->verifyNow();
		}
		catch(LazyAssertionException $e) {
			dd($e->getMessage());
		}
	}

	public function wfImprovement()
	{
		$workflow = new WorkflowPaginationHandler(10);
		$wfColumns = PrivateController::getWorkflowColumns();
		$wfColumns = array_keys($wfColumns);
		// $workflow->setColumnsToShow(['stake_date','rd_digitization_points_quantity']);
		$workflow->setColumnsToShow(['fiscal_responsible_id','fiscal_responsible','builder_responsible','builder_responsible_id']);
		// $workflow->setColumnsToShow($wfColumns);
		$result = $workflow->getAll();
		dd($result);
	}

	public function summary()
	{
		$materialSummary = new SummaryPaginationHandler();
		$materialSummary->setAdditionalParameters(['fiscal-id' => 30, 'builder-id' => 16]);
		$response = $materialSummary->getAll();
		dd($response);
	}

	public function fixEditedOnRecords()
	{
		$ci = &get_instance();
		$ci->load->database();

		$oldTables = [
			['sec_roles','editedon_rol'],
			['mat_internal_warehouse_operations','editedon_iwo'],
			['wfl_project_status_log','editedon_psl'],
			['wfl_incidents','editedon_inc'],
			['bui_building_structures','editedon_bus'],
			['mat_materials_summary','editedon_msu'],
			['wfl_warehouse_setup','editedon_wsu'],
			['wfl_work_plans','editedon_wpl'],
			['mat_material_status','editedon_mst'],
			['bui_blocked_log_date_ranges','editedon_bld'],
			['sec_executive_summary_log','editedon_esl'],
			['bui_labor_cost','editedon_lac'],
			['wfl_external_fiscal_observations','editedon_efo'],
			['bui_labor_details','editedon_lad'],
			['mat_materials_summary_types','editedon_mqt'],
			['mat_internals','editedon_int'],
			['sec_user_supervisor_by_period','editedon_usp'],
			['wfl_project_stakes','editedon_prs'],
			['bui_custom_structure_materials','editedon_csm'],
			['wfl_work_plan_dates','editedon_wpd'],
			['bui_building_points','editedon_bpo'],
			['wfl_project_status','editedon_pst'],
			['sec_users','editedon_usr'],
			['wfl_workflow_column_groups','editedon_wcg'],
			['base_table','editedon_'],
			['sec_features','editedon_fes'],
			['bui_builders_in_manpower','editedon_bim'],
			['wfl_production_limits','editedon_prl'],
			['sys_files','editedon_fil'],
			['wfl_project_budgets','editedon_prb'],
			['wfl_stakes_team_leader','editedon_stl'],
			['wfl_dates_to_work','editedon_wpl'],
			['mat_materials','editedon_mat'],
			['wfl_status_log_responsibles','editedon_slr'],
			['bui_labor_cost_log','editedon_lal'],
			['wfl_payment_orders_projects','editedon_pop'],
			['mat_material_tensions','editedon_mte'],
			['mat_projects_materials','editedon_prm'],
			['bui_structure_by_points','editedon_sbp'],
			['wfl_project_real_budgets','editedon_reb'],
			['wfl_project_status_files','editedon_psf'],
			['wfl_construction_assignments','editedon_cas'],
			['bui_worked_up_structures','editedon_wus'],
			['wfl_status_line_management','editedon_'],
			['bui_point_to_point_master','editedon_ptp'],
			['wfl_cre_fiscal','editedon_cfi'],
			['sec_deleted_status_logs','editedon_dsl'],
			['wfl_project_points','editedon_prp'],
			['bui_default_structure_materials','editedon_dsm'],
			['wfl_process_line','editedon_prl'],
			['sec_userroles','editedon_uro'],
			['sec_permissions','editedon_per'],
			['wfl_tracking_list','editedon_trl'],
			['wfl_user_ubmos','editedon_uub'],
			['wfl_warehouses','editedon_war'],
			['wfl_contracts','editedon_con'],
			['wfl_warehouse_status_log','editedon_wsl'],
			['wfl_payment_orders','editedon_pao'],
			['wfl_projects','editedon_pro'],
			['mat_internal_warehouse_operation_types','editedon_oty'],
			['wfl_status_responsibles','editedon_sre'],
			['wfl_payment_orders_status_log','editedon_pos']
		];
		$modifieds = [];
		foreach ($oldTables as $row) 
		{
			$query = "update ".$row[0]." set ".$row[1]." = null where ".$row[1]."='0000-00-00 00:00:00';";
			$ci->db->query($query);
			$modifieds[$row[0]] = $ci->db->affected_rows();
		}
		dd($modifieds);
	}
}
