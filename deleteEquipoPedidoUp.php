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
$idactual = $_POST["idactual"];
$idEquipo = $_POST["idequipo"];

//

//
$query = "DELETE FROM pedidos_equipos WHERE pe_id_pedido = '" . $idactual."' AND pe_id_equipo =".$idEquipo;
$intIdRegistroDel1 = $objContenido->getAllContenido($link, $query);
?>