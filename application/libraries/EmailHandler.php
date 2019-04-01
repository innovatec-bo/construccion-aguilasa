<?php
class EmailHandler
{
	private $_api;
	private $ci;

	public function __construct()
	{
		$this->_api='';
		$this->ci= &get_instance();
		$this->ci->load->library('email');
	}

	function initialize()
	{
		switch ($this->_api) {
			case 'mailJet':
				$config=$this->mailJet();
				break;
			case 'gMail':
				$config=$this->gMail();
				break;
			default:
                switch (ENVIRONMENT)
                {
                    case 'development':
                    case 'testing':
                    $config = array(
                        'protocol' => 'smtp',
                        '_smtp_auth' => TRUE,
                        'smtp_host' => 'ssl://serebo.toqueeltimbre.com',
                        'smtp_port' => 465,
                        'smtp_user' => 'noreply@serebo.toqueeltimbre.com',
                        'smtp_pass' => 'p9VOu&X6n!tD',
                        'mailtype' => 'html',
                        'charset' => 'utf-8',
                        'newline' => "\r\n"
                    );
                    break;
                    case 'production':
                        $config = array(
                            'protocol' => 'smtp',
                            '_smtp_auth' => TRUE,
                            'smtp_host' => 'ssl://serebo.toqueeltimbre.com',
                            'smtp_port' => 465,
                            'smtp_user' => 'noreply@serebo.toqueeltimbre.com',
                            'smtp_pass' => 'p9VOu&X6n!tD',
                            'mailtype' => 'html',
                            'charset' => 'utf-8',
                            'newline' => "\r\n"
                        );
                    break;
                }

		}
		$this->ci->email->initialize($config);
		return $this->ci->email;

	}
	
	private function mailJet(){
		
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://in.mailjet.com';
		$config['smtp_port'] = '465';
		$config['smtp_user'] = '75dfe73fe84ae8424c40fbdc75f197d6';
		$config['smtp_pass'] = 'b82eec48ec6fe1907432614d865d48ae';
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['newline'] = "\r\n";

		return $config;
	}
	
	private function gMail(){
		
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp-relay.gmail.com';
		$config['smtp_port'] = '465';
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['newline'] = "\r\n";

		return $config;
	}

	public static function getSender($emailType = "noreply")
    {
        $emails = array();
        switch(ENVIRONMENT)
        {
            CASE "development":
            CASE "testing":
                $emails = array(
                    "noreply" => "noreply@serebo.toqueeltimbre.com"
                    );
                break;
            CASE "production":
                $emails = array(
                    "noreply" => "noreply@serebo.toqueeltimbre.com"
                );
                break;
        }
        return $emails[$emailType];
    }
}