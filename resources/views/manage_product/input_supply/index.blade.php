@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="container justify text-center">
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-sm-4">
                    <h4 style="text-align:left;">Pasok Barang</h4>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/manage_product/input_pasok/export/') }}'">
                        <i class="fa fa-file-pdf-o" ></i>
                        <span>Export</span>
                    </button>
                    <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_product/input_pasok/print/') }}')"><i class='fa fa-print'></i>
                        Print</button>
                </div>
                <div class="col-sm text-right">
                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke"
                        onclick="location.href='{{ url('/manage_product/input_pasok/supplyhistories/create') }}'">
                        <span>+ Add</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <hr>

    @if($histories->count())
    <div class="iq-card">
        <div class="iq-card-body">
            <table class="table table-hover table-striped table-light display sortable text-nowrap" cellspacing="0" id="myTable" style="text-align:left">
                <thead>
                    <br>
                    <tr>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Kode Pasok</th>
                        <th scope="col">Nama Pasok</th>
                        <th scope="col">Total Pasok</th>
                        <th scope="col">Metode Pembayaran</th>
                        <th >Admin</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                        <tr>
                            <td>{{ $history->created_at->format('j F Y H:m:s') }}</td>
                            <td>{{ $history->kode_pasok }}</td>
                            <td>{{ $history->nama_supplier }}</td>
                            <td>Rp {{ number_format($history->total, 0, ',', '.') }}</td>
                            <td>{{ $history->metode_pembayaran }}</td>
                            <td>{{ $history->nama_input }}</td>
                            <td>
                                <div class="form-group text-left">
                                    <button type="button" onclick="window.location.href='{{ url('/manage_product/input_pasok/detail/'.$history->id) }}'" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke">
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
    @else
    <p class="text-center fs-4">No history found</p>
    @endif
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>
<script>
@if ($message = Session::get('create_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

$.fn.dataTable.moment( 'DD/MM/YY HH:mm:ss' );

$(document).ready(function () {
    $('#myTable').DataTable({   
            "oSearch": { "bSmart": false, "bRegex": true },
            "columnDefs": [{ "orderDataType": "date-time", "targets": [0] }],
            "order": [[ 0, "desc" ]],
        });
});
</script>
@endsection

