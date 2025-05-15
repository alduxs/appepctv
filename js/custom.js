$(document).ready(function () {

   /* var $modal = $('#modal');
    var image = document.getElementById('sample_image');
    var nombreOriginal;
    var cropper;
    var imgCuadActual;

    $('#upload_image').change(function (event) {

        var files = event.target.files;

        nombreOriginal = files[0]["name"];
        
        imgCuadActual = $("#imageNewCuadrada").val();

        var done = function (url) {
            image.src = url;

            $modal.modal('show');

        };

        if (files && files.length > 0) {
            reader = new FileReader();
            reader.onload = function (event) {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: 4/2.8,
            viewMode: 3,
            preview: '.preview',
            crop: function (e) {

                $("#alto").val(Math.round(e.detail.height));
                $("#ancho").val(Math.round(e.detail.width));

            }
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });

    $('#crop').click(function () {
        canvas = cropper.getCroppedCanvas({
            width: 600,
            height: 417
        });

        canvas.toBlob(function (blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64data = reader.result;
                $.ajax({
                    url: 'upload.php',
                    method: 'POST',
                    data: {
                        image: base64data,
                        nombre: nombreOriginal,
                        tipo: 1,
                        imgActual: imgCuadActual
                    },
                    success: function (data) {
                        $modal.modal('hide');
                        $('#uploaded_image').attr('src', data);

                        var divide = data.split("/");
                        var imageUp = divide[3];
                        $("#imageNewCuadrada").val(imageUp);

                    }
                });
            };
        }, 'image/jpeg', 0.95);

    });*/

    //------------------------ Segunda Imagen
    var $modal2 = $('#modal2');
    var image2 = document.getElementById('sample_image2');
    var nombreOriginal2;
    var cropper2;
    var altoImg2;
    var anchoImg2;
    var imgRectActual;

    $('#upload_image2').change(function (event) {

        var files2 = event.target.files;

        nombreOriginal2 = files2[0]["name"];

        imgRectActual = $("#imageNewRect").val();
        //console.log(imgRectActual);

        var done = function (url2) {
            image2.src = url2;
            $modal2.modal('show');
        };

        if (files2 && files2.length > 0) {
            reader = new FileReader();
            reader.onload = function (event) {
                done(reader.result);
            };
            reader.readAsDataURL(files2[0]);
        }
    });

    $modal2.on('shown.bs.modal', function () {
        cropper2 = new Cropper(image2, {
            aspectRatio: 4 / 3,
            viewMode: 3,
            preview: '.preview2',
            crop: function (e) {

                $("#alto2").val(Math.round(e.detail.height));
                $("#ancho2").val(Math.round(e.detail.width));

                anchoImg2 = Math.round(e.detail.width);
                altoImg2 = Math.round(e.detail.height);

            }
        });
    }).on('hidden.bs.modal', function () {
        
        cropper2.destroy();
        cropper2 = null;
    });

    $('#crop2').click(function () {
        
        canvas = cropper2.getCroppedCanvas({
            width: anchoImg2,
            height: altoImg2
        });

        canvas.toBlob(function (blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64data = reader.result;
                $.ajax({
                    url: 'upload.php',
                    method: 'POST',
                    data: {
                        image: base64data,
                        nombre: nombreOriginal2,
                        tipo: 2,
                        imgActual: imgRectActual
                    },
                    success: function (data) {
                        $modal2.modal('hide');
                        var divide = data.split("/");
                        var imagen = "post-temp/"+divide[1];
                        $('#uploaded_image2').attr('src', imagen);
                        
                        
                        var imageUp = divide[1];
                        $("#imageNewRect").val(imageUp);
                        $("#idImag").val(divide[2]);
                        $(".borrarImag").show();

                    }
                });
            };
        }, 'image/jpeg', 0.95);

    });

});