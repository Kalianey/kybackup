<?php

echo '<table>';
echo '<tr>';
echo '<td style="width: 80px;">Host</td>';
echo '<td style="width: 140px;">Username</td>';
echo '<td style="width: 140px;">DB Name</td>';
echo '<td style="width: 80px;">'.KY::getText()->textForKey('label.prefix').'</td>';
echo '</tr>';
foreach ($params['rows'] as $row)
{
    echo '<tr>';
    echo '<td>'.$row->host.'</td>';
    echo '<td>'.$row->username.'</td>';
    echo '<td>'.$row->dbname.'</td>';
    echo '<td>'.$row->prefix.'</td>';
    echo '<td><a class="button" href="'.KY::getRoute()->urlForRoute('db.delete',array('id'=>$row->id)).'">Delete</a></td>';
    echo '</tr>';

}
echo '</table>';
echo '</form>';
