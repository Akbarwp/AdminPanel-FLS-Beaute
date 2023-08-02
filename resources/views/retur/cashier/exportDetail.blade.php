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
                @can('superadmin_pabrik')
                Retur Pabrik ke Supplier
                @endcan
                @can('superadmin_distributor')
                Retur Distributor ke Pabrik
                @endcan
                @can('reseller')
                Retur Reseller ke Distributor
                @endcan
            </div>
            <hr style="border-color:black;"><br>
            <div class="container justify text-center">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 grid-margin">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="table-responsive-xl" style="overflow: scroll; ">
                                    <table>
                                        <tr>
                                            <td>No Nota</td>
                                            <td>:</td>
                                            <td>
                                                @if(auth()->user()->user_position == "superadmin_pabrik")
                                                {{ $retur->pasok->kode_pasok }}
                                                @else
                                                {{ $retur->transaction->transaction_code }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Supplier</td>
                                            <td>:</td>
                                            <td>
                                                @if($retur->id_supplier == 0)
                                                Pabrik Astana
                                                @else
                                                {{ $retur->supplier->firstname }} {{ $retur->supplier->lastname }} 
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>No Surat Keluar</td>
                                            <td>:</td>
                                            <td>{{ $retur->surat_keluar }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Retur</td>
                                            <td>:</td>
                                            <td>{{ $retur->updated_at->format('d/m/y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td>:</td>
                                            <td>{{ $retur->keterangan }}</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <table id="myTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nama Barang</th>
                                                <th scope="col">Kuantitas Barang yang Diretur</th>
                                                <th scope="col">Harga Satuan</th>
                                                <th scope="col">Harga Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($details as $detail)
                                                <tr>
                                                    <td scope="col">{{ $detail->nama_produk }}</td>
                                                    <td scope="col">{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                                    <td scope="col">Rp. {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                                    <td scope="col">Rp. {{ number_format($detail->jumlah*$detail->harga, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    Total Retur : Rp. {{ number_format($retur->total, 0, ',', '.') }}
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