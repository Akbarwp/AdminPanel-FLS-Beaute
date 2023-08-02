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
                        @can('superadmin_pabrik')
                        <h4>Retur Pabrik ke Supplier</h4>
                        @endcan
                        @can('superadmin_distributor')
                        <h4>Retur dari Customer</h4>
                        @endcan
                        @can('reseller')
                        <h4>Retur dari Customer</h4>
                        @endcan
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/retur/to_cashier/export/') }}'">
                            <i class="fa fa-file-pdf-o"></i>
                            <span>Export</span>
                        </button>
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/retur/to_cashier/print/') }}')">
                            <i class="fa fa-print"></i>
                            <span>Print</span>
                        </button>
                    </div>
                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/retur/to_cashier/create/') }}'">
                            <span>+ Add</span>
                        </button>
                    </div>

                </div>
                
            </div>
        </div>
    </div>

    <hr>

    <div class="row w-100">
        <div class="col-12 grid-margin">
            <div class="iq-card">
                <div class="iq-card-body">
                    <form action="/manage_report/transaction/retur/sell/get_date" method="get">
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
                                        <th scope="col">No Nota</th>
                                        @endif
                                        <th scope="col">Customer</th>
                                        <th scope="col">No Surat Keluar</th>
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
                                            <td scope="col">{{ $retur->transaction->transaction_code }}</td>
                                            @endif
                                            <td scope="col">
                                                {{ $retur->transaction->nama_pembeli }} 
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
                                                    <button type="button" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/retur/to_cashier/detail/'.$retur->id) }}'" class="btn btn-primary">
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

$(document).ready(function () {
    var table=$('#logTable').DataTable({
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

// $('#search').click(function () {
//     var min = document.getElementById("min").value;
//     var max = document.getElementById("max").value;
    
//     $.ajax({
//         type:'get',
//         url:'{{ url("/manage_report/returs/getDate") }}',
//         data: {
//             "_token": "{{ csrf_token() }}",
//             min:min,
//             max:max        
//         },
//         success:function(data) {
//             //console.log(data);
//             document.getElementById("logTableDiv").innerHTML = data;
//             $('#logTable').DataTable(
//             {
//                 "oSearch": { "bSmart": false, "bRegex": true },
//                 "aaSorting": [],
//                 footerCallback: function (row, data, start, end, display) {
//                     var api = this.api();
        
//                     // Remove the formatting to get integer data for summation
//                     var intVal = function (i) {
//                         return typeof i === 'string' ? i.replace(/[\Rp. .]/g, '') * 1 : typeof i === 'number' ? i : 0;
//                     };
        
//                     // Total over all pages
//                     total = api
//                         .column(2)
//                         .data()
//                         .reduce(function (a, b) {
//                             return intVal(a) + intVal(b);
//                         }, 0);
        
//                     // Total over this page
//                     pageTotal = api
//                         .column(2, { page: 'current' })
//                         .data()
//                         .reduce(function (a, b) {
//                             return intVal(a) + intVal(b);
//                         }, 0);
        
//                     // Update footer
//                     $("#totalAll").html(number_format(pageTotal, 0, ',', '.'));
//                 },
//             });
//         },
//         error: function(data){
//             console.log(data);
//         }
//     });
// });

</script>
@endsection