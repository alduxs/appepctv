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
$idEquipo = $_POST["idEquipoF"];
$idTemp = $_POST["idtemporal"];
//
$fechahoy = date("Ymdhis");
//
$query = "SELECT * 
        FROM pedidos_equipos pe
        LEFT JOIN pedidos p ON p.pedidos_id = pe.pe_id_pedido
        WHERE pe_id_equipo = " . $idEquipo . " AND (p.pedidos_estado = 1 || p.pedidos_estado = 2) AND  p.pedidos_fechaout >= '" . $fechahoy . "'
        AND pe_id_pedido_temp != '" . $idTemp . "'
        ORDER BY p.pedidos_estado DESC, p.pedidos_fechain DESC";
$rsCont = $objContenido->getAllContenido($link, $query);

?>
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

            <?php
            while ($arrCont = $rsCont->fetch(PDO::FETCH_BOTH)) {

            ?>
                <tr>

                    <td><?php echo $arrCont["pe_id_pedido"]; ?></td>
                    <td><?php echo $arrCont["pedidos_nombre"]; ?></td>
                    <td><?php echo revertFecha($arrCont["pedidos_fechain"]) . " | " . revertHora($arrCont["pedidos_fechain"]); ?></td>

                    <td><?php echo revertFecha($arrCont["pedidos_fechaout"]) . " | " . revertHora($arrCont["pedidos_fechaout"]); ?></td>
                    <td><?php echo estadoPedido($arrCont["pedidos_estado"]); ?></td>

                </tr>


            <?php

            }

            ?>


        </tbody>

    </table>