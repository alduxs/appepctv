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
$idTemp = $_POST["idTemp"];

$response = array();

$query = "SELECT *
    FROM pedidos_equipos_temp pe
    WHERE pe.pe_id_pedido_temp ='" . $idTemp . "'";
$rsCont = $objContenido->getAllContenido($link, $query);
$intQtyRecords = $rsCont->rowCount();


if ($intQtyRecords > 0) {

    $response = ["estado" => 1];
} else {
    $response = ["estado" => 0];
}

echo json_encode($response);
