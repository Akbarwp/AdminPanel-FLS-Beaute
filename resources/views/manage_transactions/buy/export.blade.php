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
            <div class="row d-flex justify-content-center" style="font-weight:bold; font-size:24px; text-align:center">
                Riwayat Transaksi
            </div>
            <hr style="border-color:black;"><br>
            <div class="container justify text-center">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 grid-margin">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="table-responsive-xl" style="overflow: scroll; ">
                                    <table style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Kode Transaksi</th>
                                                <th scope="col">Distributor</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Metode Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $totalAll = 0;
                                            @endphp
                                            @foreach($histories as $history)
                                            @php
                                                $totalAll += $history->total;
                                            @endphp
                                            <tr id="{{ $history->id }}">
                                                <td>{{ $history->transaction_code }}</td>
                                                <td>
                                                    @if($history->id_distributor == 1)
                                                        Pabrik
                                                    @else
                                                        {{ $history->distributor->firstname }} {{ $history->distributor->lastname }}
                                                    @endif
                                                </td>
                                                <td>Rp. {{ number_format($history->total, 0, ',', '.') }}</td>
                                                <td>
                                                    @if($history->status_pesanan == 1)
                                                        Sukses
                                                    @else
                                                        Menunggu Konfirmasi
                                                    @endif
                                                </td>
                                                <td>{{ $history->updated_at->format('d/m/y H:i:s') }}</td>
                                                <td>{{ $history->metode_pembayaran }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <h4>Total : Rp. {{$totalAll}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

