<?php
    DEFINE("DB_SERVER", "localhost");
    DEFINE("DB_USERNAME", "root");
    DEFINE("DB_PASSWORD", "");
    DEFINE("DB_NAME", "shopeedb");
    function openConnection(){
        $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if($con === false){
            die("ERROR: Could not Connect : " . mysqli_connect_error());
        }

        return $con;
    }

    function closeConnections($con){
        mysqli_close($con);
    }

    function getRecord($con, $strSQL){
        $arrRec = [];
        $count = 0;

        if ($rs = mysqli_query($con, $strSQL)){
            if(mysqli_num_rows($rs) === 1){
                $rec = mysqli_fetch_array($rs);
                foreach ($rec as $key => $value) {
                    $arrRec[$count][$key] = $value;
                }
            }
            else if(mysqli_num_rows($rs) > 1){
                while($rec = mysqli_fetch_array($rs)){
                    foreach ($rec as $key => $value) {
                        $arrRec[$count][$key] = $value;
                    } 
                    $count++;   
                }
            }
            mysqli_free_result($rs);
        }
        else{
            die("ERROR: Could not execute your request!");
        }
        return $arrRec;
    }


    function executeInsertLastIDQuery($con, $strSQL){
        if(mysqli_query($con, $strSQL)){
            return mysqli_insert_id($con);
        }
        else{
            return 0;
        }
    }

    function sanitizeInputs($con, $input){
        return mysqli_real_escape_string($con, stripslashes(htmlspecialchars($input)));
    }

?>