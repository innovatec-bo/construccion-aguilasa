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

    public function delete($projectId = NULL)
    {
        $this->_validateFeature("delete_project");
        $project = Model_project::getById($projectId);
        $project->delete();
        $this->session->set_flashdata("successMessage", "Proyecto eliminado!");
        redirect(base_url("panel/Project"));
    }
}