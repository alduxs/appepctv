<?php
include_once("includes/constantes.inc.php");
?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Panel de Control - <?php echo _CONST_TITLE_ ?></title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

  <link href="css/estilos.css" rel="stylesheet" type="text/css">
</head>

<body class="gray-bg">

  <div class="loginColumns animated fadeInDown">
    <div class="row">
      <div class="col-md-6">
        <h3 class="text-center">Administrador de Contenidos</h3>
        <img src="img/logo.png"  class="img-responsive center-block">
      </div>
      <div class="col-md-6">
        <div class="ibox-content">
          <?php if (isset($_GET["idErr"]) && !empty($_GET["idErr"])) {?>
            <?php  if(intval($_GET["idErr"]) == 1) {  ?>
              <div class="alert alert-danger">El nombre de Usuario o la Contrase&ntilde;a son incorrectos </div>
            <?php } elseif (intval($_GET["idErr"]) == 2) { ?>
              <div class="alert alert-danger">Expiró la sesión de usuario. Por favor ingrese sus datos nuevamente.</div>
            <?php } ?>
          <?php } ?>
          <form class="m-t" role="form" action="login.php" method="POST">
            <div class="form-group" id="cnombre">
              <label for="strEmail"></label>
              <input type="text" class="form-control" placeholder="Usuario"  name="strEmail" id="strEmail">
            </div>
            <div class="form-group" id="cpass">
              <label for="strPassword"></label>
              <input type="password" class="form-control" placeholder="Password" name="strPassword" id="strPassword">
            </div>

            <button type="submit" class="btn btn-primary block full-width m-b">Ingresar</button>
          </form>
        </div>
      </div>
    </div>
    <hr/>
    <div class="row">
      <div class="col-md-6 text-right">
        <small>© 2015 - <?php echo date ("Y") ?></small>
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
  <script type="text/javascript" src="../js/jQuery.validity.js"></script><!-- Carga Valydity -->
  <script>
  (function(){
    $.validity.outputs.custom = {
      start:function(){
        $(".red").remove();
      },
      end:function(results) {
        // If not valid and scrollTo is enabled, scroll the page to the first error.
        if (!results.valid && $.validity.settings.scrollTo) {
          location.hash = $(".fail:eq(0)").attr('id')
        }
      },
      raise:function($obj, msg){
        var idbt= $($obj).parents().attr("id");
        $("#"+idbt).find( "label" ).append( " <span class='red'>"+msg+"</span>" );
        $obj
      },
      // Just raise the error on the last input.
      raiseAggregate:function($obj, msg){
        this.raise($($obj), msg);
      }
    }
    $.validity.setup({ outputMode:'custom' });
  })();

  // Instruct validity to validate the page by requiring
  // the input matched by a jQuery selector.
  $(function() { $("form").validity(function() {
    $("#strEmail")
    .require()
    .nonHtml()
    .match(/^[0-9a-zA-Z]+$/);

    $("#strPassword")
    .require()
    .nonHtml()
    .match(/^[0-9a-zA-Z]+$/);

  })
});
</script>

</body>
</html>
