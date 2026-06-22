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
        $this->complementHandler->addProjectCss('payment-management.index', TRUE);
        $this->complementHandler->addProjectJs('payment-management.index', TRUE);
        $data["viewTitle"] = "Todas las ordenes de pago";
        $data["status"] = "42, 43, 44";
        $data["statusSet"] = "payment_management";
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("payment-management/index",$data);
    }

    public function createPaymentOrder()
    {
        $this->complementHandler->addViewComplement('sweet-alert2');
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("jquery.inputmask.bundle");
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addProjectCss('payment-management.create-payment-order', TRUE);
        $this->complementHandler->addProjectJs('payment-management.create-payment-order', TRUE);
        $this->_validateFeature('payment_management_add');
		$contractList = Model_contract::getAll(100, 0);
		$data['contractList'] = $contractList;
        $this->_loadPanelView("payment-management/add", $data);
    }

	public function editPaymentOrder(int $paymentOrderId)
	{
        $this->complementHandler->addViewComplement('sweet-alert2');
		$this->complementHandler->addViewComplement("date-time-picker");
		$this->complementHandler->addViewComplement("jquery.inputmask.bundle");
		$this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
		$this->complementHandler->addViewComplement('select2');
		$this->complementHandler->addProjectCss('payment-management.edit-payment-order', TRUE);
		$this->complementHandler->addProjectJs('payment-management.edit-payment-order', TRUE);
		$this->_validateFeature('payment_management_add');

		$paymentOrder = Model_payment_order::getById($paymentOrderId);
		$contractList = Model_contract::getAll(100, 0);
		$data["paymentOrder"] = $paymentOrder->toArray();
		$data["contractList"] = $contractList;

		$this->_loadPanelView("payment-management/edit", $data);
	}

	public function PaymentOrderRegistered()
    {
        $this->_validateFeature('payment_management_index');
        $this->complementHandler->addViewComplement('sweet-alert2');
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
        $this->complementHandler->addProjectCss('payment-management.index', TRUE);
        $this->complementHandler->addProjectJs('payment-management.index', TRUE);
        $data["viewTitle"] = "Ordenes de pago por facturar";
        $data["status"] = "42";
        $data["statusSet"] = "payment_management";
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("payment-management/index",$data);
    }

    public function PaymentOrderInvoiceSent()
    {
        $this->_validateFeature('payment_management_index');
        $this->complementHandler->addViewComplement('sweet-alert2');
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
        $this->complementHandler->addProjectCss('payment-management.index', TRUE);
        $this->complementHandler->addProjectJs('payment-management.index', TRUE);
        $data["viewTitle"] = "Facturas enviadas a CRE(pendiente de confirmacion)";
        $data["status"] = "43";
        $data["statusSet"] = "payment_management";
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("payment-management/index",$data);
    }

    public function PaymentOrderSettled()
    {
        $this->_validateFeature('payment_management_index');
        $this->complementHandler->addViewComplement('sweet-alert2');
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
        $this->complementHandler->addProjectCss('payment-management.index', TRUE);
        $this->complementHandler->addProjectJs('payment-management.index', TRUE);
        $data["viewTitle"] = "Pagos confirmados";
        $data["status"] = "44";
        $data["statusSet"] = "payment_management";
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("payment-management/index",$data);
    }

    public function statusManagement($orderId = NULL)
    {
//        $this->_validateFeature('payment_status_management');
        $paymentOrder = $this->_validateObjectToEdit($orderId,"Model_payment_order","panel/PaymentManagement");
        $paymentOrder= $paymentOrder->toArray();
//        $keywordList = $this->_validateStatusSet($statusSet, $paymentOrder);
        $keywordList = array("payment_order_registered", "payment_order_invoice_sent", "payment_order_has_been_settled");
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("jquery.inputmask.bundle");
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addProjectCss('payment-management.status-management',TRUE);
        $this->complementHandler->addProjectJs('payment-management.status-management',TRUE);
        $this->complementHandler->addProjectCss('project.status-management.wizardv2');
        $this->complementHandler->addProjectJs('project.status-management.wizardv2');
        $this->complementHandler->addProjectJs('modify-log', TRUE);

        $statusList = Model_project_status::getByStatusKeywordList($keywordList);
        $projectList = Model_project::getAllByPaymentOrderId($orderId);
        $data["paymentOrder"] = $paymentOrder;
        $data["projectList"] = $projectList;
        $data["statusList"] = $statusList;
        $data["projectSystems"] = $this->_projectSystems;
        $responsibleList = Model_status_responsible::getUsersResponsible();
        $data["responsibleList"] = json_encode($responsibleList);
        $this->_loadPanelView("payment-management/status-management", $data);
    }

    public function advancePayments()
    {
        $viewTitle = "Anticipos";
        $this->_loadPanelView("payment-management/advance-payments", compact('viewTitle'));
    }
}
