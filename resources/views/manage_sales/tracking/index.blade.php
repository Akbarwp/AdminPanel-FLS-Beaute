@extends('templates/main')

@section('css')

@endsection

@section('content')
<div class="container justify text-center">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between">
            <div class="container">
                <!-- <div class="row d-flex justify-content-between"> -->

                <div class="row align-items-center form-group">

                    <div class="col-md-3 text-left">
                        <h4>Tracking Sales</h4>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ url('/sales/tracking/export/'.$id_sales) }}'">
                            <i class="fa fa-file-pdf-o"></i>
                            <span>Export</span>
                        </button>
                        <button type="button" class="btn btn-primary" onclick="window.open('{{ url('/sales/tracking/print/'.$id_sales) }}')">
                            <i class="fa fa-print"></i>
                            <span>Print</span>
                        </button>
                    </div>
                    @can('sales')
                    @if(auth()->user()->user_position == "sales")
                    <div class="col-md-3 text-right">
                        <button type="button" class="btn btn-primary"
                            onclick="location.href='{{ url('/sales/new_tracking/') }}'">
                            <span>+ Adds</span>
                        </button>
                    </div>
                    @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="iq-card">
        <div class="iq-card-body">
            <table id="mytable" class="table table-hover table-striped table-light" style="text-align:left">
                <thead>
                    <tr>
                        <th scope="col">Toko</th>
                        <th scope="col">Lokasi (lat/long)</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                        <tr>
                            <td>{{ $history->nama_toko }}</td>
                            <td>{{ $history->address }} ({{ $history->latitude }} / {{$history->longitude}})</td>
                            <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                            <td><button class="btn btn-primary"
                                    onclick="location.href='{{ url('/sales/detail_tracking/'.$history->id) }}'"><i
                                        class="fa fa-eye"></i></button></td>
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
@if ($message = Session::get('create_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

$(document).ready(function () {
    $('#mytable').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
});
</script>
@endsection