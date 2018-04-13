<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends PublicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
        $this->load->library('form_validation');
        /** server validations */
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->_loadPublicView('login');
        }
        else
        {
            $formData = $this->input->post();

            $password = $formData['password'];
            $options = [
                'cost' => 10,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
            $passwordHash = password_hash("test", PASSWORD_BCRYPT, $options);
            $passwordVerify = password_verify($password, $passwordHash);
//            exit('dfd');
            if($passwordVerify)
            {
                redirect(base_url('panel/Home'));
            }
            else
            {
                exit('password unverified');
            }

        }
	}

	public function cost()
    {
        $timeTarget = 0.05; // 50 milisegundos
        $cost = 8;
        do {
            $cost++;
            $start = microtime(true);
            password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        $passwordHash = password_hash("", PASSWORD_BCRYPT, $options);
        $passwordVerify = password_verify('', $passwordHash);
        var_dump($passwordVerify);exit;
        echo "Coste apropiado encontrado: " . $coste . "\n".mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
    }
}
