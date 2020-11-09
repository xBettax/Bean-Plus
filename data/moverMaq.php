<?php
    include 'conexion/db.php';
    $db = new DB();
    $codMaq = isset($_POST["codMaq"]) ? $_POST["codMaq"] : null;
    $local = isset($_POST["local"]) ? $_POST["local"] : null;

    try{
 
        $db = new DB();
        $conn = $db->Open();
        if($conn){
            $query ="UPDATE maquinas SET fk_local= $local where codigo = $codMaq";
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