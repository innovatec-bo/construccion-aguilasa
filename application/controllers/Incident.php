<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incident extends PublicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
        $this->_loadPublicView('incident/index');
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
