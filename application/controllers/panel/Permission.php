<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/4/2018
 * Time: 11:15
 */

class Permission extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->complementHandler->addViewComplement("bootbox");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("jstree");
        $this->complementHandler->addViewComplement("handlebars");
        $this->complementHandler->addViewComplement("handlebars.custom.helpers");
        $this->complementHandler->addProjectJs('permission.index');

        $parentId = NULL;
        $roleList = Model_role::getAll(100,0);
        $list = Model_feature::getFeaturesTreeSeed();
        $tree = array();
        $tree = Model_feature::drawTree(NULL, $list, $tree);
        $jsonTree = json_encode($tree);
        $data["jsonTree"] = $jsonTree;
        $data["roleList"] = $roleList;

        $this->_loadPanelView('permission/index',$data);
    }

    public function drawTree_deprecated($currentFeatureId, array $list, array $tree)
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