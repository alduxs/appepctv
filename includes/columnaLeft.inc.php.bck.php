<?php
if (isset($_GET["seccion"])) {
	$seccion = $_GET["seccion"];
} else {
	$seccion = "inicio";
}
if (isset($_GET["subseccion"])) {
	$subseccion = $_GET["subseccion"];
} else {
	$subseccion = "";
}
?>
<li <?php if ($seccion == "inicio") : ?>class="active" <?php endif; ?>>
	<a href="home.php?seccion=inicio"><i class="fa fa-home"></i> <span class="nav-label">Inicio</span> </a>
</li>



<li <?php if ($seccion == "clases") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-tasks"></i> <span class="nav-label">Clases de Equipos</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="lstClases.php?seccion=clases">Listar </a></li>
		<li><a href="addClases.php?seccion=clases">Agregar </a></li>
	</ul>
</li>

<li <?php if ($seccion == "categorias") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">Categorías</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="lstCategorias.php?seccion=categorias">Listar </a></li>
		<li><a href="addCategorias.php?seccion=categorias">Agregar </a></li>
	</ul>
</li>

<!--<li <?php if ($seccion == "tpracticos") : ?>class="active"<?php endif; ?>>
	<a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Trabajos Prácticos</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="lstTpracticos.php?seccion=tpracticos">Listar </a></li>
		<li><a href="addTpracticos.php?seccion=tpracticos">Agregar </a></li>
	</ul>
</li>-->

<li <?php if ($seccion == "alumnos") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Alumnos</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="lstAlumnos.php?seccion=alumnos">Listar </a></li>
		<li><a href="addAlumnos.php?seccion=alumnos">Agregar </a></li>
	</ul>
</li>

<li <?php if ($seccion == "profesores") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Profesores</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="lstProfesores.php?seccion=profesores">Listar </a></li>
		<li><a href="addProfesores.php?seccion=profesores">Agregar </a></li>
	</ul>
</li>

<li <?php if ($seccion == "materias") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Materias</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="lstMaterias.php?seccion=materias">Listar </a></li>
		<li><a href="addMaterias.php?seccion=materias">Agregar </a></li>
	</ul>
</li>

<li <?php if ($seccion == "equipos") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-camera"></i> <span class="nav-label">Equipos</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="lstEquipos.php?seccion=equipos">Listar </a></li>
		<li><a href="addEquipos.php?seccion=equipos">Agregar </a></li>
		<!--<li><a href="lstEquipossPed.php?seccion=equipos">Equipos s/ Pedidos </a></li>-->
	</ul>
</li>


<li <?php if ($seccion == "pedidos") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-archive"></i> <span class="nav-label">Pedidos</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="lstPedidos.php?seccion=pedidos">Listar</a></li>
		<li><a href="addPedidos.php?seccion=pedidos">Agregar</a></li>

	</ul>
</li>


<li <?php if ($seccion == "usuarios") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-user"></i> <span class="nav-label">Usuarios</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="lstUsuarios.php?seccion=usuarios">Listar </a></li>
		<li><a href="addUsuario.php?seccion=usuarios">Agregar </a></li>
	</ul>
</li>

<script type="text/javascript">
	function checkPedidos(page,seccion,control) {
		if(control == 1){

		} else {

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