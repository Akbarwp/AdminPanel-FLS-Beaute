@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="container justify text-center">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-sm-4" style="text-align:left;">
                <h4 style="text-align:left;">History '{{ $product->product_type->nama_produk }}' {{ $owner->firstname }} {{ $owner->lastname }}</h4>
            </div>
            <div class="col-sm" style="text-align:left;">
                <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/sales/export-history-items/'.$product->id) }}'">
                    <i class="fa fa-file-pdf-o"></i>
                    <span>Export</span>
                </button>
                <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/sales/print-history-items/'.$product->id) }}')"><i class='fa fa-print'></i>Print</button>
            </div>
        </div>
    </div>
    <hr>
    <div class="iq-card">
        <div class="iq-card-body">
            <h5 style="text-align:left;font-weight:bold;">Barang Keluar</h5>
            <table
                class="table table-hover table-striped table-light display sortable text-left text-nowrap"
                cellspacing="0" id="myTable">
                <thead>
                    <br>
                    <tr id="_judul" onkeyup="_filter()" id="myFilter">
                        <th>Tanggal Keluar</th>
                        <th>Nama Toko</th>
                        <th>Jumlah barang Keluar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($keluar as $k)
                        <tr>
                            <td>{{ $k->created_at->format('d/m/y H:i:s') }}</td>
                            <td>{{ $k->nama_toko }}</td>
                            <td>{{ number_format($k->jumlah, 0, ',', '.') }} pcs</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="iq-card">
        <div class="iq-card-body">
            <h5 style="text-align:left;font-weight:bold;">Barang Masuk</h5>
            <table
                class="table table-hover table-striped table-light display sortable text-nowrap text-left"
                cellspacing="0" id="myTable2">
                <thead>
                    <br>
                    <tr id="_judul" onkeyup="_filter()" id="myFilter">
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Terima</th>
                        <th>Jumlah barang Masuk</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($masuk as $m)
                        <tr>
                            <td>{{ $m->created_at->format('d/m/y H:i:s') }}</td>
                            <td>{{ $m->updated_at->format('d/m/y H:i:s') }}</td>
                            <td>{{ number_format($m->jumlah, 0, ',', '.') }} pcs</td>
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
$(document).ready(function(){
    $('#myTable').DataTable({
    "   oSearch": { "bSmart": false, "bRegex": true },
    });
    $('#myTable2').DataTable({
    "   oSearch": { "bSmart": false, "bRegex": true },
    });
    
    $('#myTable3').DataTable({
    "   oSearch": { "bSmart": false, "bRegex": true },
    });
});
</script>
@endsection