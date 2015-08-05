<?php
class EntityJob extends Entity
{
    var $jobConfId, $jobConfName, $filename, $dbfilename, $status, $starttime, $endtime, $uploaded, $deleted;
}

//class EntityBackupPlus extends EntityBackup
//{
//    var $confname;
//}

class ModelJob extends Model
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
        return 'ky_kybackup_job';
    }
    
    function entityName() {
        return 'EntityJob';
    }
    
//    function findList()
//    {
//        $db = Database::sharedInstance();
//        $sql = "SELECT job.* , conf.name as confname FROM ky_kybackup_job job, ky_kybackup_job_configuration conf WHERE job.jobConfId = conf.id";
//        $res = $db->query($sql);   
//        if (!$res) {
//            return false;
//        }
//        
//        
//        return $db->fetchAll($res,  Database::FETCH_CLASS, 'EntityBackupPlus');   
//    }
    
//    function save($params)
//    {
//        
//        $sql = "INSERT INTO ky_kybackup_job (filename, dbfilename, status, starttime, uploaded, deleted) VALUES "
//                . "(".$params['filename'].",`".$params['dbfilename']."`, started, ".time().", 0, 0)";
//
//        print_r($sql);
//        return KY::getDB()->query($sql);
//    }
    
    
//    function delete($id)
//    {
//        
//        $sql = "DELETE FROM ky_kybackup_job WHERE id=".$id;
//        return KY::getDB()->query($sql);
//        
//    }
    
//    function run($params)
//    {
//        
//        
//
//        echo 'New job configuration created';
////        $sql = "UPDATE ky_kybackup_job SET status = ".$params['status'].", endtime=".time().", uploaded = ".$params['uploaded'].", deleted= ".$params['dbfilename']>" WHERE id = ".$params['id'];
////
////        print_r($sql);
////        return KY::getDB()->query($sql);
//    }
    
    
//    function updateJob($params)
//    {
//        
//        $sql = "UPDATE ky_kybackup_job SET status = ".$params['status'].", endtime=".time().", uploaded = ".$params['uploaded'].", deleted= ".$params['dbfilename']>" WHERE id = ".$params['id']
//                . " IF @@ROWCOUNT = 0 "
//                . "INSERT INTO ky_kybackup_job (filename, dbfilename, status, starttime, uploaded, deleted) VALUES "
//                . "(".$params['filename'].",`".$params['dbfilename']."`, started, ".time().", 0, 0) "
//              ;
//
//        print_r($sql);
//        return KY::getDB()->query($sql);
//    }
}

