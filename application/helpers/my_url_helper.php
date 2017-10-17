<?php
/**
 * Created by PhpStorm.
 * User: jair
 * Date: 2017-10-17
 * Time: 12:26 AM
 */

function panel_url($url="")
{
    return base_url("/panel/".$url);
}

function public_url($url="")
{
    return base_url("/web/".$url);
}

function assets_url($url="")
{
    return base_url("assets/".$url);
}