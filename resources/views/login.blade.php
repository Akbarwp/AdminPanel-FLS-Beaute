<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
        <!-- TEMPLATE -->
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/astanalogo.jpg" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    {{-- swall --}}
    <link rel="stylesheet" href="css/sweetalert.css">

    <link href="css/star-rating.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.1.2/js/star-rating.min.js"></script>



    <!-- bootdtrap css cdn -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"> -->


    <!-- Latest compiled and minified CSS ??????-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <!-- popper.js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
        integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!-- bootstrap js -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Latest compiled and minified JavaScript ??????/ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- bootstrap dropdown js ?????? -->
    <!-- <script src="https://gist.github.com/dstaley/8c9d53f88d1ad53c57b4.js"></script> -->

    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />

        <!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.1.2/css/star-rating.min.css"></script>

        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> --}}


    <style type="text/css">
        .cont{
            margin-top: 50px;
            padding: 30px;
            width:500px;
            height:530px;
            background-color: aliceblue;
            border-radius: 10px;
        }
        h3{
            font-family:spartan;
            color: #633687;
        }
        .gin{
            font-family:spartan;
            color: #633687;
            font-weight: bold;
        }
        img{
            width: 60%;
            height: 30%;
        }
        .form-control{
            padding: 10px;
            border-color: #633687;
            border-width: 1px;
        }
        .btn{
            background-color: #633687;
            color: white;
            padding: 10px;
        }
    </style>
</head>
<body>
    <center>
        <div class="cont">
            <img src="{{asset('images/templates/main/logo.png')}}">
            <h3>Pancarkan cantikmu bersama kami</h3>
            <br>
            <h3 class="gin">Log In</h3>
            <br>

            <div class="col-sm-12">
                <form action="{{ url('/verify_login') }}" method="post" name="login_form">
                    @csrf
                    {{-- <div class="row form-group">
                        <div class="col-sm">
                            <select type="text" id="user_type" name="user_type" class="form-control" placeholder="Login Sebagai">
                                <option value="0">Login Sebagai Pabrik/Distributor...</option>
                                <option value="pabrik">Pabrik</option>
                                <option value="distributor">Distributor</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username..." autofocus required>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password..." required>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm text-center">
                            <input type="submit" id="" class="btn btn-primary" value="Login">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </center>

    <script src="js/sweetalert.min.js"></script>
    <script>
        @if ($message = Session::get('create_success'))
            console.log("berhasil");

            swal(
                "Berhasil!",
                "{{ $message }}",
                "success"
            );
        @endif

        @if ($message = Session::get('login_failed'))
            console.log("gagal");
            swal(
                "Gagal!",
                "{{ $message }}",
                "error"
            );
        @endif
        // $(document).ready(
        //     function(){
        //         $('#sidebarcollapse').on('click',function(){
        //             $('#sidebar').toggleClass('active');
        //         });
        //     }
        // )


    </script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> --}}

</body>
</html>
