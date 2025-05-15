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
$intIdCont = sanInt($_GET["id"]);
//
//LIMPIA TABLA TEMPORAL
$queryClean1 = "SELECT * FROM pedidos_equipos_temp";
$rsContClean1 = $objContenido->getAllContenido($link, $queryClean1);
$intQtyRecords = $rsContClean1->rowCount();
if($intQtyRecords > 0){
    $queryClean = "TRUNCATE TABLE pedidos_equipos_temp";
    $rsContClean = $objContenido->getAllContenido($link, $queryClean);
}
// FIN LIEMPIEZA TABLA TEMPORAL
//
$query = "SELECT * FROM pedidos WHERE pedidos_id=" . $intIdCont;
$rsCont = $objContenido->getAllContenido($link, $query);
$arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
//MATERIAS
$queryMat = "SELECT * FROM pedidos_detalle WHERE pd_id_pedido = " . $intIdCont . " AND pd_tipo = 1";
$rsContMat = $objContenido->getAllContenido($link, $queryMat);
$arrContMat = $rsContMat->fetch(PDO::FETCH_BOTH);
//PROFESOR
$queryProf = "SELECT * FROM pedidos_detalle WHERE pd_id_pedido = " . $intIdCont . " AND pd_tipo = 2";
$rsContProf = $objContenido->getAllContenido($link, $queryProf);
$arrContProf = $rsContProf->fetch(PDO::FETCH_BOTH);


//Comision y Turno
$queryDet = "SELECT * FROM pedidos_detalle2 WHERE pd2_id_pedido = " . $intIdCont;
$rsContDet = $objContenido->getAllContenido($link, $queryDet);
$arrContDet = $rsContDet->fetch(PDO::FETCH_BOTH);

//EQUIPOS
$queryEqip = "SELECT peq.*,eq.*
            FROM pedidos_equipos peq
            LEFT JOIN equipos eq ON eq.eq_id = peq.pe_id_equipo
            WHERE peq.pe_id_pedido = " . $intIdCont . "
            ORDER BY eq.eq_clase ASC, eq.eq_subclase ASC, eq.eq_nombre ASC";;
$rsContEqip = $objContenido->getAllContenido($link, $queryEqip);

$idtemp =  date('l jS \of F Y h:i:s A') . $_SESSION["id"];
$idtemp = md5($idtemp);

