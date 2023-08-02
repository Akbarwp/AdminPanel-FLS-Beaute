@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="container justify text-center">
    <div class="row align-items-center">
        <div class="col-md-3 text-left">
            <h4>Permission</h4>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/manage_account/permission/export') }}'">
                <i class="fa fa-file-pdf-o"></i>
                <span>Export</span>
            </button>
            <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_account/permission/print') }}')"><i class='fa fa-print'></i>
                Print</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 grid-margin ">
            <div class="iq-card">
                <div class="iq-card-body">
                    <div>
                        <table id="mytable" class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                                @foreach($users as $user)
                                <tr>
                                    <td class="text-left">{{ $user->firstname }} {{ $user->lastname }}</td>
                                    <td class="text-right">               
                                        <button type="button" class="btn btn-link carousel" style="background-color:rgba(165,78,182); color:whitesmoke" data-toggle="collapse" data-target="#permission{{ $user->id }}">
                                        <span><i class="fa fa-angle-down"></i></span>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="collapse text-left" id="permission{{ $user->id }}">
                                    <td>
                                        <div class="row" >
                                            @if($user->user_position != "sales")
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_barang" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->lihat_barang)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Barang</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if(auth()->user()->id_group == 1 && $user->id_group == 1)
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="tambah_barang" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->tambah_barang)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Tambah Barang</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if($user->user_position != "sales")
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="edit_barang" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->edit_barang)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Edit Barang</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if(auth()->user()->id_group == 1 && $user->id_group == 1)
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="hapus_barang" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->hapus_barang)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Hapus Barang</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="pasok_barang" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->pasok_barang)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Pasok Barang</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if(auth()->user()->id_group != 1 && $user->user_position != "sales")
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_pos" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->lihat_pos)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat POS</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="input_pos" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->input_pos)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Input POS</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if($user->user_position != "reseller" && $user->user_position != "sales")
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="acc_transaksi" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->acc_transaksi)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Acc Transaksi</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if(auth()->user()->id_group != 1)
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="input_retur" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->input_retur)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Input Retur</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if($user->user_position != "reseller" && $user->user_position != "sales")
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="acc_retur" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->acc_retur)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Acc Retur</label>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_laporan_penjualan" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->lihat_laporan_penjualan)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Laporan Penjualan</label>
                                                </div>
                                            </div>
                                            @if($user->user_position != "sales")
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_laporan_pembelian" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->lihat_laporan_pembelian)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Laporan Pembelian</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if($user->user_position != "reseller" && $user->user_position != "sales")
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_laporan_pegawai" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->lihat_laporan_pegawai)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Laporan Pegawai</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if($user->user_position != "reseller")
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_tracking_sales" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->lihat_tracking_sales)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat Tracking Sales</label>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="lihat_crm" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->lihat_crm)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Lihat CRM</label>
                                                </div>
                                            </div>
                                            @if(auth()->user()->id_group == 1 && $user->id_group == 1)
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="input_poin_crm" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->input_poin_crm)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Input Poin CRM</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="input_reward_crm" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->input_reward_crm)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Input Reward CRM</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check form-switch form-group ml-3" data-access="acc_reward" data-user="{{ $user->id }}">
                                                    <input class="form-check-input btn-checkbox" type="checkbox" id="flexSwitchCheckChecked" @if($user->acc_reward)checked @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Acc Reward CRM</label>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </td>
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
@endsection

@section('script')
<script>

$(document).ready(function(){
    var table=$('#mytable').DataTable({
        "oSearch": { "bSmart": false, "bRegex": true },
    });
});

function refreshNav(){
    $.ajax({
        url: "{{ url('/manage_account/access/sidebar') }}",
        method: "GET",
        success:function(data){
            $('#sidebar').html(data);
        }
    });
}

$(document).on('click', '.btn-checkbox', function(){
    var data_access = $(this).parent().attr('data-access');
    var data_user = $(this).parent().attr('data-user');
    
    swal("Sedang diproses....", {
        buttons: false,
        timer: 1000,
    });
    $.ajax({
        url: "{{ url('/manage_account/change_permission') }}/" + data_user + '/' + data_access,
        method: "GET",
        success:function(data_1){
        var my_account = "{{ auth()->user()->id }}";
        refreshNav();
        // alert("bb");
        // $.ajax({
        //     url: "{{ url('/access/check') }}/" + my_account,
        //     method: "GET",
        //     success:function(data_2){
        //     if(data_2 == 'benar'){
        //         $('tbody').html(data_1);
        //         refreshNav();
        //     }else{
        //         window.open("{{ url('/dashboard') }}", "_self");
        //     }
        //     }
        // });
        }
    });
    
});
</script>
@endsection