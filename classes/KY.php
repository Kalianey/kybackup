<?php

class KY
{
    // we use KY class a a global singleton container
    /** @var Text */
    static $text;
    /** @var Route */
    static $route;
    /** @var Database */
    static $database;
    /** @var View */
    static $view;
    
    static function init()
    {
        self::$text = Text::sharedInstance();
        self::$route = Route::sharedInstance();
        self::$database = Database::sharedInstance();
        self::$view = View::sharedInstance();
    }
    
    /* GETTERS */
    static function getText()
    {
        return self::$text;
    }
    
    static function getRoute()
    {
        return self::$route;
    }
    
    static function getDB()
    {
        return self::$database;
    }
    
    static function getView()
    {
        return self::$view;
    }
    
    
    
    
}