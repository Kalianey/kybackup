<?php
include 'config.php';

KY::init();

KY::getText()->setLanguage($language);
KY::getDB()->connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
KY::getView()->setBasePath($viewPath);
KY::getRoute()->setBaseUrl($baseurl);
KY::getRoute()->setUrlVar($urlVarName);

include 'routes.php';

KY::getView()->draw('header');

$currentRoute = KY::getRoute()->getCurrentRoute();
KY::getRoute()->loadRoute($currentRoute);