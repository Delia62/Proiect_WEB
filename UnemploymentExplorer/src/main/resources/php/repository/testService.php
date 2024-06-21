<?php

    include './dataService.php';
    
    echo "Data received: \n";
    print_r($_POST);
    echo "";
    echo "";
    echo "";


    $startYear = $_POST["perioadaDeTimpStart"];
    $endYear = $_POST["perioadaDeTimpEnd"];
    unset($_POST["perioadaDeTimpStart"]);
    unset($_POST["perioadaDeTimpEnd"]);
    $filtering = $_POST;

    print_r($filtering);
    echo "";
    echo "";
    echo "";

    print_r(getFilteringResult($startYear, $endYear, $filtering));
?>  