$equipos = array();
$contador = 0;
$orden = "";
while ($arrContenidoEq = $rsContEqip->fetch(PDO::FETCH_BOTH)) {
    $arrData[0] = '';
    $arrData[1] = $idtemp;
    $arrData[2] = $arrContenidoEq["eq_id"];
    //


    $query = "INSERT INTO pedidos_equipos_temp (pe_id_pedido_temp,pe_id_equipo) VALUES (?,?)";
    $intIdRegistro = $objContenido->insertContenido($link, $arrData, $query); //Registro de página

    $lines = ["id" => $arrContenidoEq["eq_id"], "nombre" => $arrContenidoEq["eq_nombre"], "idregistro" => $intIdRegistro];
    array_push($equipos, $lines);

    if ($contador == 0) {
        $orden .= $arrContenidoEq["eq_id"];
    } else {
        $orden .= "," . $arrContenidoEq["eq_id"];
    }


    $contador++;
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
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dropzone.css" />
    <link rel="stylesheet" href="css/cropper.css" />
    <link href="css/image.css" rel="stylesheet" type="text/css">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/amsify.suggestags.css">
    <link href="css/estilos.css" rel="stylesheet" type="text/css">

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

        .alerta-eqocupado {
            background-color: #e3dbdb;
            border: 1px solid #ff0000;
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
                    <h2>Duplicar Pedido</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php?seccion=inicio">Home</a></li>
                        <li><a href="#">Pedidos</a></li>
                        <li class="active"><strong>Duplicar Pedido</strong></li>
                    </ol>
                </div>
            </div>



            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <form method="post" action="svPedidos.php" enctype="multipart/form-data" name="form1" id="form1">
                                    <input type="hidden" name="strOperacion" value="I" />
                                    <input name="id" type="hidden" id="id" value="<?php echo $intIdCont ?>">

                                    <input type="hidden" name="idtemporal" id="idtemporal" value="<?php echo $idtemp; ?>">

                                    <input type="hidden" name="cantidadModulos" value="<?php echo $contador; ?>" id="cantidadModulos">
                                    <input type="hidden" name="ordenModulos" id="ordenModulos" value="<?php echo $orden; ?>">


                                    <!-- Todos los paneles -->
                                    <div class="paneles-g" style="display: inline-block;">
                                        <!-- Datos principales-->
                                        <div class="panel-p" id="p1">

                                            <!-- Título -->
                                            <div class="form-group col-xs-12">
                                                <label for="nombre">Título</label>
                                                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $arrCont["pedidos_nombre"]; ?> - Duplicado">
                                            </div>
                                            <div class="hr-line-dashed col-xs-12"></div>

                                            <!-- Clase -->
                                            <div class="form-group col-xs-12">
                                                <label for="materia">Materia</label>
                                                <select name="materia" class="form-control" id="materia">

                                                    <option value="">Seleccionar materia</option>
                                                    <?php
                                                    $queryPost = "SELECT * FROM data_materia
                                                    ORDER BY materia_nombre ASC, materia_id ASC";
                                                    $rsPost = $objContenido->getAllContenido($link, $queryPost);
                                                    ?>
                                                    <?php while ($arrPost = $rsPost->fetch(PDO::FETCH_BOTH)) { ?>
                                                        <option value="<?php echo $arrPost["materia_id"] ?>" <?php if ($arrPost["materia_id"] == $arrContMat["pd_id_registro"]) { ?>selected<?php } ?>><?php echo $arrPost["materia_nombre"] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="hr-line-dashed col-xs-12"></div>

                                            <!-- Clase -->
                                            <div class="form-group col-xs-12">
                                                <label for="docente">Profesor</label>
                                                <select name="docente" class="form-control" id="docente">

                                                    <option value="">Seleccionar Profesor</option>
                                                    <?php
                                                    $queryPost = "SELECT *
                                                    FROM data_profesores
                                                    ORDER BY profesores_apellido ASC, profesores_name ASC, profesores_id ASC";
                                                    $rsPost = $objContenido->getAllContenido($link, $queryPost);
                                                    ?>
                                                    <?php while ($arrPost = $rsPost->fetch(PDO::FETCH_BOTH)) { ?>
                                                        <?php var_dump($arrPost); ?>
                                                        <option value="<?php echo $arrPost["profesores_id"] ?>" <?php if ($arrPost["profesores_id"] == $arrContProf["pd_id_registro"]) { ?>selected<?php } ?>><?php echo $arrPost["profesores_apellido"] . " " . $arrPost["profesores_name"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="hr-line-dashed col-xs-12"></div>

                                            <!-- Clase -->
                                            <div class="form-group col-xs-12">
                                                <label for="responsable">Responsable</label>
                                                <select name="responsable" class="form-control" id="responsable">

                                                    <option value="">Seleccionar Estudiante</option>
                                                    <?php
                                                    $queryPost = "SELECT * FROM data_estudiantes
                                                    ORDER BY estudiantes_apellido ASC,estudiantes_name ASC,  estudiantes_id ASC";
                                                    $rsPost = $objContenido->getAllContenido($link, $queryPost);
                                                    ?>
                                                    <?php while ($arrPost = $rsPost->fetch(PDO::FETCH_BOTH)) { ?>
                                                        <option value="<?php echo $arrPost["estudiantes_id"] ?>"><?php echo $arrPost["estudiantes_name"] . " " . $arrPost["estudiantes_apellido"] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="hr-line-dashed col-xs-12"></div>

                                            <!-- Clase -->
                                            <div class="form-group col-xs-12">
                                                <label for="integrantes">Integrantes</label>
                                                <!--<select name="integrantes" class="form-control" id="integrantes">-->
                                                <select data-placeholder="Seleccionar Estudiantes..." name="integrantes[]" class="chosen-select form-control" id="integrantes" multiple>

                                                    <option value="">Seleccionar Estudiante</option>
                                                    <?php
                                                    $queryPost = "SELECT * FROM data_estudiantes
                                                    ORDER BY estudiantes_apellido ASC,estudiantes_name ASC,  estudiantes_id ASC";
                                                    $rsPost = $objContenido->getAllContenido($link, $queryPost);
                                                    //
                                                    ?>
                                                    <?php while ($arrPost = $rsPost->fetch(PDO::FETCH_BOTH)) { ?>
                                                        <option value="<?php echo $arrPost["estudiantes_id"] ?>"><?php echo $arrPost["estudiantes_apellido"] . " " . $arrPost["estudiantes_name"] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="hr-line-dashed col-xs-12"></div>

                                            <!-- Curso -->
                                            <div class="form-group col-xs-6">
                                                <label for="curso">Curso</label>
                                                <select name="curso" class="form-control" id="curso">

                                                    <option value="" <?php if ($arrContDet["pd2_curso"] == 0) { ?>selected<?php } ?>>Seleccionar Curso</option>
                                                    <option value="1" <?php if ($arrContDet["pd2_curso"] == 1) { ?>selected<?php } ?>>1º</option>
                                                    <option value="2" <?php if ($arrContDet["pd2_curso"] == 2) { ?>selected<?php } ?>>2º</option>
                                                    <option value="3" <?php if ($arrContDet["pd2_curso"] == 3) { ?>selected<?php } ?>>3º</option>
                                                    <option value="4" <?php if ($arrContDet["pd2_curso"] == 4) { ?>selected<?php } ?>>4º</option>

                                                </select>
                                            </div>


                                            <!-- Comisión -->
                                            <div class="form-group col-xs-6">
                                                <label for="comision">Comisión</label>
                                                <select name="comision" class="form-control" id="comision">

                                                    <option value="" <?php if ($arrContDet["pd2_comision"] == 0) { ?>selected<?php } ?>>Seleccionar Comisión</option>
                                                    <option value="1" <?php if ($arrContDet["pd2_comision"] == 1) { ?>selected<?php } ?>>Nº 1</option>
                                                    <option value="2" <?php if ($arrContDet["pd2_comision"] == 2) { ?>selected<?php } ?>>Nº 2</option>
                                                    <option value="3" <?php if ($arrContDet["pd2_comision"] == 3) { ?>selected<?php } ?>>Nº 3</option>

                                                </select>

                                            </div>

                                            <div class="hr-line-dashed col-xs-12"></div>


                                            <!-- Fecha In -->
                                            <div class="form-group col-xs-6" id="data_1">
                                                <label>Fecha Retiro</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="" name="fechain" id="fechain">
                                                </div>
                                            </div>

                                            <div class="form-group col-xs-6">
                                                <label>Hora Retiro</label>
                                                <div class="input-group clockpicker" data-autoclose="true">
                                                    <input type="text" class="form-control" name="horain" value="" id="horain">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-clock-o"></span>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="hr-line-dashed col-xs-12"></div>

                                            <!-- Fecha OUT -->
                                            <div class="form-group col-xs-6" id="data_2">
                                                <label>Fecha Devolucion</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="" name="fechaout" id="fechaout">
                                                </div>
                                            </div>

                                            <div class="form-group col-xs-6">
                                                <label>Hora Devolucion</label>
                                                <div class="input-group clockpicker" data-autoclose="true">
                                                    <input type="text" class="form-control" name="horaout" value="" id="horaout">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-clock-o"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed col-xs-12"></div>

                                            <div class="alert alert-danger dangerstyle" id="alert">

                                            </div>

                                            <!-- Contenedor general de modulo -->
                                            <div id="contenedor-modulos">
                                                <?php //for ($i = 0; $i < count($equipos); $i++) { 
                                                ?>
                                                <!--<div class="claseequipo" id="<?php echo $equipos[$i]["id"]; ?>">
                                                        <div class="nombre"><?php echo $equipos[$i]["nombre"]; ?></div>
                                                        <div class="borrar-btn" onclick="borrarMod(<?php echo $equipos[$i]["id"]; ?>)"><i class="fa fa-remove" aria-hidden="true"></i></div>
                                                    </div>-->
                                                <?php //} 
                                                ?>

                                                <?php for ($i = 0; $i < count($equipos); $i++) { ?>
                                                    <div class="claseequipo" id="<?php echo $equipos[$i]["idregistro"]; ?>">
                                                        <div class="nombre"><?php echo $equipos[$i]["nombre"]; ?></div>
                                                        <div class="borrar-btn" onclick="borrarMod(<?php echo $equipos[$i]["idregistro"]; ?>)"><i class="fa fa-remove" aria-hidden="true"></i></div>
                                                    </div>
                                                <?php } ?>


                                            </div>

                                            <!-- Fin de contenedor general de modulo -->

                                            <!-- Agregar Módulo -->
                                            <div class="form-group col-xs-12 text-center">
                                                <button type="button" class="btn btn-w-m btn-primary" id="agregarmod">Agregar Equipo</button>
                                            </div>
                                            <div class="hr-line-dashed col-xs-12"></div>

                                            <div class="form-group text-center " style="margin-top: 30px;">
                                                <!--<input name="agregar" type="submit" class="btn btn-primary" id="agregar" value="Enviar">-->
                                                <button name="agregar" class="btn btn-primary" id="agregar" type="button">Enviar</button>
                                                <a href="lstPedidos.php?seccion=pedidos" class="btn btn-primary">Cancelar</a>
                                            </div>


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

    <!-- *********************************** MODALS *********************************-->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Selecionar clase de equipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">

                            <!-- Clase -->
                            <div class="form-group col-xs-12 text-left">
                                <label for="clasef">Clase</label>
                                <select name="clasef" class="form-control" id="clasef">

                                    <option value="0">Selecciones una clase</option>
                                    <?php
                                    $queryPost = "SELECT * 
                                    FROM equipo_clases ec
                                    LEFT JOIN equipos_clases_relacion ecr ON ecr.eqr_id_clase = ec.ecl_id
                                    WHERE eqr_id_padre = 0 ORDER BY ecl_nombre ASC, ecl_id ASC";
                                    $rsPost = $objContenido->getAllContenido($link, $queryPost);
                                    ?>
                                    <?php while ($arrPost = $rsPost->fetch(PDO::FETCH_BOTH)) { ?>
                                        <option value="<?php echo $arrPost["ecl_id"] ?>"><?php echo $arrPost["ecl_nombre"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Clase -->
                            <div class="form-group col-xs-12 text-left">
                                <label for="subclase">Sub Clase</label>
                                <select name="subclase" class="form-control" id="subclase">

                                    <option value=""></option>

                                </select>
                            </div>
                            <div class="hr-line-dashed col-xs-12"></div>


                            <div class="equiposdisponibles" id="equiposdisponibles">



                            </div>




                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalcheck" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Advertencia!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Está por salir de la página y no se completó el pedido.</p>
                </div>

                <div class="modal-footer">
                    <a href="" class="btn btn-w-m btn-primary" id="proceder">Proceder</a>
                    <button type="button" class="btn btn-w-m btn-primary" id="cancelar" onclick="closeModal()">Cancelar</button>
                </div>

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
    <!-- Clock picker -->
    <script src="js/plugins/clockpicker/clockpicker.js"></script>

    <script src="js/dropzone.js"></script>
    <script src="js/cropper.js"></script>

    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>

    <!-- Chosen -->
    <script src="js/plugins/chosen/chosen.jquery.js"></script>

    <!--tag sugest -->
    <script src="js/jquery.amsify.suggestags.js"></script>

    <script src="js/custom.js"></script>

    <script src="js/jquery.validate.js"></script>
    <script>
        var idModulo = 0;
        var ordenModulo = new Array();

        var idModAcyual = $("#cantidadModulos").val();
        var idModulo = parseInt(idModAcyual);
        var ordenActual = $("#ordenModulos").val();

        var didision = ordenActual.split(",");
        var ordenModulo = didision;


        $(document).ready(function() {




            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            var d = new Date();
            var day = d.getDate();

            const month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            var m = new Date();
            var name = month[m.getMonth()];

            var y = new Date();
            var year = y.getFullYear();

            var stardaten = day + "/" + name + "/" + year;


            $('#data_1 .input-group.date').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                startDate: stardaten + " 00:00 AM",
                todayBtn: "linked",
                todayHighlight: true
            });

            $('#data_2 .input-group.date').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                //startDate:  stardaten+" 00:00 AM",
                todayBtn: "linked",
                todayHighlight: true
            });

            $("#fechain").change(function() {
                var idClase = $(this).val();
                console.log(idClase);
                $("#fechaout").val(idClase);
                $('#data_2 .input-group.date').datepicker('setStartDate', idClase);
            });

        });

        $('.clockpicker').clockpicker();

        /* Pestañas */
        var pesActiva = 1;
        $(".pes").click(function() {
            var idact = $(this).attr("id");
            var divide = idact.split("-");
            var idact2 = divide[1];
            $("#p-" + pesActiva).removeClass("activa");
            $("#p-" + idact2).addClass("activa");

            $("#p" + pesActiva).hide();
            $("#p" + idact2).show();

            pesActiva = idact2;

        });
        /* Fin pestañas */

        $('#agregarmod').click(function() {
            $("#equiposdisponibles").html("");
            $('#modal').modal('show');
        });

        function addarMod(id, nombre) {


            var fechain = $("#fechain").val();
            var fechaout = $("#fechaout").val();
            var horain = $("#horain").val();
            var horaout = $("#horaout").val();

            var idtemporal = $("#idtemporal").val();

            var arrayfechain = fechain.split("/");
            var fechainfin = arrayfechain[2] + arrayfechain[1] + arrayfechain[0];

            var arrayfechaout = fechaout.split("/");
            var fechaoutfin = arrayfechaout[2] + arrayfechaout[1] + arrayfechaout[0];

            var arrayhorain = horain.split(":");
            var horainfin = arrayhorain[0] + arrayhorain[1];

            var arrayhoraout = horaout.split(":");
            var horaoutfin = arrayhoraout[0] + arrayhoraout[1];

            var fechasalida = fechainfin + horainfin;
            var fecharegreso = fechaoutfin + horaoutfin;


            $.ajax({
                    method: "POST",
                    url: "insertEquipoPedido.php",
                    data: {
                        idtemporal: idtemporal,
                        fechasalida: fechasalida,
                        fecharegreso: fecharegreso,
                        idequipo: id
                    }
                })
                .done(function(data) {
                    /*$("#alert").html("").removeClass("dangerstyleview").addClass("dangerstyle");
                    var cont = "<div class=\"claseequipo\" id=\"" + id + "\"><div class=\"nombre\">" + nombre + "</div><div class=\"borrar-btn\" onclick=\"borrarMod(" + id + ")\"><i class=\"fa fa-remove\" aria-hidden=\"true\"></i></div></div>";*/

                    $("#alert").html("").removeClass("dangerstyleview").addClass("dangerstyle");
                    var cont = "<div class=\"claseequipo\" id=\"" + data + "\"><div class=\"nombre\">" + nombre + "</div><div class=\"borrar-btn\" onclick=\"borrarMod(" + data + ")\"><i class=\"fa fa-remove\" aria-hidden=\"true\"></i></div></div>";

                    $("#contenedor-modulos").append(cont);

                    $("#e" + id).removeClass("claseequipo2").addClass("claseequipo2off");
                    $("#e" + id + " .nombre").prop("onclick", null).off('click');
                });



        }

        function borrarMod(id) {


            /*var idactual = $("#id").val();
            var idtemporal = $("#idtemporal").val();
            var idRegistro = id;*/

            var idtemporal = $("#idtemporal").val();
            var idRegistro = id;

            $.ajax({
                    method: "POST",
                    url: "deleteEquipoPedido.php",
                    data: {
                        idtemporal: idtemporal,
                        idregistro: idRegistro
                    }
                })
                .done(function(data) {
                    $("#" + idRegistro).remove();
                });


        }

        $("#clasef").change(function() {
            var idClase = $(this).val();
            $("#equiposdisponibles").html("");
            $.ajax({
                    method: "POST",
                    url: "armaComboPed01.php",
                    data: {
                        idClase: idClase,
                    }
                })
                .done(function(data) {
                    $("#subclase").html(data);
                });
        });

        $("#subclase").change(function() {

            $("#equiposdisponibles").html("");

            var idSubClase = $(this).val();
            var fechain = $("#fechain").val();
            var fechaout = $("#fechaout").val();
            var horain = $("#horain").val();
            var horaout = $("#horaout").val();
            var idTemp = $("#idtemporal").val();


            var arrayfechain = fechain.split("/");
            var fechainfin = arrayfechain[2] + arrayfechain[1] + arrayfechain[0];

            var arrayfechaout = fechaout.split("/");
            var fechaoutfin = arrayfechaout[2] + arrayfechaout[1] + arrayfechaout[0];

            var arrayhorain = horain.split(":");
            var horainfin = arrayhorain[0] + arrayhorain[1];

            var arrayhoraout = horaout.split(":");
            var horaoutfin = arrayhoraout[0] + arrayhoraout[1];

            var fechasalida = fechainfin + horainfin;
            var fecharegreso = fechaoutfin + horaoutfin;

            var modexist = $("#ordenModulos").val();


            $.ajax({
                    method: "POST",
                    url: "armaComboPed02.php",
                    data: {
                        idSubClase: idSubClase,
                        fechasalida: fechasalida,
                        fecharegreso: fecharegreso,
                        modexist: modexist,
                        idTemp: idTemp
                    }
                })
                .done(function(data) {
                    //$("#subclase").html(data);
                    $("#equiposdisponibles").append(data);
                });
        });

        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {
                allow_single_deselect: true
            },
            '.chosen-select-no-single': {
                disable_search_threshold: 10
            },
            '.chosen-select-no-results': {
                no_results_text: 'Oops, nothing found!'
            }

        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

        $("#agregar").click(function() {

            var fechain = $("#fechain").val();
            var fechaout = $("#fechaout").val();
            var horain = $("#horain").val();
            var horaout = $("#horaout").val();
            var idTemp = $("#idtemporal").val();

            var arrayfechain = fechain.split("/");
            var fechainfin = arrayfechain[2] + arrayfechain[1] + arrayfechain[0];

            var arrayfechaout = fechaout.split("/");
            var fechaoutfin = arrayfechaout[2] + arrayfechaout[1] + arrayfechaout[0];

            var arrayhorain = horain.split(":");
            var horainfin = arrayhorain[0] + arrayhorain[1];

            var arrayhoraout = horaout.split(":");
            var horaoutfin = arrayhoraout[0] + arrayhoraout[1];

            var fechasalida = fechainfin + horainfin;
            var fecharegreso = fechaoutfin + horaoutfin;



            $.ajax({
                    method: "POST",
                    url: "validarCantEquipos.php",
                    dataType: "json",
                    data: {
                        idTemp: idTemp
                    }
                })
                .done(function(data) {
                    if (data.estado == 0) {
                        $("#alert").html("Tiene que agregar equipos al pedido.").removeClass("dangerstyle").addClass("dangerstyleview");
                    } else {
                        $.ajax({
                                method: "POST",
                                url: "validarInsert.php",
                                dataType: "json",
                                data: {
                                    fechasalida: fechasalida,
                                    fecharegreso: fecharegreso,
                                    idTemp: idTemp
                                }
                            })
                            .done(function(data) {
                                if (data.estado == 1) {
                                    $("#alert").html("Hay equipos ocupados en la fecha.").removeClass("dangerstyle").addClass("dangerstyleview");
                                } else {
                                    document.getElementById("form1").submit();
                                }

                            });
                    }

                });

        });
    </script>



</body>

</html>