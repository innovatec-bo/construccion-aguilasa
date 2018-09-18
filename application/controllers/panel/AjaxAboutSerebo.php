<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 18/09/2018
 * Time: 10:18 A.M.
 */


class AjaxAboutSerebo extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function getPushEvents()
    {
        $gitLabResponse = new GitLabHandler();
        $response = $gitLabResponse->getPushEvents();
        $response = json_decode($response,TRUE);

        for($i = 0; $i <count($response);$i++)
        {
            $response[$i]['class'] = "";
            if($i%2 != 0)
                $response[$i]['class'] = "timeline-inverted";
        }
//        echo"<pre>";var_dump($response);exit;
        echo json_encode($response);exit;
    }
}