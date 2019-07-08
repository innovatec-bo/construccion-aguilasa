<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
*/

class Model_building_structure extends Model_building_structure_base
{
    public function __construct($structureCode = "", $description = "", $unitOfMeasurement = "", $budgetType = NULL)
    {
        parent::__construct($structureCode, $description, $unitOfMeasurement, $budgetType);
    }

    public static function getByStructureList($structureList = array())
    {
        $ci = &get_instance();
        $ci->load->database();

        $escapedList = "";
        foreach ($structureList as $structure)
        {
            $escapedList .= $ci->db->escape($structure).", ";
        }
        $escapedList = substr($escapedList, 0, -2);
        $sql = "
        select * from ".static::TABLE_NAME." where structure_code_bus in (".$escapedList.") and deleted_bus != 1
        ";
        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(), $query->result());
        return $result;
    }

    public static function getMasterDetailByStructureCodeList($structureList = array())
    {
        $ci = &get_instance();
        $ci->load->database();

        $escapedList = "";
        foreach ($structureList as $structure)
        {
            $escapedList .= $ci->db->escape($structure).", ";
        }
        $escapedList = substr($escapedList, 0, -2);
        $sql = "
        select * from ".static::TABLE_NAME." where structure_code_bus in (".$escapedList.") and deleted_bus != 1
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}