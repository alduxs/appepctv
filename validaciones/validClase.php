<?php
include_once('../includes/conexion.inc.php');
include_once('../includes/funciones.inc.php');
//
include_once('../includes/class.inc.php');
//
$link = Conectarse();
//
$objContenido   = new General();
//
$tipo = $_POST["tipo"];
if($tipo == 1){
        $nombre = $_POST["nombre"];
        $query = "SELECT *
        FROM equipo_clases
        WHERE ecl_nombre LIKE '%".$nombre."%'";
        $rsCont = $objContenido->getAllContenido($link, $query);
        $intQtyRecords = $rsCont->rowCount();

} else if($tipo == 2){
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];

        $query = "SELECT *
        FROM equipo_clases
        WHERE ecl_nombre LIKE '%".$nombre."%' AND ecl_id !=".$id;
        $rsCont = $objContenido->getAllContenido($link, $query);
        $intQtyRecords = $rsCont->rowCount();
}
echo $intQtyRecords;