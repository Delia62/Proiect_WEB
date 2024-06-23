<?php
    ob_start();
    include './connectionFactory.php';
    // include '../form_data/educatie.php';
    // include '../form_data/grupeVarsta.php';
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
        // echo "basic values gotten:";
        // print_r($result);
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";

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

        // echo "percentege data gotten:";
        // print_r($data);
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";




        
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
        $mediuSelectat = $filtering["mediu"];
        $sexSelectat = $filtering["sex"];

        if(array_key_exists($xAxis, $filtering))
            $filtering[$xAxis] = "total"; 
        
        setMediu($filtering);




        


        
            if( $xAxis == "luni"){
                $result = getValues($startYear, $endYear, $filtering);
            }
            else if( $xAxis == "ani"){
                $result = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
            }
            else if( $xAxis == "sex" ){
                $filtering["mediu"] = $mediuSelectat;
                $filtering["sex"] = "feminin";
                setMediu($filtering);
                $resultFeminin = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                $filtering["mediu"] = $mediuSelectat;
                $filtering["sex"] = "masculin";
                setMediu($filtering);
                $resultMasculin = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);


                // echo "feminin";
                // print_r($resultFeminin);
                // echo "<br>";
                // echo "<br>";
                // echo "<br>";
                // echo "masculin";
                // print_r($resultMasculin);
                // echo "<br>";
                // echo "<br>";
                // echo "<br>";

                $finalResult = [];
                foreach ($resultFeminin as $femininEntry) {
                    $temp = [
                        "feminin" => $femininEntry["nr_someri"],
                        "masculin" => null, // Default value
                        "an" => $femininEntry["an"]
                    ];
                
                    // Search for a matching year in masculinArray
                    foreach ($resultMasculin as $masculinEntry) {
                        if ($masculinEntry["an"] === $femininEntry["an"]) {
                            $temp["masculin"] = $masculinEntry["nr_someri"];
                            break; // Stop searching once a match is found
                        }
                    }
                
                    array_push($finalResult, $temp);
                }

                $result = $finalResult;
            }
            else if( $xAxis == "educatie" ){
                $filtering["educatie"] = "fara";
                $resultFara = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                $filtering["educatie"] = "primar";
                $resultPrimar = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                $filtering["educatie"] = "gimnazial";
                $resultGimnazial = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                $filtering["educatie"] = "liceal";
                $resultLiceal = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                $filtering["educatie"] = "postliceal";
                $resultPostliceal = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                $filtering["educatie"] = "profesional";
                $resultProfesional = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                $filtering["educatie"] = "universitar";
                $resultUniversitar = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);

                $finalResult = [];
                foreach($resultFara as $key => $value){
                    $temp = [];
                    $temp["fara"] = $value["nr_someri"];
                    $temp["an"] = $value["an"];
                
                    // Primar
                    $temp["primar"] = null;
                    foreach($resultPrimar as $item){
                        if($item["an"] == $value["an"]){
                            $temp["primar"] = $item["nr_someri"];
                            break;
                        }
                    }
                
                    // Gimnazial
                    $temp["gimnazial"] = null;
                    foreach($resultGimnazial as $item){
                        if($item["an"] == $value["an"]){
                            $temp["gimnazial"] = $item["nr_someri"];
                            break;
                        }
                    }
                
                    // Liceal
                    $temp["liceal"] = null;
                    foreach($resultLiceal as $item){
                        if($item["an"] == $value["an"]){
                            $temp["liceal"] = $item["nr_someri"];
                            break;
                        }
                    }
                
                    // Postliceal
                    $temp["postliceal"] = null;
                    foreach($resultPostliceal as $item){
                        if($item["an"] == $value["an"]){
                            $temp["postliceal"] = $item["nr_someri"];
                            break;
                        }
                    }
                
                    // Profesional
                    $temp["profesional"] = null;
                    foreach($resultProfesional as $item){
                        if($item["an"] == $value["an"]){
                            $temp["profesional"] = $item["nr_someri"];
                            break;
                        }
                    }
                
                    // Universitar
                    $temp["universitar"] = null;
                    foreach($resultUniversitar as $item){
                        if($item["an"] == $value["an"]){
                            $temp["universitar"] = $item["nr_someri"];
                            break;
                        }
                    }
                
                    array_push($finalResult, $temp);
                }

                $result = $finalResult;
            }
            else if( $xAxis == "mediu" ){
                    $filtering["mediu"] = "somerimediuurban";
                    $filtering["sex"] = $sexSelectat;
                    setMediu($filtering);
                    $resultUrban = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                    $filtering["mediu"] = "somerimediurural";
                    $filtering["sex"] = $sexSelectat;
                    setMediu($filtering);
                    $resultRural = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);

                    $finalResult = [];
                    foreach($resultUrban as $key => $value){
                        $temp = [];
                        $temp["urban"] = $value["nr_someri"];
                        $temp["an"] = $value["an"];

                        foreach($resultRural as $key2 => $value2){
                            if($value2["an"] == $value["an"]){
                                $temp["rural"] = $value2["nr_someri"];
                                break;
                            }
                        }
                        array_push($finalResult, $temp);
                    }

                    $result = $finalResult;
            }
            else if( $xAxis == "varsta" ){
                $filtering["varsta"] = "sub25";
                $resultSub25 = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                $filtering["varsta"] = "intre25si29";
                $resultIntre25si29 = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                $filtering["varsta"] = "intre30si39";
                $resultIntre30si39 = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                $filtering["varsta"] = "intre40si49";
                $resultIntre40si49 = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                $filtering["varsta"] = "intre50si55";
                $resultIntre50si55 = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);
                $filtering["varsta"] = "peste55";
                $resultPeste55 = sumByYears(getValues($startYear, $endYear, $filtering), $startYear, $endYear);

                $finalResult = [];
                foreach($resultSub25 as $key => $value){
                    $temp = [];
                    $temp["sub25"] = $value["nr_someri"];
                    $temp["an"] = $value["an"];

                    foreach($resultIntre25si29 as $key2 => $value2){
                        if($value2["an"] == $value["an"]){
                            $temp["intre25si29"] = $value2["nr_someri"];
                            break;
                        }
                    }

                    foreach($resultIntre30si39 as $key2 => $value2){
                        if($value2["an"] == $value["an"]){
                            $temp["intre30si39"] = $value2["nr_someri"];
                            break;
                        }
                    }

                    foreach($resultIntre40si49 as $key2 => $value2){
                        if($value2["an"] == $value["an"]){
                            $temp["intre40si49"] = $value2["nr_someri"];
                            break;
                        }
                    }

                    foreach($resultIntre50si55 as $key2 => $value2){
                        if($value2["an"] == $value["an"]){
                            $temp["intre50si55"] = $value2["nr_someri"];
                            break;
                        }
                    }

                    foreach($resultPeste55 as $key2 => $value2){
                        if($value2["an"] == $value["an"]){
                            $temp["peste55"] = $value2["nr_someri"];
                            break;
                        }
                    }


                    array_push($finalResult, $temp);
                }

                $result = $finalResult;

            }
            else $result = -1;
     
            






        if($yAxis == "nr_someri") return json_encode($result);
        else if($yAxis == "rate"){
            if($result == -1 || count($result) == 0) return -1;
            
            if($xAxis == "luni"){
                $allYears = [];
                foreach($result as $key => $value){
                    if(!in_array($value["an"], $allYears)) array_push($allYears, $value["an"]);
                }

                $totalPerYear = [];
                foreach($allYears as $year){
                    $totalPerYear[$year] = ["nr_someri" => 0, "an" => $year];
                }

                foreach($result as $key => $value){
                    $totalPerYear[$value["an"]]["nr_someri"] += $value["nr_someri"];
                }

                $finalResult = [];
                foreach($result as $key => $value){
                    $temp = [];
                    $temp["nr_someri"] = round((intval($value["nr_someri"]) * 100 / $totalPerYear[$value["an"]]["nr_someri"]), 2);
                    $temp["luna"] = $value["luna"];
                    $temp["an"] = $value["an"];
                    array_push($finalResult, $temp);
                }

                // echo "start result:";
                // echo json_encode($result);
                // echo "final result:";
                // echo json_encode($finalResult);
                return json_encode($finalResult);
            }
            else if($xAxis == "ani"){
                $total = 0;
                foreach($result as $key => $value){
                    $total += $value["nr_someri"];
                }

                $finalResult = [];
                foreach($result as $key => $value){
                    $temp = [];
                    $temp["nr_someri"] = round((intval($value["nr_someri"]) * 100 / $total), 2);
                    $temp["an"] = $value["an"];
                    array_push($finalResult, $temp);
                }

                return json_encode($finalResult);
            }
            else if($xAxis == "sex"){
                $totalPerYear = [];

                foreach($result as $key => $value){
                    if(!array_key_exists($value["an"], $totalPerYear)){
                        $totalPerYear[$value["an"]] = 0;
                    }

                    $totalPerYear[$value["an"]] += $value["feminin"] + $value["masculin"];
                }


                $finalResult = [];
                foreach($result as $key => $value){
                    $temp = [];
                    $temp["feminin"] = round(($value["feminin"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["masculin"] = round(($value["masculin"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["an"] = $value["an"];
                    array_push($finalResult, $temp);
                }

                return json_encode($finalResult);
            }
            else if($xAxis == "educatie"){
                $totalPerYear = [];

                foreach($result as $key => $value){
                    if(!array_key_exists($value["an"], $totalPerYear)){
                        $totalPerYear[$value["an"]] = 0;
                    }

                    $totalPerYear[$value["an"]] += $value["fara"] + $value["primar"] + $value["gimnazial"] + $value["liceal"] + $value["postliceal"] + $value["profesional"] + $value["universitar"];
                }

                $finalResult = [];
                foreach($result as $key => $value){
                    $temp = [];
                    $temp["fara"] = round(($value["fara"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["primar"] = round(($value["primar"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["gimnazial"] = round(($value["gimnazial"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["liceal"] = round(($value["liceal"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["postliceal"] = round(($value["postliceal"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["profesional"] = round(($value["profesional"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["universitar"] = round(($value["universitar"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["an"] = $value["an"];
                    array_push($finalResult, $temp);
                }

                return json_encode($finalResult);
            }
            else if($xAxis == "mediu"){
                $totalPerYear = [];

                foreach($result as $key => $value){
                    if(!array_key_exists($value["an"], $totalPerYear)){
                        $totalPerYear[$value["an"]] = 0;
                    }

                    $totalPerYear[$value["an"]] += $value["urban"] + $value["rural"];
                }

                $finalResult = [];
                foreach($result as $key => $value){
                    $temp = [];
                    $temp["urban"] = round(($value["urban"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["rural"] = round(($value["rural"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["an"] = $value["an"];
                    array_push($finalResult, $temp);
                }

                return json_encode($finalResult);
            }
            else if($xAxis == "varsta"){
                $totalPerYear = [];

                foreach($result as $key => $value){
                    if(!array_key_exists($value["an"], $totalPerYear)){
                        $totalPerYear[$value["an"]] = 0;
                    }

                    $totalPerYear[$value["an"]] += $value["sub25"] + $value["intre25si29"] + $value["intre30si39"] + $value["intre40si49"] + $value["intre50si55"] + $value["peste55"];
                }

                $finalResult = [];
                foreach($result as $key => $value){
                    $temp = [];
                    $temp["sub25"] = round(($value["sub25"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["intre25si29"] = round(($value["intre25si29"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["intre30si39"] = round(($value["intre30si39"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["intre40si49"] = round(($value["intre40si49"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["intre50si55"] = round(($value["intre50si55"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["peste55"] = round(($value["peste55"] * 100 / $totalPerYear[$value["an"]]), 2);
                    $temp["an"] = $value["an"];
                    array_push($finalResult, $temp);
                }

                return json_encode($finalResult);
            }
            else return -1;
            
        }

    }

    function getValues($startYear, $endYear, $filtering){
        if(countFilters($filtering) == 0 || countFilters($filtering) == 1)
                    $result = getOverallValuesByYearsAndMonths($startYear, $endYear, $filtering);//theres no need to turn to percentages if theres only one or no filter; get the basic values already provided
                    else $result = getOverallPrecentagesByYearsAndMonths($startYear, $endYear, $filtering);
                    
        return formatToGraphInput($result, $filtering);
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






    
?>
