<?php


function index()
{
    $res = ModelJobConf::sharedInstance()->findAll();
    if (is_array($res)) 
    {
        echo '<table>';
        echo '<tr>';
        echo '<td>ID</td>';
        echo '<td>Name</td>';
        echo '</tr>';
        foreach ($res as $row)
        {
            echo '<tr>';
            echo '<td>'.$row->id.'</td>';
            echo '<td>'.$row->name.'</td>';
            echo '<td><a class="button" href="'.KY::getRoute()->urlForRoute('job.delete',array('id'=>$row->id)).'">Delete</a></td>';
            echo '<td><a class="button" href="'.KY::getRoute()->urlForRoute('job.run',array('id'=>$row->id)).'">Run now</a></td>';
            echo '</tr>';
        }
        echo '</table>';
    }
}

function add()
{
    $db = ModelDb::sharedInstance()->findAll();
    $path = ModelPath::sharedInstance()->findAll();
    
    $params = array(
        'db' => $db,
        'path' => $path
    );
    
    KY::getView()->draw('job.add.form',$params);
 
}

function addSave()
{   
    
    $newConf = new EntityJobConf();
    $newConf->name = $_POST['name'];
    $newConf->dbId = $_POST['dbId'];
    $newConf->pathId = $_POST['pathId'];
    $newConf->recurrence = $_POST['recurrence'];
    
    ModelJobConf::sharedInstance()->save($newConf);

    echo 'New job configuration created';
    
}

function delete($params)
{    
    $id = $params['id'];
    
    ModelJobConf::sharedInstance()->delete($id);
  
}

//run the task in background
function run($params)
{
    $id = (int)$params['id'];
    
    $url = KY::getRoute()->urlForRoute("job.curlbackup", array('id' => $id));
    
    $cmd = "curl ".$url." >> backup-in-background.log &";

    system($cmd);
    
    header("Location: ".KY::getRoute()->urlForRoute('home'));
    die();

}

function curlBackup($params)
{    
    $id = (int)$params['id'];
    
    $backup = Backup::sharedInstance();
    $modelJob = ModelJob::sharedInstance();
    
    ini_set("max_execution_time", 0);

    $jobConf = ModelJobConf::sharedInstance()->findById($id)[0];
    $db = ModelDb::sharedInstance()->findById((int)$jobConf->dbId)[0];
    $path = ModelPath::sharedInstance()->findById((int)$jobConf->pathId)[0];

    if (!is_null($jobConf))
    {
        $job = new EntityJob();
        $job->jobConfId = $jobConf->id;
        $job->jobConfName = $jobConf->name;
        $job->starttime = time();
        $job->status = "file";
        $job->uploaded = 0;
        $job->deleted = 0;
        $modelJob->save($job);
        // update job status to "file" and save()
        $filename = $backup->backupFiles($path->path, $path->ignored);
        $job->filename = $filename;
        // update job status to "db" and save()
        $job->status = "db";
        $modelJob->save($job);
        $dbfilename = $backup->backupDatabase($db->host, $db->username, $db->pass, $db->dbname);
        $job->dbfilename = $dbfilename;
        // update job status to "cleanup" and save()
        $job->status = "files";
        $modelJob->save($job);
        //$backup->deleteBackups(); //TODO: implement a counter int he config and delete old backups when necessary
        $job->status = "done";
        $job->endtime = time();
        $modelJob->save($job);
        echo "<br/>All done\n";
         //update job status to "complete" or "error" and save()
    }
    exit();
    
}

