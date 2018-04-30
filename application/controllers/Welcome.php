<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends PublicController {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	    $userList = Model_user::getAll(100,0);
	    echo"<pre>";var_dump($userList);exit;
	}

	public function tree()
    {
        $this->complementHandler->addViewComplement("jstree");
        $this->complementHandler->addProjectJs('tree');

        $parentId = NULL;
        $list = Model_feature::getFeatures();
        $tree = array();
        $tree = $this->drawTree(NULL, $list, $tree);
        $jsonTree = json_encode($tree);
//        echo "<pre>";var_dump($jsonTree);exit;
        $data["jsonTree"] = $jsonTree;
        $this->_loadPublicView("tree",$data);
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

    public function arrayFilter()
    {
        $list = Model_feature::getFeatures();
        $parentId = 2;
        $newArray = array_filter($list, function($item) use($parentId){
            if($item["parent_id"] == null)
                return $item;
        });

        echo"<pre>";var_dump($newArray);exit;
    }
}
