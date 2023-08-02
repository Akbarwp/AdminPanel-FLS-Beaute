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
                <h4>History Point - {{ $owner->firstname }} {{ $owner->lastname }}</h4>
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
                <div class="row">
                    <div class="col-12">
                        <div class="iq-card">
                            <div class="iq-card-body ">
                                <table id="myTable" class="table text-left table-hover table-striped table-light"
                                    id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Claim</th>
                                            <th>Point Keluar</th>
                                            <th>Point Masuk</th>
                                            <th>Sisa Point Saya</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($owner->user_position != "reseller" && $owner->user_position != "sales")
                                        @foreach($reseller_beli as $history)
                                        <tr>
                                            <td>{{ $history->updated_at->format('d/m/y H:i:s') }}</td>
                                            <td>-</td>
                                            <td>{{ number_format($history->crm_poin_distributor, 0, ',', '.') }}</td>
                                            <td><b>Pembelian reseller</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                                        </tr>
                                        @endforeach
                                        @foreach($jual_kasir as $history)
                                        <tr>
                                            <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                            <td>-</td>
                                            <td>{{ number_format($history->crm_poin_distributor, 0, ',', '.') }}</td>
                                            <td><b>Penjualan kasir</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                                        </tr>
                                        @endforeach
                                        @foreach($reseller_jual as $history)
                                        <tr>
                                            <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                            <td>-</td>
                                            <td>{{ number_format($history->crm_poin_distributor, 0, ',', '.') }}</td>
                                            <td><b>Penjualan reseller</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                                        </tr>
                                        @endforeach
                                        @endif
            
                                        @if($owner->user_position == "reseller")
                                        @foreach($jual_kasir as $history)
                                        <tr>
                                            <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                            <td>-</td>
                                            <td>{{ number_format($history->crm_poin_reseller, 0, ',', '.') }}</td>
                                            <td><b>Penjualan kasir</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                                        </tr>
                                        @endforeach
                                        @endif
            
                                        @if($owner->user_position == "sales")
                                        @foreach($jual_tracking as $history)
                                        <tr>
                                            <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                            <td>-</td>
                                            <td>{{ number_format($history->crm_poin_sales, 0, ',', '.') }}</td>
                                            <td><b>Penjualan Tracking</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                                        </tr>
                                        @endforeach
                                        @endif
            
                                        @foreach($claim_reward_history as $history)
                                        <tr>
                                            <td>
                                                {{ $history->updated_at->format('d/m/y H:i:s') }}
                                            </td>
                                            <td>{{ number_format($history->poin, 0, ',', '.') }}</td>
                                            <td>-</td>
                                            <td><b>Claim</b> reward {{ $history->reward }}</td>
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
</body>
</html>