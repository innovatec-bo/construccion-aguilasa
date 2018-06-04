<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 04/06/2018
 * Time: 10:34 AM
 */


class Project extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_validateFeature('project_index');
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
        $this->complementHandler->addProjectCss('project.index');
        $this->complementHandler->addProjectJs('project.index');
        $this->_loadPanelView("project/index");
    }

    public function add()
    {
        $this->_validateFeature('project_add');

        /** View complements */
        $this->complementHandler->addViewComplement("parsley");

        /** Server Side Validations **/
        $this->form_validation->set_rules('project-name', 'Nombre del proyecto', 'trim|required');

        if($this->form_validation->run() === FALSE)
        {
            $this->_loadPanelView("project/add");
        }
        else
        {
            $formData = $this->input->post();
            $projectName = $formData["project-name"];
            $project = new Model_project(
                $projectName
            );
            $project->save();
            $this->session->set_flashdata("successMessage", "Projecto agregado exitosamente!");
            redirect(base_url("panel/Project"));
        }
    }

    public function edit($projectId = NULL)
    {
        $this->_validateFeature('project_edit');

        if(!is_numeric($projectId))
        {
            $this->session->set_flashdata("errorMessage", "Parametro incorrecto.");
            redirect(base_url("panel/Project"));
        }

        $project = Model_project::getById($projectId);
        if(!$project instanceof Model_project)
        {
            $this->session->set_flashdata("errorMessage", "El proyecto no existe.");
            redirect(base_url("panel/Project"));
        }

        /** View complements */
        $this->complementHandler->addViewComplement("parsley");

        /** Server Side Validations **/
        $this->form_validation->set_rules('project-name', 'Nombre del proyecto', 'trim|required');

        $data["project"] = $project->toArray();
        if($this->form_validation->run() === FALSE)
        {
            $this->_loadPanelView("project/edit",$data);
        }
        else
        {
            $formData = $this->input->post();
            $projectName = $formData["project-name"];

            $project->setProjectName($projectName);
            $project->save();
            $this->session->set_flashdata("successMessage", "Proyecto editado correctamente!");
            redirect(base_url("panel/Project/edit/".$project->getId()));
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

    public function testSave()
    {
        $user = new Model_user(
            "new",
            "user2",
            "nuser2@mailinator.com",
            NULL,
            NULL,
            ""
        );
        $user->save();
    }
}