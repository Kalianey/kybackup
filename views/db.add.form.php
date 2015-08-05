<?php
echo '<form method="POST" action="'.KY::getRoute()->urlForRoute('db.add.showtables').'">';
echo '<table>';

echo '<tr>';
echo '<td>Host:</td>';
echo '<td><input type="text" name="host" value="localhost"/></td>';
echo '</tr>';

echo '<tr>';
echo '<td>User:</td>';
echo '<td><input type="text" name="user" value="kalianey_bandcka"/></td>';
echo '</tr>';

echo '<tr>';
echo '<td>Password:</td>';
echo '<td><input type="password" name="pass" value="Fxvcoar123"/></td>';
echo '</tr>';

echo '<tr>';
echo '<td>Database:</td>';
echo '<td><input type="text" name="database" value="kalianey_bandc1"/></td>';
echo '</tr>';

echo '<tr>';
echo '<td>Prefix <i>(if any)</i>:</td>';
echo '<td><input type="text" name="prefix" value=""/></td>';
echo '</tr>';

echo '</table>';
echo '<td><input type="submit" name="submit" value="Test"/></td>';
echo '</form>';