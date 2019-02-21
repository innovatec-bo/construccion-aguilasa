<?php

/**
 * Created by PhpStorm.
 * User: jair
 * Date: 2017-10-17
 * Time: 12:23 AM
 */
class ComplementHandler
{
    private $_viewJavascript;
    private $_viewCss;
    private $_complements;
    private $_projectTsPath;
    private $_projectJsPath;
    private $_projectCssPath;

    public function __construct()
    {
        $ci = get_instance();
        $ci->config->load("complements-sb-admin2");
        $this->_complements = $ci->config->item("complements");
        $this->_projectTsPath = $ci->config->item("projectTsPath");
        $this->_projectJsPath = $ci->config->item("projectJsPath");
        $this->_projectCssPath = $ci->config->item("projectCssPath");
        $this->_publicJsPath = $ci->config->item("publicJsPath");
        $this->_publicCssPath = $ci->config->item("publicJsPath");
    }

    public function addViewComplement($name)
    {
        if (array_key_exists($name, $this->_complements))
        {
            if (array_key_exists("js", $this->_complements[$name]))
            {
                $this->_viewJavascript[] = $this->_complements[$name]["js"];
            }
            if (array_key_exists("css", $this->_complements[$name]))
            {
                $this->_viewCss[] = $this->_complements[$name]["css"];
            }
        }
    }

    public function addProjectTs($name, $applyVersion = FALSE)
    {
        $version = "";
        if($applyVersion)
        {
            $version = strtotime(date("Y-m-d"));
        }
        $this->_viewJavascript[] = $this->_projectTsPath . "/" . $name . ".ts?v=".$version;
    }

    public function addProjectTsJs($name, $applyVersion = FALSE)
    {
        $version = "";
        if($applyVersion)
        {
            $version = strtotime(date("Y-m-d"));
        }
        $this->_viewJavascript[] = $this->_projectTsPath . "/" . $name . ".ts?v=".$version;
    }

    public function addProjectJs($name, $applyVersion = FALSE)
    {
        $version = "";
        if($applyVersion)
        {
            $version = strtotime(date("Y-m-d"));
        }
        $this->_viewJavascript[] = $this->_projectJsPath . "/" . $name . ".js?v=".$version;
    }

    public function addPublicJs($name)
    {
        $this->_viewJavascript[] = $this->_publicJsPath . "/" . $name . ".js";
    }

    public function addProjectCss($name, $applyVersion = FALSE)
    {
        $version = "";
        if($applyVersion)
        {
            $version = strtotime(date("Y-m-d"));
        }
        $this->_viewCss[] = $this->_projectCssPath . "/" . $name . ".css?v=".$version;
    }

    public function addPublicCss($name)
    {
        $this->_viewCss[] = $this->_publicCssPath . "/" . $name . ".css";
    }

    public function printViewJs()
    {
        if(!empty($this->_viewJavascript)){
            foreach ($this->_viewJavascript as $javascript)
            {
                echo "\n";
                echo "<script type=\"text/javascript\" src=\"" . $javascript . "\"></script>";
            }
        }
    }

    public function printViewCss()
    {
        if(!empty($this->_viewCss))
        {
            foreach ($this->_viewCss as $css)
            {
                echo "\n";
                echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $css . "\" />";
            }
        }

    }
}