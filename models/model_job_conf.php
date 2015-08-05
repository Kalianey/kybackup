<?php
class EntityJobConf extends Entity
{
    var $name,$dbId,$pathId,$recurrence;
}
    
class ModelJobConf extends Model
{
    /** @var ModelJobConf */
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
        return 'ky_kybackup_job_configuration';
    }
    
    function entityName() {
        return 'EntityJobConf';
    }
    
    function deleteAssociatedJob($id, $entityType){
        $sql = "DELETE FROM ky_kybackup_job_configuration WHERE ".$entityType."Id=".$id;
        KY::getDB()->query($sql);
    }
}

