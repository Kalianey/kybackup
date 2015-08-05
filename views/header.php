<?php

$text = KY::getText();
$route = KY::getRoute();
$currentRoute = $route->getCurrentRoute();

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
    <head>
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $route->getBaseUrl(); ?>/static/styles.css">
            <title>KY BACKUP</title>

    </head>
    <body>
        <div id="container">

            <h1><?php echo '<a href="'.$route->urlForRoute('home').'">'. $text->textForKey('title') .'</a></h1>'; ?>
                <p class="byline">by <strong><a href="http://www.kalianey.com" target="_blank"/>Kalianey</a></strong></p>
    
<?php

echo '<div class="main_menu">';
echo '<ul>';
echo '<li><a href="'.$route->urlForRoute('home').'">'.$text->textForKey('home').'</a></li>';
echo '<li><a href="'.$route->urlForRoute('job.index').'">'.$text->textForKey('jobs').'</a>';
echo '<ul>';
echo '<li><a href="'.$route->urlForRoute('job.index').'">'.$text->textForKey('job.index').'</a></li>';
echo '<li><a href="'.$route->urlForRoute('job.add').'">'.$text->textForKey('job.add').'</a></li>';
echo '</ul>';
echo '</li>';
echo '<li><a href="'.$route->urlForRoute('db.index').'">'.$text->textForKey('Databases').'</a>';
echo '<ul>';
echo '<li><a href="'.$route->urlForRoute('db.index').'">'.$text->textForKey('db.index').'</a></li>';
echo '<li><a href="'.$route->urlForRoute('db.add').'">'.$text->textForKey('db.add').'</a></li>';
echo '</ul>';
echo '</li>';
echo '<li><a href="'.$route->urlForRoute('path.index').'">'.$text->textForKey('Paths').'</a>';
echo '<ul>';
echo '<li><a href="'.$route->urlForRoute('path.index').'">'.$text->textForKey('path.index').'</a></li>';
echo '<li><a href="'.$route->urlForRoute('path.add').'">'.$text->textForKey('path.add').'</a></li>';
echo '</ul>';
echo '</li>';
echo '</ul>';

echo '</div>';

if ($currentRoute['name'] == 'home')
{
    echo '<h2>'.$text->textForKey($currentRoute['name'].'.index').'</h2>';
} 
else 
{
    echo '<h2>'.$text->textForKey($currentRoute['name']).'</h2>';
}