<?php
include_once('../includes/conexion.inc.php');
include_once('../includes/funciones.inc.php');
//
include_once('../includes/class.inc.php');
//
$link = Conectarse();
//
$objContenido   = new General();
//
$idtemporal = $_POST["idtemporal"]; //ID PEDIDO
$fechasalida = $_POST["fechasalida"];
$fecharegreso = $_POST["fecharegreso"];
//
$response["estatus"] = "ok";
$response["ideq"] = null;
$idequipos = array();

$query = "SELECT *
        FROM pedidos_equipos
        WHERE pe_id_pedido_temp ='".$idtemporal."'";
        $rsCont = $objContenido->getAllContenido($link, $query);
        

while ($arrContenido = $rsCont->fetch(PDO::FETCH_BOTH)) {
    if($fechasalida != $arrContenido["pe_fechain"] || $fecharegreso != $arrContenido["pe_fechaout"]){
        
        $query = "SELECT *
        FROM pedidos_equipos
        WHERE pe_id_equipo =" . $arrContenido["pe_id_equipo"]." AND pe_id_pedido_temp !='".$idtemporal. "' AND pe_estado < 3";
        $rsCont2 = $objContenido->getAllContenido($link, $query);
        $intQtyRecords = $rsCont2->rowCount();
        $i=0;
        if($intQtyRecords > 0){
            while ($arrCont2 = $rsCont2->fetch(PDO::FETCH_BOTH)) {
                
                if($fechasalida >= $arrCont2["pe_fechain"] && $fechasalida <= $arrCont2["pe_fechaout"]) {
                    $response["estatus"] = "error";
                    $idequipos[] = $arrCont2["pe_id_equipo"];
                    $response["ideq"] = $idequipos;
                   
                } else {
                    if($fecharegreso >= $arrCont2["pe_fechain"] && $fecharegreso <= $arrCont2["pe_fechaout"]){
                        $response["estatus"] = "error";
                        $idequipos[] = $arrCont2["pe_id_equipo"];
                        $response["ideq"] = $idequipos;
                    } else {
                        $response["estatus"] = "ok";
                    }
                }
                $i++;
            }
        }

    }

}
echo json_encode($response);