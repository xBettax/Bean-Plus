<?php
    include 'conexion/db.php';
    $db = new DB();
    $codigo = isset($_POST["codigo"]) ? $_POST["codigo"] : null;
    $totalin = isset($_POST["totalin"]) ? $_POST["totalin"] : null;
    $totalout = isset($_POST["totalout"]) ? $_POST["totalout"] : null;
    $code = isset($_POST["code"]) ? $_POST["code"] : null;
    $day=['D','L','M','X','J','V','S'];
    $hoy = getdate();
    $semana = $day[$hoy["wday"]]."-";

    $utilidad = ($totalin - $totalout)/10;
    $entrada = $totalin/10;
    $salida = $totalout/10;

    foreach ($db->read("SELECT nSemana FROM semana ORDER BY id DESC LIMIT 1") as $s) {
        $semana .= $s['nSemana'];
    }

    $db->Close();
    
    foreach ($db->read("SELECT entrada, salida FROM cortes WHERE fk_maquina = $codigo ORDER BY id DESC LIMIT 1") as $r){
        $entrada = $r["entrada"]+($totalin/10);
        $salida = $r["salida"]+($totalout/10);
    }

    try{
 
        $db = new DB();
        $conn = $db->Open();
        if($conn){
            $query = "INSERT INTO `cortes` VALUES (null,$codigo,'$semana',null,$totalin,$totalout,$utilidad,'$entrada','$salida','$code')";
            $conn->query($query);
        }
        else{
            echo $conn;
        }
    }
    catch(PDOException $ex){
        echo $ex->getMessage();
    }

    foreach ($db->read("SELECT codigo FROM maquinas WHERE id = $codigo ORDER BY id DESC LIMIT 1") as $p){
        $codigo = $p["codigo"];
    }
    
    echo "$codigo,$entrada,$salida,$utilidad,$code";
    $db->Close();
?>