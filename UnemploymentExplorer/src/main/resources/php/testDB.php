<?php
/*
    function connect(){
        $host = "localhost";
        $port = "5432";
        $dbname = "import_delia";
        $user = "postgres";
        $password = "root";

        $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

        return $conn;
    }

    function printConnectionStatus(){
        $conn = connect();
        if (!$conn) {
            echo "Connection failed";
            die();
        }
        echo "Connected successfully";
        pg_close($conn);
    }


    printConnectionStatus();

?>*/