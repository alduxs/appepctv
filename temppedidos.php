<?php
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
//
include_once('includes/class.inc.php');
//
$link = Conectarse();
$objContenido = new General();

$query = "SELECT *
FROM pedidos_equipos
WHERE pe_id_equipo = 95
group by pe_id_pedido_temp";
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
        <a href="temppedidos2.php?id=<?php echo $arrContenido["pe_id_pedido_temp"]; ?>"><?php echo $arrContenido["pe_id_pedido_temp"]."<br>"; ?></a>
    <?php } ?>
</body>
</html>