<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-04-01
 * Time: 02:20:39
 */

class Model_material_status extends Model_material_status_base
{
    public function __construct($detail = "", $code = "")
    {
        parent::__construct($detail, $code);
    }

    public static function getByCode($code)
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
		select * from ".static::TABLE_NAME." where code_mst = ".$ci->db->escape($code)."
		";

		$query = $ci->db->query($sql);
		return static::recast(get_called_class(), $query->row());
	}
}
