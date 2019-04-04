<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 21:25
 */

class Home extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_validateFeature("home");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("core");
        $this->complementHandler->addViewComplement("charts");
        $this->complementHandler->addViewComplement("themes.animated");
        $this->complementHandler->addProjectJs('home.index', TRUE);

        $this->_loadPanelView('home/index');
    }

    public function jpgraphTest()
    {
//        $jpGraphHandler = new JPGraphHandler();
//        $jpGraphHandler->printPieChart3D();

        $TCPDFHandler = new NetBuildingReportPDF();
        $TCPDFHandler->PrintReport("I");
    }

    public function notifyReport()
    {
//        Model_user::netBuildingEmail();
    }
}