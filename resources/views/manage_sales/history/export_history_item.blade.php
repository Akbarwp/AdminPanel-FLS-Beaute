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

        #myTable2 thead, #myTable2 tbody,  #myTable2 tr,  #myTable2 th, #myTable2 td{
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
                History '{{ $product->product_type->nama_produk }}' {{ $owner->firstname }} {{ $owner->lastname }}
            </div>
            <hr style="border-color:black;">
        <div class="iq-card">
            <div class="iq-card-body">
                <h5 style="text-align:left;font-weight:bold;">Barang Keluar</h5>
                <table
                    class="table table-hover table-striped table-light display sortable text-left text-nowrap"
                    cellspacing="0" id="myTable" style="width:100%">
                    <thead>
                        <tr id="_judul" onkeyup="_filter()" id="myFilter">
                            <th>Tanggal Keluar</th>
                            <th>Nama Toko</th>
                            <th>Jumlah barang Keluar</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach($keluar as $k)
                            <tr>
                                <td style="width:33%">{{ $k->created_at->format('d/m/y H:i:s') }}</td>
                                <td style="width:33%">{{ $k->nama_toko }}</td>
                                <td style="width:34%">{{ number_format($k->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="iq-card">
            <div class="iq-card-body">
                <h5 style="text-align:left;font-weight:bold;">Barang Masuk</h5>
                <table
                    class="table table-hover table-striped table-light display sortable text-nowrap text-left"
                    cellspacing="0" id="myTable2" style="width:100%">
                    <thead>
                        <tr id="_judul" onkeyup="_filter()" id="myFilter">
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Terima</th>
                            <th>Jumlah barang Masuk</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach($masuk as $m)
                            <tr>
                                <td style="width:33%">{{ $m->created_at->format('d/m/y H:i:s') }}</td>
                                <td style="width:33%">{{ $m->updated_at->format('d/m/y H:i:s') }}</td>
                                <td style="width:34%">{{ number_format($m->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>