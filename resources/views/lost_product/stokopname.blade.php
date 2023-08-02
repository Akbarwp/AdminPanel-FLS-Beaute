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
                    <h4 style="text-align:left;">Stok Opname</h4>
                </div>
            </div>
        </div>
    </div>

    <hr>

    {{-- @if($lost_products->count()) --}}
    <div class="iq-card">
        <div class="iq-card-body">
            <table class="table table-hover table-striped table-light display sortable text-nowrap" cellspacing="0" id="" style="text-align:left">
                <thead>
                    <br>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Koreksi Stok</th>
                        <th scope="col">Barang Hilang</th>
                        <th scope="col">Sisa Barang</th>
                        <th scope="col">Total Kerugian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lost_products as $history)
                        <tr>
                            <td>1</td>
                            <td>t-2626462643</td>
                            <td>10-04-2023</td>
                            <td></td>
                            <td>10 kg</td>
                            <td>5 kg</td>
                            <td>750.000</td>
                        </tr>
                    @endforeach
                </tbody>
                <tbody>
                    @foreach($lost_products as $history)
                        <tr>
                            <td>1</td>
                            <td>t-2626462643</td>
                            <td>10-04-2023</td>
                            <td></td>
                            <td>10 kg</td>
                            <td>5 kg</td>
                            <td>750.000</td>
                        </tr>
                    @endforeach
                </tbody>
                <tbody>
                    @foreach($lost_products as $history)
                        <tr>
                            <td>1</td>
                            <td>t-2626462643</td>
                            <td>10-04-2023</td>
                            <td></td>
                            <td>10 kg</td>
                            <td>5 kg</td>
                            <td>750.000</td>
                        </tr>
                    @endforeach
                </tbody>
                <tbody>
                    @foreach($lost_products as $history)
                        <tr>
                            <td>1</td>
                            <td>t-2626462643</td>
                            <td>10-04-2023</td>
                            <td></td>
                            <td>10 kg</td>
                            <td>5 kg</td>
                            <td>750.000</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="form-group text-right">
                <input type="submit" onclick="" class="btn btn-primary submit btn-simpan" style="background-color:rgba(165,78,182); color:whitesmoke" value="Submit">
            </div>
        </div>

    </div>
    {{-- @else --}}
    <p class="text-center fs-4">No history found</p>
    {{-- @endif --}}
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

