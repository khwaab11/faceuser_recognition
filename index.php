<!DOCTYPE html>
<html>

<head>
    <title>Face</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <style type="text/css">

    </style>
</head>

<body>

    <div class="container">
        <h1 class="text-center"></h1>

        <form method="post" enctype="multipart/form-data" id="myform">
            <div class="row">
                <div class="col-md-6">
                    <div id="my_camera"></div>
                    <br />
                    <input type="hidden" id="img" name="image" class="image-tag">
                </div>
                <div class="col-md-6">
                    <div id="results"></div>

                </div>
                <div class="col-md-12 text-center">
                    <br />
                    <div style="font-size:60px" id="count">

                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Configure a few settings and attach camera -->
    <script language="JavaScript">
        Webcam.set({
            width: 490,
            height: 390,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            });
        }

        call();

        function call() {
            take_snapshot();
            var x = $('#img').val();
            $.ajax({
                url: 'submit.php',
                type: 'post',
                data: {
                    image: x
                },
                success: function(data) {
                    console.log(data);
                    $("#count").empty();
                    $("#count").append(data);
                    call();
                },
                failure: function(data) {
                    console.log(data);
                }
            });
        }
    </script>

</body>

</html>