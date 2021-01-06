<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 */

class Model_custom_structure_material extends Model_custom_structure_material_base
{
    public function __construct($structureId = "", $materialId = "", $quantity = "")
    {
        parent::__construct($structureId, $materialId, $quantity);
    }
}
