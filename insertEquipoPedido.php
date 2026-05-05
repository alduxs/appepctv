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
$idTemporal = $_POST["idtemporal"];
$idEquipo = $_POST["idequipo"];
//
$arrData[0] = '';
$arrData[1] = $idTemporal;
$arrData[2] = $idEquipo;
//
$query = "INSERT INTO pedidos_equipos_temp (pe_id_pedido_temp,pe_id_equipo) VALUES (?,?)";
$intIdRegistro = $objContenido->insertContenido($link, $arrData, $query); //Registro de página

$arr = array(
    'idEquipo' => $idEquipo, 
    'idRegistro' => $intIdRegistro , 
);

// Agregado para ORdenar

//EQUIPOS
$queryEqip = "SELECT peq.*,eq.*
            FROM pedidos_equipos_temp peq
            LEFT JOIN equipos eq ON eq.eq_id = peq.pe_id_equipo
            WHERE peq.pe_id_pedido_temp = '" . $idTemporal . "'
            ORDER BY eq.eq_clase ASC, eq.eq_subclase ASC, eq.eq_nombre ASC";

//var_dump($queryEqip);exit();

$rsContEqip = $objContenido->getAllContenido($link, $queryEqip);

$equipos = array();
$lines = array();

while ($arrContenidoEq = $rsContEqip->fetch(PDO::FETCH_BOTH)) {

    $lines = ["id" => $arrContenidoEq["eq_id"], "nombre" => $arrContenidoEq["eq_nombre"], "idregistro" => $arrContenidoEq["pe_id"]];
    array_push($equipos, $lines);
}

//echo json_encode($arr);
echo json_encode($equipos);
?>