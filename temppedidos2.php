<?php
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
//
include_once('includes/class.inc.php');
//
$link = Conectarse();
$objContenido = new General();

$query = "SELECT e.eq_nombre,e.eq_id,pe.pe_id
FROM pedidos_equipos pe
left join equipos e on e.eq_id = pe.pe_id_equipo
WHERE pe_id_pedido_temp = '".$_GET["id"]."'";
$rsCont = $objContenido->getAllContenido($link, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php while ($arrContenido = $rsCont->fetch(PDO::FETCH_BOTH)) { ?>
        <a href=""><?php echo $arrContenido["pe_id"]." - ".$arrContenido["eq_nombre"]." - ".$arrContenido["eq_id"]."<br>"; ?></a>
    <?php } ?>
</body>
</html>