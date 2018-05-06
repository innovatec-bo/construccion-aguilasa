<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/4/2018
 * Time: 11:15
 */

class AjaxPermission extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getByRoleId()
    {
        $formData = $this->input->post();
        $roleId = $formData["roleId"];
        $roleList = Model_permission::getByRoleId($roleId);
        $arrayRoles = array();
        foreach ($roleList as $role)
        {
            $arrayRoles[] = $role->toArray();
        }
        echo json_encode($arrayRoles);exit;
    }

    public function getFeaturesByRoleId()
    {
        $formData = $this->input->post();
        $roleId = $formData["roleId"];
        $allFeatures = Model_feature::getAll(200,0);
        $featureList = Model_feature::getByRoleId($roleId);

        $response = array();
        $arrayFeature = array();
        foreach ($featureList as $feature)
        {
            $arrayFeature[] = $feature->toArray();
        }
        $response['allFeatures'] = $allFeatures;
        $response['featureByRole'] = $arrayFeature;
        echo json_encode($response);exit;
    }

    public function savePermissions()
    {
        $formData = $this->input->post();
        $roleId = $formData['roleId'];
        $featureList = $formData['featureList'];
        Model_permission::saveBatch($roleId, $featureList);
    }

    public function getTreeFeatures()
    {
        $list = Model_feature::getFeatures();
        $tree = array();
        $tree = $this->drawTree(NULL, $list, $tree);
        echo json_encode($tree);exit;
    }

    public function drawTree($currentFeatureId, array $list, array $tree)
    {
        $results = array_filter($list, function($item) use($currentFeatureId){
            if($item["parent_id"] == $currentFeatureId)
                return $item;
        });

        foreach($results as $feature)
        {
            $currentFeatureId = $feature["feature_id"];
            $isGroup = array_filter($list, function($item) use($currentFeatureId){
                if($item["parent_id"] == $currentFeatureId)
                    return $item;
            });
            $isGroup = count($isGroup) > 0?TRUE:FALSE;

            $children = array();
            if($isGroup)
            {
                $children = $this->drawTree($feature["feature_id"], $list, $children);
            }

            if(count($children) > 0)
            {
                $tree[] = array(
                    "id" => $feature["feature_id"],
                    "text" => $feature["feature_name"],
                    "state" => array("opened" => true),
                    "children" => $children
                );
            }
            else
            {
                $tree[] = array(
                    "id" => $feature["feature_id"],
                    "text" => $feature["feature_name"],
                    "state" => array("opened" => true),
                    "children" => array()
                );
            }
        }
        return $tree;
    }
}