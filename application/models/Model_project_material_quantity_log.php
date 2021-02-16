<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-08
 * Time: 18:21:46
 */

class Model_project_material_quantity_log extends Model_project_material_quantity_log_base
{
    public function __construct(string $projectMaterialId = "", int $quantity = 0, int $isAdditional = 0, int $quantityType = 1)
	{
		parent::__construct($projectMaterialId, $quantity, $isAdditional, $quantityType);
	}
}
