<?php
    include 'conexion/db.php';
    $db = new DB();
    $codigo = isset($_POST["cod"]) ? $_POST["cod"] : "" ;

    $out = "<tr>";
    foreach ($db->read("SELECT * FROM cortes INNER JOIN maquinas ON cortes.fk_maquina = maquinas.id INNER JOIN locales ON maquinas.fk_local = locales.id WHERE maquinas.codigo LIKE '%$codigo%' OR maquinas.id_maquina LIKE '%$codigo%'  ORDER BY fecha DESC") as $row) {
        $out .= "<td><a href='#' name='update' id='". $row["codigo"] ."'>".$row['codigo']."</a></td>";
        $out .= "<td>".$row['id_maquina']."</td>";
        $out .= "<td>".$row['nombre']."</td>";
        $out .= "<td>".$row['fecha']."</td>";
        $out .= "<td>".$row['semana']."</td>";
        $out .= "<td>".$row['totalin']."</td>";
        $out .= "<td>".$row['totalout']."</td>";
        $out .= "<td>".$row['utilidad']."</td>";
        $out .= "<td>".$row['entrada']."</td>";
        $out .= "<td>".$row['salida']."</td>";
        $out .= "<td>".$row['activacion']."</td>";
        echo $out . "</tr>";
        $out="";
    }
    $db->Close();
?>    



