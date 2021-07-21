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
//    	$codeGen = new CodeGenHandler('mat_material_status', 'material_status');
//    	$codeGen->generateModelFiles();
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
		$workflow = new WorkflowPaginationHandler(2);
		$workflow->setColumnsToShow(['stakes']);
		$result = $workflow->getAll();
		dd($result);
	}

	public function columnsDependencies()
	{
		$columnsAndDependencies = [
			//Column => table or query join
			'stake_date' => ['stakes'],
			'stake_responsible_user_id' => ['stakes'],
			'stake_responsible' => ['stakes'],
			'rd_digitization_points_quantity' => ['rd_digitization'],
			'rd_digitization_distance' => ['rd_digitization'],
			'returned_date' => ['returned'],
			'digitization_points_quantity' => ['digitization'],
			'digitization_distance' => ['digitization'],
			'digitization_date' => ['digitization'],
			'drawing_date' => ['drawing'],
			'schedule_date' => [],
			'schedule_design_budget' => [],
			'schedulee_tentative_total_budget' => [],
			'project_current_design_budget' => []
		];
	}
}
