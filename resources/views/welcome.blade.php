<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/0f62af5d1d.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Погода NOW</title>
</head>
<body>

<style>
    #myVideo {
        position: fixed;
        right: 0;
        bottom: 0;
        min-width: 100%;
        min-height: 100%;
    }

    .container-fluid {
        position: fixed;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        color: #f1f1f1;
        width: 100%;
        padding: 20px;
    }
</style>

<video autoplay muted loop id="myVideo">
    <source src="{{ asset('storage/video.mp4') }}" type="video/mp4">
</video>

<div class="container-fluid col-md-12 d-flex justify-content-center">
    <div class="row align-items-center justify-content-center vh-100">
        <form>
            <div class="lh-1 text-center">
                <h1 class="fw-bold">Погода <strong class="text-warning">NOW</strong></h1>
                <p class="small fw-light">знайди погоду любої країни та міста</p>
            </div>
            <div class="input-group mb-3 input-group-lg">
                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-tree-city text-secondary"></i></span>
                <input type="text" class="form-control" name="city" placeholder="Введіть місто" aria-label="Username" aria-describedby="inputGroup-sizing-lg">
                <button class="btn btn-warning" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="text-center result fw-bold"></div>
        </form>
    </div>
</div>


</body>

<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".btn").click(function (e) {
        e.preventDefault();
        var city = $("input[name=city]").val();

        $.ajax({
            type: 'POST',
            url: "{{ route('show') }}",
            data: {city: city},
            success: function (data) {
                if (data.response == 'bad') {
                    $('.result').text('Такого міста немає!');
                } else {
                    $('.result').text('В місті зараз: ' + data.response);
                }
            },
            error: function (data) {
                $('.result').text('Посилання не правильне (https://)');
            }
        });
    });

</script>

</html>
