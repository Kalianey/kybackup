<?php

function index()
{   
    
    $rows = ModelDb::sharedInstance()->findAll();
    $params = array(
        'rows' => $rows
    );
    
    KY::getView()->draw('db.index',$params);
}


function addForm()
{   
    KY::getView()->draw('db.add.form');
}

function addShowTables()
{    
    $host = $_POST['host'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $database = $_POST['database'];
    $prefix = $_POST['prefix'];
    
    $rows = ModelDb::sharedInstance()->showTables($host,$user,$pass,$database,$prefix);
    
    $params = array(
        'rows'=>$rows
    );
    KY::getView()->draw('db.add.showtables',$params);
}

function addSave()
{
    $host = $_POST['host'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $database = $_POST['database'];
    $prefix = $_POST['prefix'];
    
    $newConf = new EntityDb();
    $newConf->host = $host;
    $newConf->username = $user;
    $newConf->pass = $pass;
    $newConf->dbname = $database;
    $newConf->prefix = $prefix;
    
    ModelDb::sharedInstance()->save($newConf);
    
    echo 'New database configuration created';
}

function delete($params)
{    
    $id = $params['id'];
    
    ModelDb::sharedInstance()->deleteById($id);
    ModelJobConf::sharedInstance()->deleteAssociatedJob($id, 'db');
    
}
