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
                @if($user == "distributor")
                    Distributor
                @elseif($user == "reseller")
                    Reseller
                @endif
                    - 
                @if($type == "stok")
                    Available Stock
                @elseif($type == "penjualan")
                    Total Penjualan
                @elseif($type == "retur")
                    Total Retur
                @endif
            </div>
            <hr style="border-color:black;">
            <table style="width:100%;">
                <tr>
                    <td style="width:10%;">Kepada</td>
                    <td style="width:10%;">:</td>
                    <td style="width:30%;"></td>
                    <td style="width:10%;">NO INV</td>
                    <td style="width:10%;">:</td>
                    <td style="width:30%;"></td>
                </tr>
                <tr>
                    <td style="width:10%;">Alamat</td>
                    <td style="width:10%;">:</td>
                    <td style="width:30%;"></td>
                    <td style="width:10%;">Tanggal</td>
                    <td style="width:10%;">:</td>
                    <td style="width:30%;"></td>
                </tr>
            </table>
            <div class="container justify text-center">
                <!-- dashboard pabrik -->
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 grid-margin">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="table-responsive-xl" style="overflow: scroll; ">
                                    <table style="width:100%;" id="myTable">
                                        <thead>
                                            <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                <th>Distributor</th>

                                                @if($user=="reseller")
                                                <th>Reseller</th>
                                                @endif

                                                @if($type=="stok")
                                                <th>Stok Available</th>
                                                @elseif($type=="penjualan")
                                                <th>Total Penjualan</th>
                                                @elseif($type=="retur")
                                                <th>Total Retur</th>
                                                @endif
                                            </tr>
                                        </thead>
    
                                        <tbody>
                                            @foreach($datas as $data)
                                            <tr>
                                                @if($user=="reseller")
                                                @php
                                                    $distributor = \App\Models\User::where('id_group', $data->id_group)->where('user_position', 'superadmin_distributor')->first();
                                                @endphp
                                                <td>{{ $distributor->firstname }} {{ $distributor->lastname }}</td>
                                                @endif

                                                <td>{{ $data->firstname }} {{ $data->lastname }}</td>

                                                @if($type=="stok")
                                                <td>{{ number_format($data->stok, 0, ',', '.') }} pcs</td>
                                                @elseif($type=="penjualan")
                                                <td>Rp {{ number_format($data->totalPenjualan, 0, ',', '.') }}</td>
                                                @elseif($type=="retur")
                                                <td>Rp {{ number_format($data->totalRetur, 0, ',', '.') }}</td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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