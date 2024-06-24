<?php
    // Database credentials
    $dbHost = '127.0.0.1';
    $dbUsername = 'postgres';
    $dbPassword = 'root';
    $dbName = 'import_delia';
    $backupFilePath = 'dump.sql';

    ob_start(); 
    
    $command = sprintf(
        '"D:\\stuff\\postgres\\bin\\pg_dump" -h %s -U %s -d %s 2>&1',
        escapeshellarg($dbHost),
        escapeshellarg($dbUsername),
        escapeshellarg($dbName)
    );
    
    putenv("PGPASSWORD={$dbPassword}");
    
    exec($command, $output, $return_var);
    
    putenv("PGPASSWORD");
    
    if ($return_var === 0) {
        $dumpData = implode("\n", $output);
    
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="database_backup.sql"');
        header('Content-Length: ' . strlen($dumpData));
        echo $dumpData;
    } else {
        // echo $return_var;
        echo "Error during database backup.";
        echo print_r($output);
    }
    
    ob_end_flush(); 
?>