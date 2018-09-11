<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 05/09/218
 * Time: 12:01 AM
 */


class PaymentManagement extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_validateFeature('payment_management_index');
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
        $this->complementHandler->addProjectJs('DTAdditionalParameterHandler');
        $this->complementHandler->addProjectCss('project.index', TRUE);
        $this->complementHandler->addProjectJs('project.index', TRUE);
        $data["viewTitle"] = "Listos para iniciar la construccion";
        $data["status"] = "21";
        $data["statusSet"] = "building";
        $data["projectSystems"] = $this->_projectSystems;
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("project/index",$data);
    }

    public function createPaymentOrder()
    {
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("jquery.inputmask.bundle");
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("handlebars");
        $this->complementHandler->addViewComplement('handlebars.custom.helpers');
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addProjectCss('payment-management.create-payment-order', TRUE);
        $this->complementHandler->addProjectJs('payment-management.create-payment-order', TRUE);
        $this->_validateFeature('payment_management_add');
        $this->_loadPanelView("payment-management/add");
    }

    public function sendInvoiceToCRE($orderId)
    {
        $this->_validateFeature('payment_management_send_invoice_to_cre');
    }

    public function confirmPaymentSettled($orderId)
    {
        $this->_validateFeature('payment_management_confirm_payment_settled');
    }
}