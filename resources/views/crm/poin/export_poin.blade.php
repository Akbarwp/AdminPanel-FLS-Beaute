<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FLS Beauty</title>
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
                History Point
            </div>
            <hr style="border-color:black;">
            <div class="row">
                <div class="col-12">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="row d-flex justify-content-between m-1">
                            <h4>Reward Distributor</h4>
                        </div>
                        
                        <div class="table-responsive-xl">
                            
                            <table
                                class="table table-hover table-striped table-light display sortable"
                                cellspacing="0" id="myTable" style="width:100%">
                                <thead>
                                    <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                        <th>Produk</th>
                                        <th>Point Distributor</th>
                                        <th>Point Distributor-Reseller</th>
                                        <th>Point Reseller</th>
                                    </tr>
                                </thead>
    
                                <tbody>
                                    @foreach($poins as $poin)
                                <tr>
                                    <td>{{ $poin->product_type->nama_produk }}</td>
                                    <td>{{ $poin->distributor_jual }}</td>
                                    <td>{{ $poin->distributor_reseller_jual }}</td>
                                    <td>{{ $poin->reseller_jual }}</td>
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