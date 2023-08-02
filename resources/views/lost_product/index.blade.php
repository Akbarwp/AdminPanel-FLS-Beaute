@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="container justify text-left">
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex justify-content align-items-left">
                <div class="col-sm-4">
                    <h4 style="text-align:left;">Laporan Stok Opname</h4>
                </div>
            </div>
        </div>
    </div>

    <hr>

    @if($lost_products->count())
    <div class="iq-card">
        <div class="iq-card-body">
            <table class="table table-hover table-striped table-light display sortable text-nowrap" cellspacing="0" id="myTable" style="text-align:left">
                <thead>
                    <br>
                    <tr>
                        <th scope="col">Tanggal Koreksi Stok</th>
                        <th scope="col">Nama Admin</th>
                        <th scope="col">Total Barang hilang</th>
                        <th scope="col">Total Kerugian</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lost_products as $history)
                        <tr>
                            <td>{{ $history->created_at->format('j F Y H:m:s') }}</td>
                            <td>{{ $history->kode_pasok }}</td>
                            <td>{{ $history->nama_supplier }}</td>
                            <td>Rp {{ number_format($history->total, 0, ',', '.') }}</td>
                            <td>
                                <div class="form-group text-left">
                                    <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_product/input_pasok/print/') }}')"><i class='fa fa-print'></i>
                                        Print
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

