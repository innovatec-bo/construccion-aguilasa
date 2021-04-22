<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 */

class Model_material extends Model_material_base
{
    public function __construct(string $code, ?string $name, string $description, ?string $unitOfMeasurement = NULL)
	{
		parent::__construct($code, $name, $description, $unitOfMeasurement);
	}

	public static function getByCodeList($structureList = array())
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
        select * from ".static::TABLE_NAME." where code_mat in (".$escapedList.") and deleted_mat != 1
        ";
		$query = $ci->db->query($sql);
		$result = static::recastArray(get_called_class(), $query->result());
		return $result;
	}

	public static function getMasterDetailByMaterialCodeList(array $materialList) : array
	{
		$ci = &get_instance();
		$ci->load->database();

		$escapedList = "";
		foreach ($materialList as $material)
		{
			$escapedList .= $ci->db->escape($material).", ";
		}
		$escapedList = substr($escapedList, 0, -2);
		$sql = "
        select * from ".static::TABLE_NAME." where code_mat in (".$escapedList.") and deleted_mat != 1
        ";
		$query = $ci->db->query($sql);
		return $query->result_array();
	}
}
