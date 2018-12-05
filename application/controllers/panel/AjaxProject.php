<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/1/2018
 * Time: 2:01 PM
 */


class AjaxProject extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
//        $this->_validateFeature("project_index");
    }

    public function ajaxDtAllProjects()
    {
        $response = $this->_is("fiscal");
        $userId = "";
        if($response == 1)
        {
            $userId = $this->sessionUser->id;
        }
        $dt = new JqdtHandler($this->input->post());
        $additionalParameters = $this->input->post("additionalParameters");
        $additionalParameters["status"] = isset($additionalParameters["status"])?$additionalParameters["status"]:"";
        $recordsTotal = Model_project::countAll($additionalParameters["status"], $userId);
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue() && count($additionalParameters) <= 1)
        {
            $resultArray = Model_project::getAllProjects($additionalParameters["status"], $userId, $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0));
        }
        else
        {
            $resultArray = Model_project::searchProject($additionalParameters["status"], $userId, $dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs(), $additionalParameters);
            $recordsFiltered = Model_project::searchTotalCount($additionalParameters["status"], $userId, $dt->getSearchValue(),$dt->getSearchableColumnDefs(), $additionalParameters);
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }

    public function getStakesLeaderProjects()
    {
        $stakesLeaderProject = Model_project::getStakesLeaderProjects();
        $arrayStakes = array();
        $singleList = array();
        for ($i = 0; $i < count($stakesLeaderProject); $i++)
        {
            $stakeLeaderId = $stakesLeaderProject[$i]["id_stl"];
            $singleList[] = $stakesLeaderProject[$i];
            if(isset($stakesLeaderProject[$i+1]))
            {
                if($stakesLeaderProject[$i]["id_stl"] != $stakesLeaderProject[$i+1]["id_stl"])
                {
                    $arrayStakes[$stakeLeaderId]['teamLeaderId'] = $stakesLeaderProject[$i]["id_stl"];
                    $arrayStakes[$stakeLeaderId]['teamLeader'] = $stakesLeaderProject[$i]["leader_stl"];
                    $arrayStakes[$stakeLeaderId]['projectList'] = $singleList;
                    $singleList = array();
                }
            }
            else
            {
                $arrayStakes[$stakeLeaderId]['teamLeaderId'] = $stakesLeaderProject[$i]["id_stl"];
                $arrayStakes[$stakeLeaderId]['teamLeader'] = $stakesLeaderProject[$i]["leader_stl"];
                $arrayStakes[$stakeLeaderId]['projectList'] = $singleList;
            }
        }
        $list[] = $arrayStakes;
        echo json_encode($arrayStakes);exit;
    }

    public function updateStakesLeaderProjects()
    {
        $formData = $this->input->post();
        $leaderId = $formData["leaderId"];
        $projectId = $formData["projectId"];
//        var_dump($leaderId, $projectId);exit;
        $projectStakes = Model_project_stakes::getByLeaderIdAndProjectId($leaderId, $projectId);
        if($projectStakes instanceof Model_project_stakes)
        {

        }
    }

    public function select2ProjectsThatReturnedMaterials()
    {
        $currentIds = $this->input->post("currentIds");
        $term = $this->input->post("term");
        $limit = $this->input->post("limit");
        $page = $this->input->post("page");
        $offset = ($page-1)*$limit;
        $projects = Model_project::searchProject("39","",$term, $limit, $offset, 'code_pro', 'asc', array('code_pro'));
        $recordsFiltered = Model_project::searchTotalCount("39","",$term, array('code_pro'));

        $resultArray = array();
        $list = array();

        foreach ($projects as $project)
        {
            if(array_search($project->id_pro,$currentIds) === FALSE)
            {
                $list[] = array(
                    "id" => $project->id_pro,
                    "text" => $project->code_pro,
                    "responsible" => $project->responsible,
                    "points" => $project->points_pro,
                    "distance" => $project->distance_pro
                );
            }
        }
        $moreResults = ($page * $limit) < $recordsFiltered;
        $resultArray['list'] = $list;
        $resultArray['pagination'] = array("more" => $moreResults);
        echo json_encode($resultArray);exit;
    }

    public function getTotalProjects()
    {
        $recordsTotal = Model_project::countAll();
        $response["total"] = $recordsTotal;
        echo json_encode($response);exit;
    }


}