<?php

use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/1/2018
 * Time: 2:01 PM
 */


class Contract extends PrivateController
{
    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->_validateFeature('contract_index');
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
        $this->complementHandler->addProjectCss('contract.index');
        $this->complementHandler->addProjectJs('contract.index');
        $this->_loadPanelView("contract/index");
    }

    public function add()
    {
        $this->_validateFeature('contract_add');
        /** View complements */
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addProjectJs('contract.add');
        /** Server Side Validations **/
        $this->form_validation->set_rules('number', 'numero', 'trim|required');
        $this->form_validation->set_rules('amount', 'monto', 'trim|required');
        $this->form_validation->set_rules('start-date', 'desde', 'trim|required');
        $this->form_validation->set_rules('end-date', 'hasta', 'trim|required');
        $this->form_validation->set_rules('UMBO', 'UMBO', 'trim|required');

        if($this->form_validation->run() === FALSE)
        {
            $this->_loadPanelView("contract/add",[]);
        }
        else
        {
            $formData = $this->input->post();

            $number = $formData["number"];
            $amount = $formData["amount"];
            $startDate = Carbon::createFromFormat('d-m-Y',$formData["start-date"])->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d-m-Y',$formData["end-date"])->format('Y-m-d');
            $UMBO = $formData["UMBO"];
            $active = isset($formData['active']) && $formData['active']?1:0;
            $contract = new Model_contract(
                $number,
                $amount,
                $startDate,
                $endDate,
                $UMBO,
                $active
            );

            $contract->save();
            if ($active == 1) 
            {
                Model_contract::deactiveExceptThis($contract->getId());
            }
            $this->session->set_flashdata("successMessage", "Nuevo contrato agregado existosamente!");
            redirect(base_url("panel/Contract"));
        }
    }

    public function edit($contractId = NULL)
    {
        $this->_validateFeature('contract_edit');
        $contract = $this->_validateObjectToEdit($contractId,"Model_contract","panel/Contract");
        /** View complements */
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addProjectJs('contract.add');
        /** Server Side Validations **/
        $this->form_validation->set_rules('number', 'numero', 'trim|required');
        $this->form_validation->set_rules('amount', 'monto', 'trim|required');
        $this->form_validation->set_rules('start-date', 'desde', 'trim|required');
        $this->form_validation->set_rules('end-date', 'hasta', 'trim|required');
        $this->form_validation->set_rules('UMBO', 'UMBO', 'trim|required');
        
        $data['startDate'] = Carbon::createFromFormat('Y-m-d H:i:s',$contract->getStartDate())->format('d-m-Y');
        $data['expirationDate'] = Carbon::createFromFormat('Y-m-d H:i:s',$contract->getExpirationDate())->format('d-m-Y');
        
        $data['contract'] = $contract->toArray();
        if($this->form_validation->run() === FALSE)
        {
            $this->_loadPanelView("contract/edit", $data);
        }
        else
        {
            $formData = $this->input->post();

            $number = $formData["number"];
            $amount = $formData["amount"];
            $startDate = Carbon::createFromFormat('d-m-Y',$formData["start-date"])->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d-m-Y',$formData["end-date"])->format('Y-m-d');
            $UMBO = $formData["UMBO"];
            $active = isset($formData['active']) && $formData['active']?1:0;

            $contract->setContractNumber($number);
            $contract->setAmount($amount);
            $contract->setStartDate($startDate);
            $contract->setExpirationDate($endDate);
            $contract->setUmbo($UMBO);
            $contract->setActive($active);
            $contract->save();
            if ($active == 1) 
            {
                Model_contract::deactiveExceptThis($contract->getId());
            }
            
            $this->session->set_flashdata("successMessage", "Contrato editado existosamente!");
            redirect(base_url("panel/Contract"));
        }
    }
}