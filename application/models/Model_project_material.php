<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-08
 * Time: 18:20:57
 */

class Model_project_material extends Model_project_material_base
{
    public function __construct(int $materialsSummaryId, int $materialId, float $quantity, int $statusId, ?int $tension = NULL)
	{
		parent::__construct($materialsSummaryId, $materialId, $quantity, $statusId, $tension);
	}

	/**
	 * @param int $summaryId
	 * @return array
	 */
	public static function getBySummaryId(int $summaryId) : array
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
            select 
                id_mat material_id,
                code_mat material_code,
            	description_mat material_description,
			   	unit_of_measurement_mat material_unit_of_measurement,
                quantity_prm material_quantity,
			   	status_id_prm material_status_id,
                code_mst material_status_code,
                tension_id_prm material_tension_id                   
            from 
                 ".static::TABLE_NAME."
			 left join mat_materials on id_mat = material_id_prm
			 left join mat_material_status on status_id_prm = id_mst 
			where 
				materials_summary_id_prm = ".$ci->db->escape($summaryId)." 
				and ".static::notDeleted()."
        ";

		$query = $ci->db->query($sql);
		return $query->result_array();
	}
}
