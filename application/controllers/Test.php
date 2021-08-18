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
		$workflow = new WorkflowPaginationHandler(10);
		$wfColumns = PrivateController::getWorkflowColumns();
		$wfColumns = array_keys($wfColumns);
		// $workflow->setColumnsToShow(['stake_date','rd_digitization_points_quantity']);
		$workflow->setColumnsToShow(['fiscal_responsible_id','fiscal_responsible','builder_responsible','builder_responsible_id']);
		// $workflow->setColumnsToShow($wfColumns);
		$result = $workflow->getAll();
		dd($result);
	}

	public function getFiscals()
	{
		$users = Model_user::getByRoleKeyword('fiscal');
		$list = [];
		/** @var Model_user $user */
		foreach($users as $user)
		{
			$list[] = $user->getFullName().': '.$user->getId();
		}
		dd($list);
	}
}
