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
if ($intQtyRecords > 0) {
    $queryClean = "TRUNCATE TABLE pedidos_equipos_temp";
    $rsContClean = $objContenido->getAllContenido($link, $queryClean);
}
// FIN LIEMPIEZA TABLA TEMPORAL
//
$query = "SELECT * FROM pedidos WHERE pedidos_id=" . $intIdCont;
$rsCont = $objContenido->getAllContenido($link, $query);
$arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
//OBETNER ID TEMPORAL
$idtemp = $arrCont["pedidos_id_temporal"];

//MATERIAS
$queryMat = "SELECT * FROM pedidos_detalle WHERE pd_id_pedido = " . $intIdCont . " AND pd_tipo = 1";
$rsContMat = $objContenido->getAllContenido($link, $queryMat);
$arrContMat = $rsContMat->fetch(PDO::FETCH_BOTH);
//PROFESOR
$queryProf = "SELECT * FROM pedidos_detalle WHERE pd_id_pedido = " . $intIdCont . " AND pd_tipo = 2";
$rsContProf = $objContenido->getAllContenido($link, $queryProf);
$arrContProf = $rsContProf->fetch(PDO::FETCH_BOTH);
//RESPONSABLE
$queryResp = "SELECT * FROM pedidos_detalle WHERE pd_id_pedido = " . $intIdCont . " AND pd_tipo = 3";
$rsContResp = $objContenido->getAllContenido($link, $queryResp);
$arrContResp = $rsContResp->fetch(PDO::FETCH_BOTH);
//INTEGRANTES
$integrantesarr = array();
$queryInt = "SELECT * FROM pedidos_detalle WHERE pd_id_pedido = " . $intIdCont . " AND pd_tipo = 4";
$rsContInt = $objContenido->getAllContenido($link, $queryInt);

while ($arrContInt = $rsContInt->fetch(PDO::FETCH_BOTH)) {
    $integrantesarr[] = $arrContInt["pd_id_registro"];
}

//Comision y Turno
$queryDet = "SELECT * FROM pedidos_detalle2 WHERE pd2_id_pedido = " . $intIdCont;
$rsContDet = $objContenido->getAllContenido($link, $queryDet);
$arrContDet = $rsContDet->fetch(PDO::FETCH_BOTH);

//EQUIPOS
/*$queryEqip = "SELECT peq.*,eq.*
            FROM pedidos_equipos peq
            LEFT JOIN equipos eq ON eq.eq_id = peq.pe_id_equipo
            WHERE peq.pe_id_pedido = " . $intIdCont . "
            ORDER BY eq.eq_clase ASC, eq.eq_subclase ASC, eq.eq_nombre ASC";
$rsContEqip = $objContenido->getAllContenido($link, $queryEqip);



$equipos = array();
$contador = 0;
$orden = "";

while ($arrContenidoEq = $rsContEqip->fetch(PDO::FETCH_BOTH)) {
    $lines = ["id" => $arrContenidoEq["pe_id_equipo"], "nombre" => $arrContenidoEq["eq_nombre"], "idregistro" => $arrContenidoEq["pe_id"]];
    array_push($equipos, $lines);

    if ($contador == 0) {
        $orden .= $arrContenidoEq["pe_id_equipo"];
    } else {
        $orden .= "," . $arrContenidoEq["pe_id_equipo"];
    }
    $contador++;
}*/

// BORRO TOTDO EN TEMP
/*$query = "DELETE FROM pedidos_equipos_temp WHERE pe_id_pedido_temp = '" . $idtemp . "'";
$intIdRegistroDel1 = $objContenido->getAllContenido($link, $query);*/

//EQUIPOS
$queryEqip = "SELECT peq.*,eq.*
            FROM pedidos_equipos peq
            LEFT JOIN equipos eq ON eq.eq_id = peq.pe_id_equipo
            WHERE peq.pe_id_pedido = " . $intIdCont . "
            ORDER BY eq.eq_clase ASC, eq.eq_subclase ASC, eq.eq_nombre ASC";;
$rsContEqip = $objContenido->getAllContenido($link, $queryEqip);

/*$idtemp =  date('l jS \of F Y h:i:s A') . $_SESSION["id"];
$idtemp = md5($idtemp);*/

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

