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

    public function clarificationEmail($currentDate)
    {
        if($currentDate == date("Y-m-d"))
        {
            Model_user::emailClarification();
        }
    }
}
