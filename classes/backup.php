<?php

class Backup {
    
    static private $sharedInstance;
    
    static function sharedInstance()
    {
        if ( is_null(self::$sharedInstance))
        {
            self::$sharedInstance = new self();
        }
        return self::$sharedInstance;
    }
    
    public function backupDatabase($host, $username, $pass, $database) {
        // Set execution time to 0 in case the site is huge and will take much time for back-up as default execution time for PHP is 30 seconds. //are the two the same?
        set_time_limit(0);
        ini_set("max_execution_time", 0);
        
        $backupdir = './ky_backups/';
        if (!is_dir($backupdir))
        {
            mkdir($backupdir,0777,true);
        }
        
        // Config
        $db = new Database();
        $db->connect($host,$username,$pass,$database);
        $res = $db->query('show databases');

        // Create dump file
        $date = date('Y-m-d_His');
        $dumpfile = $backupdir.'db-backup_' . $date . ".sql.gz";
        $fp = gzopen($dumpfile, 'w');
        if (!is_resource($fp)) {
            exit('Backup failed: unable to open dump file');
        }

        // Header
        $out = 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";';

        // Write
        gzwrite($fp, $out);
        $out = '';

        // Fetch tables
        $tables = $db->query("SHOW TABLE STATUS");

        if (!$tables) {
            return false;
        }
        $c = 0;

        while ($table = $db->fetch($tables)) {

            $tableName = $table['Name'];

            $tmp = $db->query("SHOW CREATE TABLE `$tableName`");

            // Create table
            $create = $db->fetch($tmp);
            $out .= "\n\n" . $create['Create Table'] . ' ;';

            // Clean
            $tmp->closeCursor();
            unset($tmp);

            // Write
            gzwrite($fp, $out);
            $out = '';

            // Rows
            $tmp = $db->query("SHOW COLUMNS FROM `$tableName`");
            $rows = array();
            while ($row = $db->fetch($tmp)) {
                $rows[] = $row['Field'];
            }
            
            
            // Clean
            $tmp->closeCursor();
            unset($tmp, $row);

            // Get data
            $tmp =$db->query("SELECT * FROM `$tableName`");
            $count = $db->count($tmp);

            if ($count > 0) {

                $out .= "\nINSERT INTO `$tableName` (`" . implode('`, `', $rows) . "`) VALUES ";

                $i = 1;
                $limit = 1;
                
                // Fetch data
                while ($entry = $db->fetch($tmp)) {

                    // Create values
                    $out .= "\n(";
                    $tmp2 = array();

                    foreach ($rows as $row) {
                        //$tmp2[] = "'" . mysql_real_escape_string($entry[$row]) . "'";
                        $tmp2[] = "'" . addslashes($entry[$row]) . "'";
                    }

                    $out .= implode(', ', $tmp2);
                    $out .= $i++ === $count ? ');' : ')';

                    if ($limit > 100) {
                        $out .= ";\nINSERT INTO `$tableName` (`" . implode('`, `', $rows) . "`) VALUES ";
                        $limit = 1;
                    } else {
                        $out .= $i === $count + 1 ? '' : ',';
                        $limit++;
                    }

                    // Save
                    gzwrite($fp, $out);
                    $out = '';
                }

                // Clean
                $tmp->closeCursor();
                unset($tmp, $tmp2, $i, $count, $entry);
            }

            // Operations counter
            $c++;
        }

        // Close dump file
        gzclose($fp);
        
        echo "Done! Backup $c tables to `$dumpfile` (" . filesize($dumpfile) . " o). <br/>";
        return $dumpfile;
        
    }

    
    
    public function backupFiles($path, $ignored)
    {
        $backupdir = './ky_backups/';
        if (!is_dir($backupdir))
        {
            mkdir($backupdir,0777,true);
        }
        $date = date('Y-m-d_His');
        $filename = $backupdir.'file-backup_'.$date.".zip";
        
        $ignoredArray = array_map('trim', explode(",", $ignored));
        
        $exclude = "-x ky_backups/* "; //here need to exclude full folder
        for($i=0; $i<count($ignoredArray); $i++) {
            $exclude .= '-x '.$ignoredArray[$i].'/* ';
        }
        
        $logfile = './last_backup_file.log';
        
        $cmd = "zip -r $filename ./ $exclude";
        system('echo "['.$date.'] BACK START --------------------------------------" > '. $logfile);
        system($cmd .' >> '.$logfile);
        system('echo "['.$date.'] BACK FINISH -------------------------------------" >> '.$logfile);
        echo 'Done! Files Backup completed: `'.KY::getRoute()->getBaseUrl().$filename.'`<br/>';
        return KY::getRoute()->getBaseUrl().$filename;
    }

}
