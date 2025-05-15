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
$intIdCont = $_POST["idEquipo"];
//
$query = "SELECT * FROM equipos WHERE eq_id=" . $intIdCont;
$rsCont = $objContenido->getAllContenido($link, $query);
$arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
//

//Seleccionar Imagen Rectangular Asociada
$query4 = "SELECT * FROM equiposximagenes WHERE exi_equipo_id = " . $intIdCont . " AND exi_tipo = 2";
$rsCont4 = $objContenido->getAllContenido($link, $query4);
$intQtyRecords4 = $rsCont4->rowCount();
$arrCont4 = $rsCont4->fetch(PDO::FETCH_BOTH);

//Notas relacionadas
$arrayNr = array();
$query5 = "SELECT ai.*
            FROM equipos_categoria ai
            WHERE ai.ec_id_equipo = " . $intIdCont;
$rsCont5 = $objContenido->getAllContenido($link, $query5);
$contador = 0;
while ($arrContenidoMat5 = $rsCont5->fetch(PDO::FETCH_BOTH)) {
    $arrayNr[$contador] = $arrContenidoMat5["ec_id_categoria"];
    $contador++;
}
//
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $arrCont["eq_nombre"]; ?></h4>
</div>
<div class="modal-body">
        <div class="row">
            <div class="col-md-4">
                <?php if ($intQtyRecords4 > 0) { ?>
                    <img src="equipos/<?php echo $arrCont4["exi_imagen"]; ?>" class="img-responsive" />
                <?php } else { ?>
                    <img src="img/imagen2.png" class="img-responsive" />
                <?php }  ?>
            </div>

            <div class="col-md-8">
                <p><strong>Marca y modelo:</strong> <?php echo $arrCont["eq_marca_modelo"]; ?></p>
                <p><strong>Información Adicional:</strong> </p>
                <p><?php echo  html_entity_decode( $arrCont["eq_mas_info"]); ?></p>
                <?php if($arrCont["eq_observaciones"] != "") {?>
                <p><strong>Observaciones:</strong> </p>
                <p><?php echo html_entity_decode($arrCont["eq_observaciones"]); ?></p>
                <?php } ?>
                <?php
                $query5 = "SELECT ec.ec_id_categoria, c.cat_nombre, c.cat_id
                        FROM equipos_categoria ec
                        LEFT JOIN categorias c ON c.cat_id = ec.ec_id_categoria
                        WHERE ec.ec_id_equipo = " . $arrCont["eq_id"] . " ORDER BY c.cat_id ASC";
                $rsCont5 = $objContenido->getAllContenido($link, $query5);
                ?>
                <p><strong>Categorías:</strong> </p>
                <p>
                    <?php while ($arrCont5 = $rsCont5->fetch(PDO::FETCH_BOTH)) {
                    ?>
                     <button class="btn btn-info btn-circle" type="button"><strong><?php echo  categoriGear($arrCont5["cat_id"]); ?></strong></button>
                    <?php
                    } ?>
                </p>
            </div>

        </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>