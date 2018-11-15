<?php
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
        //TODO:add feature validation
        $this->_validateFeature('contract_add');
        /** View complements */
        $this->complementHandler->addViewComplement("parsley");
        /** Server Side Validations **/
        $this->form_validation->set_rules('first-name', 'Email', 'trim|required');
        $this->form_validation->set_rules('last-name', 'Email', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_unique_email');
        $this->form_validation->set_rules('roles[]', 'Roles', 'callback_validate_roles');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm-password', 'Confirm password', 'trim|required|matches[password]');

        $roleList = Model_role::getAll(100,0);
        $data["roleList"] = $roleList;

        if($this->form_validation->run() === FALSE)
        {
            $this->_loadPanelView("user/add",$data);
        }
        else
        {
            $formData = $this->input->post();
            $firstName = $formData["first-name"];
            $lastName = $formData["last-name"];
            $email = $formData["email"];
            $password = $formData["password"];
            $userRoleList = $formData["roles"];
            $user = new Model_user(
                $firstName,
                $lastName,
                $email,
                NULL,
                NULL,
                $this->_encryptPassword($password)
            );
            $user->save();
            Model_user_role::saveUserRoleList($user->getId(), $userRoleList, $this->sessionUser);
            $this->session->set_flashdata("successMessage", "User was added successfully");
            redirect(base_url("panel/User"));
        }
    }

    public function edit($userId = NULL)
    {
        $this->_validateFeature('user_edit');
        $this->_formEditUser($userId);

    }
}