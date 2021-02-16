<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2021-02-08
 * Time: 18:22:50
 */

class Model_warehouse_material_withdrawal_log extends Model_warehouse_material_withdrawal_log_base
{
    public function __construct($materialsSummaryId = "", $userId = "", $withdrawalDate = "", $applicantProjectId = "", $detail = "")
    {
        parent::__construct($materialsSummaryId, $userId, $withdrawalDate, $applicantProjectId, $detail);
    }
}