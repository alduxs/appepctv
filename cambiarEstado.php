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
$query = "SELECT * FROM pedidos WHERE pedidos_id=" . $intIdCont;
$rsCont = $objContenido->getAllContenido($link, $query);
$arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
//MATERIAS
$queryMat = "SELECT dm.materia_nombre
            FROM pedidos_detalle pd
            LEFT JOIN data_materia dm ON dm.materia_id = pd.pd_id_registro
            WHERE pd_id_pedido = " . $intIdCont . " AND pd_tipo = 1";
$rsContMat = $objContenido->getAllContenido($link, $queryMat);
$arrContMat = $rsContMat->fetch(PDO::FETCH_BOTH);
//PROFESOR
$queryProf = "SELECT dp.profesores_name,dp.profesores_apellido
              FROM pedidos_detalle pd
              LEFT JOIN data_profesores dp ON dp.profesores_id = pd.pd_id_registro
              WHERE pd_id_pedido = " . $intIdCont . " AND pd_tipo = 2";
$rsContProf = $objContenido->getAllContenido($link, $queryProf);
$arrContProf = $rsContProf->fetch(PDO::FETCH_BOTH);
//RESPONSABLE
$queryResp = "SELECT de.estudiantes_name,de.estudiantes_apellido
              FROM pedidos_detalle pd
              LEFT JOIN data_estudiantes de ON de.estudiantes_id = pd.pd_id_registro
              WHERE pd_id_pedido = " . $intIdCont . " AND pd_tipo = 3";
$rsContResp = $objContenido->getAllContenido($link, $queryResp);
$arrContResp = $rsContResp->fetch(PDO::FETCH_BOTH);
//INTEGRANTES
$integrantesarr = array();
$queryInt = "SELECT * FROM pedidos_detalle WHERE pd_id_pedido = " . $intIdCont . " AND pd_tipo = 4";
$rsContInt = $objContenido->getAllContenido($link, $queryInt);
//$arrContInt = $rsContInt->fetch(PDO::FETCH_BOTH);
while ($arrContInt = $rsContInt->fetch(PDO::FETCH_BOTH)) {


    $queryResp2 = "SELECT de.estudiantes_name,de.estudiantes_apellido
              FROM data_estudiantes de
              WHERE estudiantes_id = " . $arrContInt["pd_id_registro"];
    $rsContResp2 = $objContenido->getAllContenido($link, $queryResp2);
    $arrContResp2 = $rsContResp2->fetch(PDO::FETCH_BOTH);

    $integrantesarr[] = $arrContResp2["estudiantes_name"] . " " . $arrContResp2["estudiantes_apellido"];
}


//Comision y Turno
$queryDet = "SELECT * FROM pedidos_detalle2 WHERE pd2_id_pedido = " . $intIdCont;
$rsContDet = $objContenido->getAllContenido($link, $queryDet);
$arrContDet = $rsContDet->fetch(PDO::FETCH_BOTH);

//EQUIPOS
//Comision y Turno
$queryEqip = "SELECT peq.*,eq.*
            FROM pedidos_equipos peq
            LEFT JOIN equipos eq ON eq.eq_id = peq.pe_id_equipo
            WHERE peq.pe_id_pedido = " . $intIdCont;
$rsContEqip = $objContenido->getAllContenido($link, $queryEqip);

$equipos = array();
$contador = 0;
$orden = "";

