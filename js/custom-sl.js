$(document).ready(function () {

    

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
            aspectRatio: 4 / 1,
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
        console.log(altoImg2);
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
                        tipo: 3,
                        imgActual: imgRectActual
                    },
                    success: function (data) {
                        $modal2.modal('hide');
                        $('#uploaded_image2').attr('src', data);

                        var divide = data.split("/");
                        var imageUp = divide[3];
                        $("#imageNewRect").val(imageUp);

                    }
                });
            };
        }, 'image/jpeg', 0.95);

    });

});