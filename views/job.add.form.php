<?php

echo '<form method="POST" action="'.KY::getRoute()->urlForRoute('job.add.save').'">';
echo '<fielset>';
echo 'Choose a name for this job:<br/>';
echo '<input type="text" name="name" value=""/><br/>';
echo '</fielset>';
echo '<fielset>';
echo 'Choose a database:<br/>';
foreach($params['db'] as $db)
{
    echo '<input type="checkbox" name="dbId" value="'.$db->id.'">'.$db->dbname.'<br/>';
}
echo '</fielset>'; 
echo '<fielset>';
echo 'Choose a path:<br/>';
foreach($params['path'] as $path)
{
    echo '<input class="checkbox" type="checkbox" name="pathId" value="'.$path->id.'">'.$path->path.'<br/>';
}
echo '</fielset>'; 
echo '<fielset>';
echo 'Choose a recurrence:<br/>';
echo '<select name="recurrence">';
echo '<option value="never">Never</option>';
echo '<option value="daily">Daily</option>';
echo '<option value="weekly">Weekly</option>';
echo '<option value="weekly">Monthly</option>';
echo '</select>';
echo '</fielset><br/>'; 
echo '<input type="submit" name="submit" value="Save"/>';
echo '</form>';

