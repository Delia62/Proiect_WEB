<?php

    ob_start();
    include './connectionFactory.php';
    ob_end_clean();


    $conn = connect();
    $query = "SELECT DISTINCT luna, an FROM educatie ORDER BY an";
    $result = pg_query($conn, $query);
    $responseEducatie = array();
    while($row = pg_fetch_row($result)){
        $responseEducatie[] = $row;
    }

    $query = "SELECT DISTINCT luna, an FROM mediu ORDER BY an";
    $result = pg_query($conn, $query);
    $responseMediu = array();
    while($row = pg_fetch_row($result)){
        $responseMediu[] = $row;
    }

    $query = "SELECT DISTINCT luna, an FROM varsta ORDER BY an";
    $result = pg_query($conn, $query);
    $responseVarsta = array();
    while($row = pg_fetch_row($result)){
        $responseVarsta[] = $row;
    }

    $query = "SELECT DISTINCT luna, an FROM rata ORDER BY an";
    $result = pg_query($conn, $query);
    $responseRata = array();
    while($row = pg_fetch_row($result)){
        $responseRata[] = $row;
    }



    // echo "Educatie: ";
    // print_r($responseEducatie);
    // echo "<br><br>";
    // echo "Mediu: ";
    // print_r($responseMediu);
    // echo "<br><br>";
    // echo "Varsta: ";
    // print_r($responseVarsta);
    // echo "<br><br>";
    // echo "Rata: ";
    // print_r($responseRata);





    $allYears = [];
    foreach([$responseEducatie, $responseMediu, $responseVarsta, $responseRata] as $response) {
        foreach($response as $index => $row) {
            if (!array_key_exists($row[1], $allYears)) {
                $allYears[$row[1]] = [];
            }
            if (!array_key_exists($row[0], $allYears[$row[1]])) {
                // Initialize each month as an array to hold types
                $allYears[$row[1]][$row[0]] = [];
            }
        }
    }

    // echo "<br><br>";
    // echo "All years: ";
    // print_r($allYears);
    // echo "<br><br>";




    
    foreach($allYears as $year => &$months) {
        foreach($months as $month => &$types) {
            foreach([$responseEducatie, $responseMediu, $responseVarsta, $responseRata] as $response) {
                foreach($response as $row) {
                    if($row[1] == $year && $row[0] == $month) {
                        // Determine the type based on which response array we're currently iterating
                        $type = $response === $responseEducatie ? "educatie" : 
                                ($response === $responseMediu ? "mediu" : 
                                ($response === $responseVarsta ? "varsta" : "rata"));
                        if (!in_array($type, $types)) {
                            $types[] = $type;
                        }
                    }
                }
            }
        }
    }


    echo json_encode($allYears);



?>