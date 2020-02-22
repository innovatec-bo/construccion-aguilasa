<?php
class WorkPlan extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // $this->_validateFeature("home");
        $this->complementHandler->addViewComplement("jquery.datatables");
        $this->complementHandler->addViewComplement("jquery.datatables.bootstrap");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("moment-range");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("core");
        $this->complementHandler->addViewComplement("charts");
        $this->complementHandler->addViewComplement("themes.animated");
        $this->complementHandler->addViewComplement("perfect-scrollbar");
        $this->complementHandler->addProjectJS('WorkPlanHandler', TRUE);
        $this->complementHandler->addProjectCss('work-plan.index', TRUE);
        $this->complementHandler->addProjectJs('work-plan.index', TRUE);
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        $this->_loadPanelView('work-plan/index', $data);
    }

    public function add()
    {

    }

    public function edit()
    {
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("moment-range");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("perfect-scrollbar");
        $this->complementHandler->addProjectJS('WorkPlanHandler', TRUE);
        $this->complementHandler->addProjectCss('work-plan.index', TRUE);
        $this->complementHandler->addProjectJs('work-plan.index', TRUE);
        $this->_loadPanelView('work-plan/index', $data);
    }

    public function test()
    {
        $result = Model_work_plan::getWorkPlanMasterDetail(1);
        echo"<pre>";var_dump($result);exit;
    }
}