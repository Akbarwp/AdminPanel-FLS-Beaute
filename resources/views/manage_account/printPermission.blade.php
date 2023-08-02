@extends('templates/print')

@section('css')

@endsection

@section('content')
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <img src="{{ asset('images/flslogo.jpg') }}" style="width:25%">
            </div>
            <div class="col-sm-7">
                <div class="d-flex justify-content-end" style="font-weight:bold">
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
            </div>
        </div>
        <hr style="border-color:black;">
        <div class="row d-flex justify-content-center" style="font-weight:bold; font-size:24px;">
            Permission
        </div>
        <hr style="border-color:black;">
        <div class="row">
        <div class="col-12 grid-margin ">
            <div class="iq-card">
                <div class="iq-card-body">
                    <div>
                        <table id="mytable" class="table table-hover table-light">
                            @foreach($users as $user)
                            <thead>
                                <tr>
                                    <th scope="col">{{ $user->firstname }} {{ $user->lastname }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                                <tr class="text-left" id="">
                                    <td>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_barang" data-user="">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->lihat_barang)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Barang</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="tambah_barang" data-user="">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->tambah_barang)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Tambah Barang</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="edit_barang" data-user="">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->edit_barang)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Edit Barang</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="hapus_barang" data-user="">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->hapus_barang)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Hapus Barang</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="pasok_barang" data-user="">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->pasok_barang)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Pasok Barang</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_pos" data-user="">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->lihat_pos)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat POS</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="input_pos" data-user="">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->input_pos)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Input POS</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="acc_transaksi" data-user=" ">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->acc_transaksi)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Acc Transaksi</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="input_retur" data-user=" ">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->input_retur)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Input Retur</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="acc_retur" data-user=" ">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->acc_retur)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Acc Retur</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_laporan_penjualan" data-user=" " @if($user->lihat_laporan_penjualan)checked @endif>
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Laporan Penjualan</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_laporan_pembelian" data-user=" " @if($user->lihat_laporan_pembelian)checked @endif>
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Laporan Pembelian</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_laporan_pegawai" data-user=" " @if($user->lihat_laporan_pegawai)checked @endif>
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Laporan Pegawai</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_tracking_sales" data-user=" " >
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->lihat_tracking_sales)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Tracking Sales</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_crm" data-user=" ">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->lihat_crm)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat CRM</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="input_poin_crm" data-user=" ">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->input_poin_crm)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Input Poin CRM</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="input_reward_crm" data-user=" ">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->input_reward_crm)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Input Reward CRM</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="acc_reward" data-user=" ">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" disabled @if($user->acc_reward)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Acc Reward CRM</label>
                                                </div>
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
@endsection

@section('script')
<script>

<script>
@endsection