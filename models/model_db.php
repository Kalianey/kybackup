<?php

class EntityDb extends Entity
{
    var $host,$username,$pass,$dbname,$prefix;
}


class ModelDb extends Model
{
    /** @var ModelDb */
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
        return 'ky_kybackup_db_configuration';
    }
    
    function entityName() {
        return 'EntityDb';
    }
            
    function showTables($host,$user,$pass,$dbname,$prefix){
        //can't use singleton as we are connecting to the "victim" database
    
        $db = new Database();
        $db->connect($host,$user,$pass,$dbname);


        $params = array(
            'schema' => $dbname,
            'prefix' => $prefix.'%'
        );
        $sql = "select table_name from information_schema.tables where table_schema = :schema and table_name like :prefix ";
        $res = $db->query($sql,$params);  
        
        return $res->fetchAll();
    }
    
}