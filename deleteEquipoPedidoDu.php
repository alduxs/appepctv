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

//
$query = "DELETE FROM pedidos_equipos WHERE pe_id_pedido_temp = '" . $idTemporal."' AND pe_id_equipo =".$idEquipo;
$intIdRegistroDel1 = $objContenido->getAllContenido($link, $query);
?>