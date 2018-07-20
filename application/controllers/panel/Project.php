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
//        $this->_validateFeature('project_index');
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
        $data["viewTitle"] = "Lista de proyectos";
        $data["status"] = '1,2,3,4,5,6,7';
        $data["projectSystems"] = $this->_projectSystems;
        $projectStatus = Model_project_status::getAll(100,0);
        $arrayStatus = array();
        foreach ($projectStatus as $status)
        {
            $status = (array)$status;
            $arrayStatus[$status['id_pst']] = $status["status_name_pst"];
        }
        $data["projectStatusJson"] = json_encode($arrayStatus);
        $this->_loadPanelView("project/index", $data);
    }

    public function add()
    {
        $this->_validateFeature('project_add');

        /** View complements */
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addProjectCss('project.add');
        $this->complementHandler->addProjectJs('project.add');

        /** Server Side Validations **/
        $this->form_validation->set_rules('project-code', 'Codigo del proyecto', 'trim|required|callback_validate_code');
        $this->form_validation->set_rules('project-name', 'Nombre del proyecto', 'trim');
        $this->form_validation->set_rules('project-entry-date', 'Nombre del proyecto', 'trim|required');
        $this->form_validation->set_rules('project-cre-fiscal', 'Fiscal de CRE', 'trim|required');
        $this->form_validation->set_rules('project-system', 'Sistema', 'trim|required');
        $this->form_validation->set_rules('project-address', 'Direccion/Ubicacion', 'trim|required');
        $this->form_validation->set_rules('project-points', 'Cantidad de puntos', 'trim|required|numeric');
        $this->form_validation->set_rules('project-meters-distance', 'Metros de distancia', 'trim|required|numeric');
        $this->form_validation->set_rules('project-status', 'Estado', 'trim|numeric');

        $projectStatusList = Model_project_status::getAll(100,0);
        $data["projectStatusList"] = $projectStatusList;
        $data["projectSystems"] = $this->_projectSystems;
        if($this->form_validation->run() === FALSE)
        {
            $this->_loadPanelView("project/add",$data);
        }
        else
        {
            $formData = $this->input->post();
            $projectCode = $formData["project-code"];
            $projectName = $formData["project-name"];
            $projectEntryDate = $formData["project-entry-date"];
            $projectEntryDate = DateTime::createFromFormat('d-m-Y', $projectEntryDate);
            $projectEntryDate = date_format($projectEntryDate, 'Y-m-d');
            $projectCreFiscal = $formData["project-cre-fiscal"];
            $projectSystem = $formData["project-system"];
            $projectAddress = $formData["project-address"];
            $projectPoints = $formData["project-points"];
            $projectMetersDistance = $formData["project-meters-distance"];
            $projectStatus = $formData["project-status"] == ""?NULL:$formData["project-status"];
            $project = new Model_project($projectCode, $projectName, $projectSystem, $projectAddress, $projectEntryDate, $projectCreFiscal, $projectStatus);
            $project->save();
            $statusDetail = "Proyecto enviado a diseño";
            if($projectStatus == 7)
            {
                $keyword = "unsigned";
                $statusDetail = "Proyecto creado";
            }
            $responsibleList = Model_status_responsible::getUsersResponsible($keyword);
            $responsibleList = $responsibleList[0];//array_column($responsibleList,'id_sre');
            $responsibleList = array($responsibleList['id_sre']);
            $project->savePoints($projectPoints, $projectMetersDistance,$projectStatus,$statusDetail,$projectEntryDate,$responsibleList);
            $this->session->set_flashdata("successMessage", "Proyecto agregado exitosamente!");
            redirect(base_url("panel/Project"));
        }
    }

    public function edit($projectId = NULL)
    {
        $this->_validateFeature('project_edit');
        $project = $this->_validateObjectToEdit($projectId,"Model_project","panel/Project");

        /** View complements */
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addProjectCss('project.edit');
        $this->complementHandler->addProjectJs('project.edit');

        /** Server Side Validations **/
        $this->form_validation->set_rules('project-code', 'Codigo del proyecto', 'trim|required');
        $this->form_validation->set_rules('project-cre-fiscal', 'Fiscal', 'trim|required');
        $this->form_validation->set_rules('project-system', 'sistema', 'trim|required');
        $this->form_validation->set_rules('project-address', 'Direccion', 'trim');
        $this->form_validation->set_rules('project-status', 'Estado', 'trim|numeric');

        $getLastProjectStatus = Model_project_status_log::getLastProjectStatusLogByProjectId($project->getId());
        $data["lastProjectStatus"] = $getLastProjectStatus;
        $projectStatusList = Model_project_status::getAll(100,0);
        $data["projectStatusList"] = $projectStatusList;
        $data["project"] = $project->toArray();
        $data["projectSystems"] = $this->_projectSystems;
        if($this->form_validation->run() === FALSE)
        {
            $this->_loadPanelView("project/edit", $data);
        }
        else
        {
            $formData = $this->input->post();
//            $projectCode = $formData["project-code"];
            $projectName = $formData["project-name"];
            $projectCreFiscal = $formData["project-cre-fiscal"];
            $projectSystem = $formData["project-system"];
            $projectAddress = $formData["project-address"];
            $projectStatus = $formData["project-status"];

            $project->setProjectName($projectName);
            if($projectStatus != "")
            {
                $project->setStatus($projectStatus);
            }
            $project->setCREFiscal($projectCreFiscal);
            $project->setSystem($projectSystem);
            $project->setAddress($projectAddress);
            $project->save();
            //The status isn't empty when is send to design
            if($projectStatus != "")
            {
                $project->addStatusToLog($projectStatus);
            }

            $this->session->set_flashdata("successMessage", "Proyecto editado correctamente!");
            redirect(base_url("panel/Project/edit/".$project->getId()));
        }
    }

    public function delete($projectId = NULL)
    {
        $this->_validateFeature("delete_project");
        $project = $this->_validateObjectToEdit($projectId,"Model_project","panel/Project");
        $project->delete();
        $this->session->set_flashdata("successMessage", "Proyecto eliminado!");
        redirect(base_url("panel/Project"));
    }

    public function test()
    {
        $a1=array(0 => 2, 1=>3);
        $a2=array(0 => 2, 1=>4);

        $result=array_diff($a1,$a2);
        print_r($result);exit;
    }

    public function validate_code()
    {
        $formData = $this->input->post();
        $code = isset($formData["project-code"])?$formData["project-code"]:"";
        $project = Model_project::getByCode($code);
        $result = TRUE;
        if($project instanceof Model_project)
        {
            $this->form_validation->set_message('validate_code', 'Ya existe un proyecto con el codigo '.$code);
            $result = FALSE;
        }
        return $result;
    }
}