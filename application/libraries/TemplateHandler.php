<?php

/**
 * Created by PhpStorm.
 * User: jair
 * Date: 2017-10-16
 * Time: 9:51 PM
 */
class TemplateHandler
{
    /**
     * @var CI_Controller
     */
    private $_ci;
    /**
     * @var array
     */
    private $_templateData = array();

    public function __construct()
    {
        $this->_ci =& get_instance();
    }

    function set($content_area, $value)
    {
        $this->_templateData[$content_area] = $value;
    }

    function load($template = '', $name ='', $view = '' , $view_data = array()/*, $return = FALSE*/)
    {
        $this->set($name , $this->_ci->load->view($view, $view_data, TRUE));

        $this->_ci->load->view('layouts/'.$template, $this->_templateData);
    }
}