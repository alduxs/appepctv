<?php

define ('_CONST_PAGINADO_', "20");
define ('_CONST_PAGINADO_H_', "6");

$host = $_SERVER["HTTP_HOST"];

if ($host == "localhost" || $host == "192.168.100.106"):
	$urlweb = "http://".$host."/appepctv/";
	$urladmin = "http://".$host."/appepctv/admin/";
else:
	$urlweb = "http://".$host."/";
	$urladmin = "http://".$host."/admin/";
endif;

define ('_CONST_DOMINIO_', $urlweb);
define ('_CONST_BACKEND_', $urladmin);

define ('_CONST_TITLE_', "EPCTV - Sistema de Pedido de Equipos");
define ('_CONST_CONTACT_', "agi.iniguez@gmail.com");



/* ---------------------------------------------------------------------*/

//Usuarios
define ('_PATH_REVISTAS_', "usuarios/");
define ('_IMG_REVISTAS_WIDTH_', "600");
define ('_IMG_REVISTAS_HEIGHT_', "600");


//IMAGEN EQUIPO
define ('_CONST_PATH_IMG_', "equipos/");
define ('_CONST_PATH_TH_IMG_', "post-temp/");
define ('_CONST_IMG_WIDTH_', "800");
define ('_CONST_IMG_HEIGHT_', "600");

//IMAGEN POST
/*define ('_CONST_PATH_IMG_', "../assets/post/");
define ('_CONST_IMG_WIDTH_', "563");
define ('_CONST_IMG_HEIGHT_', "800");

//IMAGEN POST THUMB
define ('_CONST_PATH_THUMB_IMG_', "../assets/post/thumb/");
//IMAGEN POST BIG
define ('_CONST_PATH_BIG_IMG_', "../assets/post/big/");

//IMAGEN USUARIOS SMALL
define ('_PATH_USER_IMG_', "files/");
define ('_IMG_USER_SMALL_WIDTH_', "500");
define ('_IMG_USER_SMALL_HEIGHT_', "500");

//SOCIOS
define ('_PATH_SOCIOS_', "../assets/socios/");
define ('_IMG_SOCIOS_WIDTH_', "400");
define ('_IMG_SOCIOS_HEIGHT_', "200");

//DOCENTES
define ('_PATH_DOC_', "../assets/docentes/");
define ('_IMG_DOC_WIDTH_', "500");
define ('_IMG_DOC_HEIGHT_', "500");

//DIRECTIVOS
define ('_PATH_DIR_', "../assets/directivos/");


//ARCHIVOS
define ('_PATH_ARCHIVOS_', "../assets/archivos/");

//INTEGRANTES DE ALAINZAS
define ('_PATH_INT_ALI_', "../assets/alianzas/");
define ('_IMG_INT_ALI_WIDTH_', "400");
define ('_IMG_INT_ALI_HEIGHT_', "200");*/

?>
