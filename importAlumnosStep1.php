<?php
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
//
include_once('includes/class.inc.php');
//
$link = Conectarse();
$objContenido = new General();
?>
<!DOCTYPE HTML>
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
                    <h2>Importar Alumnos - Paso 1</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php?seccion=inicio">Home</a></li>
                        <li><a href="#">Alumnos</a></li>
                        <li class="active"><strong>Importar Alumnos - Paso 1</strong></li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <form method="post" action="importAlumnosStep2.php?seccion=alumnos&page=lstAlumnos" enctype="multipart/form-data" name="form1" id="form1">
                                    <input type="hidden" name="idusuario" value="<?php echo $_SESSION["id"]; ?>">

                                    <!-- Nombre -->
                                    <div class="form-group col-xs-12">
                                        <label for="omitfilas">Filas a ignorar desde la parte superior del archivo excel</label>
                                        <input class="form-control" type="number" name="omitfilas" id="omitfilas" value="0">
                                    </div>
                                    <div class="hr-line-dashed col-xs-12"></div>

                                    <!-- Apellido -->
                                    <div class="form-group col-xs-12">
                                        <label for="xlsLista">Seleccione un archivo Excel</label>
                                        <input class="form-control" type="file" name="archivo" id="archivo" step="" value="" style="text-align:left;" maxlength="" placeholder="Seleccione un archivo" alt="Seleccione un archivo" title="Seleccione un archivo" autofocus="">
                                    </div>
                                    <div class="hr-line-dashed col-xs-12"></div>

                                    
                                    <div class="form-group text-center">
                                        <input name="agregar" type="submit" class="btn btn-primary" id="agregar" value="Agregar">
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