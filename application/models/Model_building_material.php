<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 2019/06/18
 * Time: 12:04 PM
*/

class Model_building_material extends Model_building_material_base
{
    public function __construct($structure = "", $description = "", $unit = "", $budgetType = NULL)
    {
        parent::__construct($structure, $description, $unit, $budgetType);
    }

    public static function getByStructureList($structureList = array())
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        select * from ".static::TABLE_NAME." where structure_bum in (".implode(',',$structureList).") and deleted_bum != 1
        ";
        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(), $query->result());
        return $result;
    }
}