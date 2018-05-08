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
    }

    public function getById()
    {
        $formData = $this->input->post();
        $featureId = $formData['node']['id'];
        $feature = Model_feature::getById($featureId);
        echo $feature;exit;
    }

    public function save()
    {
        $response = array("success" => 1, "message" => array());
        $formData = $this->input->post();
        $featureId = $formData['feature-id'];
        $feature = Model_feature::getById($featureId);

        /** Server Side Validations **/
        $this->form_validation->set_rules('feature-name', 'Feature name', 'trim|required');
        $this->form_validation->set_rules('feature-security-string', 'Security string', 'trim|required');
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
            $feature->save();
        }
        echo json_encode($response);exit;
    }
}