while ($arrContenidoEq = $rsContEqip->fetch(PDO::FETCH_BOTH)) {
    $lines = ["id" => $arrContenidoEq["pe_id_equipo"], "nombre" => $arrContenidoEq["eq_nombre"]];
    array_push($equipos, $lines);

    if ($contador == 0) {
        $orden .= $arrContenidoEq["pe_id_equipo"];
    } else {
        $orden .= "," . $arrContenidoEq["pe_id_equipo"];
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
                    <h2>Cambiar Estado</h2>
                    <ol class="breadcrumb">
                        <li><a href="home.php?seccion=inicio">Home</a></li>
                        <li><a href="#">Pedidos</a></li>
                        <li class="active"><strong>Cambiar Estado</strong></li>
                    </ol>
                </div>
            </div>



            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <form method="post" action="svPedidosEstate.php" enctype="multipart/form-data" name="form1">
                                    <input type="hidden" name="strOperacion" value="U" />
                                    <input name="id" type="hidden" id="id" value="<?php echo $intIdCont ?>">

                                    <input type="hidden" name="cantidadModulos" value="<?php echo $contador; ?>" id="cantidadModulos">
                                    <input type="hidden" name="ordenModulos" id="ordenModulos" value="<?php echo $orden; ?>">


                                    <!-- Todos los paneles -->
                                    <div class="paneles-g">
                                        <!-- Datos principales-->

                                        <div class="row">
                                            <div class="col-md-12">
                                                <p><strong><?php echo $arrCont["pedidos_nombre"]; ?></strong></p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="hr-line-dashed col-xs-12"></div>
                                            </div>

                                            <div class="col-md-6">
                                                <p><strong>Retiro:</strong> <?php echo revertFecha($arrCont["pedidos_fechain"]); ?> - <?php echo revertHora($arrCont["pedidos_fechain"]); ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Devolución:</strong> <?php echo revertFecha($arrCont["pedidos_fechaout"]); ?> - <?php echo revertHora($arrCont["pedidos_fechaout"]); ?></p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="hr-line-dashed col-xs-12"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <p><strong>Profesor: </strong><?php echo $arrContProf["profesores_name"] . " " . $arrContProf["profesores_apellido"]; ?></p>

                                            </div>
                                            <div class="col-md-3">
                                                <p><strong>Materia: </strong><?php echo $arrContMat["materia_nombre"]; ?></p>

                                            </div>

                                            <div class="col-md-3">
                                                <p><strong>Comisión:</strong> <?php echo $arrContDet["pd2_comision"]; ?></p>
                                            </div>

                                            <div class="col-md-3">
                                                <p><strong>Curso:</strong> Nº <?php echo $arrContDet["pd2_curso"]; ?></p>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="hr-line-dashed col-xs-12"></div>
                                            </div>

                                            <div class="col-md-12">
                                                <p><strong>Responsable: </strong> <?php echo $arrContResp["estudiantes_name"] . " " . $arrContResp["estudiantes_apellido"]; ?></p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="hr-line-dashed col-xs-12"></div>
                                            </div>

                                            <div class="col-md-12">
                                                <p><strong>Integrantes: </strong> </p>
                                                <p>
                                                    <?php for ($i = 0; $i < count($integrantesarr); $i++) { ?>
                                                        <?php echo $integrantesarr[$i]; ?><br>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="hr-line-dashed col-xs-12"></div>
                                            </div>

                                            <div class="col-md-12">
                                                <p><strong>Equipos: </strong> </p>
                                            </div>
                                            <div class="col-md-12">
                                                <?php for ($i = 0; $i < count($equipos); $i++) { ?>
                                                    <div class="claseequipo" id="<?php echo $equipos[$i]["id"]; ?>">
                                                        <div class="nombre"><?php echo $equipos[$i]["nombre"]; ?></div>
                                                        
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="hr-line-dashed col-xs-12"></div>
                                            </div>

                                            
                                            <div class="col-md-12">
                                            <label for="responsable">Estado</label>
                                                <select name="estado" class="form-control" id="estado">

                                                    <option value="0" <?php if($arrCont["pedidos_estado"] == 0){?>selected<?php } ?>>Seleccionar Estado</option>
                                                    <option value="1" <?php if($arrCont["pedidos_estado"] == 1){?>selected<?php } ?>>Reservado</option>
                                                    <option value="2" <?php if($arrCont["pedidos_estado"] == 2){?>selected<?php } ?>>Entregado</option>
                                                    <option value="3" <?php if($arrCont["pedidos_estado"] == 3){?>selected<?php } ?>>Devuelto</option>
                                                    <option value="4" <?php if($arrCont["pedidos_estado"] == 4){?>selected<?php } ?>>Cancelado</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="hr-line-dashed col-xs-12"></div>
                                            </div>

                                        </div>





                                    </div>

                                    <div class="form-group text-center " style="margin-top: 30px;">
                                        <input name="agregar" type="submit" class="btn btn-primary" id="agregar" value="Cambiar Estado">

                                        <a href="pdf/topdf.php?idPedido=<?php echo $intIdCont; ?>" class="btn btn-primary" target="_blank">Imprimir</a>
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
                startDate: stardaten + " 00:00 AM",
                todayBtn: "linked",
                todayHighlight: true
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
            //var id = $(this).parent().attr("id");
            console.log(id);

            var cont = "<div class=\"claseequipo\" id=\"" + id + "\"><div class=\"nombre\">" + nombre + "</div><div class=\"borrar-btn\" onclick=\"borrarMod(" + id + ")\"><i class=\"fa fa-remove\" aria-hidden=\"true\"></i></div></div>";

            $("#contenedor-modulos").append(cont);

            var cantidad = idModulo + 1;
            $("#cantidadModulos").val(cantidad);
            ordenModulo.push(id);
            $("#ordenModulos").val(ordenModulo);



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

            /*console.log(fechasalida);
            console.log(fecharegreso);*/


            $.ajax({
                    method: "POST",
                    url: "armaComboPed02.php",
                    data: {
                        idSubClase: idSubClase,
                        fechasalida: fechasalida,
                        fecharegreso: fecharegreso
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
    </script>



</body>

</html>