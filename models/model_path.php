<?php
class EntityPath extends Entity
{
    var $path,$ignored;
}
  
class ModelPath extends Model
{
    /** @var ModelPath */
    static private $sharedInstance;
    
    static function sharedInstance()
    {
        if ( is_null(self::$sharedInstance))
        {
            self::$sharedInstance = new self();
        }
        return self::$sharedInstance;
    }
    
    function tableName() {
        return 'ky_kybackup_path_configuration';
    }
    
    function entityName() {
        return 'EntityPath';
    }
    
    
}

