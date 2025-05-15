<?php
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
//
include_once('includes/class.inc.php');
//
$link = Conectarse();
//
$objContenido   = new General();
//
$idClase = $_POST["idClase"];
//
$query = "SELECT ec.*,ecr.* 
FROM equipo_clases ec
LEFT JOIN equipos_clases_relacion ecr ON ecr.eqr_id_clase = ec.ecl_id
WHERE ecr.eqr_id_padre=" . $idClase ;
$rsCont = $objContenido->getAllContenido($link, $query);
?>
<option value="0">Selecciones una sub clase</option>
<?php 
while ($arrCont = $rsCont->fetch(PDO::FETCH_BOTH)) {

//
?>
<option value="<?php echo $arrCont["eqr_id_clase"]; ?>"><?php echo $arrCont["ecl_nombre"]; ?></option>
<?php }?>