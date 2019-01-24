<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 18/01/2019
 * Time: 12:11 PM
 */

class AjaxWorkflowColumnGroup extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function ajaxDtAllWorkflowColumnsGroup()
    {
        $dt = new JqdtHandler($this->input->post());
        $recordsTotal = Model_workflow_column_group::countAll();
        $recordsFiltered = $recordsTotal;
        if (!$dt->hasSearchValue())
        {
            $resultArray = Model_workflow_column_group::getAll($dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0));
        }
        else
        {
            $resultArray = Model_workflow_column_group::search($dt->getSearchValue(), $dt->getLength(), $dt->getStart(), $dt->getOrderName(0), $dt->getOrderDir(0), $dt->getSearchableColumnDefs());
            $recordsFiltered = Model_workflow_column_group::searchTotalCount($dt->getSearchValue(),$dt->getSearchableColumnDefs());
        }

        echo $dt->getJsonResponse($recordsTotal, $recordsFiltered, $resultArray);
        exit;
    }

    public function add()
    {
//        $this->_validateFeature('role_add');
        /** Server Side Validations **/
        $this->form_validation->set_rules('groupName', 'Name', 'trim|required');
        $this->form_validation->set_rules('groupColumns', 'Columns', 'trim');

        if($this->form_validation->run() === FALSE)
        {
            //Right now isn't necessary make a get request to add a new column group.
//            $response["success"] = 1;
//            $response["message"] = "";
//            $response["template"] = $this->loadView("panel/content/role/ht-modal-add", array(),true);
//            $response["role"] = array();
        }
        else
        {
            $formData = $this->input->post();
            $groupName = $formData["groupName"];
            $groupColumns = $formData["groupColumns"];
            if(is_array($groupColumns))
            {
                $groupColumns = implode(",",$groupColumns);
            }
            else
            {
                $groupColumns = "";
            }
            $wfColumnGroup = new Model_workflow_column_group($groupName, "code_pro");
            $wfColumnGroup->save();
            $response["success"] = 1;
            $response["message"] = "Group column added successfully";
            $wfColumnGroup = $wfColumnGroup->toArray();
            $response["wfColumnGroup"]["wfGroupId"] =  $wfColumnGroup["id_wcg"];
            $response["wfColumnGroup"]["wfGroupName"] =  $wfColumnGroup["column_group_name_wcg"];
            $response["wfColumnGroup"]["wfGroupList"] =  $wfColumnGroup["column_list_wcg"];
            echo json_encode($response);exit;
        }
    }

    public function edit()
    {
//        $this->_validateFeature('role_add');
        /** Server Side Validations **/
        $this->form_validation->set_rules('groupId', 'Id', 'trim|required');
        $this->form_validation->set_rules('groupColumns', 'Columns', 'trim');

        if($this->form_validation->run() === FALSE)
        {
            //Right now isn't necessary make a get request to add a new column group.
//            $response["success"] = 1;
//            $response["message"] = "";
//            $response["template"] = $this->loadView("panel/content/role/ht-modal-add", array(),true);
//            $response["role"] = array();
        }
        else
        {
            $formData = $this->input->post();
            $groupId = $formData["groupId"];
            $groupColumns = $formData["groupColumns"];
            if(is_array($groupColumns))
            {
                $groupColumns = implode(",",$groupColumns);
            }
            else
            {
                $groupColumns = "";
            }
            $wfColumnGroup = Model_workflow_column_group::getById($groupId);
            $wfColumnGroup->setGroupColumns($groupColumns);
            $wfColumnGroup->save();
            $response["success"] = 1;
            $response["message"] = "Group column was updated successfully";
            $wfColumnGroup = $wfColumnGroup->toArray();
            $response["wfColumnGroup"]["wfGroupId"] =  $wfColumnGroup["id_wcg"];
            $response["wfColumnGroup"]["wfGroupName"] =  $wfColumnGroup["column_group_name_wcg"];
            $response["wfColumnGroup"]["wfGroupList"] =  $wfColumnGroup["column_list_wcg"];
            echo json_encode($response);exit;
        }
    }

    public function select2Ajax()
    {
        $term = $this->input->post("term");
        $limit = $this->input->post("limit");
        $page = $this->input->post("page");
        $offset = ($page-1)*$limit;
        $objects = Model_workflow_column_group::search($term, $limit, $offset, 'column_group_name_wcg', 'asc', array('column_group_name_wcg'));
        $recordsFiltered = Model_workflow_column_group::searchTotalCount($term, array('column_group_name_wcg'));

        $resultArray = array();
        $list = array();

        foreach ($objects as $object)
        {
            $list[] = array(
                "id" => $object->id_wcg,
                "text" => $object->column_group_name_wcg,
                "columnsList" => $object->column_list_wcg
            );
        }
        $moreResults = ($page * $limit) < $recordsFiltered;
        $resultArray['list'] = $list;
        $resultArray['pagination'] = array("more" => $moreResults);
        echo json_encode($resultArray);exit ;
    }
}