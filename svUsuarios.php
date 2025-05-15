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
//$intPageId = sanInt($_POST["intPageId"]);
//
switch ($strOperacion) {
  case 'I':
    //
    if ($_FILES['imagen']['name'] != "") {
      $Uploads = new iUpload();
      $strImg = $Uploads->renameImage($_FILES['imagen']['name']);

      $handle = new \Verot\Upload\Upload($_FILES['imagen']);

      if ($handle->uploaded) {

        // IMAGEN SLIDE
        $handle->file_new_name_body = $strImg;
        $handle->file_name_body_pre = 'user_';
        $handle->image_resize          = true;
        $handle->image_ratio_crop      = true;
        $handle->jpeg_quality            = 100;
        $handle->image_y               = _IMG_REVISTAS_HEIGHT_;
        $handle->image_x               = _IMG_REVISTAS_WIDTH_;
        $handle->Process(_PATH_REVISTAS_);

        if ($handle->processed) {
          $imagen = $handle->file_dst_name;
        } else {
          $imagen = "nd";
        }
        $handle->Clean();
      }
    } else {
      $imagen = "nd";
    }
    //
    $arrData[0] = '';
    $arrData[1] = sanStrHtmlSpecial($_POST["strNombre"]);
    $arrData[2] = sanStrHtmlSpecial($_POST["strApellido"]);
    $arrData[3] = $imagen;
    $arrData[4] = sanStrHtmlSpecial($_POST["dni"]);
    $arrData[5] = sanStrHtmlSpecial($_POST["strEmail"]);
    $arrData[6] = sanStrHtmlSpecial($_POST["celular"]);
    $arrData[7] = sanStrHtmlSpecial($_POST["strUsuario"]);
    $arrData[8] = sha1($_POST["strPassword"]);
    $arrData[9] = sanInt($_POST["tipo"]);
    $arrData[10] = sanInt($_POST["habilitado"]);
    //
    $Insert_row = new Usuarios();
    $intIdRegistro = $Insert_row->insertUser($link, $arrData);
    break;

  case 'U':
    //
    $arrData[0] = sanInt($_POST["id"]);
    $target_path = _PATH_REVISTAS_;
    $Update_row = new General();
    $query = "SELECT * FROM login WHERE id_usuario=" . $arrData[0];
    $rsCont = $Update_row->getOneContenido($link, $arrData[0], $query);
    $arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
    //
    $Uploads = new iUpload();

    //--------------------------------------------------------------------------------------

    if ($_FILES['imagen']['name'] != "") {

      if ($arrCont["ds_imagen"] != "nd") {
        $Uploads->deleteFile($target_path . $arrCont["ds_imagen"]);
      }

      $strImg = $Uploads->renameImage($_FILES['imagen']['name']);
      $handle = new \Verot\Upload\Upload($_FILES['imagen']);

      if ($handle->uploaded) {

        // IMAGEN SLIDE
        $handle->file_new_name_body = $strImg;
        $handle->file_name_body_pre = 'user_';
        $handle->image_resize          = true;
        $handle->image_ratio_crop      = true;
        $handle->jpeg_quality            = 100;
        $handle->image_y               = _IMG_REVISTAS_HEIGHT_;
        $handle->image_x               = _IMG_REVISTAS_WIDTH_;
        $handle->Process(_PATH_REVISTAS_);

        if ($handle->processed) {
          $imagen = $handle->file_dst_name;
        } else {
          $imagen = $arrCont["ds_imagen"];
        }
        $handle->Clean();
      }
    } else {
      $imagen = $arrCont["ds_imagen"];
    }

    //----------------------------------------------------------------------------------------

    $arrData[1] = sanStrHtmlSpecial($_POST["strNombre"]);
    $arrData[2] = sanStrHtmlSpecial($_POST["strApellido"]);
    $arrData[3] = $imagen;
    $arrData[4] = sanStrHtmlSpecial($_POST["dni"]);
    $arrData[5] = sanStrHtmlSpecial($_POST["strEmail"]);
    $arrData[6] = sanStrHtmlSpecial($_POST["celular"]);
    $arrData[7] = sanStrHtmlSpecial($_POST["strUsuario"]);
    if ($_POST["strPassword"] != "") {
      $arrData[8] = sha1($_POST["strPassword"]);
    } else {
      $arrData[8] = $_POST["oldPas"];
    }
    $arrData[9] = sanInt($_POST["tipo"]);
    $arrData[10] = sanInt($_POST["habilitado"]);
    //
    $Update_row = new Usuarios();
    $intIdRegistro = $Update_row->updateUser($link, $arrData);
    break;

  case 'D':
    //Recibo variables
    $arrData[0] = sanInt($_POST["intIdRegistro"]);
    $arrData[1] = sanStrHtmlSpecial($_POST["strDb"]);
    //
    $target_path = _PATH_REVISTAS_;
    $Uploads = new iUpload();
    $Update_row = new General();
    $query = "SELECT * FROM login WHERE id_usuario=" . $arrData[0];
    $rsCont = $Update_row->getOneContenido($link, $arrData[0], $query);
    $arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
    // Borramos la Imagen
    if ($arrCont["ds_imagen"] != "nd") {
      $Uploads->deleteFile($target_path . $arrCont["ds_imagen"]);
    }
    // Borro el registro de la DB
    $objRegistro = new ComonClases();
    $rsRegistro = $objRegistro->deleteRegistro($link, $arrData);
    //
    break;
}
//
header("Location: lstUsuarios.php?seccion=usuarios&intPageId=$intPageId");
