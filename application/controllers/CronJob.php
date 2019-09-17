<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CronJob extends PublicController
{
	public function __construct()
    {
        parent::__construct();
    }

	public function netBuildingEmail($challenge = "nbreport2019")
    {
        if($challenge == "nbreport2019")
        {
            Model_user::netBuildingEmail();
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
            Model_user::emailClarification();
        }
    }

    public function notifyProjectStatusToCreFiscal($challenge)
    {
        if($challenge == 'notifyProjectStatusToCreFiscal2019')
        {
            $fiscalListToNotify = Model_project::creFiscalProjectStatusReminder();
            foreach ($fiscalListToNotify as $fiscalData)
            {
                //Let's make sure that the fiscal have not mailinator.com email
                if(strpos($fiscalData['creFiscalEmail'], 'mailinator.com') === FALSE)
                {
                    $response = Model_user::notifyProjectStatusToCreFiscal($fiscalData);
//            echo'<pre>';var_dump($response);exit;
                }
            }
        }
    }

    public function notifyProjectStatusToSereboFiscal($challenge)
    {
        if($challenge == 'notifyProjectStatusToSereboFiscal2019')
        {
            $fiscalListToNotify = Model_project::sereboFiscalProjectStatusReminder();
            foreach ($fiscalListToNotify as $fiscalData)
            {
                //Let's make sure that the fiscal have not mailinator.com email
                if(strpos($fiscalData['sereboFiscalEmail'], 'mailinator.com') === FALSE)
                {
                    Model_user::notifyProjectStatusToSereboMembers($fiscalData);
                }
            }
        }
    }

    public function notifyProjectsByStatusToInternalMembers($challenge)
    {
        if($challenge == 'notifyProjectsByStatusToInternalMembers2019')
        {
            $statusToNotify = array("approved");
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
            Model_user::notifyProjectByStatusToSereboMembers($projectListFiltered);
        }
    }
}
