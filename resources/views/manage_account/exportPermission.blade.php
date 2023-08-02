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
            
            <div class="row">
                <div class="row d-flex justify-content-center" style="font-weight:bold; font-size:24px;text-align:center;">
                    Permission
                </div>
                <hr style="border-color:black;">
                <div class="col-12 grid-margin ">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div>
                                <table id="mytable" class="table table-hover table-light" style="width:100%">
                                    @foreach($users as $user)
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ $user->firstname }} {{ $user->lastname }}</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablebody">
                                        <tr class="text-left" id="">
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="lihat_barang" data-user="">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->lihat_barang)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Barang</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="tambah_barang" data-user="">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->tambah_barang)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Tambah Barang</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="edit_barang" data-user="">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->edit_barang)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Edit Barang</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="hapus_barang" data-user="">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->hapus_barang)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Hapus Barang</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="text-left" id="">
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="pasok_barang" data-user="">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->pasok_barang)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Pasok Barang</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="lihat_pos" data-user="">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->lihat_pos)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Lihat POS</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="input_pos" data-user="">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->input_pos)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Input POS</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="acc_transaksi" data-user=" ">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->acc_transaksi)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Acc Transaksi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="text-left" id="">
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="input_retur" data-user=" ">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->input_retur)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Input Retur</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="acc_retur" data-user=" ">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->acc_retur)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Acc Retur</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="lihat_laporan_penjualan" data-user=" " @if($user->lihat_laporan_penjualan)checked @endif>
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Laporan Penjualan</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="lihat_laporan_pembelian" data-user=" " @if($user->lihat_laporan_pembelian)checked @endif>
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Laporan Pembelian</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="text-left" id="">
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="lihat_laporan_pegawai" data-user=" " @if($user->lihat_laporan_pegawai)checked @endif>
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Laporan Pegawai</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="lihat_tracking_sales" data-user=" " >
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->lihat_tracking_sales)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Tracking Sales</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="lihat_crm" data-user=" ">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->lihat_crm)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Lihat CRM</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="input_poin_crm" data-user=" ">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->input_poin_crm)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Input Poin CRM</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="text-left" id="">
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="input_reward_crm" data-user=" ">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->input_reward_crm)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Input Reward CRM</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="col-3">
                                                    <div class="form-check form-switch form-group ml-3" data-access="acc_reward" data-user=" ">
                                                        <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->acc_reward)checked @endif>
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Acc Reward CRM</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
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