<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 05/09/2018
 * Time: 11:52 AM
 */

class Model_payment_order extends Model_payment_order_base
{
    public function __construct($orderNumber = "", $status = 1, $invoiceNumber = NULL)
    {
        parent::__construct($orderNumber, $status, $invoiceNumber);
    }
}