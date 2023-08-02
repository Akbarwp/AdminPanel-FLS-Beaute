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
                                    <table cellspacing="0" id="myTable" style="width: 100%">
                                        <thead>
                                            <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                <th scope="col">No Nota</th>
                                                <th scope="col">Supplier</th>
                                                <th scope="col">No Surat Keluar</th>
                                                <th scope="col">Tanggal Retur</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($returs as $retur)
                                                <tr>
                                                    @if(auth()->user()->user_position == "superadmin_pabrik")
                                                    <td scope="col">{{ $retur->pasok->kode_pasok }}</td>
                                                    @else
                                                    <td scope="col">{{ $retur->transaction->transaction_code }}</td>
                                                    @endif
                                                    <td scope="col">
                                                        @if($retur->id_supplier == 0)
                                                        Pabrik Astana
                                                        @else
                                                        {{ $retur->supplier->firstname }} {{ $retur->supplier->lastname }} 
                                                        @endif
                                                    </td>
                                                    <td scope="col">{{ $retur->surat_keluar }}</td>
                                                    <td scope="col">{{ $retur->updated_at->format('d/m/y H:i:s') }}</td>
                                                    <td scope="col">{{ $retur->keterangan }}</td>
                                                    <td scope="col">
                                                        @if($retur->status_retur == 0)
                                                            Menunggu Konfirmasi
                                                        @else
                                                            Retur Sukses
                                                        @endif
                                                    </td>
                                                    <td scope="col">Rp. {{ number_format($retur->total, 0, ',', '.') }}</td>
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