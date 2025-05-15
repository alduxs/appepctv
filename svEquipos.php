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

    $imagen = "nd";

    $arrData[0] = '';
    $arrData[1] = sanStrHtml($_POST["nombre"]);
    $arrData[2] = "";
    $arrData[3] = sanStrHtml($_POST["marcamodelo"]);
    $arrData[4] = sanStrHtml($_POST["observaciones"]);
    $arrData[5] = sanInt($_POST["enservicio"]);
    $arrData[6] = 1;
    $arrData[7] = sanInt($_POST["clase"]);
    $arrData[8] = 0;
    $arrData[9] = 0;
    $arrData[10] = sanStrHtml($_POST["infoadicional"]);
    if($_POST["subclase"]!=""){
      $arrData[11] = sanInt($_POST["subclase"]);
    } else {
      $arrData[11] = 0;
    }

    //
    $query = "INSERT INTO equipos (eq_nombre,eq_codigo,eq_marca_modelo,eq_observaciones,eq_enservicio,eq_estado,eq_clase,eq_time_inicio,eq_time_fin,eq_mas_info,eq_subclase) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $intIdRegistro = $Insert_row->insertContenido($link, $arrData, $query);

    //Processa Imagenes
    //Imagen Rectangular
    if ($_POST["imageNewRect"] != "nd") {
      //Consulta en la Tabla Temporal
      $imagenRect = $_POST["imageNewRect"];
      $query = "SELECT * FROM equiposximag_temp WHERE exit_imagen ='" . $imagenRect . "'";
      $rsCont = $Insert_row->getAllContenido($link, $query);
      $arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
      $intQtyRecords = $rsCont->rowCount();

      if ($intQtyRecords > 0) {

        //Inserta registro en Tabla definitiva
        $arrData2[0] = '';
        $arrData2[1] = $intIdRegistro;
        $arrData2[2] = $imagenRect;
        $arrData2[3] = $arrCont["exit_tipo"];

        $query = "INSERT INTO equiposximagenes (exi_equipo_id,exi_imagen,exi_tipo) VALUES (?,?,?)";
        $intIdRegistro3 = $Insert_row->insertContenido($link, $arrData2, $query);

        //Borra el registro de la Tabla Temporal
        $query = "DELETE FROM equiposximag_temp WHERE exit_imagen = '" . $imagenRect . "'";
        $rsCont = $Insert_row->getAllContenido($link, $query);

        //Mueve el archivo
        rename("post-temp/" . $imagenRect . "", "equipos/" . $imagenRect . "");
      }
    }

    //Notas relacionadas
    if (count($_POST["categoria"]) > 0) {

      $arrData3[0] = '';
      $arrData3[1] = $intIdRegistro;


      for ($i = 0; $i < count($_POST["categoria"]); $i++) {

        $tag = $_POST["categoria"][$i];

        $arrData3[2] = $tag;

        $query = "INSERT INTO equipos_categoria (ec_id_equipo,ec_id_categoria) VALUES (?,?)";
        $idTag = $Insert_row->insertContenido($link, $arrData3, $query);
      }
    }


    break;

  case 'U':
    //
    $arrData[0] = sanInt($_POST["id"]);
    $target_path = _CONST_PATH_IMG_;
    $Update_row = new General();
    $query = "SELECT * FROM equipos WHERE eq_id=" . $arrData[0];
    $rsCont = $Update_row->getOneContenido($link, $arrData[0], $query);
    $arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
    //
    $Uploads = new iUpload();
    $Update_row = new General();


    $imagen = "nd";

    $arrData[1] = sanStrHtml($_POST["nombre"]);
    $arrData[2] = "";
    $arrData[3] = sanStrHtml($_POST["marcamodelo"]);
    $arrData[4] = sanStrHtml($_POST["observaciones"]);
    $arrData[5] = sanInt($_POST["enservicio"]);
    $arrData[6] = sanInt($_POST["estado"]);
    $arrData[7] = sanInt($_POST["clase"]);
    $arrData[8] = sanStrHtml($_POST["timeInicio"]);;
    $arrData[9] = sanStrHtml($_POST["timeFinal"]);;
    $arrData[10] = sanStrHtml($_POST["infoadicional"]);
    if($_POST["subclase"]!=""){
      $arrData[11] = sanInt($_POST["subclase"]);
    } else {
      $arrData[11] = 0;
    }
    //
    $query = "UPDATE equipos SET eq_nombre = ?, eq_codigo = ?, eq_marca_modelo = ?,eq_observaciones = ?,eq_enservicio = ?,eq_estado = ?,eq_clase = ?,eq_time_inicio = ?,eq_time_fin = ?,eq_mas_info = ?, eq_subclase = ? WHERE eq_id = ?";
    $intIdRegistro = $Update_row->updateContenido($link, $arrData, $query);

    //Processa Imagenes
    

    //Imagen Rectangular
    if ($_POST["iRectStat"] != 0) {
      if ($_POST["iRectStat"] == 1) {
        //Consulta en la Tabla Temporal
        $imagenRect = $_POST["imageNewRect"];
        $query = "SELECT * FROM equiposximag_temp WHERE exit_imagen ='" . $imagenRect . "'";
        $rsCont = $Update_row->getAllContenido($link, $query);
        $arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
        $intQtyRecords = $rsCont->rowCount();

        if ($intQtyRecords > 0) {

          //Inserta registro en Tabla definitiva
          $arrData2[0] = '';
          $arrData2[1] = $arrData[0];
          $arrData2[2] = $imagenRect;
          $arrData2[3] = $arrCont["exit_tipo"];

          $query = "INSERT INTO equiposximagenes (exi_equipo_id,exi_imagen,exi_tipo) VALUES (?,?,?)";
          $intIdRegistro2 = $Update_row->insertContenido($link, $arrData2, $query);

          //Borra el registro de la Tabla Temporal
          $query = "DELETE FROM equiposximag_temp WHERE exit_imagen = '" . $imagenRect . "'";
          $rsCont = $Update_row->getAllContenido($link, $query);

          //Mueve el archivo
          rename("post-temp/" . $imagenRect . "", "equipos/" . $imagenRect . "");
        }
      } else if ($_POST["iRectStat"] == 2) {

        $imagenRect = $_POST["imageNewRect"];
        $imagenOldRect = $_POST["imageOldRect"];


        //Consulta en la Tabla Final
        $query = "SELECT * FROM equiposximagenes WHERE exi_imagen ='" . $imagenOldRect . "'";
        $rsCont = $Update_row->getAllContenido($link, $query);
        $arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
        $intQtyRecords = $rsCont->rowCount();

        if ($intQtyRecords > 0) {
          //Borra Archivo de carpeta
          $target_path = _CONST_PATH_IMG_;
          $Uploads->deleteFile($target_path . $imagenOldRect); //Borra Archivo

          //Borra el registro de la Tabla final
          $query = "DELETE FROM equiposximagenes WHERE exi_imagen = '" . $imagenOldRect . "'";
          $rsCont = $Update_row->getAllContenido($link, $query);
        }

        $query = "SELECT * FROM equiposximag_temp WHERE exit_imagen ='" . $imagenRect . "'";
        $rsCont = $Update_row->getAllContenido($link, $query);
        $arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
        $intQtyRecords = $rsCont->rowCount();

        if ($intQtyRecords > 0) {

          //Inserta registro en Tabla definitiva
          $arrData2[0] = '';
          $arrData2[1] = $arrData[0];
          $arrData2[2] = $imagenRect;;
          $arrData2[3] = $arrCont["exit_tipo"];

          $query = "INSERT INTO equiposximagenes (exi_equipo_id,exi_imagen,exi_tipo) VALUES (?,?,?)";
          $intIdRegistro2 = $Update_row->insertContenido($link, $arrData2, $query);

          //Borra el registro de la Tabla Temporal
          $query = "DELETE FROM equiposximag_temp WHERE exit_imagen = '" . $imagenRect . "'";
          $rsCont = $Update_row->getAllContenido($link, $query);

          //Mueve el archivo
          rename("post-temp/" . $imagenRect . "", "equipos/" . $imagenRect . "");
        }
      }
    };

    //Borra notas  relacionadas
    $strQuery = "DELETE FROM equipos_categoria WHERE ec_id_equipo = " . $arrData[0];
    $rsContd = $Update_row->getAllContenido($link, $strQuery);

    //Notas relacionadas
    //Notas relacionadas
    if (count($_POST["categoria"]) > 0) {

      $arrData3[0] = '';
      $arrData3[1] =$arrData[0];


      for ($i = 0; $i < count($_POST["categoria"]); $i++) {

        $tag = $_POST["categoria"][$i];

        $arrData3[2] = $tag;

        $query = "INSERT INTO equipos_categoria (ec_id_equipo,ec_id_categoria) VALUES (?,?)";
        $idTag = $Update_row->insertContenido($link, $arrData3, $query);
      }
    }


    break;

  case 'D':
    //Recibo variables
    $arrData[0] = sanInt($_POST["intIdRegistro"]);
    $arrData[1] = sanStrHtmlSpecial($_POST["strDb"]);

    // Borramos la Imagen de la obra
    $Update_row = new General();
    $Uploads = new iUpload();
    $target_path_bg = _CONST_PATH_IMG_;

    $query = "SELECT * FROM equiposximagenes WHERE exi_equipo_id =" . $arrData[0];
    $rsCont = $Update_row->getAllContenido($link, $query);
    $intQtyRecords = $rsCont->rowCount();

    if ($intQtyRecords > 0) {
      while ($arrContenido = $rsCont->fetch(PDO::FETCH_BOTH)) {
        if ($arrContenido["exi_tipo"] == 1) {
          $Uploads->deleteFile($target_path_th . $arrContenido["exi_imagen"]); //Borra Archivo
        } else if ($arrContenido["exi_tipo"] == 2) {
          $Uploads->deleteFile($target_path_bg . $arrContenido["exi_imagen"]); //Borra Archivo
        }
      }
      $query = "DELETE FROM equiposximagenes WHERE exi_equipo_id =" . $arrData[0];
      $rsCont = $Update_row->getAllContenido($link, $query);
    }

    //Borra notas  relacionadas
    $strQuery = "DELETE FROM equipos_categoria WHERE ec_id_equipo = " . $arrData[0];
    $rsContd = $Update_row->getAllContenido($link, $strQuery);

    // Borro el registro de la DB
    $objRegistro = new ComonClases();
    $rsRegistro = $objRegistro->deleteRegistro($link, $arrData);
    //
    break;
}
//
header("Location: lstEquipos.php?seccion=equipos");
