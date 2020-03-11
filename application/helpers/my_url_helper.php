<?php
/**
 * Created by PhpStorm.
 * User: jair
 * Date: 2017-10-17
 * Time: 12:26 AM
 */

if ( ! function_exists('panel_url'))
{
    function panel_url($url="")
	{
	    return base_url("/panel/".$url);
	}

}

if ( ! function_exists('public_url'))
{
    function public_url($url="")
	{
	    return base_url("/web/".$url);
	}

}

if ( ! function_exists('assets_url'))
{
    function assets_url($url="")
	{
	    return base_url("assets/".$url);
	}

}