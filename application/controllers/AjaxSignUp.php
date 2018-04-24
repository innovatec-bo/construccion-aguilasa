<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 23/04/2018
 * Time: 11:38 PM
 */

class AjaxSignUp extends PublicController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function signUp()
    {
        $this->load->library('form_validation');
        /** server validations */
        $this->form_validation->set_rules('first-name', 'Email', 'trim|required');
        $this->form_validation->set_rules('last-name', 'Email', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm-password', 'Confirm password', 'trim|required|matches[password]');

        if ($this->form_validation->run() === FALSE)
        {
            $validationErrors = validation_errors();
            $validationErrors = str_replace("<p>","",$validationErrors);
            $validationErrors = str_replace("</p>","<br>",$validationErrors);
            $response = array("success" => 0, "message" => $validationErrors, "url" => "");
        }
        else
        {
            $formData = $this->input->post();
            $firstName = $formData["first-name"];
            $lastName = $formData["last-name"];
            $email = $formData["email"];
            $password = $formData["password"];

            $user = Model_user::getByEmail($email);
            //If the user exist then notice to user that request the signup
            if($user instanceof Model_user)
            {
                $response = array("success" => 0, "message" => "The user already exist, please try with another email!", "url" => "");
            }
            //If the user doesn't exist then let's create his account
            else
            {
                $user = new Model_user($firstName,$lastName,$email,NULL,NULL,$this->_encryptPassword($password));
                $user->save();
                $user->startSession();
                $response = array("success" => 1, "message" => "Your account was created successfully. We are redirecting to you home page..!", "url" => "panel/Home");
            }
        }

        echo json_encode($response);exit;
    }

    private function _encryptPassword($password)
    {
        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, $options);
        return $passwordHash;
    }
}