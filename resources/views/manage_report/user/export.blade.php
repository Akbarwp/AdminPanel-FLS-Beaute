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
            <p style="font-weight:bold; font-size: 20px; text-align:left;">Laporan Pegawai</p>
            <table cellspacing="0" id="myTable" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col" colspan="2">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Posisi</th>
                        <th scope="col">Aktifitas Pasok</th>
                        <th scope="col">Aktifitas Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawais as $pegawai)
                        <tr>
                            <td class='jname full-body' style="width:8%">
                                @if($pegawai->image)
                                    <img src="{{ public_path() . $pegawai->image }}" alt=profile-img class="avatar-50 roundimg" img-fluid width="90%"/>
                                @else
                                    <?php $image_path = '/images/manage_account/users/11.png'; ?>
                                    <img src="{{ public_path() . $image_path }}" alt=profile-img class="avatar-50 roundimg" img-fluid width="90%"/>
                                @endif
                            </td>
                            <td class='jname full-body'>
                                {{ $pegawai->firstname }} {{ $pegawai->lastname }}
                            </td>
                            <td>{{ $pegawai->email }}</td>
                            <td>{{ $pegawai->user_position }}</td>
                            @if(auth()->user()->id_group == 1)
                            <td>
                                @php
                                    $countPembelian = \App\Models\SupplyHistory::where('id_input',$pegawai->id)->count();
                                @endphp
                                {{ $countPembelian }} x
                            </td>
                            <td>
                                @php
                                    $countPenjualan = \App\Models\TransactionHistory::where('id_approve',$pegawai->id)->count();
                                @endphp
                                {{ $countPenjualan }} x
                            </td>
                            @else
                                <td>
                                    @php
                                        $countPembelian = \App\Models\TransactionHistory::where('id_input',$pegawai->id)->count();
                                    @endphp
                                    {{ $countPembelian }} x
                                </td>
                                <td>
                                    @php
                                        $countPenjualan = \App\Models\TransactionHistory::where('id_approve',$pegawai->id)->count();
                                        $countPenjualanKasir = \App\Models\TransactionHistorySell::where('id_input',$pegawai->id)->count();
                                        $countPenjualanTracking = \App\Models\TrackingSalesHistory::where('id_reseller',$pegawai->id)->count();
                                    @endphp
                                    {{ $countPenjualan+$countPenjualanKasir+$countPenjualanTracking }} x
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>