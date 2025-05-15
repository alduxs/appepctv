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
echo $intIdRegistro;
?>