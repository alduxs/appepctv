<?php
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
//
include_once('includes/class.inc.php');
//
$link = Conectarse();
//
$intIdCont = sanInt($_GET["id"]);
//
$objCont = new Usuarios();
$rsCont = $objCont->getOneUser($link, $intIdCont);
$arrCont = $rsCont->fetch(PDO::FETCH_BOTH);
//
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
</head>

<head>

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
          <h2>Modificar perfil</h2>
          <ol class="breadcrumb">
            <li><a href="home.php?seccion=inicio">Home</a></li>
            <li class="active"><strong>Modificar perfil</strong></li>
          </ol>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">

              <div class="ibox-content">
                <form method="post" action="svPerfil.php" enctype="multipart/form-data" name="form1">
                  <input type="hidden" name="strOperacion" value="U" />
                  <input name="id" type="hidden" id="id" value="<?php echo $intIdCont ?>">

                  <div class="form-group col-xs-12">
                    <label for="strUsuario">Usuario</label>
                    <input name="strUsuario" type="text" maxlength="50" value="<?php echo $arrCont["ds_usuario"] ?>" class="form-control" minlength="4" id="strUsuario" />
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <div class="form-group col-xs-12">
                    <label for="strPassword">Contraseña</label>
                    <input type="password" name="strPassword" value="" class="form-control" minlength="4" id="strPassword" />
                  </div>

                  <div class="form-group col-xs-12">
                    <label for="strPassword2">Repetir Contraseña</label>
                    <input type="password" name="strPassword2" value="" class="form-control" minlength="4" id="strPassword2" />

                    <div class="alert alert-danger" id="alert1" style="display:none;margin-bottom:0px; margin-top:20px;">
                      Las contraseñas no coinciden.
                    </div>

                  </div>

                  <div class="hr-line-dashed col-xs-12"></div>


                  <div class="form-group col-xs-12">
                    <label for="strNombre">Nombre</label>
                    <input name="strNombre" type="text" maxlength="50" value="<?php echo $arrCont["ds_nombre"] ?>" id="strNombre" class="form-control" />
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>
                  <div class="form-group col-xs-12">
                    <label for="strApellido">Apellido</label>
                    <input name="strApellido" type="text" maxlength="50" value="<?php echo $arrCont["ds_apellido"] ?>" id="strApellido" class="form-control" />
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <div class="form-group col-xs-12">
                    <label for="dni">DNI</label>
                    <input name="dni" type="text" maxlength="10" value="<?php echo $arrCont["id_dni"] ?>" id="dni" class="form-control" />
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <div class="form-group col-xs-12">
                    <label for="strEmail">E-Mail</label>
                    <input name="strEmail" type="text" maxlength="250" value="<?php echo $arrCont["ds_mail"] ?>" id="strEmail" class="form-control" />
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <!-- Imagen -->
                  <div class="form-group col-xs-12">
                    <label for="imagen">Imagen</label>
                    <?php if ($arrCont["ds_imagen"] != "nd") { ?>
                      <div class="imagem-p">
                        <img src="usuarios/<?php echo $arrCont["ds_imagen"] ?>" width="200" height="100%">
                      </div>
                      <label for="imagen">Nueva Imagen</label>
                      <input type="file" name="imagen" id="imagen" class="form-control form-file">
                    <?php } else { ?>
                      <input type="file" name="imagen" id="imagen" class="form-control form-file">
                    <?php } ?>
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <div class="form-group col-xs-12">
                    <label for="celular">Celular</label>
                    <input name="celular" type="text" maxlength="250" value="<?php echo $arrCont["id_celular"] ?>" id="celular" class="form-control" />
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <input name="oldPas" type="hidden" id="oldPas" value="<?php echo $arrCont["ds_password"] ?>">
                  <div class="form-group text-center">
                    <input name="agregar" type="submit" class="btn btn-primary" id="agregar" value="Enviar">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="footer">
        <div>&copy; 2014 - <?php echo date("Y") ?></div>
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

  <!-- Script de página -->
  <script>
    $(document).ready(function() {
      $("#agregar").click(function(event) {
        var valor1 = $("#strPassword").val();
        var valor2 = $("#strPassword2").val();
        if (valor1 != valor2) {
          event.preventDefault();
          $("#alert1").show();
          $("#strPassword").val("");
          $("#strPassword2").val("");

          $("#strPassword").parent().addClass("has-error");
          $("#strPassword2").parent().addClass("has-error");

        }
      });

      $("#strPassword,#strPassword2").keyup(function() {
        $("#alert1").hide();
        $("#strPassword").parent().removeClass("has-error");
        $("#strPassword2").parent().removeClass("has-error");
      });
    });
  </script>
</body>

</html>