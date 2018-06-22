<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/1/2018
 * Time: 2:01 PM
 */


class ProjectStatus extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_validateFeature('project_status_index');
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
        $this->complementHandler->addViewComplement("handlebars");
        $this->complementHandler->addViewComplement("handlebars.custom.helpers");
        $this->complementHandler->addProjectCss('project-status.index');
        $this->complementHandler->addProjectJs('project-status.index');
        $this->_loadPanelView("project-status/index");
    }

    public function add()
    {
        //TODO:add feature validation
        $this->_validateFeature('user_add');
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

    public function myProfile()
    {
        $this->_validateFeature('user_profile');
        $this->_formEditUser($this->sessionUser->id);
    }

    private function _formEditUser($userId = NULL)
    {
        if(!is_numeric($userId))
        {
            $this->session->set_flashdata("errorMessage", "Wrong request.");
            redirect(base_url("panel/User"));
        }

        $user = Model_user::getById($userId);
        if(!$user instanceof Model_user)
        {
            $this->session->set_flashdata("errorMessage", "The user doesn't exist.");
            redirect(base_url("panel/User"));
        }

        /** View complements */
        $this->complementHandler->addViewComplement("parsley");

        /** Server Side Validations **/
        $this->form_validation->set_rules('first-name', 'Email', 'trim|required');
        $this->form_validation->set_rules('last-name', 'Email', 'trim|required');
        $this->form_validation->set_rules('roles[]', 'Roles', 'callback_validate_roles');
        $this->form_validation->set_rules('password', 'Password', 'trim');
        $this->form_validation->set_rules('confirm-password', 'Confirm password', 'trim|matches[password]');

        $roleList = Model_role::getAll(100,0);
        $userRoleList = Model_role::getByUserId($user->getId());
        $data["roleList"] = $roleList;
        $data["user"] = $user->toArray();
        $data["userRoleList"] = $userRoleList;
        //TODO:this variable is passed to define weather show or not the role section, would be handled as functionality.
        $data["isSuperAdmin"] = $this->_is("super_admin");
        if($this->form_validation->run() === FALSE)
        {
            $this->_loadPanelView("user/edit",$data);
        }
        else
        {
            $formData = $this->input->post();
            $firstName = $formData["first-name"];
            $lastName = $formData["last-name"];
            $roleListToSave = $formData["roles"];

            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            if(isset($formData["update-password"]))
            {
                $password = $formData["password"];
                $passwordEncrypted = $this->_encryptPassword($password);
                $user->setPassword($passwordEncrypted);
            }
            $user->save();
            Model_user_role::saveUserRoleList($user->getId(), $roleListToSave, $this->sessionUser);
            $this->session->set_flashdata("successMessage", "User was updated successfully.");
            redirect(base_url("panel/User/edit/".$user->getId()));
        }
    }

    public function unique_email($email)
    {
        $user = Model_user::getByEmail($email);
        //If the user exist then notice to user that request the signup
        $response = TRUE;
        if($user instanceof Model_user)
        {
            $this->form_validation->set_message('unique_email', 'The email {field} already exist.');
            $response = FALSE;
        }
        return $response;
    }

    public function validate_roles()
    {
        $formData = $this->input->post();
        $roles = $formData['roles'];
        $arrayRoleList = array();
        $roleList = Model_role::getAll(100,0);
        foreach ($roleList as $role)
        {
            $arrayRoleList[] = (array)$role;
        }
        $validRoleListIds = array_column((array)$arrayRoleList,'id_rol');
        $quantityValidIds = 0;
        foreach ($roles as $roleId)
        {
            if(array_search($roleId, $validRoleListIds) !== FALSE)
            {
                $quantityValidIds++;
            }
        }
        $response = TRUE;
        if($quantityValidIds != count($roles))
        {
            $this->form_validation->set_message('validate_roles', 'You need to adds valid roles');
            $response = FALSE;
        }
        return $response;
    }

    public function delete($roleId = NULL)
    {
        $this->_validateFeature("delete_role");
        $role = $this->_validateObjectToEdit($roleId,"Model_role","panel/Role");
        $role->delete();
        $this->session->set_flashdata("successMessage", "Rol eliminado!");
        redirect(base_url("panel/Role"));
    }

    public function statusManagement($projectId = NULL)
    {
        $this->_validateFeature('project_status_management');

        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addViewComplement("handlebars");
        $this->complementHandler->addViewComplement("handlebars.custom.helpers");
        $this->complementHandler->addProjectCss('project-status.status-management');
        $this->complementHandler->addProjectJs('project-status.status-management');
        $this->complementHandler->addProjectCss('project.status-management.wizard');
        $this->complementHandler->addProjectJs('project.status-management.wizard');

        $statusList = Model_project_status::getChildrenByParentStatusId(1);
        $projectStakeLeaders = Model_project_stakes::getByProjectId($projectId);
        $data["statusList"] = $statusList;
        $data["teamLeadersOnProject"] = json_encode($projectStakeLeaders);
        $this->_loadPanelView("project-status/status-management", $data);
    }
}