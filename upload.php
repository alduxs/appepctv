<?php
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
$link = Conectarse();
include_once('includes/class.inc.php');
//
$objCont = new General();

if(isset($_POST['image']))
{
	$data = $_POST['image'];
	$nombreOriginal = $_POST['nombre'];
	$tipo = $_POST['tipo'];
	$imagenActual = $_POST['imgActual'];

	if($tipo == 1){
		$prefix = "th_";
	} else if($tipo == 2){
		$prefix = "bg_";
	} else if($tipo == 3){
		$prefix = "sl_";
	}

	// Procesa el nombre
	$porciones = explode(".", $nombreOriginal);
	$largo = count($porciones);

	$nombreFinal = "";

	if($largo > 2){
		for ($i=0; $i < ($largo-1); $i++) { 
			$nombreFinal .= $porciones[$i];
		}
	} else {
		$nombreFinal .= $nombreFinal.$porciones[0];
	}
	$Uploads = new iUpload;
	$strImg = $Uploads->renameImageBlob($nombreFinal);
	//Fin proceso Nombre

	//Proceso de cragdo de Imagen
	$image_array_1 = explode(";", $data);
	$image_array_2 = explode(",", $image_array_1[1]);
	$data = base64_decode($image_array_2[1]);
	$image_name = 'post-temp/' .$prefix. $strImg . '.jpg';
	file_put_contents($image_name, $data);
	//Fin del proceso de carga de imágenes

	//Proceso de borrado y carga
	
	if($imagenActual == "nd"){
	// Caso 1: Es la primera imagen que se carga.
	// 1 - Se guarda un registro en la tabla temporal
		$imagen = $prefix.$strImg.".jpg";
		$arrData[0] = '';
		$arrData[1] = $imagen;
		$arrData[2] = $tipo;
		//Inserta el registro
		$query = "INSERT INTO equiposximag_temp (exit_imagen,exit_tipo) VALUES (?,?)";
		$intIdRegistro = $objCont->insertContenido($link,$arrData,$query);
	} else {
	// Caso 2: Ya se cargaron otras imagenes.
	// 1 - Se consulta si exiten en la tabla temporal
		$query = "SELECT * FROM equiposximag_temp WHERE exit_imagen='".$imagenActual."'";
		$rsCont = $objCont->getAllContenido($link, $query);
		$intQtyRecords = $rsCont->rowCount();
		if($intQtyRecords > 0){
		// Si existe:
		// 1 - Borrar imagen de la carpeta temporal
		// 2 - Borrar registro de tabla temporal
		// 3 - Se guarda un registro en la tabla temporal

			//Borrar Imagen
			$target_path = "post-temp/".$imagenActual;
			$Uploads->deleteFile($target_path);

			//Borrar registro
			$query = "DELETE FROM equiposximag_temp WHERE exit_imagen = '".$imagenActual."'";
			$rsCont = $objCont->getAllContenido($link, $query);
			//Inserta el registro
			$imagen = $prefix.$strImg.".jpg";
			$arrData[0] = '';
			$arrData[1] = $imagen;
			$arrData[2] = $tipo;
			$query = "INSERT INTO equiposximag_temp (exit_imagen,exit_tipo) VALUES (?,?)";
			$intIdRegistro = $objCont->insertContenido($link,$arrData,$query);
		}
	}


	//Carga Base de datos temporal
	$image_name .="/".$intIdRegistro;
	echo $image_name;
}
