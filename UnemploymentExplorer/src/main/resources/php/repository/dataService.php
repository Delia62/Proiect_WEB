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

  

    function getFilteringResult($startYear, $endYear, $filtering, $xAxis, $yAxis){
        $result = null;
        if(array_key_exists($xAxis, $filtering))
            $filtering[$xAxis] = "total"; 
        setMediu($filtering);





         
        if(countFilters($filtering) == 0 || countFilters($filtering) == 1)
        $result = getOverallValuesByYearsAndMonths($startYear, $endYear, $filtering);//theres no need to turn to percentages if theres only one or no filter; get the basic values already provided
        else $result = getOverallPrecentagesByYearsAndMonths($startYear, $endYear, $filtering);
        
        $result = formatToGraphInput($result, $filtering);


        if( $yAxis == "total")
        {   
            if( $xAxis == "luni")
                return json_encode($result);
            else if( $xAxis == "ani"){
                return json_encode(sumByYears($result, $startYear, $endYear));
            }
            else if( $xAxis == "sex" ){
                return json_encode(getNumbersBySex(sumByYears($result, $startYear, $endYear), $filtering, $startYear, $endYear));
            }
            else if( $xAxis == "educatie" ){
                return json_encode(getNumbersByEducation(sumByYears($result, $startYear, $endYear), $filtering, $startYear, $endYear));
            }
        }
    }



    function sumByYears($data, $startYear, $endYear){
        $finalCalculation = [];
        for($year = $startYear; $year <= $endYear; $year++)
            $finalCalculation[$year] = 0;

        foreach($data as $key => $value){
            $finalCalculation[$value["an"]] += $value["nr_someri"];
        }

        $finalFormat = [];
        foreach($finalCalculation as $key => $value){
            $temp = [];
            $temp["nr_someri"] = $value;
            $temp["an"] = $key;
            array_push($finalFormat, $temp);
        }

        return $finalFormat;
    }








    function getNumbersBySex($data, $filtering, $startYear, $endYear){
        //
        
        $mediu = $filtering["mediu"];
        $filtering["sex"] = "feminin";
        setMediu($filtering);
        $mediuFeminin = $filtering["mediu"];
        $filtering["sex"] = "masculin";
        setMediu($filtering);
        $mediuMasculin = $filtering["mediu"];


        $conn = connect();
        $mediu = pg_escape_string($mediu);
        $mediuFeminin = pg_escape_string($mediuFeminin);
        $mediuMasculin = pg_escape_string($mediuMasculin);

        $query = "SELECT SUM(m.$mediu) as mediu, SUM(m.$mediuFeminin) as feminin, SUM(m.$mediuMasculin) as masculin, m.an 
                    FROM mediu m WHERE m.an BETWEEN $1 AND $2 GROUP BY m.an";
        $result = pg_prepare($conn, "my_query", $query);
        $result = pg_execute($conn, "my_query", array($startYear, $endYear));
        $result = pg_fetch_all($result);

        pg_close($conn);


        $finalResult = [];
        foreach($data as $key => $value){
            $temp = [];
            
            $mediu = array_filter($result, function($var) use ($value){
                return $var["an"] == $value["an"];
            })[0]["mediu"];
            $mediuFeminin = array_filter($result, function($var) use ($value){
                return $var["an"] == $value["an"];
            })[0]["feminin"];
            $mediuFeminin = round((floatval($mediuFeminin) / floatval($mediu)), 3, PHP_ROUND_HALF_UP);
            



            $temp["feminin"] = round($value["nr_someri"] * $mediuFeminin, 0, PHP_ROUND_HALF_UP);
            $temp["masculin"] = $value["nr_someri"] - $temp["feminin"];
            $temp["an"] = $value["an"];
            array_push($finalResult, $temp);
        }
        return $finalResult;

    }
    

    function getNumbersByEducation($data, $filtering, $startYear, $endYear){
        // $educatie = $filtering["educatie"];
        $conn = connect();

        $query = "SELECT SUM(e.total) as total, SUM(e.fara) as fara, SUM(e.primar) as primar, SUM(e.gimnazial) as gimnazial, SUM(e.liceal) as liceal, SUM(e.postliceal) as postliceal, SUM(e.profesional) as profesional, SUM(e.universitar) as universitar, e.an 
                    FROM educatie e WHERE e.an BETWEEN $1 AND $2 GROUP BY e.an";

        $result = pg_prepare($conn, "my_query", $query);
        $result = pg_execute($conn, "my_query", array($startYear, $endYear));
        $result = pg_fetch_all($result);

        pg_close($conn);

        $finalResult = [];
        foreach($data as $key => $value){
            $temp = [];
            
            $educatie = array_filter($result, function($var) use ($value){
                return $var["an"] == $value["an"];
            })[0];
            $total = $educatie["total"];
            $fara = round((floatval($educatie["fara"]) / floatval($total)), 3, PHP_ROUND_HALF_UP);
            $primar = round((floatval($educatie["primar"]) / floatval($total)), 3, PHP_ROUND_HALF_UP);
            $gimnazial = round((floatval($educatie["gimnazial"]) / floatval($total)), 3, PHP_ROUND_HALF_UP);
            $liceal = round((floatval($educatie["liceal"]) / floatval($total)), 3, PHP_ROUND_HALF_UP);
            $postliceal = round((floatval($educatie["postliceal"]) / floatval($total)), 3, PHP_ROUND_HALF_UP);
            $profesional = round((floatval($educatie["profesional"]) / floatval($total)), 3, PHP_ROUND_HALF_UP);
            $universitar = round((floatval($educatie["universitar"]) / floatval($total)), 3, PHP_ROUND_HALF_UP);

            $temp["fara"] = round($value["nr_someri"] * $fara, 0, PHP_ROUND_HALF_UP);
            $temp["primar"] = round($value["nr_someri"] * $primar, 0, PHP_ROUND_HALF_UP);
            $temp["gimnazial"] = round($value["nr_someri"] * $gimnazial, 0, PHP_ROUND_HALF_UP);
            $temp["liceal"] = round($value["nr_someri"] * $liceal, 0, PHP_ROUND_HALF_UP);
            $temp["postliceal"] = round($value["nr_someri"] * $postliceal, 0, PHP_ROUND_HALF_UP);
            $temp["profesional"] = round($value["nr_someri"] * $profesional, 0, PHP_ROUND_HALF_UP);
            $temp["universitar"] = round($value["nr_someri"] * $universitar, 0, PHP_ROUND_HALF_UP);
            $temp["an"] = $value["an"];
            array_push($finalResult, $temp);
        }
        return $finalResult;
    }
?>
