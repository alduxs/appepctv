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
        $apellido = $_POST["apellido"];
        $dni = $_POST["dni"];
        $email = $_POST["email"];

        

        $query1 = "SELECT *
        FROM data_estudiantes
        WHERE (estudiantes_name LIKE '%".$nombre."%' AND estudiantes_apellido LIKE '%".$apellido."%')";
        $rsCont1 = $objContenido->getAllContenido($link, $query1);
        $intQtyRecords1 = $rsCont1->rowCount();

        

        $query2 = "SELECT *
        FROM data_estudiantes
        WHERE estudiantes_dni = ".$dni;
        $rsCont2 = $objContenido->getAllContenido($link, $query2);
        $intQtyRecords2 = $rsCont2->rowCount();

        

        $query3 = "SELECT *
        FROM data_estudiantes
        WHERE estudiantes_email = '".$email."'";
        $rsCont3 = $objContenido->getAllContenido($link, $query3);
        $intQtyRecords3 = $rsCont3->rowCount();
        


} else if($tipo == 2){
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $dni = $_POST["dni"];
        $email = $_POST["email"];

        $query1 = "SELECT *
        FROM data_estudiantes
        WHERE (estudiantes_name LIKE '%".$nombre."%' AND estudiantes_apellido LIKE '%".$apellido."%') AND estudiantes_id !=".$id;
        $rsCont1 = $objContenido->getAllContenido($link, $query1);
        $intQtyRecords1 = $rsCont1->rowCount();

        $query2 = "SELECT *
        FROM data_estudiantes
        WHERE estudiantes_dni = ".$dni. " AND estudiantes_id !=".$id;
        $rsCont2 = $objContenido->getAllContenido($link, $query2);
        $intQtyRecords2 = $rsCont2->rowCount();

        $query3 = "SELECT *
        FROM data_estudiantes
        WHERE estudiantes_email = '".$email."'AND estudiantes_id !=".$id;
        $rsCont3 = $objContenido->getAllContenido($link, $query3);
        $intQtyRecords3 = $rsCont3->rowCount();
}
if($intQtyRecords1 == 0 && $intQtyRecords2 == 0 && $intQtyRecords3 == 0){
    $string = "ok";
} else {
    $string = "";
    if($intQtyRecords1 > 0){
        $string .= "Ya existe un/a alumno/a con el nombre y apellido: ".$nombre." ".$apellido.".";
    } 
    if($intQtyRecords2 > 0){
        $string .= "El DNI: ".$dni." ya está ultilizado por otro alumno/a.";
    }
    if($intQtyRecords3 > 0){
        $string .= "El e-mail: ".$email." ya está ultilizado por otro alumno/a";
    }
}
echo $string;