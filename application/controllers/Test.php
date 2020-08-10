<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 21:25
 */
class Test extends PublicController
{
    public function __construct()
    {
        parent::__construct();
    }

//    public function codegen()
//    {
//    	$codeGen = new CodeGenHandler('sec_user_supervisor_by_period', 'user_supervisor_by_period');
//    	$codeGen->generateModelFiles();
//    }

	public function populateData()
	{
		date_default_timezone_set('America/La_Paz');
		$begin = new DateTime( '2017-01-01' );
		$end = new DateTime( date('Y-m-d') );
		$interval = new DateInterval('P1M');
		$dateRange = new DatePeriod($begin, $interval ,$end);

		$years = array();
		$dataToSave = array();
		$supervisingList = array(
			array('user_id' => 12, 'supervisor_id' => 11),
			array('user_id' => 13, 'supervisor_id' => 11),
			array('user_id' => 14, 'supervisor_id' => 11),
			array('user_id' => 16, 'supervisor_id' => 15),
			array('user_id' => 18, 'supervisor_id' => 15),
			array('user_id' => 20, 'supervisor_id' => 19),
			array('user_id' => 21, 'supervisor_id' => 19)
		);
		foreach($dateRange as $year)
		{
		  	$years[] = $year->format("Y-m-01")." - ".$year->format("Y-m-t");
		  	foreach ($supervisingList as $row)
			{
				$dataToSave[] = array(
					'user_id_usp' => $row['user_id'],
					'supervisor_id_usp' => $row['supervisor_id'],
					'from_usp' => $year->format("Y-m-01"),
					'to_usp' => $year->format("Y-m-t"),
					'createdon_usp' => date('Y-m-d'),
					'createdby_usp' => 1
				);
			}
		}
//		Model_user_supervisor_by_period::insertBatch($dataToSave);
		$d = new DateTime( );
		$d->modify( 'first day of previous month' );
		$from = $d->format( 'Y-m-01' );
		$to = $d->format( 'Y-m-t' );
		$dateRange = array('from' => $from, 'to' => $to);
		$assignment = Model_user_supervisor_by_period::getAssignmentByDateRange($dateRange);
		echo "<pre>";var_dump($assignment);exit;
	}
}
