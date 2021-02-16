<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-08
 * Time: 18:22:14
 */

class Model_virtual_warehouse extends Model_virtual_warehouse_base
{
    public function __construct($warehouseWithdrawalLogId = "", $materialId = "", $quantityId = "")
    {
        parent::__construct($warehouseWithdrawalLogId, $materialId, $quantityId);
    }
}