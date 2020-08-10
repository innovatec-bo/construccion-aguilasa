<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 21:25
 */
class SupervisorAssignment extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_validateFeature("supervisor_assigment_index");
        $this->complementHandler->addViewComplement("dragula");
        $this->complementHandler->addViewComplement("perfect-scrollbar");
        $this->complementHandler->addProjectJs('SupervisorAssignmentHandler', TRUE);
        $this->complementHandler->addProjectCss('supervisor-assignment.index', TRUE);
        $this->complementHandler->addProjectJs('supervisor-assignment.index', TRUE);

        $months = array(
        	"01" => "Enero",
        	"02" => "Frebrero",
			"03" => "Marzo",
        	"04" => "Abril",
        	"05" => "Mayo",
        	"06" => "Junio",
        	"07" => "Julio",
        	"08" => "Agosto",
        	"09" => "Septiembre",
        	"10" => "Octubre",
        	"11" => "Noviembre",
        	"12" => "Diciembre"
		);
		$data['months'] = $months;
		$begin = new DateTime( '2017-01-01' );
		$end = new DateTime( date('Y-m-d') );
		$interval = new DateInterval('P1Y');
		$dateRange = new DatePeriod($begin, $interval ,$end);

		$years = array();
		foreach($dateRange as $year)
		{
			$years[] = $year->format("Y");
		}
		$data['years'] = $years;
        $this->_loadPanelView('supervisor-assignment/index', $data);
    }
}
