<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/05/2018
 * Time: 11:34 AM
 */

class Dashboard extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_validateFeature("dashboard_index");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addProjectCss('dashboard.index', TRUE);
        $this->complementHandler->addProjectJs('dashboard.index', TRUE);

        $this->_loadPanelView('dashboard/index');
    }

//    public function addCratedDateToLog()
//    {
//        set_time_limit(300);
//        $projectList = Model_project::getAllProject();
//        echo"<pre>";var_dump($projectList);exit;
//        $statusId = "46";
//        $statusDetail = 'El proyecto ha sido creado';
//        $keyword = "project_has_been_created";
//        $responsibleList = Model_status_responsible::getUsersResponsible($keyword);
//        $responsibleList = $responsibleList[0];//array_column($responsibleList,'id_sre');
//        $responsibleList = array($responsibleList['id_sre']);
//        foreach($projectList as $project)
//        {
//            $entryDate = $project->getEntryDate();
//            $project->addStatusToLog($statusId, $statusDetail, $entryDate, $responsibleList);
//        }
//    }

}