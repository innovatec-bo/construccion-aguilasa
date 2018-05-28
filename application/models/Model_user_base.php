<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/01/2018
 * Time: 2:35 PM
 */

class Model_user_base extends MY_Model
{
    const TABLE_NAME = "sec_users";
    const TABLE_ID = "id_usr";
    const ATTRIB_SUFIX = "_usr";

    protected $_firstName;
    protected $_lastName;
    protected $_email;
    protected $_facebookId;
    protected $_phone;
    protected $_password;
    protected $_avatar;
    protected $_passwordHash;
    protected $_activationHash;
    protected $_status;
    protected $_taxDeductible;
    protected $_googleId;

    public function __construct($firstName, $lastName, $email, $facebookId, $phone, $password, $avatar = NULL, $passwordHash = "", $activationHash = "", $status = 1,
                                $taxDeductible = "", $googleId = "")
    {
        parent::__construct();
        $this->_firstName = $firstName;
        $this->_lastName = $lastName;
        $this->_email = $email;
        $this->_facebookId = $facebookId;
        $this->_phone = $phone;
        $this->_password = $password;
        $this->_avatar = $avatar;
        $this->_passwordHash = $passwordHash;
        $this->_activationHash = $activationHash;
        $this->_status = $status;
        $this->_taxDeductible = $taxDeductible;
        $this->_googleId = $googleId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_usr" => $this->_id,
            "firstname_usr" => $this->_firstName,
            "lastname_usr" => $this->_lastName,
            "email_usr" => $this->_email,
            "facebookid_usr" => $this->_facebookId,
            "phone_usr" => $this->_phone,
            "password_usr" => $this->_password,
            "avatar_usr" => $this->_avatar,
            "passwordhash_usr" => $this->_passwordHash,
            "activationhash_usr" => $this->_activationHash,
            "status_usr" => $this->_status,
            "tax_deductible_usr" => $this->_taxDeductible,
            "googleid_usr" => $this->_googleId,
            "deleted_usr" => $this->_deleted,
            "createdon_usr" => $this->_createdOn,
            "createdby_usr" => $this->_createdBy,
            "editedon_usr" => $this->_editedOn,
            "editedby_usr" => $this->_editedBy

        );
        return $tableAttributes;
    }

    /**
     * @param $className
     * @param $object
     * @return object
     */
    protected static function recast($className, $object)
    {
        $response =  null;
        if ($object instanceof stdClass)
        {
            if (!class_exists($className))
                throw new InvalidArgumentException(sprintf('Inexistant class %s.', $className));

            //Let's set the values to payment object using the data from stdObject
            $instance = new $className(
                $object->firstname_usr,
                $object->lastname_usr,
                $object->email_usr,
                $object->facebookid_usr,
                $object->phone_usr,
                $object->password_usr,
                $object->avatar_usr,
                $object->passwordhash_usr,
                $object->activationhash_usr,
                $object->status_usr,
                $object->tax_deductible_usr,
                $object->googleid_usr
            );
            $instance->_id = $object->id_usr;

            $instance->_deleted = $object->deleted_usr;
            $instance->_createdOn = $object->createdon_usr;
            $instance->_createdBy = $object->createdby_usr;
            $instance->_editedOn = $object->editedon_usr;
            $instance->_editedBy = $object->editedby_usr;
            $response = $instance;
        }
        return $response;
    }

    ################################################################################### begin getters
    public function getFullName()
    {
        return ucwords($this->_firstName." ".$this->_lastName);
    }
    ################################################################################### end getters

    ################################################################################### begin setters
    public function setFirstName($firstName)
    {
        $this->_firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->_lastName = $lastName;
    }

    public  function setPassword($password)
    {
        $this->_password = $password;
    }

    public function setGoogleId($googleId)
    {
        $this->_googleId = $googleId;
    }
    ################################################################################### end setters

}