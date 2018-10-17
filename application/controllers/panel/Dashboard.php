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
//        echo"<pre>";var_dump(Model_project::getStatusQuantityDetailByYear("as_built","2018"));exit;
        $this->_validateFeature("dashboard_index");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addProjectCss('dashboard.index');
        $this->complementHandler->addProjectJs('dashboard.index');

        $projectsQuantityTable = array(
            "approved"
        );

        $data["projectsQuantityTable"] = $projectsQuantityTable;

        $this->_loadPanelView('dashboard/index');
    }
}