<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 15/11/2018
 * Time: 10:25 AM
 */

class Model_contract extends Model_contract_base
{
    public function __construct($contractNumber = "", $amount = 0, $expirationDate = NULL)
    {
        parent::__construct($contractNumber, $amount, $expirationDate);
    }
}