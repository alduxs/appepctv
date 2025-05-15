<?php
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
//
include_once('includes/class.inc.php');
//
$link = Conectarse();
//
$intIdCont = sanInt($_GET["id"]);
//
//$intPage = sanInt($_GET["intPage"]);
//
$objContenido = new General();
$query = "SELECT * FROM combos WHERE cb_id =" . $intIdCont;
$rsCont = $objContenido->getAllContenido($link, $query);
$arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
//
$query2 = "SELECT ce.*,ec.*
           FROM combos_equipos ce
           LEFT JOIN equipo_clases ec ON ec.ecl_id = ce.ce_id_tipo_equipo
           WHERE ce.ce_id_combo =" . $intIdCont;
$rsCont2 = $objContenido->getAllContenido($link, $query2);

$valores = array();
$cantidad = 0;
$orden = "";

while ($arrContenido2 = $rsCont2->fetch(PDO::FETCH_BOTH)) {
    $value = ['id'=>$arrContenido2["ecl_id"],'nombre'=> $arrContenido2["ecl_nombre"],'posicion'=> $cantidad];
    array_push($valores,$value);
    if($cantidad == 0){
        $orden .= $arrContenido2["ecl_id"];
    } else {
        $orden .= ",".$arrContenido2["ecl_id"];
    }
    $cantidad ++;
}

?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - <?php echo _CONST_TITLE_ ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dropzone.css" />
    <link rel="stylesheet" href="css/cropper.css" />
    <link href="css/image.css" rel="stylesheet" type="text/css">
    <link href="css/estilos.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <style>
        .claseequipo {
            width: 100%;
            background: #f4f4f4;
            display: inline-block;
            margin-bottom: 10px;
            padding: 10px 15px;
            border: 1px solid #ccc;
        }

        .claseequipo div {
            display: inline-block;
        }

        .claseequipo .nombre {
            font-weight: 700;
        }

        .borrar-btn {
            float: right;
            border-radius: 3px;
            background-color: #1ab394;
            border-color: #1ab394;
            color: #FFFFFF;
            padding: 5px 8px;
            cursor: pointer;
        }
    </style>
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
                    <h2>Modificar Combo</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php?seccion=inicio">Home</a></li>
                        <li><a href="#">Combos</a></li>
                        <li class="active"><strong>Modificar combo</strong></li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <form action="svCombos.php" method="post" enctype="multipart/form-data" name="form1">
                                    <input type="hidden" name="strOperacion" value="U" />
                                    <input name="id" type="hidden" id="id" value="<?php echo $intIdCont ?>">
                                    <!--<input type="hidden" name="intPage" value="<?php echo $intPage ?>" />-->
                                    <input type="hidden" name="cantidadModulos" value="<?php echo $cantidad; ?>" id="cantidadModulos">
                                    <input type="hidden" name="ordenModulos" id="ordenModulos" value="<?php echo $orden; ?>">

                                    <!-- Título -->
                                    <div class="form-group col-xs-12">
                                        <label for="nombre">Título</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $arrCont["cb_nombre"]; ?> ">
                                    </div>
                                    <div class="hr-line-dashed col-xs-12"></div>

                                    <!-- Contenedor general de modulo -->
                                    <div id="contenedor-modulos">
                                        
                                        <?php for ($i=0; $i < count($valores); $i++) { ?>
                                            <div class="claseequipo" id="<?php echo $valores[$i]["id"]; ?>">
                                                <div class="nombre"><?php echo $valores[$i]["nombre"]; ?></div>
                                                <div class="borrar-btn" onclick="borrarMod(<?php echo $valores[$i]["id"]; ?>,<?php echo $valores[$i]["posicion"]; ?>)"><i class="fa fa-remove" aria-hidden="true"></i></div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <!-- Fin de contenedor general de modulo -->

                                    <!-- Agregar Módulo -->
                                    <div class="form-group col-xs-12 text-center">
                                        <button type="button" class="btn btn-w-m btn-primary" id="agregarmod">Agregar Equipo</button>
                                    </div>
                                    <div class="hr-line-dashed col-xs-12"></div>

                                    <!-- Publicado -->
                                    <div class="form-group col-xs-12">
                                        <label for="publicado">Activo</label>
                                        <p><label class="checkbox-inline i-checks"> <input type="radio" value="1" name="publicado" <?php if (!(strcmp($arrCont["cb_estado"], 1))) {echo "checked=\"checked\"";} ?>> <i></i> Si </label><label class="checkbox-inline i-checks"> <input name="publicado" type="radio" value="0" <?php if (!(strcmp($arrCont["cb_estado"], 0))) {echo "checked=\"checked\"";} ?>> <i></i> No </label></p>
                                    </div>
                                    <div class="hr-line-dashed col-xs-12"></div>


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
    <!-- Mainly scripts -->
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <!-- Tinymce -->
    <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
    <!-- Data picker -->
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="js/dropzone.js"></script>
    <script src="js/cropper.js"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>

    <script src="js/customup-sl.js"></script>

    <script>
        var idModAcyual = $("#cantidadModulos").val();
        var idModulo = parseInt(idModAcyual);
        var ordenActual = $("#ordenModulos").val();
        
        var didision = ordenActual.split(",");
        console.log(didision);
        var ordenModulo = didision;

        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });


            $('#data_1 .input-group.date').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true
            });

        });

        $('#agregarmod').click(function() {
            $('#modal').modal('show');
        });

        function clonarMod() {
            var id = $("#clase").val();

            $.post("armaCombo2.php", {
                    id: id,
                    posicion: idModulo
                })
                .done(function(data) {

                    $("#contenedor-modulos").append(data);


                    var cantidad = idModulo + 1;
                    $("#cantidadModulos").val(cantidad);
                    ordenModulo.push(id);
                    $("#ordenModulos").val(ordenModulo);

                    idModulo++;

                });

        }

        function borrarMod(id, posicion) {
            //Remuevo el bloque 
            $("#" + id).remove();
            //Reduzco el numero de modulos
            var cantidad = $("#cantidadModulos").val();
            cantidad = cantidad - 1;
            $("#cantidadModulos").val(cantidad);
            //Cambio el valor en el array
            ordenModulo.splice(posicion, 1, -1);
            $("#ordenModulos").val(ordenModulo);

        }
    </script>
    <!-- *********************************** MODALS *********************************-->

    <!-- Modal imagen grande -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Selecionar calse de equipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">

                            <div class="form-group col-xs-12">

                                <select name="clase" class="form-control" id="clase">

                                    <option value="0" selected>Elegir clase de equipo</option>
                                    <?php
                                    $query = "SELECT ec.* ,ecr.*
                                    FROM equipo_clases ec
                                    LEFT JOIN equipos_clases_relacion ecr ON ecr.eqr_id_clase = ec.ecl_id
                                    WHERE ecr.eqr_id_padre > 0
                                    ORDER BY ecr.eqr_id_grupo ASC, ecr.eqr_id_padre ASC, ec.ecl_nombre ASC";
                                    $rsCont = $objContenido->getAllContenido($link, $query);
                                    ?>
                                    <?php while ($arrPost = $rsCont->fetch(PDO::FETCH_BOTH)) { ?>
                                        <option value="<?php echo $arrPost["ecl_id"] ?>"><?php echo $arrPost["ecl_nombre"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group text-center">
                                <button type="button" name="agregarclase" class="btn btn-primary" id="agregarclase" onclick="clonarMod()">Agregar</button>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- *********************************** FIN MODALS *********************************-->
</body>

</html>
<?php
$link = null;
?>