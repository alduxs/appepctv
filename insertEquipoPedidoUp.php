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






/*$idactual = $_POST["idactual"];
$idEquipo = $_POST["idequipo"];
$fechasalida = $_POST["fechasalida"];
$fecharegreso = $_POST["fecharegreso"];
//
$arrData[0] = '';
$arrData[1] = 0;
$arrData[2] = $idactual;
$arrData[3] = $idEquipo;
$arrData[4] = $fechasalida;
$arrData[5] = $fecharegreso;
$arrData[6] = 0;
$arrData[7] = 0;
//
$query = "INSERT INTO pedidos_equipos (pe_id_pedido_temp,pe_id_pedido,pe_id_equipo,pe_fechain,pe_fechaout,pe_estado,pe_posicion) VALUES (?,?,?,?,?,?,?)";
$intIdRegistro = $objContenido->insertContenido($link, $arrData, $query); //Registro de página*/
?>