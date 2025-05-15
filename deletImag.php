<?php
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
$link = Conectarse();
include_once('includes/class.inc.php');
//
if (isset($_POST['imagen'])) {

  if ($_POST['origen'] == 2) {
    $Update_row = new General();
    $Uploads = new iUpload();
    $target_path_bg = _CONST_PATH_IMG_;

    $query = "SELECT * FROM equiposximagenes WHERE exi_imagen = '" . $_POST['imagen'] . "'";
    $rsCont = $Update_row->getAllContenido($link, $query);
    $intQtyRecords = $rsCont->rowCount();
    $arrContenido = $rsCont->fetch(PDO::FETCH_BOTH);

    if ($intQtyRecords > 0) {


      $Uploads->deleteFile($target_path_bg . $arrContenido["exi_imagen"]); //Borra Archivo
      $query = "DELETE FROM equiposximagenes WHERE exi_id =" . $arrContenido["exi_id"];
      $rsCont = $Update_row->getAllContenido($link, $query);
    }
  } else if ($_POST['origen'] == 1) {
    $Update_row = new General();
    $Uploads = new iUpload();
    $target_path_bg = _CONST_PATH_TH_IMG_;

    $query = "SELECT * FROM equiposximag_temp WHERE exit_imagen = '" . $_POST['imagen'] . "'";
    $rsCont = $Update_row->getAllContenido($link, $query);
    $intQtyRecords = $rsCont->rowCount();
    $arrContenido = $rsCont->fetch(PDO::FETCH_BOTH);
    

    if ($intQtyRecords > 0) {

      $Uploads->deleteFile($target_path_bg . $arrContenido["exit_imagen"]); //Borra Archivo
      $query = "DELETE FROM equiposximag_temp WHERE exit_id =" . $arrContenido["exit_id"];
      $rsCont = $Update_row->getAllContenido($link, $query);
    }
  }



  //Carga Base de datos temporal

  echo "ok";
}
