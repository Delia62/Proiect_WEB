<?php

    ob_start();
    include './connectionFactory.php';
    require_once '../../dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    ob_end_clean();

    $headers = [
        "educatie" => ["judet", "total", "fara", "primar", "gimnazial", "liceal", "postliceal", "profesional", "universitar", "an", "luna"],
        "mediu" => ["judet", "total", "somerifemei", "someribarbati", "somerimediuurban", "femeiurban", "barbatiurban", "somerimediurural", "femeirural", "barbatirural", "an", "luna"],
        "rata" => ["judet", "total", "femei", "barbati", "indemnizati", "neindemnizati", "rata", "rata_femei", "rata_barbati", "an", "luna"],
        "varsta" => ["judet", "total", "sub25", "intre25si29", "intre30si39", "intre40si49", "intre50si55", "peste55", "an", "luna"],
    ];

    
    $type = $_POST['type'];
    $year = $_POST['year'];
    $month = $_POST['month'];

    $conn = connect();
    $type = pg_escape_string($conn, $type);
    $year = pg_escape_string($conn, $year);
    $month = pg_escape_string($conn, $month);
    $query = "SELECT * FROM $type WHERE an = $year AND luna = '$month'";

    $result = pg_query($conn, $query);

    if($_POST['format'] == "csv"){
        if (is_array($headers[$type])) {
            echo implode(',', $headers[$type]) . "\r\n";
        } else {
            echo "Error: Invalid type or headers not defined for type.\r\n";
        }

        while($row = pg_fetch_assoc($result)){
            $csvRow = [];
            foreach($row as $value) {
                if (is_numeric($value)) {
                    $csvRow[] = $value;
                } else {
                    $value = str_replace('"', '""', $value);
                    $csvRow[] = '"' . $value . '"';
                }
            }
            echo implode(',', $csvRow) . "\r\n";
        }
    } else if($_POST['format'] == "json"){
        $json = [];
        while($row = pg_fetch_assoc($result)){
            $json[] = $row;
        }
        echo json_encode($json);
    } else if($_POST['format'] == "pdf"){
        $dompdf = new Dompdf();
        $html = '<html><body><table border="1"><tr><th>' . implode('</th><th>', $headers[$type]) . '</th></tr>';
    
        while($row = pg_fetch_assoc($result)){
            $html .= '<tr><td>' . implode('</td><td>', $row) . '</td></tr>';
        }
    
        $html .= '</table></body></html>';
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream();


    }
    pg_close($conn);

?>