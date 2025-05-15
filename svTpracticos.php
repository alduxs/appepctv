<?php
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
$link = Conectarse();
include_once('includes/class.inc.php');
//
include("includes/class.upload.php");
//
$strOperacion = sanStrHtmlSpecial($_POST["strOperacion"]);
//
switch ($strOperacion) {
  case 'I':
    //
    $Uploads = new iUpload();
    $Insert_row = new General();

    //T maximo
    $multiplicador = sanInt($_POST["tmaximo"]);
    $tmaximo = (3600*24)*$multiplicador;

    $arrData[0] = '';
    $arrData[1] = sanStrHtml($_POST["nombre"]);
    $arrData[2] = sanInt($_POST["categoria"]);
    $arrData[3] = $tmaximo;
    

    //
    $query = "INSERT INTO trabajos_practicos (tp_nombre,tp_categoria,tp_max_time) VALUES (?,?,?)";
    $intIdRegistro = $Insert_row->insertContenido($link, $arrData, $query);

    break;

  case 'U':
    //
    $arrData[0] = sanInt($_POST["id"]);
    $target_path = _CONST_PATH_IMG_;
    $Update_row = new General();
    


    //T maximo
    $multiplicador = sanInt($_POST["tmaximo"]);
    $tmaximo = (3600*24)*$multiplicador;

    $arrData[1] = sanStrHtml($_POST["nombre"]);
    $arrData[2] = sanInt($_POST["categoria"]);
    $arrData[3] = $tmaximo;
    //
    $query = "UPDATE trabajos_practicos SET tp_nombre = ?, tp_categoria = ?, tp_max_time = ? WHERE tp_id = ?";
    $intIdRegistro = $Update_row->updateContenido($link, $arrData, $query);


    break;

  case 'D':
    //Recibo variables
    $arrData[0] = sanInt($_POST["intIdRegistro"]);
    $arrData[1] = sanStrHtmlSpecial($_POST["strDb"]);

    // Borro el registro de la DB
    $objRegistro = new ComonClases();
    $rsRegistro = $objRegistro->deleteRegistro($link, $arrData);
    //
    break;
}
//
header("Location: lstTpracticos.php?seccion=tpracticos");
