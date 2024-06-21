<?php
    ob_start();
    include './connectionFactory.php';
    ob_end_clean();//to remove

    $filtering = [
        "judet" => "Alba",
        "educatie" => "fara",
        "mediu" => "total",
        "sex" => "feminin",
        "rata" => "total",
        "varsta" => "total"
    ];

    $monthMapping = ['ianuarie', 'februarie', 'martie', 'aprilie', 'mai', 'iunie', 'iulie', 'august', 'septembrie', 'octombrie', 'noiembrie', 'decembrie'];


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
                break;
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
                break;
            case "total":
                switch($filtering["sex"]) 
                {
                    case "feminin":
                        $filtering["mediu"] = "somerifemei";
                        break;

                    case "masculin":
                        $filtering["mediu"] = "someribarbati";
                        break;
                    
                    default:
                        break;
                }
                break;
        }
    }

    function countFilters($filtering){
        $count = 0; 
        foreach($filtering as $key => $value){
            if($key != "judet" && $key != "sex" && $value != "total") $count++;
        }
        return $count;
    }


    function removeDuplicates(&$data, $startYear, $endYear){
        global $monthMapping;
        for($year = $startYear; $year <= $endYear; $year++){
            foreach($monthMapping as $month){
                $count = 0;
                foreach($data as $key => $value){
                    if($value["an"] == $year && $value["luna"] == $month){
                        $count++;
                        if($count > 1)  unset($data[$key]);
                    }
                }
            }
        }
    }
 






    function getOverallValuesByYearsAndMonths($startYear, $endYear, &$filtering){
        $conn = connect();
        // setMediu($filtering);
        // print_r($filtering);
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";

        // $oneJudet = $filtering["judet"] == "total" ? false : true;
        $filtering["judet"] = strtoupper($filtering["judet"]);

        // Sanitize the input
        $educatie = pg_escape_string($filtering["educatie"]);
        $mediu = pg_escape_string($filtering["mediu"]);
        $rata = pg_escape_string($filtering["rata"]);
        $varsta = pg_escape_string($filtering["varsta"]);

 
        if( $filtering["judet"] == "TOTAL" )
            $query = "SELECT SUM(e.total) as total, SUM(e.$educatie) as educatie, SUM(m.$mediu) as mediu, SUM(r.$rata) as rata, SUM(v.$varsta) as varsta, e.luna, e.an 
                            FROM educatie e JOIN mediu m ON e.judet = m.judet AND e.luna = m.luna AND e.an = m.an
                            JOIN rata r ON e.judet = r.judet AND e.luna = r.luna AND e.an = r.an
                            JOIN varsta v ON e.judet = v.judet AND e.luna = v.luna AND e.an = v.an
                            WHERE e.an BETWEEN $1 AND $2
                            GROUP BY e.luna, e.an";

        else $query = "SELECT e.total, e.$educatie as educatie, m.$mediu as mediu, r.$rata as rata, v.$varsta as varsta, e.luna, e.an
            FROM educatie e JOIN mediu m ON e.judet = m.judet AND e.luna = m.luna AND e.an = m.an
            JOIN rata r ON e.judet = r.judet AND e.luna = r.luna AND e.an = r.an
            JOIN varsta v ON e.judet = v.judet AND e.luna = v.luna AND e.an = v.an
            WHERE UPPER(e.judet) LIKE $1 AND e.an BETWEEN $2 AND $3";

        // echo $query;


        $result = pg_prepare($conn, "my_query", $query);
        if( $filtering["judet"] == "TOTAL" ) $data = pg_execute($conn, "my_query", array($startYear, $endYear));
        else  $data = pg_execute($conn, "my_query", array('%'.$filtering["judet"].'%', $startYear, $endYear));


        $data = pg_fetch_all($data);
        pg_close($conn);



        removeDuplicates($data, $startYear, $endYear);


        return $data;
    }

    function getOverallPrecentagesByYearsAndMonths($startYear, $endYear, $filtering){
        $result = getOverallValuesByYearsAndMonths($startYear, $endYear, $filtering);
        echo "basic values gotten:";
        print_r($result);
        echo "<br>";
        echo "<br>";
        echo "<br>";

        foreach($result as $key => $value){
            $total = $value["total"];
            foreach($value as $key2 => $value2){
                if($key2 == "total" || $key2 == "luna" || $key2 == "an") continue;
                $result[$key][$key2] = round(($value2 / $total), 3, PHP_ROUND_HALF_UP);
            }
        }


        return $result;
    }

    function formatToGraphInput($data, $filtering){
        setMediu($filtering);

        echo "percentege data gotten:";
        print_r($data);
        echo "<br>";
        echo "<br>";
        echo "<br>";




        
        $keysToKeep = [];
        foreach($filtering as $key => $value){
            if($value != "total" && $key != "judet" && $key != "sex") array_push($keysToKeep, $key);
        }

        // print_r($keysToKeep);
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";

        $result = [];
        foreach($data as $key => $value){
            $temp = [];


            if(countFilters($filtering) == 0 || countFilters($filtering) == 1)
            {
                if(count($keysToKeep) == 0) $temp["nr_someri"] = intval($value["total"]);
                else $temp["nr_someri"] = intval($value[$keysToKeep[0]]);
                $temp["luna"] = $value["luna"];
                $temp["an"] = intval($value["an"]);
            }
            else {
                $procent = 1;
                foreach($keysToKeep as $key2){
                    $procent *= floatval($value[$key2]);
                }

                $temp["nr_someri"] = round(intval($value["total"]) * $procent, 0, PHP_ROUND_HALF_UP);
                $temp["luna"] = $value["luna"];
                $temp["an"] = intval($value["an"]);
            }


            array_push($result, $temp);
        }

        return $result;
    }

  

    function getFilteringResult($startYear, $endYear, $filtering){
        $result = null;
        setMediu($filtering);





        //if oy axis is nr of someri and oy axis is months
        if(countFilters($filtering) == 0 || countFilters($filtering) == 1)
            $result = getOverallValuesByYearsAndMonths($startYear, $endYear, $filtering);//theres no need to turn to percentages if theres only one or no filter; get the basic values already provided
        else $result = getOverallPrecentagesByYearsAndMonths($startYear, $endYear, $filtering);


        return json_encode(formatToGraphInput($result, $filtering));
    }

    
    

?>
