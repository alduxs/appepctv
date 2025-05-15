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
$idregistro = $_POST["idregistro"];
$tipo = $_POST["tipo"];
//
if($tipo == 1){
    $query = "SELECT * FROM data_profesores WHERE profesores_id=" . $idregistro;
    $rsCont = $objContenido->getAllContenido($link, $query);
    $arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
} else if($tipo == 2){
    $query = "SELECT * FROM data_estudiantes WHERE estudiantes_id=" . $idregistro;
    $rsCont = $objContenido->getAllContenido($link, $query);
    $arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
} else if($tipo == 3){
    $query = "SELECT * FROM login WHERE id_usuario=" . $idregistro;
    $rsCont = $objContenido->getAllContenido($link, $query);
    $arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
}
//


//
?>
<?php if($tipo == 1){ ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $arrCont["profesores_name"]. " ".$arrCont["profesores_apellido"]; ?></h4>
</div>
<div class="modal-body">
        <div class="row">
            

            <div class="col-md-12">

                <p><strong>DNI:</strong> <?php echo $arrCont["profesores_dni"]; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $arrCont["profesores_celular"]; ?></p>
                <p><strong>E-mail:</strong> <?php echo $arrCont["profesores_email"]; ?></p>
            </div>

        </div>
</div>
<?php } else if($tipo == 2){ ?>
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $arrCont["estudiantes_name"]. " ".$arrCont["estudiantes_apellido"]; ?></h4>
</div>
<div class="modal-body">
        <div class="row">
            

            <div class="col-md-12">

                <p><strong>DNI:</strong> <?php echo $arrCont["estudiantes_dni"]; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $arrCont["estudiantes_celular"]; ?></p>
                <p><strong>E-mail:</strong> <?php echo $arrCont["estudiantes_email"]; ?></p>
            </div>

        </div>
</div>
<?php } else if($tipo == 3){ ?>
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $arrCont["ds_nombre"]. " ".$arrCont["ds_apellido"]; ?></h4>
</div>
<div class="modal-body">
        <div class="row">
            

            <div class="col-md-12">

                <p><strong>DNI:</strong> <?php echo $arrCont["id_dni"]; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $arrCont["id_celular"]; ?></p>
                <p><strong>E-mail:</strong> <?php echo $arrCont["ds_mail"]; ?></p>
            </div>

        </div>
</div>
<?php } ?>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>