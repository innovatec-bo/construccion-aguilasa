<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: {date}
 * Time: {time}
 */

class Model_{model_name}_base extends MY_Model
{
    const TABLE_NAME = "{table_name}";
    const TABLE_ID = "{table_id}";
    const ATTRIB_SUFIX = "{table_sufix}";

    {attrib_list}

    public function __construct({construct_arguments})
    {
        parent::__construct();
        {construct_assignment}
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            {to_array_list}
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
                {recast_list}
            );
            $instance->_id = $object->id{table_sufix};

            $instance->_deleted = $object->deleted{table_sufix};
            $instance->_createdOn = $object->createdon{table_sufix};
            $instance->_createdBy = $object->createdby{table_sufix};
            $instance->_editedOn = $object->editedon{table_sufix};
            $instance->_editedBy = $object->editedby{table_sufix};
            $response = $instance;
        }
        return $response;
    }

    //Setters
    {setters}

    //Getters
    {getters}
}