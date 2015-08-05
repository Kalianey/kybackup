<?php

class Text
{
    // keyword 'static' means it's a variable that belongs to the class. 
    // This means that this variable is shared among all the objects of this class
    static private $sharedInstance;
    
    private $text = array();
    private $lang_default='en';
    private $lang = 'en';
    
    //Creating a singleton
    static function sharedInstance()
    {
        if ( is_null(self::$sharedInstance))
        {
            self::$sharedInstance = new self();
        }
        return self::$sharedInstance;
    }
    
    function __construct() {
        $this->text['en'] = array(
            'title' => 'KYBACKUP, website backup made easy',
            'home' => 'home',
            'home.index' => 'Welcome to KYBackup, here are your previous backup jobs:',
            'job.index' => 'Job List',
            'job.add' => 'Create a Job',
            'job.run' => 'Running Job',
            'db.index' => 'Database List',
            'db.add' => 'Add a Database',
            'path.index' => 'Path List',
            'path.add' => 'Add a Path',
            'path.add.save' => 'Configuration Saved!',
            'path.add.showfiles' => 'Verify and continue',
            'label.prefix' => 'Prefix'
        );
        $this->text['it'] = array(
            'home.index' => 'Benvenuto KyBackup',
            'job.index' => 'Lista dei Job ',
        );
        $this->text['de'] = array(
            'home.index' => 'Wilkommen KyBackup'
        );
    }
    
    function setLanguage($lang_code)
    {
        $this->lang = $lang_code; //en, fr, it, de
    }
    
    function textForKey($key)
    {
        if (key_exists($this->lang, $this->text) && key_exists($key, $this->text[$this->lang]))
        {
            return $this->text[$this->lang][$key];
        }
        
        if (key_exists($this->lang_default, $this->text) && key_exists($key, $this->text[$this->lang_default]))
        {
            return $this->text[$this->lang_default][$key];
        }
        
        return $key;
    }
}