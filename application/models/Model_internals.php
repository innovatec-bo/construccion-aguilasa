<?php

class Model_internals extends Model_internals_base
{
    public function __construct(int $materialId, float $quantity, int $status, int $tension)
    {
        parent::__construct($materialId, $quantity, $status, $tension);
    }
}