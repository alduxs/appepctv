<?php
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
//
include_once('includes/class.inc.php');
//
$link = Conectarse();
//
$objContenido   = new General();
//
$intIdCont = $_POST["idPedido"];
//
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

    $integrantesarr[] = $arrContResp2["estudiantes_name"]." ".$arrContResp2["estudiantes_apellido"];
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
//
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $arrCont["pedidos_nombre"]; ?></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <p><strong>Materia:</strong> <?php echo $arrContMat["materia_nombre"]; ?></p>
            <p><strong>Comisión:</strong> <?php echo $arrContDet["pd2_comision"]; ?></p>
        </div>

        <div class="col-md-6">
            <p><strong>Profesor:</strong> <?php echo $arrContProf["profesores_name"]." ".$arrContProf["profesores_apellido"]; ?></p>
            <p><strong>Curso:</strong> Nº <?php echo $arrContDet["pd2_curso"]; ?></p>
        </div>

        <div class="col-md-12">
            <p><strong>Responsable:</strong> <?php echo $arrContResp["estudiantes_name"]." ".$arrContResp["estudiantes_apellido"]; ?></p>
            <p><strong>Integrantes:</strong> <br>
            <?php for ($i = 0; $i < count($integrantesarr); $i++) { ?>
                    <?php echo $integrantesarr[$i]; ?><br>
                <?php } ?>
            
        </p>
        </div>
        <div class="col-md-12">
            <p><strong>Retiro:</strong> <?php echo revertFecha($arrCont["pedidos_fechain"]); ?> - <?php echo revertHora($arrCont["pedidos_fechain"]); ?></p>
            <p><strong>Devolución:</strong> <?php echo revertFecha($arrCont["pedidos_fechaout"]); ?> - <?php echo revertHora($arrCont["pedidos_fechaout"]); ?></p>
        </div>

        <div class="col-md-12">
            <p><strong>Equipos:</strong> </p>
            <p>
                <?php for ($i = 0; $i < count($equipos); $i++) { ?>
                    <?php echo $equipos[$i]["nombre"]; ?><br>
                <?php } ?>
            </p>
        </div>

    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>