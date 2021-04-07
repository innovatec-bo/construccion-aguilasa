<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-04-01
 * Time: 02:20:39
 */

class Model_material_status_base extends MY_Model
{
    const TABLE_NAME = "mat_material_status";
    const TABLE_ID = "id_mst";
    const ATTRIB_SUFIX = "_mst";

    protected $_detail;
	protected $_code;

    public function __construct($detail = "", $code = "")
    {
        parent::__construct();
        $this->_detail = $detail;
		$this->_code = $code;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_mst" => $this->_id,
			"detail_mst" => $this->_detail,
			"code_mst" => $this->_code,
			"deleted_mst" => $this->_deleted,
			"createdon_mst" => $this->_createdOn,
			"createdby_mst" => $this->_createdBy,
			"editedon_mst" => $this->_editedOn,
			"editedby_mst" => $this->_editedBy
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
                $object->detail_mst,
				$object->code_mst
            );
            $instance->_id = $object->id_mst;

            $instance->_deleted = $object->deleted_mst;
            $instance->_createdOn = $object->createdon_mst;
            $instance->_createdBy = $object->createdby_mst;
            $instance->_editedOn = $object->editedon_mst;
            $instance->_editedBy = $object->editedby_mst;
            $response = $instance;
        }
        return $response;
    }

    //Setters
    public function setDetail($detail)
	{
		$this->_detail = $detail;
	}

	public function setCode($code)
	{
		$this->_code = $code;
	}

    //Getters
    public function getDetail()
	{
		return $this->_detail;
	}

	public function getCode()
	{
		return $this->_code;
	}
}