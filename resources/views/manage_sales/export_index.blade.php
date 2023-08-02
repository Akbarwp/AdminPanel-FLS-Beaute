<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Account</title>

    <style>
        #myTable thead, #myTable tbody,  #myTable tr,  #myTable th, #myTable td{
            border: 1px solid black;
        }

    </style>
</head>

<body style="background-color:white">
    <div class="wrapper">
        <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table style="width:100%;">
                    <tr style="width:100%;">
                        <td style="width:20%;">
                            <?php $image_path = '/images/flslogo.jpg'; ?>
                            <img src="{{ public_path() . $image_path }}" style="width:75%">
                        </td>
                        
                        <td style="text-align: right; width:80%;">
                            <div class="d-flex justify-content-end" style="font-weight:bold; ">
                                PT ANDARA CANTIKA
                            </div>
                            <div class="d-flex justify-content-end">
                                Pergudangan Bumi Benowo Sukses Sejahtera Tbk
                            </div>
                            <div class="d-flex justify-content-end">
                                Jl. Raya Gelora Bung Tomo No. 8, Surabaya, Jawa Timur
                            </div>
                            <div class="d-flex justify-content-end">
                                Email: flsbeautyofficial@gmail.com
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <hr style="border-color:black;">
            <div class="row d-flex justify-content-center" style="font-weight:bold; font-size:24px">
                Sales Dari {{ $distributor->firstname }} {{ $distributor->lastname }}
            </div>
            <hr style="border-color:black;">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 grid-margin ">
                <div class="iq-card">
                    <div class="iq-card-body">
                        
                        <div class="table-responsive-xl">
                            
                            <table
                                class="table table-hover table-striped table-light display sortable"
                                cellspacing="0" id="myTable" style="width:100%">
                                <thead>
                                    <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                        <th>ID Sales</th>
                                        <th>Nama Sales</th>
                                        <th>Alamat Sales</th>
                                        <th>Nomor HP</th>
                                    </tr>
                                </thead>
    
                                <tbody>
                                    @foreach($sales as $s)
                                    <tr>
                                        <td>{{ $s->id }}</td>
                                        <td>{{ $s->firstname }} {{ $s->lastname }}</td>
                                        <td>{{ $s->address }}</td>
                                        <td>{{ $s->no_hp }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
    
                            <div>
                            </div>
                        </div>
    
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>