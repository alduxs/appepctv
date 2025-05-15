<?php
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
//
include_once('includes/class.inc.php');
//
$link = Conectarse();

$objContenido = new General();


$query = "SELECT e.*,cl.ecl_nombre 
		FROM equipos e 
		LEFT JOIN equipo_clases cl ON cl.ecl_id = e.eq_clase
		ORDER BY eq_enservicio DESC, eq_nombre ASC,eq_id";
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
					<h2>Listar Equipos</h2>
					<ol class="breadcrumb">
						<li><a href="home.php?seccion=inicio">Home</a></li>
						<li><a href="#">Equipos</a></li>
						<li class="active"><strong>Listar equipos</strong></li>
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
									<table id="table"
										data-toggle="table"
										data-search="true"
										data-show-toggle="true"
										data-show-fullscreen="true"
										data-show-columns="true"
										data-show-columns-toggle-all="true"
										data-detail-view="false"
										data-locale="es-AR"
										data-show-export="true"
										data-click-to-select="true"
										data-show-columns="true"
										data-show-pagination-switch="true"
										data-pagination="true"
										data-id-field="id"
										data-sortable="tue"
										data-page-list="[10, 25, 50, 100, all]"
										data-show-footer="false"
										class="table table-striped">
										<thead>
											<tr>
										
												<th data-field="id">ID</th>
												<th data-field="clase" data-sortable="true">Clase</th>
												<th data-field="subclase" data-sortable="true">Subclase</th>
												<th data-field="nombre" data-sortable="true">Nombre</th>
												<th>Categorías</th>
												<th data-field="servicio" data-sortable="true">En servicio</th>
												<th>Acción</th>
											</tr>
										</thead>
										<tbody>
											<?php $intCounter = 0; ?>
											<?php while ($arrContenido = $rsCont->fetch(PDO::FETCH_BOTH)) { ?>
												<tr>

													<td><?php echo $arrContenido["eq_id"]; ?></td>
													<td><?php echo $arrContenido["ecl_nombre"]; ?></td>
													<?php if ($arrContenido["eq_subclase"] > 0) { ?>
														<?php
														$queryPost = "SELECT ecl_nombre 
															FROM equipo_clases ec
															WHERE ecl_id = " . $arrContenido["eq_subclase"];
														$rsPost = $objContenido->getAllContenido($link, $queryPost);
														$arrPost = $rsPost->fetch(PDO::FETCH_BOTH);
														?>
														<td><?php echo $arrPost["ecl_nombre"]; ?></td>

													<?php } else { ?>
														<td>-</td>
													<?php }  ?>
													<td><?php echo $arrContenido["eq_nombre"]; ?></td>

													<td>
														<?php
														$query5 = "SELECT ec.ec_id_categoria, c.cat_nombre, c.cat_id
																FROM equipos_categoria ec
																LEFT JOIN categorias c ON c.cat_id = ec.ec_id_categoria
																WHERE ec.ec_id_equipo = " . $arrContenido["eq_id"] . " ORDER BY c.cat_id ASC";
														$rsCont5 = $objContenido->getAllContenido($link, $query5);
														?>
														<?php while ($arrCont5 = $rsCont5->fetch(PDO::FETCH_BOTH)) {
														?>
															<button class="btn btn-info btn-circle" type="button"><strong><?php echo  categoriGear($arrCont5["cat_id"]); ?></strong></button>
														<?php
														} ?>

													</td>
													<td>
													<?php if($arrContenido["eq_enservicio"] == 0){ ?>
													<a class="btn btn-danger btn-rounded" href="#">Fuera de servicio</a>
													<?php } else { ?>
													<a class="btn btn-info btn-rounded" href="#">En servicio</a>
													<?php }  ?>
													</td>

										
													<td class="tooltip-demo">
														<a href="equipopedido.php?seccion=equipos&id=<?php echo $arrContenido["eq_id"]; ?>" class="btn btn-primary btn-bitbucket" data-toggle="tooltip" data-placement="bottom" title="Pedidos en los que esta el equipo"><i class="fa fa-list" aria-hidden="true"></i></a>
														<a class="btn btn-primary btn-bitbucket" href="#" onclick="openModal(<?php echo $arrContenido["eq_id"] ?>)" data-toggle="tooltip" data-placement="bottom" title="Ver"><i class="fa fa-search"></i></a>
														<a href="dupEquipos.php?seccion=equipos&id=<?php echo $arrContenido["eq_id"]; ?>" class="btn btn-primary btn-bitbucket" data-toggle="tooltip" data-placement="bottom" title="Duplicar"><i class="fa fa-files-o"></i></a>
														<a href="updEquipos.php?seccion=equipos&id=<?php echo $arrContenido["eq_id"]; ?>" class="btn btn-primary btn-bitbucket" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="fa fa-pencil"></i></a>
														<a href="javascript:;" onclick="delRegistro('<?php echo $arrContenido["eq_id"] ?>','','equipos');" class="btn btn-primary btn-bitbucket" data-toggle="tooltip" data-placement="bottom" title="Borrar"><i class="fa fa-trash-o"></i></a>
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
						<?php //echo printPaginado("lstEquipos.php", $intQtyPages, $intPage, "equipos"); ?>
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

	<!-- Custom and plugin javascript -->
	<script src="js/inspinia.js"></script>
	<script src="js/plugins/pace/pace.min.js"></script>

	<!-- Table -->
	<script src="js/tableExport.min.js"></script>
	<script src="js/bootstrap-table.js"></script>
	<script src="js/bootstrap-table-locale-all.js"></script>
	<script src="js/extensions/export/bootstrap-table-export.min.js"></script>
	
	<script type="text/javascript">
		function delRegistro(pIdRegistro, pDsArchivo, strDb/*, intPage*/) {
			if (!window.confirm("Esta seguro que desea borrar este registro?")) {
				return;
			} else {
				document.frm.intIdRegistro.value = pIdRegistro;
				document.frm.strDb.value = strDb;
				document.frm.Archivo.value = pDsArchivo;
				//document.frm.intPage.value = intPage;
				document.frm.submit();
			}
		}

		function openModal(idEquipo) {
			$.ajax({
					method: "POST",
					url: "detalleEquipo.php",
					data: {
						idEquipo: idEquipo,
					}
				})
				.done(function(data) {
					$("#contenido-modal").html(data);
					$('#myModal').modal();
				});

		}
	</script>
</body>

</html>