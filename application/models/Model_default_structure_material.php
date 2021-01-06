<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 */

class Model_default_structure_material extends Model_default_structure_material_base
{
    public function __construct($structureId = "", $materialId = "", $quantity = "")
    {
        parent::__construct($structureId, $materialId, $quantity);
    }
}
