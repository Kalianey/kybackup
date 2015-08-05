<?php

$baseurl = 'http://localhost/backup/';
$urlVarName = 'q'; //see htaccess for correct variable name -> RewriteRule ^(.*)$ index.php?q=/$1%{QUERY_STRING} [L]

$mysql_host = '127.0.0.1';
$mysql_db = 'backup';
$mysql_user = 'kalianey_bandcka';
$mysql_pass = 'Fxvcoar123';

$language = 'en';

$viewPath = "./views/";

include 'classes/KY.php';
include 'classes/text.php';
include 'classes/database.php';
include 'classes/route.php';
include 'classes/view.php';
include 'classes/backup.php';
include 'models/model.php';
include 'models/model_path.php';
include 'models/model_job_conf.php';
include 'models/model_job.php';
include 'models/model_db.php';