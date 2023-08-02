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
                <p style="font-weight:bold; font-size: 20px; text-align:left;">
                    Tracking {{ $sales->firstname }} {{ $sales->lastname }} - {{ date('F Y') }}
                </p>
                <table id="myTable" class="table table-hover table-striped table-light" style="text-align:left">
                    <thead>
                        <tr>
                            <th scope="col">Id Sales</th>
                            <th scope="col">Toko</th>
                            <th scope="col">Lokasi (lat/long)</th>
                            <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $history)
                            <tr>
                                <td>{{ $history->id_reseller }}</td>
                                <td>{{ $history->nama_toko }}</td>
                                <td>{{ $history->address }} ({{ $history->latitude }} / {{$history->longitude}})</td>
                                <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>