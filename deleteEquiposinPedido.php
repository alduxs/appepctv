<?php
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
//
include_once('includes/class.inc.php');
//
$link = Conectarse();
//
$objContenido   = new General();
//
$query = "DELETE FROM pedidos_equipos WHERE pe_id_pedido = 0";
$rsCont = $objContenido->getAllContenido($link, $query);
header("Location: home.php?seccion=inicio");
?>