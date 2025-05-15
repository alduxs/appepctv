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
if( $_GET["seccion"] == "pedidos" && isset($_GET["page"]) && ($_GET["page"] == "addPedidos" || $_GET["page"] == "dupPedidos")){
	$control = 1;
} else {
	$control = 0;
}

?>
<li <?php if ($seccion == "inicio") : ?>class="active" <?php endif; ?>>
	<a href="javascript:;" onclick="checkPedidos('home','inicio',<?php echo $control; ?>)"><i class="fa fa-home"></i> <span class="nav-label">Inicio</span> </a>
</li>


<li <?php if ($seccion == "clases") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-tasks"></i> <span class="nav-label">Clases de Equipos</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="javascript:;" onclick="checkPedidos('lstClases','clases',<?php echo $control; ?>)">Listar </a></li>
		<li><a href="javascript:;" onclick="checkPedidos('addClases','clases',<?php echo $control; ?>)">Agregar </a></li>
	</ul>
</li>

<li <?php if ($seccion == "categorias") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">Categorías</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="javascript:;" onclick="checkPedidos('lstCategorias','categorias',<?php echo $control; ?>)">Listar </a></li>
		<li><a href="javascript:;" onclick="checkPedidos('addCategorias','categorias',<?php echo $control; ?>)">Agregar </a></li>
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
		<li><a href="javascript:;" onclick="checkPedidos('lstAlumnos','alumnos',<?php echo $control; ?>)">Listar </a></li>
		<li><a href="javascript:;" onclick="checkPedidos('addAlumnos','alumnos',<?php echo $control; ?>)">Agregar </a></li>
		<li><a href="javascript:;" onclick="checkPedidos('importAlumnosStep1','alumnos',<?php echo $control; ?>)">Importar Excel </a></li>
	</ul>
</li>

<li <?php if ($seccion == "profesores") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Profesores</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="javascript:;" onclick="checkPedidos('lstProfesores','profesores',<?php echo $control; ?>)">Listar </a></li>
		<li><a href="javascript:;" onclick="checkPedidos('addProfesores','profesores',<?php echo $control; ?>)">Agregar </a></li>
	</ul>
</li>

<li <?php if ($seccion == "materias") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Materias</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="javascript:;" onclick="checkPedidos('lstMaterias','materias',<?php echo $control; ?>)">Listar </a></li>
		<li><a href="javascript:;" onclick="checkPedidos('addMaterias','materias',<?php echo $control; ?>)">Agregar </a></li>
	</ul>
</li>

<li <?php if ($seccion == "equipos") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-camera"></i> <span class="nav-label">Equipos</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="javascript:;" onclick="checkPedidos('lstEquipos','equipos',<?php echo $control; ?>)">Listar </a></li>
		<li><a href="javascript:;" onclick="checkPedidos('addEquipos','equipos',<?php echo $control; ?>)">Agregar </a></li>
		<!--<li><a href="lstEquipossPed.php?seccion=equipos">Equipos s/ Pedidos </a></li>-->
	</ul>
</li>


<li <?php if ($seccion == "pedidos") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-archive"></i> <span class="nav-label">Pedidos</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="javascript:;" onclick="checkPedidos('lstPedidos','pedidos',<?php echo $control; ?>)">Listar</a></li>
		<li><a href="javascript:;" onclick="checkPedidos('addPedidos','pedidos',<?php echo $control; ?>)">Agregar</a></li>

	</ul>
</li>


<li <?php if ($seccion == "usuarios") : ?>class="active" <?php endif; ?>>
	<a href="#"><i class="fa fa-user"></i> <span class="nav-label">Usuarios</span> <span class="fa arrow"></span></a>
	<ul class="nav nav-second-level collapse">
		<li><a href="javascript:;" onclick="checkPedidos('lstUsuarios','usuarios',<?php echo $control; ?>)">Listar </a></li>
		<li><a href="javascript:;" onclick="checkPedidos('addUsuario','usuarios',<?php echo $control; ?>)">Agregar </a></li>
	</ul>
</li>

<script type="text/javascript">
	function checkPedidos(page,seccion,control) {
	
		if(control == 1){
			
				var idtemporalControl = $("#idtemporal").val();
			
			

			$.ajax({
				method: "POST",
				url: "checkPedidos.php",
				data: {
					idtemporalControl: idtemporalControl,
				}
			})
			.done(function(data) {
				if(data == 0){
					var url = page+".php?seccion="+seccion+"&page="+page;
					var win = window.open(url, '_self');
				} else {
					var url = page+".php?seccion="+seccion+"&page="+page;
					$('#modalcheck').modal();
					$("#proceder").attr("href",url);
				}
				
			});

		} else {
			var url = page+".php?seccion="+seccion+"&page="+page;
			var win = window.open(url, '_self');
		}
	}

	function closeModal() {
		$('#modalcheck').modal('hide');
	}
</script>