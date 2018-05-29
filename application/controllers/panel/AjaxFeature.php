<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/4/2018
 * Time: 11:15
 */

class AjaxFeature extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function getById()
    {
        $formData = $this->input->post();
        $featureId = $formData['node']['id'];
        $feature = Model_feature::getById($featureId);
        echo $feature;exit;
    }

    public function edit()
    {
        $response = array("success" => 1, "message" => array());
        $formData = $this->input->post();
        $featureId = $formData['feature-id'];
        $feature = Model_feature::getById($featureId);

        /** Server Side Validations **/
        $this->form_validation->set_rules('feature-name', 'Feature name', 'trim|required');
        $this->form_validation->set_rules('feature-security-string', 'Security string', 'trim|required|callback_unique_security_string');
        $this->form_validation->set_rules('feature-icon', 'Icon', 'trim|required');
        $this->form_validation->set_rules('feature-link', 'Link', 'trim|required');
        $this->form_validation->set_rules('description', 'Longitude', 'trim');

        if ($this->form_validation->run() === FALSE)
        {
            $response = array("success" => 0, "message" => validation_errors());
        }
        else
        {
            $formData = $this->input->post();
            $feature->setName($formData["feature-name"]);
            $feature->setSecurityString($formData['feature-security-string']);
            $feature->setIcon($formData["feature-icon"]);
            $feature->setLink($formData["feature-link"]);
            $feature->setDescription($formData["feature-description"]);
            $isMenu = isset($formData["is-visible-menu"])?1:0;
            $feature->setIsMenu($isMenu);
            $feature->save();
        }
        echo json_encode($response);exit;
    }

    public function unique_security_string()
    {
        $formData = $this->input->post();
        $featureId = $formData["feature-id"];
        $securityString = $formData["feature-security-string"];
//        var_dump($featureId, $securityString);exit;
        $isDuplicated = Model_feature::securityStringDuplicated($securityString, $featureId);
        $validationResult = TRUE;
//        var_dump($isDuplicated);exit;
        if ($isDuplicated)
        {
            $this->form_validation->set_message('unique_security_string', 'The {field} already exist.');
            $validationResult = FALSE;
        }
        return $validationResult;
    }

    public function sortFeatures()
    {
        $formData = $this->input->post();
        $featureList = $formData["featureList"];
        Model_feature::sortAllFeatureByArray($featureList);
        $response["success"] = 1;
        $response["message"] = "features sorted successfully.";
        echo json_encode($response);exit;
    }
}