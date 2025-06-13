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
$fechasalida = $_POST["fechasalida"];
$fecharegreso = $_POST["fecharegreso"];
$idTemp = $_POST["idTemp"];

$response = array();
$ident = array();

$query = "SELECT *
    FROM pedidos_equipos_temp pe
    WHERE pe.pe_id_pedido_temp ='" . $idTemp . "'";
$rsCont = $objContenido->getAllContenido($link, $query);
$intQtyRecords = $rsCont->rowCount();


if ($intQtyRecords > 0) {
    while ($arrCont = $rsCont->fetch(PDO::FETCH_BOTH)) {


        $query = "SELECT *
        FROM pedidos_equipos pe
        LEFT JOIN pedidos p ON p.pedidos_id = pe.pe_id_pedido
        WHERE pe.pe_id_equipo =" . $arrCont["pe_id_equipo"] . " AND p.pedidos_estado < 3";
        $rsCont2 = $objContenido->getAllContenido($link, $query);
        $intQtyRecords2 = $rsCont2->rowCount();

        if ($intQtyRecords2 > 0) {
            $estado = 0;
            while ($arrCont2 = $rsCont2->fetch(PDO::FETCH_BOTH)) {

                if ($arrCont2["pedidos_fechain"] < $fechasalida) {

                    if ($arrCont2["pedidos_fechaout"] > $fechasalida) {
                        //$equipo[$i]["estado"] = "1";
                        $ident[] = $arrCont["pe_id_equipo"];
                        $estado = 1;
                    }
                } else if ($arrCont2["pedidos_fechain"] == $fechasalida) {
                    //$equipo[$i]["estado"] = "1";
                    $ident[] = $arrCont["pe_id_equipo"];
                    $estado = 1;
                } else if ($arrCont2["pedidos_fechain"] > $fechasalida) {

                    if ($arrCont2["pedidos_fechain"] < $fecharegreso) {
                        //$equipo[$i]["estado"] = "1";
                        $ident[] = $arrCont["pe_id_equipo"];
                        $estado = 1;
                    }
                }

                /*
                $fechainrange = in_range($fechasalida, $arrCont2["pedidos_fechain"], $arrCont2["pedidos_fechaout"]);

                if ($fechainrange) {
                    $ident[] = $arrCont["pe_id_equipo"];
                    $estado = 1;
                } else {
                    $fechaoutrange = in_range($fecharegreso, $arrCont2["pedidos_fechain"], $arrCont2["pedidos_fechaout"]);
                    if ($fechaoutrange) {
                        $ident[] = $arrCont["pe_id_equipo"];
                        $estado = 1;
                    }
                }
                    */
            }
            $response = ["estado" => $estado, "identificadores" => $ident];
        } else {
            $response = ["estado" => 0, "identificadores" => $ident];
        }
    }
} else {
    $response = ["estado" => 0, "identificadores" => $ident];
}

echo json_encode($response);
