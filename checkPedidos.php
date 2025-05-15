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
$idtemporalControl = $_POST["idtemporalControl"];
//

//
$query = "SELECT *
            FROM pedidos_equipos
            WHERE pe_id_pedido_temp = '".$idtemporalControl."'";
$rsCont = $objContenido->getAllContenido($link, $query);
$intQtyRecords = $rsCont->rowCount();
echo $intQtyRecords;
?>