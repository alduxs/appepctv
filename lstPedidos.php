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
		FROM pedidos 
		/*LEFT JOIN equipo_clases cl ON cl.ecl_id = e.eq_clase*/
		ORDER BY pedidos_fechain DESC, pedidos_estado ASC";
$rsCont = $objContenido->getAllContenido($link, $query)
?>
<!DOCTYPE HTML>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panel de Control - <?php echo _CONST_TITLE_ ?></title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="css/animate.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css//bootstrap-table.css" rel="stylesheet">
	<link href="css/estilos.css" rel="stylesheet" type="text/css">
</head>


<body>

	<div id="wrapper">
		<nav class="navbar-default navbar-static-side" role="navigation">
			<div class="sidebar-collapse">
				<ul class="nav metismenu" id="side-menu">
					<?php include_once('includes/columnaTop.inc.php'); ?>
					<?php include_once('includes/columnaLeft.inc.php'); ?>
				</ul>
			</div>
		</nav>
		<div id="page-wrapper" class="gray-bg">
			<div class="row border-bottom">
				<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
					<div class="navbar-header">
						<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
					</div>
					<ul class="nav navbar-top-links navbar-right">
						<li><a href="logout.php"><i class="fa fa-sign-out"></i> Log out</a></li>
					</ul>
				</nav>
			</div>
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-sm-12">
					<h2>Listar Pedidos</h2>
					<ol class="breadcrumb">
						<li><a href="home.php?seccion=inicio">Home</a></li>
						<li><a href="#">Pedidos</a></li>
						<li class="active"><strong>Listar Pedidos</strong></li>
					</ol>
				</div>
			</div>
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-content">
								<form name="frm" method="post" action="svEquipos.php">
									<input type="hidden" name="intIdRegistro" value="" />
									<input type="hidden" name="strDb" value="" />
									<input type="hidden" name="Archivo" value="" />
									<!--<input type="hidden" name="intPage" value="" />-->
									<input type="hidden" name="strOperacion" value="D" />
									<table id="table" data-toggle="table" data-search="true" data-show-toggle="true" data-show-fullscreen="true" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-locale="es-AR" data-show-export="true" data-click-to-select="true" data-show-columns="true" data-show-pagination-switch="true" data-pagination="true" data-sortable="tue" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-show-footer="false" class="table table-striped">
										<thead>
											<tr>
												<th data-field="id">ID</th>
												<th data-field="nombre" data-sortable="true">Nombre</th>
												<th data-field="fecharetiro" data-sortable="true" data-sorter="fecharetSorter">Fecha de Retiro</th>
												<th data-field="fechadevolucion" data-sortable="true" data-sorter="fechadevSorter">Fecha de Devolución</th>
												<th data-field="profesor" data-sortable="true">Profesor</th>
												<th data-field="alumnoresponsable" data-sortable="true">Alumno Responsable</th>
												<th data-field="estado" data-sortable="true">Estado</th>
												<th>Acción</th>
											</tr>
										</thead>
										<tbody>
											<?php $intCounter = 0; ?>
											<?php while ($arrContenido = $rsCont->fetch(PDO::FETCH_BOTH)) { ?>
												<tr>

													<td><?php echo $arrContenido["pedidos_id"]; ?></td>
													<td><?php echo $arrContenido["pedidos_nombre"]; ?></td>

													<td><?php echo revertFecha($arrContenido["pedidos_fechain"])." | ".revertHora($arrContenido["pedidos_fechain"]); ?></td>

													<td><?php echo revertFecha($arrContenido["pedidos_fechaout"])." | ".revertHora($arrContenido["pedidos_fechaout"]); ?></td>

													<?php
													$query2 = "SELECT *
													FROM pedidos_detalle pd
													LEFT JOIN data_profesores dp ON dp.profesores_id = pd.pd_id_registro
													WHERE pd.pd_id_pedido = " . $arrContenido["pedidos_id"] . " AND pd.pd_tipo = 2";
													$rsCont2 = $objContenido->getAllContenido($link, $query2);
													$arrContenido2 = $rsCont2->fetch(PDO::FETCH_BOTH);
													?>

													<td><?php echo $arrContenido2["profesores_name"] . " " . $arrContenido2["profesores_apellido"]; ?></td>

													<?php
													$query3 = "SELECT *
													FROM pedidos_detalle pd
													LEFT JOIN data_estudiantes de ON de.estudiantes_id = pd.pd_id_registro
													WHERE pd.pd_id_pedido = " . $arrContenido["pedidos_id"] . " AND pd.pd_tipo = 3";
													$rsCont3 = $objContenido->getAllContenido($link, $query3);
													$arrContenido3 = $rsCont3->fetch(PDO::FETCH_BOTH);
													//
													?>

													<td><?php echo $arrContenido3["estudiantes_name"] . " " . $arrContenido3["estudiantes_apellido"]; ?></td>

													<td><?php echo estadoPedido($arrContenido["pedidos_estado"]); ?></td>

													<td class="tooltip-demo">
														<a href="pdf/topdf.php?idPedido=<?php echo $arrContenido["pedidos_id"]; ?>" class="btn btn-primary btn-bitbucket" data-toggle="tooltip" data-placement="bottom" title="Imprimir" target="_blank"><i class="fa fa-print"></i></a>
														<a href="cambiarEstado.php?seccion=pedidos&id=<?php echo $arrContenido["pedidos_id"]; ?>" class="btn btn-primary btn-bitbucket" data-toggle="tooltip" data-placement="bottom" title="Cambiar Estado"><i class="fa fa-bars"></i></a>
														<a class="btn btn-primary btn-bitbucket" href="#" onclick="openModal(<?php echo $arrContenido["pedidos_id"] ?>)" data-toggle="tooltip" data-placement="bottom" title="Ver"><i class="fa fa-search"></i></a>
														<a href="dupPedidos.php?seccion=pedidos&id=<?php echo $arrContenido["pedidos_id"]; ?>&page=dupPedidos" class="btn btn-primary btn-bitbucket" data-toggle="tooltip" data-placement="bottom" title="Duplicar"><i class="fa fa-files-o"></i></a>
														<a href="updPedidos.php?seccion=pedidos&id=<?php echo $arrContenido["pedidos_id"]; ?>&page=updPedidos" class="btn btn-primary btn-bitbucket" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="fa fa-pencil"></i></a>
														<!--<a href="javascript:;" onclick="delRegistro('<?php echo $arrContenido["pedidos_id"] ?>','','equipos','');" class="btn btn-primary btn-bitbucket" data-toggle="tooltip" data-placement="bottom" title="Borrar"><i class="fa fa-trash-o"></i></a>-->
													</td>
												</tr>
												<?php $intCounter++; ?>
											<?php } ?>
										</tbody>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- Paginación -->
				<div class="row">
					<div class="col-lg-12 paginador">
						<?php //echo printPaginado("lstEquipos.php", $intQtyPages, $intPage, "equipos"); 
						?>
					</div>
				</div>
			</div>
			<div class="footer">
				<div>&copy; 2014 - <?php echo date("Y") ?></div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content" id="contenido-modal">

			</div>
		</div>
	</div>

	<!-- Mainly scripts -->
	<script src="js/jquery-3.3.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<!-- Table -->
	<script src="js/tableExport.min.js"></script>
	<script src="js/bootstrap-table.js"></script>
	<script src="js/bootstrap-table-locale-all.js"></script>
	<script src="js/extensions/export/bootstrap-table-export.min.js"></script>

	<!-- Custom and plugin javascript -->
	<script src="js/inspinia.js"></script>
	<script src="js/plugins/pace/pace.min.js"></script>
	<script type="text/javascript">
		function delRegistro(pIdRegistro, pDsArchivo, strDb, intPage) {
			if (!window.confirm("Esta seguro que desea borrar este registro?")) {
				return;
			} else {
				document.frm.intIdRegistro.value = pIdRegistro;
				document.frm.strDb.value = strDb;
				document.frm.Archivo.value = pDsArchivo;
				document.frm.intPage.value = intPage;
				document.frm.submit();
			}
		}

		function openModal(idPedido) {

			$.ajax({
					method: "POST",
					url: "detallePedido.php",
					data: {
						idPedido: idPedido,
					}
				})
				.done(function(data) {
					$("#contenido-modal").html(data);
					$('#myModal').modal();
				});

		}

		function fecharetSorter(a, b) {

			var arrraya = a.split("/");
			var newfechaa = arrraya[2] + arrraya[1] + arrraya[0];

			var arrrayb = b.split("/");
			var newfechab = arrrayb[2] + arrrayb[1] + arrrayb[0];

			return newfechaa - newfechab
		}

		function fechadevSorter(a, b) {

			var arrraya = a.split("/");
			var newfechaa = arrraya[2] + arrraya[1] + arrraya[0];

			var arrrayb = b.split("/");
			var newfechab = arrrayb[2] + arrrayb[1] + arrrayb[0];

			return newfechaa - newfechab
		}
	</script>
</body>

</html>