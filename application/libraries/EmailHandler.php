<?php
class EmailHandler
{
	private $_api;
	private $ci;
	private $_config;

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
						'smtp_host' => 'smtp.mailtrap.io',
						'smtp_port' => 2525,
						'smtp_user' => '9f71c5a16ae3bf',
						'smtp_pass' => 'e6c6895ce29011',
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
                            'newline' => "\r\n",
							'crlf' => "\r\n"
                        );
                    break;
                }

		}
		$this->_config = $config;
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

	public function getConfig()
	{
		return $this->_config;
	}

	public function getEmailByEnvironment($email)
	{
		switch(ENVIRONMENT)
		{
			CASE "development":
			CASE "testing":
				if(is_array($email))
				{
					foreach ($email as &$row)
					{
						$emailSegment = explode("@", $row);
						$userName = $emailSegment[0];
						$userName = $userName."_".ENVIRONMENT;
						$domain = "mailinator.com";
						$row = $userName."@".$domain;
					}
				}
				else
				{
					$emailSegment = explode("@", $email);
					$userName = $emailSegment[0];
					$userName = $userName."_".ENVIRONMENT;
					$domain = "mailinator.com";
					$email = $userName."@".$domain;
				}

				break;
		}
		return $email;
	}
}
