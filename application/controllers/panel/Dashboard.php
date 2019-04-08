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

    public function index($view = "charts")
    {
        $this->_validateFeature("dashboard_index");

        switch($view)
        {
            case "tables":
                $this->complementHandler->addViewComplement("jquery.sticky");
                $this->_tables();
                break;
            case "charts":
                $this->complementHandler->addViewComplement("jquery.sticky");
                $this->_charts();
                break;
            case "executiveSummaryDifferential":
                $this->_executiveSummaryDifferential();
        }

    }

    private function _tables()
    {
//        $this->_validateFeature("dashboard_tables");

        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addViewComplement("core");
        $this->complementHandler->addViewComplement("charts");
        $this->complementHandler->addViewComplement("themes.kelly");
        $this->complementHandler->addViewComplement("themes.animated");
        $this->complementHandler->addProjectJs('ChartHandler', TRUE);
        $this->complementHandler->addProjectCss('dashboard.index', TRUE);
        $this->complementHandler->addProjectJs('dashboard.index', TRUE);
        $this->complementHandler->addProjectCss('dashboard.tables', TRUE);
        $this->complementHandler->addProjectJs('dashboard.tables', TRUE);

        $trackingList = Model_tracking_list::getAll(100, 0);
        $contractList = Model_contract::getAll(100, 0);
        $workflowColumnList = static::getWorkflowColumns();
        $data["systemList"] = $this->_projectSystems;
        $data["trackingList"] = $trackingList;
        $data["contractList"] = $contractList;
        $data["workflowColumnList"] = $workflowColumnList;
        $data["view"] = "tables";
        $this->_loadPanelView('dashboard/tables', $data);
    }

    private function _charts()
    {
//        $this->_validateFeature("dashboard_charts");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addViewComplement("core");
        $this->complementHandler->addViewComplement("charts");
        $this->complementHandler->addViewComplement("themes.kelly");
        $this->complementHandler->addViewComplement("themes.animated");
        $this->complementHandler->addProjectJs('ChartHandler', TRUE);
        $this->complementHandler->addProjectCss('dashboard.index', TRUE);
        $this->complementHandler->addProjectJs('dashboard.index', TRUE);
        $this->complementHandler->addProjectCss('dashboard.charts', TRUE);
        $this->complementHandler->addProjectJs('dashboard.charts', TRUE);

        $trackingList = Model_tracking_list::getAll(100, 0);
        $contractList = Model_contract::getAll(100, 0);
        $data["systemList"] = $this->_projectSystems;
        $data["trackingList"] = $trackingList;
        $data["contractList"] = $contractList;
        $data["view"] = "charts";
        $this->_loadPanelView('dashboard/charts', $data);
    }

    private function _executiveSummaryDifferential()
    {
//        $this->_validateFeature("differential");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addProjectCss('dashboard.executive-summary-differential', TRUE);
        $this->complementHandler->addProjectJs('dashboard.executive-summary-differential', TRUE);

        $this->_loadPanelView('dashboard/executive-summary-differential');
    }
}