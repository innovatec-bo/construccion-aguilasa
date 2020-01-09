<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/1/2018
 * Time: 2:01 PM
 */


class AjaxTrackingList extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    // public function select2()
    // {
    //     $term = $this->input->post("term");
    //     $limit = $this->input->post("limit");
    //     $page = $this->input->post("page");
    //     $offset = ($page-1)*$limit;
    //     $users = Model_role::search($term, $limit, $offset, 'rolename_rol', 'asc', array('rolename_rol'));
    //     $recordsFiltered = Model_role::searchTotalCount($term, array('rolename_rol'));

    //     $resultArray = array();
    //     $list = array();

    //     foreach ($users as $user)
    //     {
    //         $list[] = array(
    //             "id" => $user->id_rol,
    //             "text" => $user->rolename_rol
    //         );
    //     }
    //     $moreResults = ($page * $limit) < $recordsFiltered;
    //     $resultArray['list'] = $list;
    //     $resultArray['pagination'] = array("more" => $moreResults);
    //     echo json_encode($resultArray);exit ;
    // }

    public function select2()
    {
        $term = $this->input->post("term");
        $limit = $this->input->post("limit");
        $page = $this->input->post("page");
        $offset = ($page-1)*$limit;
        $trackingList = Model_tracking_list::search($term, $limit, $offset, 'list_name_trl', 'asc', array('list_name_trl'));
        $recordsFiltered = Model_tracking_list::searchTotalCount($term, array('list_name_trl'));

        $resultArray = array();
        $list = array();

        foreach ($trackingList as $row)
        {
            $list[] = array(
                "id" => $row->id_trl,
                "text" => $row->list_name_trl,
                "code_list" => $row->code_list_trl
            );
        }
        $moreResults = ($page * $limit) < $recordsFiltered;
        $resultArray['list'] = $list;
        $resultArray['pagination'] = array("more" => $moreResults);
        echo json_encode($resultArray);exit ;
    }
    public function saveTrackingList()
    {
        $formData = $this->input->post();
        $trackingListId = isset($formData["tracking-list-id"])?$formData["tracking-list-id"]:"";
        $additionalAction = $formData["workflow-additional-actions"];
        $trackingListName = $formData["tracking-list-name"];
        $codeList = $formData["code-list"];
        $response = array("success" => 0, "message" => "Algo salio mal, por favor intente de nuevo");
        switch ($additionalAction)
        {
            case "1":
                if($trackingListName != "" && $codeList != "")
                {
                    $trackingList = new Model_tracking_list($trackingListName, $codeList);
                    $trackingList->save();
                    $response = array("success" => 1, "message" => "Se creó una nueva lista de seguimiento");
                }
                else
                {
                    $response = array("success" => 0, "message" => "El nombre de la lista y/o la lista de códigos estan vacios");
                }

                break;
            case "2":
                if($trackingListId != "")
                {
                    $trackingList = Model_tracking_list::getById($trackingListId);
                    if($trackingList instanceof  Model_tracking_list)
                    {
                        $trackingList->setCodeList($codeList);
                        $trackingList->save();
                        $response = array("success" => 1, "message" => "Se actualizo la lista de seguimiento.");
                    }
                    else
                    {
                        $response = array("success" => 0, "message" => "La lista que intenta actualizar no existe.");
                    }
                }
                else
                {
                    $response = array("success" => 0, "message" => "Para actualizar la lista de seguimiento primero debe seleccionar una.");
                }
                break;
        }
        echo json_encode($response);exit;
    }

    public function deleteTrackingList()
    {
        $formData = $this->input->post();
        $trackingListId = $formData["trackingListId"];
        $trackingList = Model_tracking_list::getById($trackingListId);
//        echo"<pre>";var_dump($trackingList);exit;
        if($trackingList instanceof Model_tracking_list)
        {
            $trackingList->delete();
            $response = array("success" => 1, "message" => "Lista de seguimiento eliminada correctamente.");
        }
        else
        {
            $response = array("success" => 0, "message" => "No se se encontro la lista de seguimiento.");
        }
        echo json_encode($response);exit;
    }
}