<?php
class GitLabHandler
{
    private $_token;
    private $_gitLabProjectId;
	public function __construct()
	{
		$this->_token = '8tAZPZyLUcxZ6JnRFirf';
		$this->_gitLabProjectId = "6940732";
	}

	function getPushEvents()
	{
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://gitlab.com/api/v4/projects/".$this->_gitLabProjectId."/events?action=pushed",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "PRIVATE-TOKEN: ".$this->_token,
                "Postman-Token: 6b14a84a-fdaa-4421-b895-6087753755b3"
            ),
        ));

        $apiResponse = curl_exec($curl);
//        $err = curl_error($curl);
//        curl_close($curl);
//
//
//        $response = array();
//        $success = 1;
//        $message = $apiResponse;
//        if ($err) {
//            $success = 1;
//            $message = $response;
//            var_dump("cURL Error #:" . $err);
//        } else {
//            var_dump($response);
//        }


//        $response["success"] = $success;
//        $response["message"] = $message;
        return $apiResponse;
	}
}