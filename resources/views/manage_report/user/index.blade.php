@extends('templates/main')

@section('css')

@endsection

@section('content')
<div class="container justify text-center">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between">
            <div class="container">
                <div class="row ">

                    <!-- <div class="row align-items-center"> -->
                        <div class="col-md-3 text-left">
                            <h4>Laporan Pegawai</h4>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/manage_report/users/export') }}'">
                                <i class="fa fa-file-pdf-o"></i>
                                <span>Export</span>
                            </button>
                            <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_report/users/print') }}')"><i class='fa fa-print'></i>
                            Print</button>
                        </div>

                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="iq-card">
        <div class="iq-card-body">
            <form action="/manage_report/users/getDate" method="get">
            <div class="row align-items-center">
                <div class="col-md-5 text-left">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                        </div>
                        <input class="form-control form-control-sm" id="min" name="min" placeholder="Tanggal Awal" type="text" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-5 text-left">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                        </div>
                        <input class="form-control form-control-sm" id="max" name="max" placeholder="Tanggal Akhir" type="text" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-2 ">
                    <button class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" type="submit" id="search">Cari</button>
                </div>
            </div>
            </form>
            <br>
            <div class="col text-left">
                
            </div>
            <div class="col text-left" id="logTableDiv">
            <table id="logTable" class="table table-responsive table-hover table-striped table-light text-nowrap" style="text-align:left" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Posisi</th>
                        <th scope="col">Aktifitas Pembelian</th>
                        <th scope="col">Aktifitas Penjualan</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawais as $pegawai)
                        <tr>
                            <td class='jname full-body'>
                                @if($pegawai->image)
                                    <img src={{ asset('storage/' . $pegawai->image) }} alt=profile-img class="avatar-50 roundimg" img-fluid/>
                                @else
                                    <img src={{ asset('images/manage_account/users/11.png') }} alt=profile-img class="avatar-50 roundimg" img-fluid/>
                                @endif
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
                            <td class="col-1">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" data-toggle="modal" data-target="#myModal" onclick="location.href='{{ url('/manage_report/users/detail/'.$pegawai->id) }}'">
                                        <i class="fas fa-eye"></i>&nbspLihat Detail</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function () {
    $('#logTable').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        "aaSorting": [],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
        },
    });
    var date_input_min = $('input[name="min"]'); //our date input has the name "date"
    var date_input_max = $('input[name="max"]'); //our date input has the name "date"
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    var options = {
        format: 'mm/dd/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    };
    date_input_min.datepicker(options);
    date_input_max.datepicker(options);
});

</script>
@endsection