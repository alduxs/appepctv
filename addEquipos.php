<?php
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
//
include_once('includes/class.inc.php');
//
$link = Conectarse();
//
$objContenido = new General();

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
  <link href="css/style.css" rel="stylesheet">
  <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
  <link href="css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
  <link rel="stylesheet" href="css/dropzone.css" />
  <link rel="stylesheet" href="css/cropper.css" />
  <link href="css/image.css" rel="stylesheet" type="text/css">

  <link href="css/plugins/select2/select2.min.css" rel="stylesheet">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="css/amsify.suggestags.css">
  <link href="css/estilos.css" rel="stylesheet" type="text/css">
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
          <h2>Agregar Equipo</h2>
          <ol class="breadcrumb">
            <li><a href="home.php?seccion=inicio">Home</a></li>
            <li><a href="#">Equipos</a></li>
            <li class="active"><strong>Agregar equipo</strong></li>
          </ol>
        </div>
      </div>



      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-content">
                <form method="post" action="svEquipos.php" enctype="multipart/form-data" name="form1">
                  <input type="hidden" name="strOperacion" value="I" />
                  <input type="hidden" name="idusuario" value="<?php echo $_SESSION["id"]; ?>">

                  <!-- Clase -->
                  <div class="form-group col-xs-12">
                    <label for="clase">Clase</label>
                    <select name="clase" class="form-control" id="clase">

                      <option value="0" selected>Selecciones una clase</option>
                      <?php
                      $queryPost = "SELECT * 
                      FROM equipo_clases ec
                      LEFT JOIN equipos_clases_relacion ecr ON ecr.eqr_id_clase = ec.ecl_id
                      WHERE eqr_id_padre = 0 ORDER BY ecl_nombre ASC, ecl_id ASC";
                      $rsPost = $objContenido->getAllContenido($link, $queryPost);
                      ?>
                      <?php while ($arrPost = $rsPost->fetch(PDO::FETCH_BOTH)) { ?>
                        <option value="<?php echo $arrPost["ecl_id"] ?>"><?php echo $arrPost["ecl_nombre"] ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <!-- Clase -->
                  <div class="form-group col-xs-12">
                    <label for="subclase">Sub Clase</label>
                    <select name="subclase" class="form-control" id="subclase">

                      <option value=""></option>

                    </select>
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <!-- Nombre -->
                  <div class="form-group col-xs-12">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control">
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <!-- Código -->
                  <!--<div class="form-group col-xs-12">
                    <label for="codigo">Código</label>
                    <input type="text" name="codigo" id="codigo" class="form-control">
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>-->

                  <!-- Marca y Modelo -->
                  <div class="form-group col-xs-12">
                    <label for="marcamodelo">Marca y Modelo</label>
                    <input type="text" name="marcamodelo" id="marcamodelo" class="form-control">
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <!-- Info Adicional -->
                  <div class="form-group col-xs-12">
                    <label for="infoadicional">Información Adicional</label>
                    <textarea name="infoadicional" rows="5" id="infoadicional"></textarea>
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>


                  <!-- Imagen -->
                  <div class="form-group col-xs-12">
                    <h4>Imagen (Relación 4:3 - Tamaño mínimo: 800 px de ancho)</h4>
                    <div class="image_area2">
                      <label for="upload_image2">
                        <img src="img/imagen2.png" id="uploaded_image2" class="img-responsive" />
                        <div class="overlay">
                          <div class="text">Cambiar Imagen</div>
                        </div>
                        <input type="file" name="image2" class="image" id="upload_image2" style="display:none" />
                        <input type="hidden" name="imageNewRect" id="imageNewRect" value="nd">
                        <input type="hidden" name="idImag" id="idImag" value="">
                      </label>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="borrarImag" style="display:none;">
                      <!-- Borrar Imagen -->
                      <a href="javascript:;" onclick="delImagen();" class="btn btn-primary btn-bitbucket" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Borrar">Borrar Imagen <i class="fa fa-trash-o"></i></a>
                    </div>
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <!-- Observaciones -->
                  <div class="form-group col-xs-12">
                    <label for="observaciones">Observaciones</label>
                    <textarea name="observaciones" rows="6" id="observaciones"></textarea>
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <!-- En Servicio -->
                  <div class="form-group col-xs-12">
                    <label for="enservicio">En servicio</label>
                    <p><label class="checkbox-inline i-checks"> <input type="radio" value="1" name="enservicio" checked> <i></i> Si </label><label class="checkbox-inline i-checks"> <input name="enservicio" type="radio" value="0"> <i></i> No </label></p>
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>

                  <!-- Estado -->
                  <!--<div class="form-group col-xs-12">
                    <label for="estado">Estado</label>
                    <p><label class="checkbox-inline i-checks"> <input type="radio" value="1" name="estado" checked> <i></i> Disponible </label><label class="checkbox-inline i-checks"> <input name="estado" type="radio" value="2"> <i></i> Solicitado </label><label class="checkbox-inline i-checks"> <input name="estado" type="radio" value="3"> <i></i> Reservado </label><label class="checkbox-inline i-checks"> <input name="estado" type="radio" value="4"> <i></i> En uso </label></p>
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>-->

                  <!-- Categoría -->
                  <div class="form-group col-xs-12">
                    <label for="categoria">Categoría</label>
                    <select name="categoria[]" class="select2_demo_4 form-control" id="categoria" multiple="">

                      <option></option>
                      <?php
                      $queryPost = "SELECT * FROM categorias";
                      $rsPost = $objContenido->getAllContenido($link, $queryPost);
                      ?>
                      <?php while ($arrPost = $rsPost->fetch(PDO::FETCH_BOTH)) { ?>
                        <option value="<?php echo $arrPost["cat_id"] ?>"><?php echo $arrPost["cat_nombre"] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="hr-line-dashed col-xs-12"></div>


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

  <!-- Tinymce -->
  <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>

  <!-- Data picker -->
  <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

  <script src="js/dropzone.js"></script>
  <script src="js/cropper.js"></script>

  <!-- Clock picker -->
  <script src="js/plugins/clockpicker/clockpicker.js"></script>

  <!-- iCheck -->
  <script src="js/plugins/iCheck/icheck.min.js"></script>

  <!-- Select2 -->
  <script src="js/plugins/select2/select2.full.min.js"></script>

  <!--tag sugest -->
  <script src="js/jquery.amsify.suggestags.js"></script>

  <script src="js/custom.js?v=3"></script>
  <script>
    $(document).ready(function() {
      $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
      });


      $('#data_1 .input-group.date').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true
      });

      $('.clockpicker').clockpicker();

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
      content_css: '/appepctv/admin/css/css.css',
      style_formats: [

        {
          title: 'Imagen Derecha',
          selector: 'p',
          classes: 'imgpost'
        }
      ],

    });

    $(".select2_demo_4").select2({
      placeholder: "Seleccionar la categoría",
      allowClear: true,
      width: '100%'
    });

    function delImagen() {
      var imagen = $("#imageNewRect").val();
      $.ajax({
          method: "POST",
          url: "deletImag.php",
          data: {
            imagen: imagen,
            origen: 1
          }
        })
        .done(function(msg) {
          console.log(msg);
          if (msg == "ok") {
            $("#uploaded_image2").attr("src", "img/imagen2.png");
            $(".borrarImag").hide();
            $("#imageNewRect").val("nd");
          }

        });
    }

    $("#clase").change(function() {
      var idClase = $(this).val();
      console.log(idClase);
      $.ajax({
					method: "POST",
					url: "armaCombo.php",
					data: {
						idClase: idClase,
					}
				})
				.done(function(data) {
          $("#subclase").html(data);
				});
    });
  </script>


  <!-- *********************************** MODALS *********************************-->


  <!-- Modal imagen grande -->
  <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">M 2 Crop Image Before Upload</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="img-container">
            <div class="row">
              <div class="col-md-8">
                <img src="" id="sample_image2" />
              </div>
              <div class="col-md-4">
                <div class="preview2"></div>
                <div class="input-group" style="width: 80%;margin-bottom:10px;">
                  <div class="input-group-addon">Ancho</div>
                  <input type="text" class="form-control" id="ancho2" placeholder="0">
                  <div class="input-group-addon">px</div>
                </div>
                <div class="input-group" style="width: 80%;">
                  <div class="input-group-addon">Alto</div>
                  <input type="text" class="form-control" id="alto2" placeholder="0">
                  <div class="input-group-addon">px</div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="crop2" class="btn btn-primary">Crop</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <!-- *********************************** FIN MODALS *********************************-->
</body>

</html>