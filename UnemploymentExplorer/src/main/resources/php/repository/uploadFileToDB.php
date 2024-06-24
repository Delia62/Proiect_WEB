<?php

    ob_start();
    include './connectionFactory.php';
    ob_end_clean();


    // echo "year received: ";
    // echo $_POST['year'];
    // echo "<br>";
    // echo "month received: ";
    // echo $_POST['month'];
    // echo "<br>";
    // echo "type received: ";
    // echo $_POST['type'];
    // echo "data received: ";
    // echo $_POST['data'];
    

    const headers = [
        "educatie" => ["judet", "total", "fara", "primar", "gimnazial", "liceal", "postliceal", "profesional", "universitar", "luna", "an"],
        "mediu" => ["judet", "total", "somerifemei", "someribarbati", "somerimediuurban", "femeiurban", "barbatiurban", "somerimediurural", "femeirural", "barbatirural", "luna", "an"],
        "rata" => ["judet", "total", "femei", "barbati", "indemnizati", "neindemnizati", "rata", "rata_femei", "rata_barbati", "luna", "an"],
        "varsta" => ["judet", "total", "sub25", "intre25si29", "intre30si39", "intre40si49", "intre50si55", "peste55", "luna", "an"],
    ];

    $year = $_POST['year'];
    $month = $_POST['month'];
    $type = $_POST['type'];

    $data = json_decode($_POST['data'], true);
    array_shift($data);
    foreach ($data as &$row) {
        foreach ($row as &$value) 
            $value = str_replace(',', '', $value);
        
        unset($value); 
    }
    unset($row);
    // echo print_r($data);


    $conn = connect();

    $sql = "INSERT INTO $type (" . implode(", ", headers[$type]) . ") VALUES ";
    $valueStrings = [];
    foreach ($data as $row) {
        $row[] = $month;
        $row[] = intval($year);

        $valueString = implode(", ", array_map(function($value) {

            if (is_numeric($value)) 
                return $value;
            else 
                return "'" . addslashes($value) . "'"; 

        }, $row));
        
        $valueStrings[] = "($valueString)";
    }
    $sql .= implode(", ", $valueStrings);

    // echo $sql;

    $result = pg_query($conn, $sql);
    if (!$result) {
        // echo "Error: " . $sql . "<br>" . pg_last_error($conn);
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => pg_last_error($conn)]);
        
    } else {
        echo "Records created successfully";
    }
    pg_close($conn);
?>