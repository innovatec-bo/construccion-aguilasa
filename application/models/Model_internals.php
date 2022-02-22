<?php

class Model_internals extends Model_internals_base
{
    public function __construct(int $materialId, float $quantity, int $status, int $tension, int $operationId)
    {
        parent::__construct($materialId, $quantity, $status, $tension, $operationId);
    }

    public static function basicEntryLog()
    {
        $ci =&get_instance();
        $ci->load->database();
        $sql = "
            select 
            ".static::TABLE_NAME.".*,
            mat_materials.*,
            mat_material_status.*,
            mat_material_tensions.*
            from ".static::TABLE_NAME."
            left join mat_materials on id_mat = material_id_int
            left join mat_material_status on status_id_int = id_mst
            left join mat_material_tensions on tension_id_int = id_mte
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}