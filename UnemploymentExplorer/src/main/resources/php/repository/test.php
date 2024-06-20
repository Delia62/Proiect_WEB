<?php
    ob_start();
    include './connectionFactory.php';
    ob_end_clean();//to remove


    // $conn = connect();

    // $query = "SELECT * FROM mediu LIMIT 10";
    // $data = pg_fetch_all(pg_query($conn, $query));

    // echo json_encode($data);



    $filtering = [
        "judet" => "Alba",
        "educatie" => "fara",
        "mediu" => "total",
        "sex" => "feminin",
        "rata" => "total",
        "varsta" => "total"
    ];


    function setMediu(&$filtering){
        switch($filtering["mediu"]){
            case "somerimediuurban":
                switch($filtering["sex"])
                {
                    case "feminin":
                        $filtering["mediu"] = "femeiurban";
                        break;

                    case "masculin":
                        $filtering["mediu"] = "barbatiurban";
                        break;
                    
                    default:
                        break;
                }
            case "somerimediurural":
                switch($filtering["sex"])
                {
                    case "feminin":
                        $filtering["mediu"] = "femeirural";
                        break;

                    case "masculin":
                        $filtering["mediu"] = "barbatirural";
                        break;
                    
                    default:
                        break;
                }
            default:
                break;
        }
    }

    function countFilters($filtering){
        $count = 0; 
        foreach($filtering as $key => $value){
            if($value != "total") $count++;
        }
        return $count;
    }
 

    function getOverallValuesByYearsAndMonths($startYear, $endYear, $filtering){
        $conn = connect();
        setMediu($filtering);

        $oneJudet = $filtering["judet"] == "total" ? false : true;
        $filtering["judet"] = strtoupper($filtering["judet"]);

        // Sanitize the input
        $educatie = pg_escape_string($filtering["educatie"]);
        $mediu = pg_escape_string($filtering["mediu"]);
        $rata = pg_escape_string($filtering["rata"]);
        $varsta = pg_escape_string($filtering["varsta"]);

 
        if(! $oneJudet )
            $query = "SELECT e.total, e.$educatie as nrEducatie, m.$mediu as nrMediu, r.$rata as nrRata, v.$varsta as nrVarsta, e.luna, e.an 
            FROM educatie e JOIN mediu m ON e.judet = m.judet AND e.luna = m.luna AND e.an = m.an
            JOIN rata r ON e.judet = r.judet AND e.luna = r.luna AND e.an = r.an
            JOIN varsta v ON e.judet = v.judet AND e.luna = v.luna AND e.an = v.an
            WHERE e.an BETWEEN $1 AND $2";

        else $query = "SELECT e.total, e.$educatie as nrEducatie, m.$mediu as nrMediu, r.$rata as nrRata, v.$varsta as nrVarsta, e.luna, e.an
            FROM educatie e JOIN mediu m ON e.judet = m.judet AND e.luna = m.luna AND e.an = m.an
            JOIN rata r ON e.judet = r.judet AND e.luna = r.luna AND e.an = r.an
            JOIN varsta v ON e.judet = v.judet AND e.luna = v.luna AND e.an = v.an
            WHERE UPPER(e.judet) LIKE $1 AND e.an BETWEEN $2 AND $3";

        echo $query;


        $result = pg_prepare($conn, "my_query", $query);
        if( $oneJudet )  $data = pg_execute($conn, "my_query", array('%'.$filtering["judet"].'%', $startYear, $endYear));
        else $data = pg_execute($conn, "my_query", array($startYear, $endYear));


        $data = pg_fetch_all($data);
        
        pg_close($conn);

        return $data;
    }

    function getOverallPrecentagesByYearsAndMonths($startYear, $endYear, $filtering){
        $result = getOverallValuesByYearsAndMonths($startYear, $endYear, $filtering);

        foreach($result as $key => $value){
            $total = $value["total"];
            foreach($value as $key2 => $value2){
                if($key2 == "total" || $key2 == "luna" || $key2 == "an") continue;
                $result[$key][$key2] = round(($value2 / $total) * 100, 2);
            }
        }


        return $result;
    }

    print_r(getOverallValuesByYearsAndMonths(2022, 2023, $filtering));
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    print_r(getOverallPrecentagesByYearsAndMonths(2022, 2023, $filtering));

?>

 <!-- 
-- SELECT e.*, m.*, r.*, v.*
-- FROM educatie e
-- JOIN mediu m ON e.judet = m.judet AND e.an = m.an AND e.luna = m.luna
-- JOIN rata r ON e.judet = r.judet AND e.an = r.an AND e.luna = r.luna
-- JOIN varsta v ON e.judet = v.judet AND e.an = v.an AND e.luna = v.luna
-- WHERE e.an IN ('2022', '2023') -- replace with the years you want to filter
-- AND m.femei = 1 -- assuming 1 indicates female
-- AND e.universitate = 1 -- assuming 1 indicates completed university
-- AND v.varsta = 33; -- filter for age 33 -->