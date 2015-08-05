<?php

echo '<form method="POST" action="'.KY::getRoute()->urlForRoute('path.add.showfiles').'">';
echo '<table>';

echo '<tr>';
echo '<td>Path:</td>';
echo '<td><input type="text" name="path" value="/Applications/XAMPP/xamppfiles/htdocs/backup"/></td>';
echo '</tr>';

echo '<tr>';
echo '<td>Files and folders to ignore (separated by a comma):</td>';
echo '<td><input type="text" name="ignored" value=""/></td>';
echo '</tr>';

echo '</table>';
echo '<td><input type="submit" name="submit" value="Test"/></td>';
echo '</form>';
