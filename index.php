<?php
    include 'data/conexion/db.php';
    include 'data/setSemana.php';
    $db = new DB(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <script src="js/functions.js"></script>
    <script src="js/filesaver.js" type="text/javascript"></script>
    <script src="js/html2canvas.js" type="text/javascript"></script>
    <title>Cortes Bean Plus</title>
</head>
<body>
    <div class="formulario">
        <div class="card">
            <div class="card-header text-center">
                <h2>Agregar Corte</h2>   
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="codigo">Codigo:</label>
                        <select class="form-control" id="codigo" name="codigo">
                            <option disabled selected value="0">Selecciona el codigo de la maquina</option>
                            <?php
                                foreach ($db->read("SELECT id, CONCAT(codigo,' - ', id_maquina) AS nombre FROM maquinas ORDER BY codigo") as $row) {
                                    echo "<option value='".$row['id']."'>". $row['nombre'] . "</option>";
                                }
                                $db->Close();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="totalin">Entrada Total:</label>
                        <input type="number" name="totalin" class="form-control" id="totalin" placeholder="Total In">
                    </div>
                    <div class="form-group">
                        <label for="totalout">Salida Total:</label>
                        <input type="number" name="totalout" class="form-control" id="totalout" placeholder="Total Out">
                    </div>
                    <div class="form-group">
                        <label for="code">Codigo Activacion:</label>
                        <input type="number" name="code" class="form-control" id="code" placeholder="Codigo Activacion">
                    </div>
                    <div class="card-footer text-center">
                        <button id="guardar" value="submit" class="btn btn-primary col-sm">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card maquinas">
            <div class="card-header">
                <h3>Buscar Maquinas</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="search">Codigo:</label>
                    <input type="number" name="search" class="form-control" id="search" placeholder="Ingrese Codigo a ID de ma Maquina">
                </div>
            </div>
        </div>

        <div class="card maquinas">
        <div class="card-header">
                <h3>Agregar Maquina</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="codMaq">Codigo:</label>
                    <input type="codM" name="search" class="form-control" id="codMaq" placeholder="Ingrese Codigo de la Maquina">
                    <label for="idMaquina">ID Codigo:</label>
                    <input type="number" name="idMaq" class="form-control" id="idMaq" placeholder="Ingrese ID de la Maquina">
                    <label for="LocMaq">Local:</label>
                        <select class="form-control" id="local" name="local">
                            <option disabled selected value="0">Seleccionar</option>
                            <?php
                                foreach ($db->read("SELECT * FROM locales") as $row) {
                                    echo "<option value='".$row['id']."'>". $row['nombre'] . "</option>";
                                }
                                $db->Close();
                            ?>
                        </select>
                    <div class="card-footer text-center">
                        <button id="agregar" value="submit" class="btn btn-primary col-sm">Agregar</button>
                    </div>
                </div>
            </div>  
        </div>

        <div class="card maquinas">
        <div class="card-header">
                <h3>Mover Local</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="codMaq">Codigo:</label>
                    <select class="form-control" id="codigom" name="codigo">
                            <option disabled selected value="0">Selecciona el codigo de la maquina</option>
                            <?php
                                foreach ($db->read("SELECT id, CONCAT(codigo,' - ', id_maquina) AS nombre FROM maquinas ORDER BY codigo") as $row) {
                                    echo "<option value='".$row['id']."'>". $row['nombre'] . "</option>";
                                }
                                $db->Close();
                            ?>
                        </select>
                    <label for="LocMaq">Local:</label>
                        <select class="form-control" id="localm" name="local">
                            <option disabled selected value="0">Seleccionar Local</option>
                            <?php
                                foreach ($db->read("SELECT * FROM locales") as $row) {
                                    echo "<option value='".$row['fk_local']."'>". $row['nombre'] . "</option>";
                                }
                                $db->Close();
                            ?>
                        </select>
                    <div class="card-footer text-center">
                        <button id="mover" value="submit" class="btn btn-primary col-sm">Mover</button>
                    </div>
                </div>
            </div>  
        </div>

    </div>
    <div class="datos">
        <div class="card">
            <div class="card-header">
            <h2 class="float-left">Registro de Datos</h2>
                <?php
                    $semana = "";
                    foreach ($db->read("SELECT nSemana,flag FROM semana ORDER BY id DESC LIMIT 1") as $row) {
                        $semana = ($row['nSemana']);
                    }
                    echo "<h2 class='float-right'>Semana = $semana</h2>";
                ?>
            </div>
            <div class="card-body">
                <table class="table table-dark table-striped text-center table-borderless table-responsive-lg">
                    <thead>
                      <tr>
                        <th>Codigo</th>
                        <th>ID</th>
                        <th>Local</th>
                        <th>Fecha</th>
                        <th>Semana</th>
                        <th>Total In</th>
                        <th>Total Out</th>
                        <th>Utilidad</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Activacion</th>
                    </thead>
                    <tbody id="view">
                        <tr>
                            <td>
                            </td>
                        </tr>
                          
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <button id="modal" data-toggle="modal" data-target="#myModal" hidden></button>
    <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
      
       <!-- Modal Header -->
       <div class="modal-header">
          <h4 class="modal-title">Nuevos Contadores</h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body text-center" id="nuevoCorte">
            <table class="table table-striped text-center table-bordered" id="crearimagen">
                    <thead>
                      <tr>
                        <th>Codigo</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Utilidad</th>
                        <th>Codigo Activacion</th>
                      </tr>
                    </thead>
                    <tbody id="nCorte">    
                    </tbody>
                  </table>
                  <div id="img" class="text-center"></div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
</body>
</html>