@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="container justify text-center">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between">
            <div class="container">

                <div class="row align-items-center form-group">

                    <div class="col-md-4 text-left">
                        <h4>Laporan Retur Pembelian</h4>
                    </div>
                    {{-- <div class="col-md-6">
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" data-toggle="modal" data-target="#importExcel">
                            <i class="fa fa-file-excel-o"></i>
                            Import
                        </button>
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/retur/to_supplier/exportXlsx/'.auth()->user()->id) }}'">
                            <i class="fa fa-file-excel-o"></i>
                            <span>Export</span>
                        </button>
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/retur/to_supplier/export/') }}'">
                            <i class="fa fa-file-pdf-o"></i>
                            <span>Export</span>
                        </button>
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/retur/to_supplier/print/') }}')">
                            <i class="fa fa-print"></i>
                            <span>Print</span>
                        </button>
                    </div> --}}

                </div>
                
            </div>
        </div>
    </div>

    <hr>

    <div class="row w-100">
        <div class="col-12 grid-margin">
            <div class="iq-card">
                <div class="iq-card-body">
                    <form action="/manage_report/transaction/retur/buy/get_date" method="get">
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
                    <table id="logTable" class="table table-hover table-striped table-light table-responsive text-left text-nowrap" >
                        <thead>
                            <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                @if(auth()->user()->user_position == "sales")
                                <th scope="col">Tanggal Terima Barang</th>
                                @else
                                <th scope="col">Kode Transaksi</th>
                                @endif
                                <th scope="col">Supplier</th>
                                <th scope="col">No Surat Masuk</th>
                                <th scope="col">Tanggal Retur</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($returs as $retur)
                                <tr>
                                    @if(auth()->user()->user_position == "sales")
                                    <td scope="col">{{ $retur->sales_stok->updated_at->format('d/m/y H:i:s') }}</td>
                                    @else
                                    @if($retur->transaction)
                                    <td scope="col">{{ $retur->transaction->transaction_code }}</td>
                                    @else
                                    <td scope="col"><strong>Tidak ada data transaksi(bisa jadi terhapus atau tidak terbuat)</strong></td>
                                    @endif
                                    @endif
                                    <td scope="col">
                                        {{ $retur->supplier->firstname }} {{ $retur->supplier->lastname }} 
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
                                    <td>
                                        <div class="form-group" >
                                            <button type="button" onclick="location.href='{{ url('/retur/to_supplier/detail/'.$retur->id) }}'" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke">
                                                <i class="fa fa-eye"></i>
                                            </button>
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

<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{route('retur.import')}}" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <label>Pilih file excel</label>
                    <div class="form-group">
                        <input type="file" name="import_excel" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" style="background-color:rgba(165,78,182); color:whitesmoke" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
@if ($message = Session::get('create_retur_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

$(document).ready(function(){
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