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
        .dtHorizontalExampleWrapper {
        max-width: 600px;
        margin: 0 auto;
        }
        a:hover{
            text-decoration:none;
        }
        .labelclass{
            color:black;
            text-align:left;
            font-weight:500;
        }
        .col{
            padding-right: 0;
        }
        p,h4{
            margin: 0;
        }
        .invert { 
            filter: invert(100%); 
        }
        body{
            background-color: rgba(197, 219, 236, 1)
        }
        label,h2{
            color: rgba(253, 190, 51, 1);
        }
        .container{
            padding:8px;
        }
        .col-sm s{
            flex-grow:0;
        }
        
        /* navbar */
        .list-group-item{
            background-color:rgba(52, 25, 80, 1);
            padding:8;
        }
        #profile{
        width: 62px;
        height: 62px;
        background: #F47D7E;
        border-radius: 45px;
        }

        .wrapper{
            display: flex;
            align-items: stretch;
            width:100%;
        }
        #sidebar{
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background: rgba(52, 25, 80, 1);
            color: #fff;
            transition: all 0.3s;
        }
        #sidebar.active{
            margin-left: -250px;
        }
        #sidebar .sidebar-header {
            padding: 20px;
            background: rgba(52, 25, 80, 1);
            color: #fff;
        }

        #sidebar ul.components {
            padding: 20px 0;
            border-bottom: 1px solid #47748b;
        }

        #sidebar ul p {
            color: #fff;
            padding: 10px;
        }

        #sidebar ul li a {
            padding: 10px;
            font-size: 1.1em;
            display: block;
            color:#fff;
        }
        #sidebar ul li.list-group-item :hover {
            background: rgb(42, 20, 64);
            transition: all 0.3s;
        } 

        #sidebar ul li.active > a, a[aria-expanded="true"] {
            color: #fff;
            background: rgb(42, 20, 64);
        }
        ul ul a {
            font-size: 0.9em !important;
            padding-left: 30px !important;
            background: rgba(52, 25, 80, 1);
        }
        a[data-toggle="collapse"]{
            position: relative;
        }
        .dropdown-toggle::after{
            display: block;
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
        }
        @media(max-width:768px){
            #sidebar{
                margin-left: -250px;
            }
            #sidebar.active{
                margin-left:0;
            }
        }

        /* back button */
        button{
            background-color: transparent;
            background-repeat: no-repeat;
            border: none;
            cursor: pointer;
            overflow: hidden;
            outline: none;
        }
        button:focus {
            border: none;
        }
        body{
            background-color: rgba(52, 25, 80, 1);
            color: white;
        }
        .iq-card{
            background-color:rgb(39, 19, 61);
        }
        h1,p{
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    {{-- <div class="row justify-content-center">
        <div class="col-md-4">
            @if(session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('loginError') }}
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div> --}}
        
    <div class="wrapper">
        <div class="container justify-content-center align-items-center text-center" style="margin-top:8%;">
            <div class="iq-card">
                <div class="row justify-content-center align-items-center text-center">
                    <div class="col-sm-3">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col">
                                    <h1>ASTANA</h1>
                                    <p>for your daily activity</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col text-left">
                                    <h4>Login</h4>
                                    <hr>
                                </div>
                            </div>
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
                                <div class="row form-group">
                                    <div class="col-sm">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background-color:white;"><i class="fa fa-user"></i></span>
                                            </div>
                                            <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username..." autofocus required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background-color:white;"><i class="fa fa-lock"></i></span>
                                            </div>
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password..." required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm text-right">
                                        <input type="submit" id="" class="btn btn-primary" value="Login">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
