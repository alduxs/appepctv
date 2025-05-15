<?php
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
//
include_once('includes/class.inc.php');
//
$link = Conectarse();
//
$objContenido = new General();
//
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
//

$Uploads = new iUpload;
//$target_path = _CONST_PATH_I_ARCH_;

function preprocesarExcel($archivo)
{
    $nombreArchivo = "files/" . $archivo;
    $spreadsheet = IOFactory::load($nombreArchivo);
    //obtenemos los datos de la hoja activa (la primera)
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    unlink($nombreArchivo);
    return $sheetData;
}
// Escribir CSV
function writeCsv($datos)
{
    $fichero = "files/ingresantes.csv";
    $fp = fopen($fichero, 'w');
    $largo = count($datos) + 1;

    for ($i = 4; $i < $largo; $i++) {
        $nombreApellido = $datos[$i]["A"];
        $porciones = explode(",", $nombreApellido);
        $dni = $datos[$i]["B"];
        $porcionesDni = explode("-", $dni);
        /*$line = $datos[$i]["A"].";".$porciones[1].";".$porciones[0].";".$datos[$i]["C"].";".$datos[$i]["D"].";".$datos[$i]["E"].";".$datos[$i]["F"].";".$datos[$i]["G"].";".$datos[$i]["H"].";".$datos[$i]["I"].";".$datos[$i]["J"].PHP_EOL;*/
        $line = trim($porciones[1]) . ";" . trim($porciones[0]) . ";" . trim($porcionesDni[1]) . ";" . trim($datos[$i]["C"]) . ";" . trim($datos[$i]["D"]) . PHP_EOL;
        fwrite($fp, $line);
    }

    // closing the file 
    fclose($fp);
}

if ($_FILES['archivo']['name'] != "") {
    $strImg = $Uploads->renameFile($_FILES['archivo']['name']);
    if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
        move_uploaded_file($_FILES['archivo']['tmp_name'], "files/" . $strImg);
        $archivo = $strImg;
        $datosExc = preprocesarExcel($archivo);
        writeCsv($datosExc);
    } else {
        $archivo = "nd";
    }
}



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - <?php echo _CONST_TITLE_ ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css//bootstrap-table.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet" type="text/css">
</head>


<body>

    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <?php include_once('includes/columnaTop.inc.php'); ?>
                    <?php include_once('includes/columnaLeft.inc.php'); ?>
                </ul>
            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li><a href="logout.php"><i class="fa fa-sign-out"></i> Log out</a></li>
                    </ul>
                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-12">
                    <h2>Importar Alumnos - Paso 2</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php?seccion=inicio">Home</a></li>
                        <li><a href="#">Importar Alumnos</a></li>
                        <li class="active"><strong>Importar Alumnos - Paso 2</strong></li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Primeros 10 resultados</h5>
                            </div>
                            <div class="ibox-content">
                                <form action="importAlumnosStep3.php?seccion=alumnos&page=lstAlumnos" method="post" enctype="multipart/form-data" name="form1">
                                    <input type="hidden" name="strOperacion" value="I" />
                                    <input type="hidden" name="idusuario" value="0">



                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre y Apellido</th>
                                                <th>N° documento</th>
                                                <th>Teléfono</th>
                                                <th>E-mail</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php for ($i = 4; $i < 14; $i++) {
                                            ?>

                                                <tr>
                                                    <td><?php echo $datosExc[$i]["A"]; ?></td>
                                                    <td><?php echo $datosExc[$i]["B"]; ?></td>
                                                    <td><?php echo $datosExc[$i]["C"]; ?></td>
                                                    <td><?php echo $datosExc[$i]["D"]; ?></td>

                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>




                                    <!-- Fin Home -->
                                    <div class="form-group text-center">
                                        <input name="agregar" type="submit" class="btn btn-primary" id="agregar" value="Enviar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="footer">
                <div>&copy; 2014 - <?php echo date("Y") ?></div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="contenido-modal">

            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Table -->
    <script src="js/tableExport.min.js"></script>
    <script src="js/bootstrap-table.js"></script>
    <script src="js/bootstrap-table-locale-all.js"></script>
    <script src="js/extensions/export/bootstrap-table-export.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script type="text/javascript">
        function delRegistro(pIdRegistro, pDsArchivo, strDb, intPage) {
            if (!window.confirm("Esta seguro que desea borrar este registro?")) {
                return;
            } else {
                document.frm.intIdRegistro.value = pIdRegistro;
                document.frm.strDb.value = strDb;
                document.frm.Archivo.value = pDsArchivo;
                document.frm.intPage.value = intPage;
                document.frm.submit();
            }
        }

        function openModal(idregistro) {
            $.ajax({
                    method: "POST",
                    url: "detalleRegistro.php",
                    data: {
                        idregistro: idregistro,
                        tipo: 2 //1:Profesosres 2:Alumnos 3:Usuarios
                    }
                })
                .done(function(data) {
                    $("#contenido-modal").html(data);
                    $('#myModal').modal();
                });

        }
    </script>
</body>

</html>