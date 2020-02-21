<?php
class EventCalendar extends PrivateController
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
        // $this->complementHandler->addViewComplement("momentsjs");
        $this->complementHandler->addViewComplement("moment-range");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("core");
        $this->complementHandler->addViewComplement("charts");
        $this->complementHandler->addViewComplement("themes.animated");
        $this->complementHandler->addViewComplement("perfect-scrollbar");
        $this->complementHandler->addProjectJS('WorkPlanHandler', TRUE);
        $this->complementHandler->addProjectCss('event-calendar.index', TRUE);
        $this->complementHandler->addProjectJs('event-calendar.index', TRUE);
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
        $this->_loadPanelView('event-calendar/index', $data);
    }
}