<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-08
 * Time: 18:20:57
 */

class Model_project_material extends Model_project_material_base
{
    public function __construct(int $materialsSummaryId, int $materialId, float $quantity)
	{
		parent::__construct($materialsSummaryId, $materialId, $quantity);
	}
}
