<?php
    $db = new DB();

    $semana = "";
    $flag = "";
    
    $hoy = getdate();

    if($hoy["wday"] == 1){
        foreach ($db->read("SELECT nSemana,flag FROM semana ORDER BY id DESC LIMIT 1") as $row) {
            $semana = ($row['nSemana'] + 1);
            $flag = $row['flag'];
        } 
        
        if($flag == 0){
            insert("INSERT INTO `semana` VALUES (null,$semana,1)");
        }
    }else{
        insert("UPDATE `semana` SET flag = 0");
    }

    function insert($query){
        $db = new DB();

        try{
            $conn = $db->Open();
            if($conn){
                $conn->query($query);
            }
            else{
                echo $conn;
            }
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }
?>
