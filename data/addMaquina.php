<?php
    include 'conexion/db.php';
    $db = new DB();
    $codMaq = isset($_POST["codMaq"]) ? $_POST["codMaq"] : null;
    $idMaq = isset($_POST["idMaq"]) ? $_POST["idMaq"] : null;
    $local = isset($_POST["local"]) ? $_POST["local"] : null;

    try{
 
        $db = new DB();
        $conn = $db->Open();
        if($conn){
            $query = "INSERT INTO `maquinas` VALUES (null,$codMaq,$idMaq,$local)";
            $conn->query($query);
        }
        else{
            echo $conn;
        }
    }
    catch(PDOException $ex){
        echo $ex->getMessage();
    }

    $db->Close();


?>