<?php
class View 
{
    /** @var View */
    static private $sharedInstance;
    private $basePath;
    
    static function sharedInstance()
    {
        if ( is_null(self::$sharedInstance))
        {
            self::$sharedInstance = new self();
        }
        return self::$sharedInstance;
    }
    
    function setBasePath($path)
    {
        $this->basePath = $path;
    }
    
    function draw($name,$params=null)
    {
        include($this->basePath.$name.'.php');
    }
}