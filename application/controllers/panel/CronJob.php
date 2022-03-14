<?php

class CronJob extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index_old() : void
    {
//        $this->_validateFeature('process_line_index');
		$this->complementHandler->addViewComplement("parsley");
		$this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("jquery.datatables");
        $this->complementHandler->addViewComplement("jquery.datatables.bootstrap");
        $this->complementHandler->addViewComplement("jquery.datatables.buttons");
        $this->complementHandler->addViewComplement("jquery.datatables.buttons.bootstrap");
        $this->complementHandler->addViewComplement("jquery.datatables.buttons.flash");
        $this->complementHandler->addViewComplement("jquery.datatables.buttons.html5");
        $this->complementHandler->addViewComplement("jquery.datatables.buttons.print");
        $this->complementHandler->addViewComplement("jquery.datatables.jszip");
        $this->complementHandler->addViewComplement("jquery.datatables.pdfmake");
        $this->complementHandler->addViewComplement("jquery.datatables.vfs_fonts");
        $this->complementHandler->addViewComplement("jquery.datatables.filterdelay");
		$this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addProjectCss('process-line.index');
        $this->complementHandler->addProjectJs('process-line.index');
        $fiscals = Model_user::getByRoleKeyword("fiscal");
        $data['fiscals'] = $fiscals;
        $this->_loadPanelView("process-line/index", $data);
    }

    public function index() : void
    {
        $cronJobs = [
                [
                 'job' => 'notifyProjectStatusToSereboFiscal2019',
                 'detail' => 'Notificacion de estados de proyectos a fiscales de SEREBO',
                 'minute' => '30',
                 'hour' => '5',
                 'day' => '*',
                 'month' =>  '*',
                 'weekday' => 'Viernes'
                ]
        ];

        $this->_loadPanelView("cron-jobs/index", compact('cronJobs'));
    }
}
