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
                Daftar Akun
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
                                                <th scope="col">Nama Akun</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Posisi</th>
                                                <th scope="col">Admin Input</th>
                                                <th scope="col">Tanggal Diinput</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>
                                                        {{ $user->firstname}} {{ $user->lastname }}
                                                    </td >
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        @if($user->user_position == "superadmin_pabrik")
                                                            superadmin
                                                        @elseif($user->user_position == "superadmin_distributor")
                                                            distributor
                                                        @else
                                                            {{ $user->user_position }}
                                                        @endif    
                                                    </td>
                                                    @canany(['superadmin_pabrik','admin'])
                                                        <td>
                                                            @if($admins->where('id', $user->id_input)->first())
                                                            {{ $admins->where('id', $user->id_input)->first()->firstname }} {{ $admins->where('id', $user->id_input)->first()->lastname }}
                                                            @else
                                                            {{ $user->nama_input }}
                                                            @endif
                                                        </td>
                                                    @endcan
                                                    @can('superadmin_distributor')
                                                        <td>
                                                            {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                                                        </td>
                                                    @endcan
                                                    <td>{{ $user->created_at->format('d/m/y H:i:s') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><br>
                                <table>
                                    @canany(['superadmin_pabrik', 'admin'])
                                        <tr>
                                            <td>Total Akun</td>
                                            <td>:</td>
                                            <td>{{ $countTotal }} Akun</td>
                                        </tr>
                                        <tr>
                                            <td>Total Akun Super Admin Pabrik</td>
                                            <td>:</td>
                                            <td>{{ $countSuperAdminPabrik }} Akun</td>
                                        </tr>
                                        <tr>
                                            <td>Total Akun Admin Pabrik</td>
                                            <td>:</td>
                                            <td>{{ $countAdmin }} Akun</td>
                                        </tr>
                                        <tr>
                                            <td>Total Akun Accounting Pabrik</td>
                                            <td>:</td>
                                            <td>{{ $countAccountingPabrik }} Akun</td>
                                        </tr>
                                        <tr>
                                            <td>Total Akun Cashier Pabrik</td>
                                            <td>:</td>
                                            <td>{{ $countCashierPabrik }} Akun</td>
                                        </tr>
                                        <tr>
                                            <td>Total Akun Distributor</td>
                                            <td>:</td>
                                            <td>{{ $countSuperAdminDistributor }} Akun</td>
                                        </tr>
                                        <tr>
                                            <td>Total Akun Prospek Distributor</td>
                                            <td>:</td>
                                            <td>{{ $countProspekDistributor }} Akun</td>
                                        </tr>
                                    @endcan
                                    @can('superadmin_distributor')
                                        <tr>
                                            <td>Total Akun</td>
                                            <td>:</td>
                                            <td>{{ $countTotal }} Akun</td>
                                        </tr>
                                        <tr>
                                            <td>Total Akun Distributor</td>
                                            <td>:</td>
                                            <td>{{ $countSuperAdminDistributor }} Akun</td>
                                        </tr>
                                        <tr>
                                            <td>Total Akun Accounting Distributor</td>
                                            <td>:</td>
                                            <td>{{ $countAccountingDistributor }} Akun</td>
                                        </tr>
                                        <tr>
                                            <td>Total Akun Cashier Distributor</td>
                                            <td>:</td>
                                            <td>{{ $countCashierDistributor }} Akun</td>
                                        </tr>
                                        <tr>
                                            <td>Total Akun Reseller</td>
                                            <td>:</td>
                                            <td>{{ $countReseller }} Akun</td>
                                        </tr>
                                        <tr>
                                            <td>Total Akun Prospek Reseller</td>
                                            <td>:</td>
                                            <td>{{ $countProspekReseller }} Akun</td>
                                        </tr>
                                    @endcan
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