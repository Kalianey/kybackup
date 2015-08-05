<?php


function index()
{
    $res = ModelJob::sharedInstance()->findAll();
    if (is_array($res)) 
    {
        echo '<table>';
        echo '<tr>';
        echo '<td style="width: 30px;">ID</td>';
        echo '<td style="width: 150px;">Name</td>';
        echo '<td style="width: 50px;">Status</td>';
        echo '</tr>';
        foreach ($res as $job)
        {
            echo '<tr>';
            echo '<td>'.$job->id.'</td>';
            echo '<td>'.$job->jobConfName.'</td>';
            echo '<td>'.$job->status.'</td>';
            echo '</tr>';
        }
        echo '</table>';

        //Make files downloadable
        $hasBackup = false;
        $backupdir = './ky_backups/';
       
        $files = glob( $backupdir.'*.*' );
        $exclude_files = array('.', '..');
        
        if (!in_array($files, $exclude_files)) {
            // Sort files by modified time, latest to earliest
            // Use SORT_ASC in place of SORT_DESC for earliest to latest
            if (count($files) > 1) {
                array_multisort(
                    array_map( 'filemtime', $files ),
                    SORT_NUMERIC,
                    SORT_DESC,
                    $files
                );
                $hasBackup = true;
            }
        }
        
        if (!empty($files)) 
        {

            $partsDb = pathinfo($files[0]);
            $basenameDb = $partsDb['basename'];
            $dbSize = filesize($files[0]);
            $dbSize = $dbSize / pow(1024, 2);
            $dbSize = str_replace(".", "," , strval(round($dbSize, 2)))." MB";

            $partsF = pathinfo($files[1]);
            $basenameF = $partsF['basename'];
            $fileSize = filesize($files[1]);
            $fileSize = $fileSize / pow(1024, 2);
            $fileSize = str_replace(".", "," , strval(round($fileSize, 2)))." MB";

            echo '<div class="border-top"> Last backup on: '. date ("F d Y H:i:s.", filemtime($files[0])) . '<br/>';      
            echo '<a href="./ky_backups/'.$basenameDb.'">Download Database ('.$dbSize.')</a><br/>';
            echo '<a href="./ky_backups/'.$basenameF.'">Download Files ('.$fileSize.').</a><br/></div>';
        }
    }
}