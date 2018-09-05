<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 05/09/2018
 * Time: 11:57 AM
 */

class Model_payment_order_project extends Model_payment_order_project_base
{
    public function __construct($orderId = NULL, $projectId = NULL)
    {
        parent::__construct($orderId, $projectId);
    }
}