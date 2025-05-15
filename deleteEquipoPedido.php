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
//$idEquipo = $_POST["idequipo"];
$idRegistro = $_POST["idregistro"];
//$destino = $_POST["destino"];
//

//
//if($destino == 1){
    //$query = "DELETE FROM pedidos_equipos_temp WHERE pe_id_pedido_temp = '" . $idTemporal."' AND pe_id_equipo =".$idEquipo;
    $query = "DELETE FROM pedidos_equipos_temp WHERE pe_id =".$idRegistro;
    $intIdRegistroDel1 = $objContenido->getAllContenido($link, $query);
/*} else if($destino == 2) {
    //$query = "DELETE FROM pedidos_equipos_temp WHERE pe_id_pedido_temp = '" . $idTemporal."' AND pe_id_equipo =".$idEquipo;
    $query = "DELETE FROM pedidos_equipos WHERE pe_id =".$idRegistro;
    $intIdRegistroDel1 = $objContenido->getAllContenido($link, $query);
}*/

?>