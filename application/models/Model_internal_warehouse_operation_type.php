<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2022-03-04
 * Time: 11:16:16
 */

class Model_internal_warehouse_operation_type extends Model_internal_warehouse_operation_type_base
{
    public function __construct($name = "", $keyword = "", $icon = "", $operationType = "")
    {
        parent::__construct($name, $keyword, $icon, $operationType);
    }

    public static function getByKeywords(array $keywords) : array
    {
        $ci = &get_instance();
        $ci->load->database();
        $keywordString = "";
        foreach ($keywords as $keyword)
        {
            $keywordString .= $ci->db->escape($keyword).",";
        }
        $keywordString = substr($keywordString,0,-1);
        $sql = "
            select ".static::TABLE_NAME.".* from ".static::TABLE_NAME." where keyword_oty in (".$keywordString.")
        ";

        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(), $query->result());
        return $result;
    }
}