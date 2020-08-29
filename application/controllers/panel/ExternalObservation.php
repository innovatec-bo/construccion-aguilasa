<?php

class ExternalObservation extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_validateFeature('external_observation_index');
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
		$this->complementHandler->addViewComplement("moment-with-locales");
		$this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addProjectCss('external-observation.index');
        $this->complementHandler->addProjectJs('external-observation.index');
        $fiscals = Model_user::getByRoleKeyword("cre_fiscal");
        $data['fiscals'] = $fiscals;
        $this->_loadPanelView("external-observation/index", $data);
    }
}
