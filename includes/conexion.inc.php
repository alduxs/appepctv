<?php // Fichero con los datos de conexion a la BBDD
function Conectarse()
{

	$db_host="localhost"; // Host al que conectar, habitualmente es el 'localhost'
	$db_nombre="w4000007_app2"; // Nombre de la Base de Datos que se desea utilizar
	$db_user="c2390748_epctv"; // Nombre del usuario con permisos para acceder
	$db_pass="goGE57toso"; // Contraseña de dicho usuario*/

	/*$db_host="localhost"; // Host al que conectar, habitualmente es el 'localhost'
	$db_nombre="w4000007_app2"; // Nombre de la Base de Datos que se desea utilizar
	$db_user="w4000007_app"; // Nombre del usuario con permisos para acceder
	$db_pass="ne32laLAve"; // Contraseña de dicho usuario*/



	try {
    	$link = new PDO('mysql:host='.$db_host.';dbname='.$db_nombre, $db_user, $db_pass);
    	return $link;
	} catch (PDOException $e) {
		print "Error: " . $e->getMessage() . "<br/>";
		die();
	}
}
?>
