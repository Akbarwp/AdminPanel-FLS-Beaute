<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FLS Beauty</title>
    <style>
        #logTable thead, #logTable tbody,  #logTable tr,  #logTable th, #logTable td{
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
                Laporan Transaksi Pembelian {{ $owner->firstname }} {{ $owner->lastname }}
            </div>
            <hr style="border-color:black;">
            <div class="iq-card">
                <div class="iq-card-body">
                    <div class="col text-left">
                        
                    </div><hr style="margin:5px;">
                    <div class="col text-left" id="logTableDiv">
                        <table id="logTable" class="table table-hover table-light" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Kode Transaksi</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Metode Pembayaran</th>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                @php
                                    if($owner->user_position == "superadmin_pabrik")
                                    {
                                        $code = $transaction->kode_pasok;
                                    }
                                    else
                                    {
                                        $code = $transaction->transaction_code;
                                    }
                                @endphp
                                <tr id="{{ $transaction->id }}">
                                    <td>{{ $code }}</td>
                                    <td>Rp. {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                    <td>{{ $transaction->updated_at->format('d/m/y H:i:s') }}</td>
                                    <td>{{ $transaction->metode_pembayaran }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>