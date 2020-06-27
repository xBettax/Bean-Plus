<?php
    include 'data/conexion/db.php';
    include 'data/setSemana.php';
    $db = new DB(); 
?>

<!DOCTYPE html>
<html lang="en">
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
    <script type="text/javascript">
    function SelectText(element) {
                var doc = document;
                if (doc.body.createTextRange) {
                    var range = document.body.createTextRange();
                    range.moveToElementText(element);
                    range.select();
                } else if (window.getSelection) {
                    var selection = window.getSelection();
                    var range = document.createRange();
                    range.selectNodeContents(element);
                    selection.removeAllRanges();
                    selection.addRange(range);
                }
            }
            $("#img").click(function (e) {
                //Make the container Div contenteditable
                $(this).attr("contenteditable", true);
                //Select the image
                SelectText($(this).get(0));
                //Execute copy Command
                //Note: This will ONLY work directly inside a click listenner
                document.execCommand('copy');
                //Unselect the content
                window.getSelection().removeAllRanges();
                //Make the container Div uneditable again
                $(this).removeAttr("contenteditable");
                //Success!!
                alert("image copied!");
            });

      $(function() { 
          $("#crearimagen").click(function() { 
              html2canvas($("#nuevoCorte"), {
                  onrendered: function(canvas) {
                      theCanvas = canvas;
                      $("#img").append(canvas);
                      $("#img").click();
                      $("#crearimagen").hide();
                  }
              });
          });
      });
    </script>
    <title>Beanstalk Plus</title>
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
                        <label for="totalin">Total In:</label>
                        <input type="number" name="totalin" class="form-control" id="totalin" placeholder="Total In">
                    </div>
                    <div class="form-group">
                        <label for="totalout">Total Out:</label>
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
                <h3>Maquinas</h3>
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
                    <label for="idMaq">ID Codigo:</label>
                    <input type="number" name="idMaq" class="form-control" id="idMaq" placeholder="Ingrese ID de la Maquina">
                    <label for="LocMaq">Local: </label>
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
          <button type="button" class="close" data-dismiss="modal">&times;</button>
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