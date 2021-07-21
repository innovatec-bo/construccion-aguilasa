<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-15
 * Time: 17:45:31
 */

class Model_material_summary_type extends Model_material_summary_type_base
{
    public function __construct(string $name = "", string $keyword = "", ?string $movementType = "", ?string $icon = NULL)
	{
		parent::__construct($name, $keyword, $movementType, $icon);
	}

	public static function getByKeyword(array $keywordList)
	{
		$ci = &get_instance();
		$ci->load->database();

		$escapedList = "";
		foreach ($keywordList as $keyword)
		{
			$escapedList .= $ci->db->escape($keyword).", ";
		}
		$escapedList = substr($escapedList, 0, -2);
		$sql = "
            select * from ".static::TABLE_NAME." where ".static::notDeleted()." and keyword_mqt in(".$escapedList.")
        ";

		$query = $ci->db->query($sql);
		return static::recastArray(get_called_class(), $query->result());
	}

	public static function getByMovementType(array $movementTypeList)
	{
		$ci = &get_instance();
		$ci->load->database();

		$escapedList = "";
		foreach ($movementTypeList as $keyword)
		{
			$escapedList .= $ci->db->escape($keyword).", ";
		}
		$escapedList = substr($escapedList, 0, -2);
		$sql = "
            select * from ".static::TABLE_NAME." where ".static::notDeleted()." and movement_type_mqt in(".$escapedList.")
        ";

		$query = $ci->db->query($sql);
		return static::recastArray(get_called_class(), $query->result());
	}
}
