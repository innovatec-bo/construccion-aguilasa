<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CronJob extends PublicController
{
	private string $_logPath;

	public function __construct()
    {
        parent::__construct();
		$this->_defineLogEnvironment();
    }

	private function _defineLogEnvironment()
	{
		switch (ENVIRONMENT)
		{
			case 'development':
				$this->_logPath = FCPATH."/assets/cronjob/development-cronjob-log.txt";
				break;
			case 'testing':
				$this->_logPath = FCPATH."/assets/cronjob/testing-cronjob-log.txt";
				break;
			case 'production':
				$this->_logPath = FCPATH."/assets/cronjob/production-cronjob-log.txt";
		}
	}

	private function _saveInLog($cronJobResult)
	{
		$trace = debug_backtrace();
		$caller = $trace[1];

		$log = $this->_logPath;
		ob_start();
		//
		echo "==================== ".date("Y-m-d H:i:s")." ====================\n";
		echo "---------------------- BEGIN - {$caller["function"]} ---------------------\n";
		print_r($cronJobResult);
		echo"\n";
		echo "---------------------- END - {$caller['function']} -------------------\n\n\n\n\n";
		//
		$data = ob_get_contents();
		ob_end_clean();
		file_put_contents($log,$data,FILE_APPEND);
	}

	public function netBuildingEmail($challenge = "nbreport2019")
    {
        if($challenge == "nbreport2019")
        {
            // Model_user::netBuildingEmail();
        }
    }

    public function registerExecutiveSummaryLog($challenge = "eslog")
    {
        if($challenge == "eslog")
        {
            $executiveSummary = Model_project::prepareExecutiveSummaryArray();
            Model_executive_summary_log::saveLog($executiveSummary);
        }
    }

    public function clarificationEmail($challenge)
    {
        if($challenge == 'clarificationEmail2019')
        {
//            Model_user::emailClarification();
        }
    }

    public function notifyProjectStatusToCreFiscal($challenge)
    { 
		set_time_limit(240);
		ini_set('memory_limit','512M');
        if($challenge == 'notifyProjectStatusToCreFiscal2019')
        {
            $fiscalListToNotify = Model_project::creFiscalProjectStatusReminder();
//            $codeList = array_column($fiscalListToNotify[1000]['statusListToNotify']['project_return_materials'],'code_pro');
//			asort($codeList);
//            echo"<pre>";var_dump($fiscalListToNotify);exit;
			$response = array();
            foreach ($fiscalListToNotify as $fiscalData)
            {
                //Let's make sure that the fiscal have not mailinator.com email
                if(strpos($fiscalData['creFiscalEmail'], 'mailinator.com') === FALSE)
                {
                    $response[] = Model_user::notifyProjectStatusToCreFiscal($fiscalData);
                }
            }
			$this->_saveInLog($response);
        }
    }

    public function notifyProjectStatusToSereboFiscal($challenge)
    { 
		set_time_limit(240);
		ini_set('memory_limit','512M');
        if($challenge == 'notifyProjectStatusToSereboFiscal2019')
        {
            $fiscalListToNotify = Model_project::sereboFiscalProjectStatusReminder();
			$response = array();
            foreach ($fiscalListToNotify as $fiscalData)
            {
                //Let's make sure that the fiscal have not mailinator.com email
                $fiscalData['sereboFiscalEmail'] = is_array($fiscalData['sereboFiscalEmail'])?implode(",",$fiscalData['sereboFiscalEmail']):$fiscalData['sereboFiscalEmail'];
                if(strpos($fiscalData['sereboFiscalEmail'], 'mailinator.com') === FALSE)
                {
					$response[] = Model_user::notifyProjectStatusToSereboMembers($fiscalData);
                }
            }
			$this->_saveInLog($response);
        }
    }

    public function notifyProjectsByStatusToInternalMembers($challenge)
    { 
        if($challenge == 'notifyProjectsByStatusToInternalMembers2019')
        {
            $statusToNotify = array("approved","project_has_been_created");
            $projectListFiltered = array();
            $projectList = Model_project::getWorkflowDetail();
            foreach ($projectList as $project)
            {
                $keyword = $project["keyword_pst"];
                if(array_search($keyword,$statusToNotify) !== FALSE)
                {
                    $projectListFiltered[$keyword][] = $project;
                }
            }
			$response = Model_user::notifyProjectByStatusToSereboMembers($projectListFiltered);
			$this->_saveInLog($response);
        }
    }

    public function fillDistribution($challenge)
	{
		if($challenge == 'fillDistribution2020')
		{
			$d = new DateTime( );
			$d->modify( 'first day of previous month' );
			$from = $d->format( 'Y-m-01' );
			$to = $d->format( 'Y-m-t' );
			$dateRange = array('from' => $from, 'to' => $to);
			$assignment = Model_user_supervisor_by_period::getAssignmentByDateRange($dateRange);
		}
	}

	public function sendExecutiveReport($challenge)
	{ 
		if($challenge == 'sendExecutiveReport2020')
		{
			$response = Model_user::sendExecutiveReport();
			if($response['success'] == 1)
			{
				/** @var ExcelExternalExecutiveReport $report */
				$report = $response['report'];
				$report->removeFile();
			}
			unset($response['report']);
			$this->_saveInLog($response);
		}
	}

	public function sendInternalExecutiveReport($challenge)
	{
		if($challenge == 'sendInternalExecutiveReport2020')
		{
			$response = Model_user::sendInternalExecutiveReport();
			if($response['success'] == 1)
			{
				/** @var ExcelInternalExecutiveReport $report */
				$report = $response['report'];
				$report->removeFile();
			}
			unset($response['report']);
			$this->_saveInLog($response);
		}
	}

	public function sendDailyReports($challenge)
	{
		if($challenge == 'sendDailyReports2024')
		{
			$response = Model_user::sendDailyReports();
			if($response['success'] == 1)
			{
				
			}
			/** @var ExcelBuildersGeneralReport $builderGeneralReport */
			$builderGeneralReport = $response['builderGeneralReport'];
			$builderGeneralReport->removeFile();

			/** @var ExcelDailyProductivityReport $dailyProductivityReport */
			$dailyProductivityReport = $response['dailyProductivityReport'];
			$dailyProductivityReport->removeFile();

			/** @var ExcelProjectWorkflow $workflowReport */
			$workflowReport = $response['workflowReport'];
			$workflowReport->removeFile();

			/** @var ExcelAllProjectsLog $allProjectsLog */
			$allProjectsLog = $response['allProjectsLog'];
			$allProjectsLog->removeFile();
			
			unset($response['builderGeneralReport']);
			unset($response['dailyProductivityReport']);
			unset($response['workflowReport']);
			unset($response['allProjectsLog']);
			$this->_saveInLog($response);
		}
	}
}
