<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
	include_once('includes/class.inc.php');
	include_once('includes/conexion.inc.php');
	include_once('includes/funciones.inc.php');
	//
	$link = Conectarse();
	// Recibo las variables 
	$strEmail = filter_var($_POST["strEmail"], FILTER_SANITIZE_STRING);
	$strEmail = htmlspecialchars($strEmail, ENT_QUOTES);
	$strPassword = filter_var($_POST["strPassword"], FILTER_SANITIZE_STRING);
	
	$arrData[0] = $strEmail;
	$arrData[1] = sha1($strPassword);
	$objUsuario = new Usuarios();
	$Login = $objUsuario->makeBackendLogin($link,$arrData);
	//
	if($Login->rowCount() <= 0){
		header("Location: " . _CONST_BACKEND_ . "index.php?idErr=1");
	}
	else{
		session_start();
		$arrUser = $Login->fetch(PDO::FETCH_BOTH);
		$_SESSION["strUsername"] = $strEmail;
		$_SESSION["strName"] = $arrUser["ds_nombre"]." ".$arrUser["ds_apellido"];
		$_SESSION["id"] = $arrUser["id_usuario"];
		$_SESSION["tipo"] = $arrUser["id_tipo"];
		$_SESSION["imagen"] = $arrUser["ds_imagen"];
		header("Location: " . _CONST_BACKEND_ . "home.php?seccion=inicio");
		$arrUser = null;
		$link = null;
	}
?>