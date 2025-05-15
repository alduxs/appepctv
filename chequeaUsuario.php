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
$usuario = $_POST["usuario"];
$dni = $_POST["dni"];
$email = $_POST["email"];
/*var_dump($usuario);
var_dump($dni);
var_dump($email);*/
//
$estado = 0;
$instancia1 = 0;
$instancia2 = 0;
$instancia3 = 0;
//
$query = "SELECT * FROM login WHERE ds_usuario ='" . $usuario."'";
$rsCont = $objContenido->getAllContenido($link, $query);
$intQtyRecordsU = $rsCont->rowCount();
if ($intQtyRecordsU > 0) {
    $estado = 1;
    $instancia1 = 1;
}
//
$query = "SELECT * FROM login WHERE id_dni='" . $dni."'";
$rsCont = $objContenido->getAllContenido($link, $query);
$intQtyRecordsI = $rsCont->rowCount();
if ($intQtyRecordsI > 0) {
    $estado = 1;
    $instancia2 = 1;
}
//
$query = "SELECT * FROM login WHERE ds_mail='" . $email."'";
$rsCont = $objContenido->getAllContenido($link, $query);
$intQtyRecordsE = $rsCont->rowCount();
if ($intQtyRecordsE > 0) {
    $estado = 1;
    $instancia3 = 1;
}
//
?>
<?php if ($estado != 0) { ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
        <?php if ($instancia1 == 1) { ?>
            <p>El nombre de usuario ya está utilizado.</p>
        <?php } ?>
        <?php if ($instancia2 == 1) { ?>
            <p>El DNI pertenece a otro usuario registrado.</p>
        <?php } ?>
        <?php if ($instancia3 == 1) { ?>
            <p>El e-mail pertenece a otro usuario registrado.</p>
        <?php } ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
<?php } else { ?>
    <?php echo "0"; ?>
<?php } ?>