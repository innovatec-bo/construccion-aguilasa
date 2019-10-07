<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_structure_by_point extends Model_structure_by_point_base
{
    public function __construct($pointId = NULL, $quantityToUse = 0, $laborCostId = NULL)
    {
        parent::__construct($pointId, $quantityToUse, $laborCostId);
    }
}