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
$idSubClase = $_POST["idSubClase"];
$fechasalida = $_POST["fechasalida"];
$fecharegreso = $_POST["fecharegreso"];
$modexist = $_POST["modexist"];
$idTemp = $_POST["idTemp"];

$fechalimite = date("YmdHi");

$partes = explode(",", $modexist);
//
$equipo = array();
$equiposdisponible = array();
//
$query = "SELECT *
FROM equipos
WHERE eq_subclase =" . $idSubClase . " AND eq_enservicio = 1";
$rsCont = $objContenido->getAllContenido($link, $query);

while ($arrCont = $rsCont->fetch(PDO::FETCH_BOTH)) {
    $linea = ["id" => $arrCont["eq_id"], "nombre" => $arrCont["eq_nombre"], "estado" => "0", "mismopedido" => "0"];
    array_push($equipo, $linea);
}


for ($i = 0; $i < count($equipo); $i++) {
    $query = "SELECT *
    FROM pedidos_equipos pe
    LEFT JOIN pedidos p ON p.pedidos_id = pe.pe_id_pedido
    WHERE pe_id_equipo =" . $equipo[$i]["id"] . " AND p.pedidos_estado < 3 AND  p.pedidos_fechaout >= '" . $fechalimite . "' AND pe_id_pedido_temp != '".$idTemp."'";

    $rsCont = $objContenido->getAllContenido($link, $query);
    $intQtyRecords = $rsCont->rowCount();

    if ($intQtyRecords > 0) {
        while ($arrCont = $rsCont->fetch(PDO::FETCH_BOTH)) {

            if ($arrCont["pedidos_fechain"] < $fechasalida) {
    
                if ($arrCont["pedidos_fechaout"] > $fechasalida) {
                    $equipo[$i]["estado"] = "1";
                }
            } else if ($arrCont["pedidos_fechain"] == $fechasalida) {
                $equipo[$i]["estado"] = "1";
            } else if ($arrCont["pedidos_fechain"] > $fechasalida) {
              
                if ($arrCont["pedidos_fechain"] < $fecharegreso) {
                    $equipo[$i]["estado"] = "1";
                }
            }

        }
    }
}


for ($i = 0; $i < count($equipo); $i++) {
    $query = "SELECT *
    FROM pedidos_equipos_temp pe
    WHERE pe.pe_id_equipo =" . $equipo[$i]["id"] . " AND pe.pe_id_pedido_temp ='" . $idTemp . "'";
    $rsCont = $objContenido->getAllContenido($link, $query);
    $intQtyRecords = $rsCont->rowCount();
    if ($intQtyRecords > 0) {
        $equipo[$i]["estado"] = "1";
        $equipo[$i]["mismopedido"] = "1";
    }
}

?>

<?php for ($i = 0; $i < count($equipo); $i++) { ?>

    <?php if ($equipo[$i]["estado"] == 1) { ?>

        <?php if ($equipo[$i]["mismopedido"] == 1) { ?>
            <div class="claseequipo2off" id="e<?php echo $equipo[$i]['id']; ?>">
                <div class="nombre"><?php echo $equipo[$i]['nombre']; ?> - <i>Ocupado en este pedido</i> </div>
            </div>
        <?php } else { ?>
            <div class="claseequipo2off" id="e<?php echo $equipo[$i]['id']; ?>">
                <div class="nombre"><?php echo $equipo[$i]['nombre']; ?> - <i>No disponible para las fechas establecidas</i> <a href="#" class="btn btn-primary btn-bitbucket nombreocupado" data-toggle="tooltip" data-placement="bottom" title="Pedidos en los que esta el equipo" id="f-<?php echo $equipo[$i]['id']; ?>"><i class="fa fa-caret-down" aria-hidden="true"></i></a></div>
            </div>

            <?php
            $query = "SELECT * 
            FROM pedidos_equipos pe
            LEFT JOIN pedidos p ON p.pedidos_id = pe.pe_id_pedido
            WHERE pe_id_equipo = " . $equipo[$i]['id'] . " AND (p.pedidos_estado = 1 || p.pedidos_estado = 2)
            ORDER BY p.pedidos_estado DESC, p.pedidos_fechain DESC LIMIT 0,3";

            $rsCont2 = $objContenido->getAllContenido($link, $query);
            ?>

            <div class="pedidosocupados" style="padding: 0px 20px;display:none;" id="po<?php echo $equipo[$i]['id']; ?>">
                <table id="table"
                    data-toggle="table"
                    data-search="false"
                    data-show-toggle="true"
                    data-show-fullscreen="false"
                    data-show-columns="true"
                    data-show-columns-toggle-all="true"
                    data-detail-view="false"
                    data-locale="es-AR"
                    data-show-export="false"
                    data-click-to-select="true"
                    data-show-columns="true"
                    data-show-pagination-switch="false"
                    data-pagination="false"
                    data-id-field="id"
                    data-sortable="tue"
                    data-page-list="[10, 25, 50, 100, all]"
                    data-show-footer="false"
                    class="table table-striped">
                    <thead>
                        <tr>

                            <th data-field="id">ID</th>
                            <th data-field="nombre" data-sortable="true">Nombre</th>
                            <th data-field="fecharetiro" data-sortable="true">Fecha de Retiro</th>
                            <th data-field="fechadevolucion" data-sortable="true">Fecha de Devolución</th>
                            <th data-field="estado" data-sortable="true">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $intCounter = 0; ?>
                        <?php while ($arrContenido2 = $rsCont2->fetch(PDO::FETCH_BOTH)) { ?>
                            <tr <?php if ($arrContenido2["pe_id_pedido_temp"] == $idTemp) { ?>style="background-color: aliceblue;" <?php } ?>>

                                <td><?php echo $arrContenido2["pe_id_pedido"]; ?></td>
                                <td><?php echo $arrContenido2["pedidos_nombre"]; ?></td>
                                <td><?php echo revertFecha($arrContenido2["pedidos_fechain"]) . " | " . revertHora($arrContenido2["pedidos_fechain"]); ?></td>

                                <td><?php echo revertFecha($arrContenido2["pedidos_fechaout"]) . " | " . revertHora($arrContenido2["pedidos_fechaout"]); ?></td>
                                <td><?php echo estadoPedido($arrContenido2["pedidos_estado"]); ?></td>


                            </tr>
                            <?php $intCounter++; ?>
                        <?php } ?>
                        <tr>
                            <td style="text-align: center;" colspan="5"><a href="equipopedido.php?seccion=equipos&id=<?php echo $equipo[$i]['id']; ?>" class="btn btn-primary btn-bitbucket" data-toggle="tooltip" data-placement="bottom" title="Pedidos en los que esta el equipo" target="_blank"><i class="fa fa-search"></i> Mas resultados</a></td>
                        </tr>
                    </tbody>

                </table>
            </div>
        <?php } ?>


    <?php } else { ?>
        <div class="claseequipo2" id="e<?php echo $equipo[$i]['id']; ?>">
            <div class="nombre" onclick="addarMod(<?php echo $equipo[$i]['id']; ?>,'<?php echo $equipo[$i]['nombre']; ?>')"><?php echo $equipo[$i]['nombre']; ?></div>
        </div>
    <?php } ?>

<?php } ?>

<script>
    //var tablaactiva = ''
    $(".nombreocupado").click(function() {
        var idact = $(this).attr("id");
        var divide = idact.split("-");
        var idact2 = divide[1];

        $("#po" + idact2).slideToggle();


    });
</script>