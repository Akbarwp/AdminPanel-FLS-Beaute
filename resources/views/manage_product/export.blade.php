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
                @canany('group_pusat')
                Stock Barang Pusat - {{ date('F Y') }}
                @endcan
                @can('group_distributor')
                Stock Barang Distributor - {{ date('F Y') }}
                @endcan
                @can('reseller')
                Stock Barang Reseller - {{ date('F Y') }}
                @endcan    
            </div>
            <hr style="border-color:black;"><br>
            <div class="container justify text-center">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 grid-margin">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="table-responsive-xl" style="overflow: scroll; ">
                                    <table cellspacing="0" id="myTable" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Barang</th>
                                                <th>Stok</th>
                                                <th>Harga Jual</th>
                                                <th>Harga Modal</th>
                                                <th>Nilai Total</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                
                                        <tbody>
                                            @php
                                                $totalNilaiStok = 0;
                                            @endphp
                                            @foreach($products as $product)
                                                <tr >
                                                    <td>{{ $product->product_type->kode_produk }}</td>
                                                    <td>{{ $product->product_type->nama_produk }}</td>
                                                    <td>{{ number_format($product->stok, 0, ',', '.') }} pcs</td>
                                                    <td>Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($product->harga_modal, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($product->stok * $product->harga_modal, 0, ',', '.')}}</td>
                                                    <td>{{ $product->keterangan }}</td>
                                                </tr>
                                                @php
                                                    $totalNilaiStok += ($product->stok * $product->harga_modal)
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <table>
                                        <tr>
                                            <td>Total Stok</td>
                                            <td>:</td>
                                            <td>{{ number_format($stock, 0, ',', '.') }} pcs</td>
                                        </tr>
                                        <tr>
                                            <td>Total Nilai Stok</td>
                                            <td>:</td>
                                            <td>Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</td>
                                        </tr>
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