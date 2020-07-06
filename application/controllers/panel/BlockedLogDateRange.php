<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/1/2018
 * Time: 2:01 PM
 */


class BlockedLogDateRange extends PrivateController
{
    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
//        $this->_validateFeature('blocked_log_date_range_index');
        $this->complementHandler->addViewComplement("bootbox");
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
        $this->complementHandler->addProjectCss('blocked-log-date-range.index');
        $this->complementHandler->addProjectJs('blocked-log-date-range.index');
        $this->_loadPanelView("blocked-log-date-range/index");
    }

    public function delete($id = NULL)
    {
//        $this->_validateFeature("delete_role");
        $BlockedLogDateRange = $this->_validateObjectToEdit($id,"Model_blocked_log_date_range","panel/BlockedLogDateRange");
		$BlockedLogDateRange->delete();
        $this->session->set_flashdata("successMessage", "Registro eliminado!");
        redirect(base_url("panel/BlockedLogDateRange"));
    }
}
