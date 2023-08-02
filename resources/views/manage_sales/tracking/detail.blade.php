@extends('templates/main')

@section('css')

@endsection

@section('content')
<div class="container justify text-center">
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-sm">
                    <h4 style="text-align:left;">Pembelian Toko - {{ $history->nama_toko }}</h4>
                </div>
                <div class="col-sm text-right">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ url('/sales/detail_tracking/export/'.$history->id) }}'">
                        <i class="fa fa-file-pdf-o"></i>
                        <span>Export</span>
                    </button>
                    <button type="button" class="btn btn-primary" onclick="window.open('{{ url('/sales/detail_tracking/print/'.$history->id) }}')">
                        <i class="fa fa-print"></i>
                        <span>Print</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    
    <!-- <div class="row d-flex justify-content-center"> -->
        <div class="col-lg">
            <div class="iq-card">
                <div class="iq-card-body">
                    <p class="text-left" style="font-weight:bold">{{ $history->user->firstname }} {{ $history->user->lastname }}</p>
                    <div class="row form-group">
                        <div class="col-sm-3 text-left">Alamat</div>
                        <div class="col-sm-1 text-left">:</div>
                        <div class="col-sm-8 text-left">
                            {{ $history->address }} (<a target="_blank" href={{ url('https://maps.google.com/?q='.$history->latitude.','.$history->longitude) }}>{{ $history->latitude }},{{ $history->longitude }}</a>)
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3 text-left">Tanggal</div>
                        <div class="col-sm-1 text-left">:</div>
                        <div class="col-sm-8 text-left">
                            {{ $history->created_at->format('d/m/y H:i:s') }}
                        </div>
                    </div>
                    <!-- <p class="text-left"></p> -->
                    <table id="mytable" class="table table-hover table-striped table-light" style="text-align:left; word-break: break-all;">
                        <thead>
                            <tr>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $detail)
                                <tr>
                                    <td>{{ $detail->nama_produk }}</td>
                                    <td>{{ $detail->jumlah }} pcs</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg">
            <div class="iq-card">
                <p class="text-left p-3" style="font-weight:bold">Penilaian Pembeli</p>
                <div class="iq-card-body">
                    <div class="row">
                        <div class="col-lg-2 text-left">Nilai</div>
                        <div class="col-lg-1 text-left">:</div>
                        <div class="col-lg-9 text-left">{{ $history->nilai }}</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 text-left">Saran</div>
                        <div class="col-lg-1 text-left">:</div>
                        <div class="col-lg-9 text-left">{{ $history->saran }}</div>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->
</div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function () {
    $('#mytable').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
});
</script>
@endsection