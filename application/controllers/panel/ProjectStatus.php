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
//        $this->complementHandler->addViewComplement("handlebars");
//        $this->complementHandler->addViewComplement("handlebars.custom.helpers");
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

    public function statusManagement($statusSet = "", $projectId = NULL)
    {
        $this->_validateFeature('project_status_management');
        $this->_validateObjectToEdit($projectId,"Model_project","panel/Project");
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("jquery.inputmask.bundle");
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addViewComplement('bootstrap.social');
        $this->complementHandler->addViewComplement('dropzone');
        $this->complementHandler->addViewComplement('photoswipe');
        $this->complementHandler->addViewComplement('photoswipe-default-skin');
        $this->complementHandler->addViewComplement('photoswipe-ui-default');
        $this->complementHandler->addProjectCss('project.status-management.wizardv2');
        $this->complementHandler->addProjectJs('project.status-management.wizardv2');
        $this->complementHandler->addProjectJs('StatusManagementHandler',TRUE);
        $this->complementHandler->addProjectCss('project-status.status-management',TRUE);
        $this->complementHandler->addProjectJs('project-status.status-management',TRUE);

        $this->complementHandler->addProjectJs('modify-log', TRUE);

        $data = array();
        $this->_loadPanelView("project-status/status-management", $data);
    }



    public function readyToAssign()
    {
        $this->_validateFeature('project_status_ready_to_assign');
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
        $this->complementHandler->addProjectCss('project.index');
        $this->complementHandler->addProjectJs('project.index');
        $data["viewTitle"] = "Listos para definir parametros de inicio de construccion";
        $data["status"] = "11";
        $data["statusSet"] = "";
        $data["projectSystems"] = $this->_projectSystems;
        $data['fiscalList'] = Model_user::getByRoleKeyword('fiscal');
        $data['builderList'] = Model_user::getByRoleKeyword('builder');
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

    public function assignProject($projectId)
    {
        $this->_validateFeature('project_status_assign_project');
        $project = $this->_validateObjectToEdit($projectId, "Model_project", "panel/Home");
        /** Server Side Validations **/
        $this->form_validation->set_rules('entry-date', 'Fecha de Asignacion', 'trim|required');
        $this->form_validation->set_rules('responsible-list', 'Responsable(s)', 'trim|required');
        $this->form_validation->set_rules('start-date', 'Fecha inicio', 'trim|required');
        $this->form_validation->set_rules('end-date', 'Fecha fin', 'trim|required');
        $this->form_validation->set_rules('estimated-time', 'Tiempo estimado', 'trim|required|numeric');
        $this->form_validation->set_rules('live-line', 'Linea viva', 'trim|in_list[1,0]');
        $this->form_validation->set_rules('power-down', 'Corte', 'trim|in_list[1,0]');
        $this->form_validation->set_rules('maneuver', 'Maniobra', 'trim|in_list[1,0]');
        $this->form_validation->set_rules('status-detail', 'Detalle', 'trim');

        //complements
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement('select2');
        $this->complementHandler->addProjectCss('project-status.assign-project');
        $this->complementHandler->addProjectJs('project-status.assign-project');
        $projectManagers = Model_user::getByRoleKeyword('project_manager');
        $responsibleListFiscal = Model_status_responsible::getResponsibleDetailListByStatusKeyword("assign_to", array('fiscal'));
        $responsibleListBuilder = Model_status_responsible::getResponsibleDetailListByStatusKeyword("assign_to", array('builder'));
        $previousEntry = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "assign_to");
        $data["project"] = $project->toArray();
        $data["previousEntry"] = $previousEntry;
        $data["responsibleListFiscal"] = $responsibleListFiscal;
        $data["responsibleListBuilder"] = $responsibleListBuilder;
        $data['projectManagers'] = $projectManagers;
        $allIncidents = Model_incident::getAllByProjectId($projectId);
        $data["allIncidents"] = $allIncidents;
        if($this->form_validation->run() === FALSE)
        {
            $this->_loadPanelView("project-status/ready-to-assign", $data);
        }
        else
        {
            $previousEntryApproved = Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "approved");

            $formData = $this->input->post();
            $entryDate = $formData["entry-date"];
            $entryDate = DateTime::createFromFormat('d-m-Y', $entryDate);
            $entryDate = date_format($entryDate, 'Y-m-d');
            $entryDate = $entryDate." ".date("H:i:s");
            $responsibleList = $formData["responsible-list"];
            $responsibleList = explode(",",$responsibleList);
            $startDate = $formData["start-date"];
            $startDate = DateTime::createFromFormat('d-m-Y', $startDate);
            $startDate = date_format($startDate, 'Y-m-d');
            $startDate = $startDate." ".date("H:i:s");
            $endDate = $formData["end-date"];
            $endDate = DateTime::createFromFormat('d-m-Y', $endDate);
            $endDate = date_format($endDate, 'Y-m-d');
            $endDate = $endDate." ".date("H:i:s");
            $estimatedTime = $formData["estimated-time"];
//            $liveLine = isset($formData["live-line"])?1:0;
            //Now the live line is defined by the approved budget(if exist)
            $liveLine = isset($previousEntryApproved[0]) && $previousEntryApproved[0]["live_line_prb"] > 0?1:0;
            $powerDown = isset($formData["power-down"])?1:0;
            $maneuver = isset($formData["maneuver"])?1:0;
            $statusId = 21;//assign_to
            $statusDetail = $formData["status-detail"];
            $projectManager = $formData["project-manager"];

            $project->setStatus($statusId);
            $project->save();
            $project->saveConstructionAssignments($startDate, $endDate, $estimatedTime, $liveLine, $powerDown, $maneuver, $statusId, $statusDetail, $entryDate, $responsibleList, $projectManager);
            $response["success"] = 1;
            $response["message"] = "Operacion realizada con exito.";
            $this->session->set_flashdata("successMessage", "Asignacion realizada con exito!");
            redirect(base_url("panel/ProjectStatus/readyToAssign"));
            echo json_encode($response);exit;
        }
    }

    public function saveStatusFiles()
    {
        $fileHandler = new FileHandler();
        if (!empty($_FILES['file']['name']))
        {
            try
            {
                if($_FILES['file']['type'] == 'application/pdf')
                    $image = $fileHandler->fileUpload($_FILES['file'], "project_status_file", "documents", "document");
                else
                    $image = $fileHandler->fileUpload($_FILES['file'], "project_status_file", 'images');
                $image->save();

                // if($_FILES['file']['type'] == 'application/pdf')
                // {
                //     echo json_encode(assets_url('images/pdf-icon.png'));
                // }
                // else
                // {
                    
                // }
                $imageSource = $fileHandler->getThumbnail($image, 160, 90);
                $imageId = $image->getId();
                echo json_encode($imageId);
                exit;
            }
            catch(Exception $e)
            {
                header("HTTP/1.0 400 Bad Request");
                echo json_encode($e->getMessage());exit;
            }
        }
    }
}