// BORRO TOTDO EN TEMP
/*
$query = "DELETE FROM pedidos_equipos WHERE pe_id_pedido_temp = '" . $idtemp . "'";
$intIdRegistroDel1 = $objContenido->getAllContenido($link, $query);
*/

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

        .alerta-epocupadounidad {
            background-color: #e3dbdb;
            color: #fff;
        }

        .check-btn {
            float: right;
            border-radius: 3px;
            background-color: red;
            border-color: red;
            color: #FFFFFF;
            padding: 5px 8px;
            cursor: pointer;
            margin-left: 6px;
            opacity: 0;
        }

        .alerta-epocupadounidad {
            border: 1px solid red;
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
                    <h2>Modificar Pedido</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php?seccion=inicio">Home</a></li>
                        <li><a href="#">Pedidos</a></li>
                        <li class="active"><strong>Modificar Pedido</strong></li>
                    </ol>
                </div>
            </div>



            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <form method="post" action="svPedidos.php" enctype="multipart/form-data" name="form1" id="form1">
                                    <input type="hidden" name="strOperacion" value="U" />
                                    <input name="id" type="hidden" id="id" value="<?php echo $intIdCont ?>">

                                    <input type="hidden" name="idtemporal" id="idtemporal" value="<?php echo $idtemp; ?>">

                                    <input type="hidden" name="cantidadModulos" value="<?php echo $contador; ?>" id="cantidadModulos">
                                    <input type="hidden" name="ordenModulos" id="ordenModulos" value="<?php echo $orden; ?>">



                                    <!-- Todos los paneles -->
                                    <div class="paneles-g" style="display: inline-block;">
                                        <!-- Datos principales-->

                                        <!-- Título -->
                                        <div class="form-group col-xs-12">
                                            <label for="nombre">Título</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $arrCont["pedidos_nombre"]; ?>">
                                        </div>
                                        <div class="hr-line-dashed col-xs-12"></div>

                                        <!-- Clase -->
                                        <div class="form-group col-xs-12">
                                            <label for="materia">Materia</label>
                                            <select name="materia" class="form-control" id="materia">

                                                <option value="0">Seleccionar materia</option>
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

                                                <option value="0">Seleccionar Profesor</option>
                                                <?php
                                                $queryPost = "SELECT *
                                                    FROM data_profesores
                                                    ORDER BY profesores_apellido ASC, profesores_name ASC, profesores_id ASC";
                                                $rsPost = $objContenido->getAllContenido($link, $queryPost);
                                                ?>
                                                <?php while ($arrPost = $rsPost->fetch(PDO::FETCH_BOTH)) { ?>
                                                    <?php //var_dump($arrPost); ?>
                                                    <option value="<?php echo $arrPost["profesores_id"] ?>" <?php if ($arrPost["profesores_id"] == $arrContProf["pd_id_registro"]) { ?>selected<?php } ?>><?php echo $arrPost["profesores_apellido"] . " " . $arrPost["profesores_name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="hr-line-dashed col-xs-12"></div>

                                        <!-- Clase -->
                                        <div class="form-group col-xs-12">
                                            <label for="responsable">Responsable</label>
                                            <select name="responsable" class="form-control" id="responsable">

                                                <option value="0">Seleccionar Estudiante</option>
                                                <?php
                                                $queryPost = "SELECT * FROM data_estudiantes
                                                    ORDER BY estudiantes_apellido ASC,estudiantes_name ASC,estudiantes_id ASC";
                                                $rsPost = $objContenido->getAllContenido($link, $queryPost);
                                                ?>
                                                <?php while ($arrPost = $rsPost->fetch(PDO::FETCH_BOTH)) { ?>
                                                    <option value="<?php echo $arrPost["estudiantes_id"] ?>" <?php if ($arrPost["estudiantes_id"] == $arrContResp["pd_id_registro"]) { ?>selected<?php } ?>><?php echo $arrPost["estudiantes_apellido"] . " " . $arrPost["estudiantes_name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="hr-line-dashed col-xs-12"></div>

                                        <!-- Clase -->
                                        <div class="form-group col-xs-12">
                                            <label for="integrantes">Integrantes</label>
                                            <!--<select name="integrantes" class="form-control" id="integrantes">-->
                                            <select data-placeholder="Seleccionar Estudiantes..." name="integrantes[]" class="chosen-select form-control" id="integrantes" multiple>

                                                <option value="0">Seleccionar Estudiante</option>
                                                <?php
                                                $queryPost = "SELECT * FROM data_estudiantes
                                                    ORDER BY estudiantes_apellido ASC,estudiantes_name ASC,estudiantes_id ASC";
                                                $rsPost = $objContenido->getAllContenido($link, $queryPost);
                                                //
                                                ?>
                                                <?php while ($arrPost = $rsPost->fetch(PDO::FETCH_BOTH)) { ?>
                                                    <option value="<?php echo $arrPost["estudiantes_id"] ?>" <?php if (in_array($arrPost["estudiantes_id"], $integrantesarr)) { ?>selected<?php } ?>><?php echo $arrPost["estudiantes_apellido"] . " " . $arrPost["estudiantes_name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="hr-line-dashed col-xs-12"></div>



                                        <!-- Curso -->
                                        <div class="form-group col-xs-6">
                                            <label for="curso">Curso</label>
                                            <select name="curso" class="form-control" id="curso">

                                                <option value="0" <?php if ($arrContDet["pd2_curso"] == 0) { ?>selected<?php } ?>>Seleccionar Curso</option>
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

                                                <option value="0" <?php if ($arrContDet["pd2_comision"] == 0) { ?>selected<?php } ?>>Seleccionar Comisión</option>
                                                <option value="1" <?php if ($arrContDet["pd2_comision"] == 1) { ?>selected<?php } ?>>Nº 1</option>
                                                <option value="2" <?php if ($arrContDet["pd2_comision"] == 2) { ?>selected<?php } ?>>Nº 2</option>
                                                <option value="3" <?php if ($arrContDet["pd2_comision"] == 3) { ?>selected<?php } ?>>Nº 3</option>

                                            </select>

                                        </div>

                                        <div class="hr-line-dashed col-xs-12"></div>




                                        <!-- Fin de datos principales -->


                                        <!-- Multimedia-->

                                        <!-- Fecha In -->
                                        <div class="form-group col-xs-6" id="data_1">
                                            <label>Fecha Retiro</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control" value="<?php echo revertFecha($arrCont["pedidos_fechain"]); ?>" name="fechain" id="fechain" autocomplete="off">
                                            </div>
                                        </div>

                                        <!--<div class="form-group col-xs-6">
                                            <label>Hora Retiro</label>
                                            <div class="input-group clockpicker" data-autoclose="true">
                                                <input type="text" class="form-control" name="horain" value="<?php echo revertHora($arrCont["pedidos_fechain"]); ?>" id="horain">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div>-->

                                        <div class="form-group col-xs-6">
                                            <label>Hora Retiro</label>
                                            <select name="horain" id="horain" class="form-control">
                                                <option value="" selected>Seleccionar hora de retiro</option>
                                                <option value="0700" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0700") { ?> selected <?php } ?>>07:00</option>
                                                <option value="0715" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0715") { ?> selected <?php } ?>>07:15</option>
                                                <option value="0730" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0730") { ?> selected <?php } ?>>07:30</option>
                                                <option value="0745" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0745") { ?> selected <?php } ?>>07:45</option>
                                                <option value="0800" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0800") { ?> selected <?php } ?>>08:00</option>
                                                <option value="0815" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0815") { ?> selected <?php } ?>>08:15</option>
                                                <option value="0830" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0830") { ?> selected <?php } ?>>08:30</option>
                                                <option value="0845" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0845") { ?> selected <?php } ?>>08:45</option>
                                                <option value="0900" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0900") { ?> selected <?php } ?>>09:00</option>
                                                <option value="0915" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0915") { ?> selected <?php } ?>>09:15</option>
                                                <option value="0930" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0930") { ?> selected <?php } ?>>09:30</option>
                                                <option value="0945" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0945") { ?> selected <?php } ?>>09:45</option>
                                                <option value="1000" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1000") { ?> selected <?php } ?>>10:00</option>
                                                <option value="1015" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1015") { ?> selected <?php } ?>>10:15</option>
                                                <option value="1030" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1030") { ?> selected <?php } ?>>10:30</option>
                                                <option value="1045" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1045") { ?> selected <?php } ?>>10:45</option>
                                                <option value="1100" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1100") { ?> selected <?php } ?>>11:00</option>
                                                <option value="1115" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1115") { ?> selected <?php } ?>>11:15</option>
                                                <option value="1130" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1130") { ?> selected <?php } ?>>11:30</option>
                                                <option value="1145" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1145") { ?> selected <?php } ?>>11:45</option>
                                                <option value="1200" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1200") { ?> selected <?php } ?>>12:00</option>
                                                <option value="1215" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1215") { ?> selected <?php } ?>>12:15</option>
                                                <option value="1230" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1230") { ?> selected <?php } ?>>12:30</option>
                                                <option value="1245" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1245") { ?> selected <?php } ?>>12:45</option>
                                                <option value="1300" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1300") { ?> selected <?php } ?>>13:00</option>
                                                <option value="1315" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1315") { ?> selected <?php } ?>>13:15</option>
                                                <option value="1330" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1330") { ?> selected <?php } ?>>13:30</option>
                                                <option value="1345" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1345") { ?> selected <?php } ?>>13:45</option>
                                                <option value="1400" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1400") { ?> selected <?php } ?>>14:00</option>
                                                <option value="1415" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1415") { ?> selected <?php } ?>>14:15</option>
                                                <option value="1430" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1430") { ?> selected <?php } ?>>14:30</option>
                                                <option value="1445" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1445") { ?> selected <?php } ?>>14:45</option>
                                                <option value="1500" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1500") { ?> selected <?php } ?>>15:00</option>
                                                <option value="1515" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1515") { ?> selected <?php } ?>>15:15</option>
                                                <option value="1530" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1530") { ?> selected <?php } ?>>15:30</option>
                                                <option value="1545" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1545") { ?> selected <?php } ?>>15:45</option>
                                                <option value="1600" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1600") { ?> selected <?php } ?>>16:00</option>
                                                <option value="1615" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1615") { ?> selected <?php } ?>>16:15</option>
                                                <option value="1630" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1630") { ?> selected <?php } ?>>16:30</option>
                                                <option value="1645" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1645") { ?> selected <?php } ?>>16:45</option>
                                                <option value="1700" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1700") { ?> selected <?php } ?>>17:00</option>
                                                <option value="1715" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1715") { ?> selected <?php } ?>>17:15</option>
                                                <option value="1730" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1730") { ?> selected <?php } ?>>17:30</option>
                                                <option value="1745" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1745") { ?> selected <?php } ?>>17:45</option>
                                                <option value="1800" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1800") { ?> selected <?php } ?>>18:00</option>
                                                <option value="1815" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1815") { ?> selected <?php } ?>>18:15</option>
                                                <option value="1830" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1830") { ?> selected <?php } ?>>18:30</option>
                                                <option value="1845" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1845") { ?> selected <?php } ?>>18:45</option>
                                                <option value="1900" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1900") { ?> selected <?php } ?>>19:00</option>
                                                <option value="1915" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1915") { ?> selected <?php } ?>>19:15</option>
                                                <option value="1930" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1930") { ?> selected <?php } ?>>19:30</option>
                                                <option value="1945" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "1845") { ?> selected <?php } ?>>19:45</option>
                                                <option value="2000" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2000") { ?> selected <?php } ?>>20:00</option>
                                                <option value="2015" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2015") { ?> selected <?php } ?>>20:15</option>
                                                <option value="2030" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2030") { ?> selected <?php } ?>>20:30</option>
                                                <option value="2045" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2045") { ?> selected <?php } ?>>20:45</option>
                                                <option value="2100" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2100") { ?> selected <?php } ?>>21:00</option>
                                                <option value="2115" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2115") { ?> selected <?php } ?>>21:15</option>
                                                <option value="2130" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2130") { ?> selected <?php } ?>>21:30</option>
                                                <option value="2145" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2145") { ?> selected <?php } ?>>21:45</option>
                                                <option value="2200" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2200") { ?> selected <?php } ?>>22:00</option>
                                                <option value="2215" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2215") { ?> selected <?php } ?>>22:15</option>
                                                <option value="2230" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2230") { ?> selected <?php } ?>>22:30</option>
                                                <option value="2245" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2245") { ?> selected <?php } ?>>22:45</option>
                                                <option value="2300" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2300") { ?> selected <?php } ?>>23:00</option>
                                                <option value="2315" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2315") { ?> selected <?php } ?>>23:15</option>
                                                <option value="2330" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2330") { ?> selected <?php } ?>>23:30</option>
                                                <option value="2345" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "2345") { ?> selected <?php } ?>>23:45</option>
                                                <option value="0000" <?php if (revertHora2($arrCont["pedidos_fechain"]) == "0000") { ?> selected <?php } ?>>00:00</option>
                                            </select>
                                        </div>

                                        <div class="hr-line-dashed col-xs-12"></div>

                                        <!-- Fecha OUT -->
                                        <div class="form-group col-xs-6" id="data_2">
                                            <label>Fecha Devolucion</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control" value="<?php echo revertFecha($arrCont["pedidos_fechaout"]); ?>" name="fechaout" id="fechaout" autocomplete="off">
                                            </div>
                                        </div>
                                        <!--
                                        <div class="form-group col-xs-6">
                                            <label>Hora Devolucion</label>
                                            <div class="input-group clockpicker" data-autoclose="true">
                                                <input type="text" class="form-control" name="horaout" value="<?php echo revertHora($arrCont["pedidos_fechaout"]); ?>" id="horaout">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div>
                                                -->
                                        <div class="form-group col-xs-6">
                                            <label>Hora Devolucion</label>
                                            <select name="horaout" id="horaout" class="form-control">
                                                <option value="" selected>Seleccionar hora de devolución</option>
                                                <option value="0700" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0700") { ?> selected <?php } ?>>07:00</option>
                                                <option value="0715" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0715") { ?> selected <?php } ?>>07:15</option>
                                                <option value="0730" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0730") { ?> selected <?php } ?>>07:30</option>
                                                <option value="0745" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0745") { ?> selected <?php } ?>>07:45</option>
                                                <option value="0800" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0800") { ?> selected <?php } ?>>08:00</option>
                                                <option value="0815" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0815") { ?> selected <?php } ?>>08:15</option>
                                                <option value="0830" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0830") { ?> selected <?php } ?>>08:30</option>
                                                <option value="0845" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0845") { ?> selected <?php } ?>>08:45</option>
                                                <option value="0900" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0900") { ?> selected <?php } ?>>09:00</option>
                                                <option value="0915" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0915") { ?> selected <?php } ?>>09:15</option>
                                                <option value="0930" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0930") { ?> selected <?php } ?>>09:30</option>
                                                <option value="0945" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0945") { ?> selected <?php } ?>>09:45</option>
                                                <option value="1000" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1000") { ?> selected <?php } ?>>10:00</option>
                                                <option value="1015" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1015") { ?> selected <?php } ?>>10:15</option>
                                                <option value="1030" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1030") { ?> selected <?php } ?>>10:30</option>
                                                <option value="1045" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1045") { ?> selected <?php } ?>>10:45</option>
                                                <option value="1100" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1100") { ?> selected <?php } ?>>11:00</option>
                                                <option value="1115" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1115") { ?> selected <?php } ?>>11:15</option>
                                                <option value="1130" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1130") { ?> selected <?php } ?>>11:30</option>
                                                <option value="1145" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1145") { ?> selected <?php } ?>>11:45</option>
                                                <option value="1200" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1200") { ?> selected <?php } ?>>12:00</option>
                                                <option value="1215" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1215") { ?> selected <?php } ?>>12:15</option>
                                                <option value="1230" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1230") { ?> selected <?php } ?>>12:30</option>
                                                <option value="1245" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1245") { ?> selected <?php } ?>>12:45</option>
                                                <option value="1300" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1300") { ?> selected <?php } ?>>13:00</option>
                                                <option value="1315" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1315") { ?> selected <?php } ?>>13:15</option>
                                                <option value="1330" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1330") { ?> selected <?php } ?>>13:30</option>
                                                <option value="1345" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1345") { ?> selected <?php } ?>>13:45</option>
                                                <option value="1400" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1400") { ?> selected <?php } ?>>14:00</option>
                                                <option value="1415" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1415") { ?> selected <?php } ?>>14:15</option>
                                                <option value="1430" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1430") { ?> selected <?php } ?>>14:30</option>
                                                <option value="1445" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1445") { ?> selected <?php } ?>>14:45</option>
                                                <option value="1500" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1500") { ?> selected <?php } ?>>15:00</option>
                                                <option value="1515" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1515") { ?> selected <?php } ?>>15:15</option>
                                                <option value="1530" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1530") { ?> selected <?php } ?>>15:30</option>
                                                <option value="1545" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1545") { ?> selected <?php } ?>>15:45</option>
                                                <option value="1600" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1600") { ?> selected <?php } ?>>16:00</option>
                                                <option value="1615" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1615") { ?> selected <?php } ?>>16:15</option>
                                                <option value="1630" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1630") { ?> selected <?php } ?>>16:30</option>
                                                <option value="1645" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1645") { ?> selected <?php } ?>>16:45</option>
                                                <option value="1700" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1700") { ?> selected <?php } ?>>17:00</option>
                                                <option value="1715" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1715") { ?> selected <?php } ?>>17:15</option>
                                                <option value="1730" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1730") { ?> selected <?php } ?>>17:30</option>
                                                <option value="1745" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1745") { ?> selected <?php } ?>>17:45</option>
                                                <option value="1800" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1800") { ?> selected <?php } ?>>18:00</option>
                                                <option value="1815" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1815") { ?> selected <?php } ?>>18:15</option>
                                                <option value="1830" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1830") { ?> selected <?php } ?>>18:30</option>
                                                <option value="1845" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1845") { ?> selected <?php } ?>>18:45</option>
                                                <option value="1900" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1900") { ?> selected <?php } ?>>19:00</option>
                                                <option value="1915" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1915") { ?> selected <?php } ?>>19:15</option>
                                                <option value="1930" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1930") { ?> selected <?php } ?>>19:30</option>
                                                <option value="1945" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "1845") { ?> selected <?php } ?>>19:45</option>
                                                <option value="2000" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2000") { ?> selected <?php } ?>>20:00</option>
                                                <option value="2015" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2015") { ?> selected <?php } ?>>20:15</option>
                                                <option value="2030" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2030") { ?> selected <?php } ?>>20:30</option>
                                                <option value="2045" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2045") { ?> selected <?php } ?>>20:45</option>
                                                <option value="2100" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2100") { ?> selected <?php } ?>>21:00</option>
                                                <option value="2115" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2115") { ?> selected <?php } ?>>21:15</option>
                                                <option value="2130" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2130") { ?> selected <?php } ?>>21:30</option>
                                                <option value="2145" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2145") { ?> selected <?php } ?>>21:45</option>
                                                <option value="2200" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2200") { ?> selected <?php } ?>>22:00</option>
                                                <option value="2215" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2215") { ?> selected <?php } ?>>22:15</option>
                                                <option value="2230" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2230") { ?> selected <?php } ?>>22:30</option>
                                                <option value="2245" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2245") { ?> selected <?php } ?>>22:45</option>
                                                <option value="2300" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2300") { ?> selected <?php } ?>>23:00</option>
                                                <option value="2315" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2315") { ?> selected <?php } ?>>23:15</option>
                                                <option value="2330" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2330") { ?> selected <?php } ?>>23:30</option>
                                                <option value="2345" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "2345") { ?> selected <?php } ?>>23:45</option>
                                                <option value="0000" <?php if (revertHora2($arrCont["pedidos_fechaout"]) == "0000") { ?> selected <?php } ?>>00:00</option>
                                            </select>
                                        </div>

                                        <div class="hr-line-dashed col-xs-12"></div>

                                        <div class="alert alert-danger dangerstyle" id="alert">

                                        </div>

                                        <!-- Contenedor general de modulo -->
                                        <div id="contenedor-modulos">
                                            <?php for ($i = 0; $i < count($equipos); $i++) { ?>
                                                <div class="claseequipo" id="ef<?php echo $equipos[$i]["id"]; ?>">
                                                    <div class="nombre"><?php echo $equipos[$i]["nombre"]; ?></div>
                                                    <div class="check-btn" onclick="revisarOcupacion(<?php echo $equipos[$i]["idregistro"]; ?>,<?php echo $equipos[$i]["id"]; ?>)"><i class="fa fa-share-square-o" aria-hidden="true"></i></div>
                                                    <div class="borrar-btn" onclick="borrarMod(<?php echo $equipos[$i]["idregistro"]; ?>,<?php echo $equipos[$i]["id"]; ?>)"><i class="fa fa-remove" aria-hidden="true"></i></div>
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
                                            <!--<button name="agregar" class="btn btn-primary" id="agregar" type="button">Enviar</button>-->
                                            <button name="agregar" class="btn btn-primary" id="agregar" type="submit">Enviar</button>
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

    <!-- MODAL VACIO -->
    <div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>La hora y fecha no pueden estar vacias</p>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalError2" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>La hora y fecha de salida no pueden ser menor o igual a la fecha de salida</p>
                </div>

            </div>
        </div>
    </div>
    <!-- FIN MODAL VACIO -->

    <div class="modal fade" id="modalEquiposOcupados" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pedidos donde se ocupa el equipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                   <div id="pedidoconequipo">
                    </div>
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
    <script src="js/plugins/datapicker/locales/bootstrap-datepicker.es.min.js"></script>
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

    <script src="js/jquery.validate.js"></script>

    <script src="js/custom.js"></script>
    <script>
        let idModulo = 0;
        let ordenModulo = new Array();

        let idModAcyual = $("#cantidadModulos").val();
        idModulo = parseInt(idModAcyual);
        let ordenActual = $("#ordenModulos").val();

        let didision = ordenActual.split(",");
        ordenModulo = didision;

        let response;


        $(document).ready(function() {

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            let d = new Date();
            let day = d.getDate();

            const month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            let m = new Date();
            let name = month[m.getMonth()];

            let y = new Date();
            let year = y.getFullYear();

            let stardaten = day + "/" + name + "/" + year;


            $('#data_1 .input-group.date').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                startDate: stardaten + " 00:00 AM",
                todayBtn: "linked",
                todayHighlight: true,
                language: "es"
            });

            $('#data_2 .input-group.date').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                //startDate:  stardaten+" 00:00 AM",
                todayBtn: "linked",
                todayHighlight: true,
                language: "es"
            });

            $("#fechain").change(function() {
                let idClase = $(this).val();
                $("#fechaout").val(idClase);
                $('#data_2 .input-group.date').datepicker('setStartDate', idClase);
            });

        });

        $('.clockpicker').clockpicker();

        let config = {
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
        for (let selector in config) {
            $(selector).chosen(config[selector]);
        }

        /*----------------------------------------------------------------------------------------------------------------------------*/

        function obtenerFecha() {

            let infoFecha = {};

            let fechain = $("#fechain").val();
            let fechaout = $("#fechaout").val();
            let horain = $('#horain option:selected').val();
            let horaout = $('#horaout option:selected').val();

            let arrayfechain = fechain.split("/");
            let fechainfin = arrayfechain[2] + arrayfechain[1] + arrayfechain[0];

            let arrayfechaout = fechaout.split("/");
            let fechaoutfin = arrayfechaout[2] + arrayfechaout[1] + arrayfechaout[0];

            let horainfin = horain;

            let horaoutfin = horaout;

            let fechasalida = fechainfin + horainfin;
            let fecharegreso = fechaoutfin + horaoutfin;

            infoFecha = {
                "fechaSalida": fechain,
                "horaSalida": horain,
                "fechaRegereso": fechaout,
                "horaRegerso": horaout,
                "fechaSalidaCompleta": fechasalida,
                "fechaRegresoCompleta": fecharegreso
            }

            return infoFecha;
        }

        $('#agregarmod').click(function() {

            let fechas = obtenerFecha();

            /*
            var fechain = $("#fechain").val();
            var fechaout = $("#fechaout").val();
            var horain = $('#horain option:selected').val();
            var horaout = $('#horaout option:selected').val();

            var arrayfechain = fechain.split("/");
            var fechainfin = arrayfechain[2] + arrayfechain[1] + arrayfechain[0];

            var arrayfechaout = fechaout.split("/");
            var fechaoutfin = arrayfechaout[2] + arrayfechaout[1] + arrayfechaout[0];

            var horainfin = horain;

            var horaoutfin = horaout;

            var fechasalida = fechainfin + horainfin;
            var fecharegreso = fechaoutfin + horaoutfin;
            

            if (fechain == "" || fechaout == "" || horain == "" || horaout == "") {
                $('#modalError').modal('show');
            } else if(fechasalida >= fecharegreso){ 
                $('#modalError2').modal('show');
            } else {
                $("#clasef").val('0');

                $("#subclase").html('<option value=""></option>');

                $("#equiposdisponibles").html("");
                $('#modal').modal('show');
            }

            */

            if (fechas.fechaSalida == "" || fechas.fechaRegereso == "" || fechas.horaSalida == "" || fechas.horaRegerso == "") {
                $('#modalError').modal('show');
            } else if (fechas.fechaSalidaCompleta >= fechas.fechaRegresoCompleta) {
                $('#modalError2').modal('show');
            } else {
                $("#clasef").val('0');
                $("#subclase").html('<option value=""></option>');
                $("#equiposdisponibles").html("");
                $('#modal').modal('show');
            }

        });

        $("#clasef").change(function() {
            let idClase = $(this).val();
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

            let idSubClase = $(this).val();
            let modexist = $("#ordenModulos").val();
            let idTemp = $("#idtemporal").val();

            let fechas = obtenerFecha();

            $("#equiposdisponibles").html("");

            /*

            var fechain = $("#fechain").val();
            var fechaout = $("#fechaout").val();
            var horain = $("#horain").val();
            var horaout = $("#horaout").val();
            

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
*/


            $.ajax({
                    method: "POST",
                    url: "armaComboPed02.php",
                    data: {
                        idSubClase: idSubClase,
                        fechasalida: fechas.fechaSalidaCompleta,
                        fecharegreso: fechas.fechaRegresoCompleta,
                        modexist: modexist,
                        idTemp: idTemp
                    }
                })
                .done(function(data) {
                    $("#equiposdisponibles").append(data);
                });
        });

        function addarMod(id, nombre) {

            let fechas = obtenerFecha();
            let idtemporal = $("#idtemporal").val();



            $.ajax({
                    method: "POST",
                    url: "insertEquipoPedido.php",
                    dataType: 'json',
                    data: {
                        idtemporal: idtemporal,
                        fechasalida: fechas.fechaSalidaCompleta,
                        fecharegreso: fechas.fechaRegresoCompleta,
                        idequipo: id
                    }
                })
                .done(function(data) {


                    let cont = "";

                    $("#contenedor-modulos").html("");

                    $("#alert").html("").removeClass("dangerstyleview").addClass("dangerstyle");

                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        cont += "<div class=\"claseequipo\" id=\"ef" + element.id + "\"><div class=\"nombre\">" + element.nombre + "</div><div class=\"check-btn\" onclick=\"revisarOcupacion(" + element.idregistro + "," + element.id + ")\"><i class=\"fa fa-share-square-o\" aria-hidden=\"true\"></i></div><div class=\"borrar-btn\" onclick=\"borrarMod(" + element.idregistro + "," + element.id + ")\"><i class=\"fa fa-remove\" aria-hidden=\"true\"></i></div> </div>";
                    }
                    
                    /*
                    let cont = "<div class=\"claseequipo\" id=\"ef" + data.idEquipo + "\"><div class=\"nombre\">" + nombre + "</div><div class=\"check-btn\" onclick=\"revisarOcupacion(" + data.idRegistro + "," + data.idEquipo + ")\"><i class=\"fa fa-share-square-o\" aria-hidden=\"true\"></i></div><div class=\"borrar-btn\" onclick=\"borrarMod(" + data.idRegistro + "," + data.idEquipo + ")\"><i class=\"fa fa-remove\" aria-hidden=\"true\"></i></div> </div>";*/

                    $("#contenedor-modulos").append(cont);

                    $("#e" + id).removeClass("claseequipo2").addClass("claseequipo2off");
                    $("#e" + id + " .nombre").prop("onclick", null).off('click');

                    /*
                    $("#alert").html("").removeClass("dangerstyleview").addClass("dangerstyle");
                    var cont = "<div class=\"claseequipo\" id=\"" + data + "\"><div class=\"nombre\">" + nombre + "</div><div class=\"borrar-btn\" onclick=\"borrarMod(" + data + ")\"><i class=\"fa fa-remove\" aria-hidden=\"true\"></i></div></div>";

                    $("#alert").html("").removeClass("dangerstyleview").addClass("dangerstyle");
                    let cont = "<div class=\"claseequipo\" id=\"ef" + data.idEquipo + "\"><div class=\"nombre\">" + nombre + "</div><div class=\"check-btn\" onclick=\"revisarOcupacion(" + data.idRegistro + "," + data.idEquipo + ")\"><i class=\"fa fa-share-square-o\" aria-hidden=\"true\"></i></div><div class=\"borrar-btn\" onclick=\"borrarMod(" + data.idRegistro + "," + data.idEquipo + ")\"><i class=\"fa fa-remove\" aria-hidden=\"true\"></i></div> </div>";

                    $("#contenedor-modulos").append(cont);

                    $("#e" + id).removeClass("claseequipo2").addClass("claseequipo2off");
                    $("#e" + id + " .nombre").prop("onclick", null).off('click');*/
                });



        }

        function borrarMod(idRegistro, idEquipo) {

            //var idactual = $("#id").val();
            //var idtemporal = $("#idtemporal").val();
            //var idRegistro = id;

            let idtemporal = $("#idtemporal").val();
            let idRegistroF = idRegistro;
            let idEquipoF = idEquipo;


            $.ajax({
                    method: "POST",
                    url: "deleteEquipoPedido.php",
                    data: {
                        idtemporal: idtemporal,
                        idregistro: idRegistroF
                    }
                })
               .done(function(data) {
                    $("#ef" + idEquipoF).remove();
                });

        }

        function revisarOcupacion(idRegistro, idEquipo) {

            let idEquipoF = idEquipo;
            let idtemporal = $("#idtemporal").val();

            $.ajax({
                    method: "POST",
                    url: "validarEquiposOcupados.php",
                    data: {
                        idEquipoF: idEquipoF,
                        idtemporal: idtemporal,
                    }
                })
                .done(function(data) {
                    $('#modalEquiposOcupados').modal('show');
                    $("#pedidoconequipo").html("");
                    $("#pedidoconequipo").append(data);
                });
        }


        $("#form1").validate({
            rules: {
                nombre: "required",
                materia: "required",
                docente: "required",
                curso: "required",
                fechain: "required",
                horain: "required",
                fechaout: "required",
                horaout: "required"

            },
            messages: {
                nombre: "Campo obligatorio",
                materia: "Campo obligatorio",
                docente: "Campo obligatorio",
                curso: "Campo obligatorio",
                fechain: "Campo obligatorio",
                horain: "Campo obligatorio",
                fechaout: "Campo obligatorio",
                horaout: "Campo obligatorio"
            },
            submitHandler: function(form) {
                
                let idTemp = $("#idtemporal").val();
                ordenModulos = $("#ordenModulos").val();
                let idsss = ordenModulos.split(",");
                
                let fechas = obtenerFecha();
                

                $("#alert").html("").removeClass("dangerstyleview").addClass("dangerstyle");
                $("div.alerta-epocupadounidad").removeClass("alerta-epocupadounidad");

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
                                    url: "validarUpdate.php",
                                    dataType: "json",
                                    data: {
                                        fechasalida: fechas.fechaSalidaCompleta,
                                        fecharegreso: fechas.fechaRegresoCompleta,
                                        idTemp: idTemp
                                    }
                                })
                                .done(function(data) {

                                    if (data.estado == 1) {

                                        let arrays = data.identificadores;

                                        for (let index = 0; index < arrays.length; index++) {

                                            $("#ef" + arrays[index]).addClass("alerta-epocupadounidad");
                                            $("#ef" + arrays[index] + " div").eq(1).css("opacity",1);

                                        }

                                        $("#alert").html("Hay equipos ocupados en la fecha.").removeClass("dangerstyle").addClass("dangerstyleview");
                                    } else {
                                        document.getElementById("form1").submit();
                                    }

                                });
                        }

                    });

            }
        });


        /*$("#agregar").click(function() {

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

            var ordenModulos = $("#ordenModulos").val();
            var idsss = ordenModulos.split(",");
            
            $("#alert").html("").removeClass("dangerstyleview").addClass("dangerstyle");
            $("div.alerta-epocupadounidad").removeClass("alerta-epocupadounidad");

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
                                url: "validarUpdate.php",
                                dataType: "json",
                                data: {
                                    fechasalida: fechasalida,
                                    fecharegreso: fecharegreso,
                                    idTemp: idTemp
                                }
                            })
                            .done(function(data) {
                                //
                                //console.log(data.estado);
                                if (data.estado == 1) {
                                    
                                    
                                    var arrays = data.identificadores;
                                    for (let index = 0; index < arrays.length; index++) {

                                        var posicion = idsss.indexOf(arrays[index]);

                                        if(posicion !=-1){
                                            posicion = posicion+1;
                                            $("#"+posicion).addClass("alerta-epocupadounidad");
                                        }

                                        //console.log(arrays[index]);
                                        
                                    }

                                    $("#alert").html("Hay equipos ocupados en la fecha.").removeClass("dangerstyle").addClass("dangerstyleview");
                                } else {
                                    document.getElementById("form1").submit();
                                }

                            });
                    }

                });

        });*/




        /*function validEquipos() {
            var fechain = $("#fechain").val();
            var fechaout = $("#fechaout").val();
            var horain = $("#horain").val();
            var horaout = $("#horaout").val();


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

            var id = $("#id").val();

            $.ajax({
                    method: "POST",
                    url: "validaciones/validEquiposEd.php",
                    dataType: "json",
                    data: {
                        id: id,
                        fechasalida: fechasalida,
                        fecharegreso: fecharegreso,
                    }
                })
                .done(function(data) {
                    
                    if (data.estatus == "ok") {
                        
                        document.getElementById("form1").submit();
                    } else {
                        for (let index = 0; index < data.ideq.length; index++) {
                            const element = data.ideq[index];
                            $("#"+element).addClass("alerta-eqocupado");
                        }
                        alert("Hay equipos ocupados para las fechas establecidas. Cambie los eipos o las fechas del pedido.");
                    }
                });

        }*/
    </script>



</body>

</html>