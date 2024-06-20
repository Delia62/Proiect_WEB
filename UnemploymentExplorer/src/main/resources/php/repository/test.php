<?php
    ob_start();
    include '../testDB.php';
    ob_end_clean();//to remove


    $conn = connect();

    $query = "SELECT * FROM mediu LIMIT 10";
    $data = pg_fetch_all(pg_query($conn, $query));

    // echo json_encode($result);
    // echo '----------------------';
    echo json_encode($data);

?>