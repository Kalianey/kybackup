<?php
echo '<h4>I found '.count($params['rows']).' tables:</h4>';

echo '<ul>';
foreach($params['rows'] as $row)
{
    echo '<li>'.$row['table_name'].'</li>';
}
echo '</ul>';

echo '<form method="POST" action="'.KY::getRoute()->urlForRoute('db.add.save').'">';
echo '<input type="hidden" name="host" value="'.$_POST['host'].'"/>';
echo '<input type="hidden" name="user" value="'.$_POST['user'].'"/>';
echo '<input type="hidden" name="pass" value="'.$_POST['pass'].'"/>';
echo '<input type="hidden" name="database" value="'.$_POST['database'].'"/>';
echo '<input type="hidden" name="prefix" value="'.$_POST['prefix'].'"/>';
echo '<input type="submit" name="submit" value="Save"/>';
echo '</form>';