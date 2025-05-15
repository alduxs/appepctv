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
$intPage = sanInt($_GET["intPage"]);
//
$objContenido = new General();
$query = "SELECT * 
        FROM data_estudiantes
        WHERE estudiantes_id = " . $intIdCont;
$rsCont = $objContenido->getAllContenido($link, $query);
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
  <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="css/dropzone.css" />
  <link rel="stylesheet" href="css/cropper.css" />
  <link href="css/image.css" rel="stylesheet" type="text/css">
  <link href="css/estilos.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
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
          <h2>Modificar Alumno</h2>
          <ol class="breadcrumb">
            <li><a href="home.php?seccion=inicio">Home</a></li>
            <li><a href="#">Alumnos</a></li>
            <li class="active"><strong>Modificar Alumno</strong></li>
          </ol>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-content">
                <form action="svAlumnos.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                  <input type="hidden" name="strOperacion" value="U" />
                  <input name="id" type="hidden" id="id" value="<?php echo $intIdCont ?>">
                  <input type="hidden" name="intPage" value="<?php echo $intPage ?>" />

                  
                  
                  <!-- Nombre -->
                  <div class="form-group col-xs-12">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $arrCont["estudiantes_name"] ?>">
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                    <!-- Apellido -->
                  <div class="form-group col-xs-12">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control"  value="<?php echo $arrCont["estudiantes_apellido"] ?>">
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <!-- DNI -->
                  <div class="form-group col-xs-12">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" value="<?php echo $arrCont["estudiantes_dni"] ?>">
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <!-- CELULAR -->
                  <div class="form-group col-xs-12">
                    <label for="celular">Celular</label>
                    <input type="text" name="celular" id="celular" class="form-control" value="<?php echo $arrCont["estudiantes_celular"] ?>">
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <!-- Email -->
                  <div class="form-group col-xs-12">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" id="email" class="form-control" value="<?php echo $arrCont["estudiantes_email"] ?>">
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <!-- Habilitado -->
                  <div class="form-group col-xs-12">
                    <label for="estado">Estado</label>
                    <p><label class="checkbox-inline i-checks"> <input type="radio" value="1" name="estado" <?php if (!(strcmp($arrCont["estudiantes_estado"], 1))) { echo "checked=\"checked\""; } ?>> <i></i> Activo </label><label class="checkbox-inline i-checks"> <input name="estado" type="radio" value="0" <?php if (!(strcmp($arrCont["estudiantes_estado"], 0))) { echo "checked=\"checked\""; } ?>> <i></i> Inactivo </label></p>
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>
                 

                  <div class="form-group text-center">
                    <input name="agregar" type="submit" class="btn btn-primary" id="agregar" value="Enviar">
                    <a href="lstAlumnos.php?seccion=alumnos" class="btn btn-primary">Cancelar</a>
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
  <!-- Tinymce -->
  <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
  <!-- Data picker -->
  <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <script src="js/dropzone.js"></script>
  <script src="js/cropper.js"></script>
  <!-- iCheck -->
  <script src="js/plugins/iCheck/icheck.min.js"></script>

  <script src="js/jquery.validate.js"></script>

  <script src="js/customup-sl.js"></script>

  <script>
    $(document).ready(function() {

      $("#form1").validate({
        rules: {
          nombre: "required",
          apellido: "required",
          dni: "required",
          celular: "required",
          email: "required"
        },
        messages: {
          nombre: "Campo obligatorio",
          apellido: "Campo obligatorio",
          dni: "Campo obligatorio",
          celular: "Campo obligatorio",
          email: "Campo obligatorio"
        },
        submitHandler: function(form) {
          validAlumno();
        }
      });


      $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
      });


      $('#data_1 .input-group.date').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true
      });

    });

    tinymce.init({
      selector: "textarea",
      theme: "modern",
      plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'save table contextmenu directionality emoticons template paste textcolor'
      ],
      toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
      image_advtab: true,
      relative_urls: false,
      content_css: '/labsonew/admin/css/css.css',
      style_formats: [

        {
          title: 'Imagen Derecha',
          selector: 'p',
          classes: 'imgpost'
        }
      ],

    });

    function validAlumno() {
      var id = $("#id").val();
      var nombre = $("#nombre").val();
      var apellido = $("#apellido").val();
      var dni = $("#dni").val();
      var email = $("#email").val();

      $.ajax({
          method: "POST",
          url: "validaciones/validAlumno.php",
          data: {
            tipo: 2,
            nombre: nombre,
            apellido: apellido,
            dni: dni,
            email: email,
            id:id
          }
        })
        .done(function(data) {
          if (data == "ok") {
            document.getElementById("form1").submit();
          } else {
            alert(data);
          }
        });

    }
    
  
  </script>
  <!-- *********************************** MODALS *********************************-->
  
  
</body>

</html>
<?php
$link = null;
?>