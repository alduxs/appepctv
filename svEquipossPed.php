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
  
  case 'D':
    //Recibo variables
    $arrData[0] = sanInt($_POST["intIdRegistro"]);
    $arrData[1] = sanStrHtmlSpecial($_POST["strDb"]);

    

    // Borramos la Imagen de la obra
    $Update_row = new General();
   
    //Borra notas  relacionadas
    $strQuery = "DELETE FROM pedidos_equipos WHERE pe_id = " . $arrData[0];
    
    $rsContd = $Update_row->getAllContenido($link, $strQuery);
    //
    break;

    case 'A':
    
      // Borramos la Imagen de la obra
      $Update_row = new General();
     
      //Borra notas  relacionadas
      $strQuery = "DELETE FROM pedidos_equipos WHERE pe_id = " . $arrData[0];
      
      $rsContd = $Update_row->getAllContenido($link, $strQuery);
      //
      break;

      
}
//
if($strOperacion == "D"){
  header("Location: lstEquipossPed.php?seccion=equipos");
} else if($strOperacion == "A"){
  header("Location: home.php?seccion=inicio");
}

