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
                        <h4>Detail Retur Pabrik</h4>
                    </div>
                    <div class="col-md-5">
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/retur/to_cashier/exportDetail/'.$retur->id) }}'">
                            <i class="fa fa-file-pdf-o"></i>
                            <span>Export</span>
                        </button>
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/retur/to_cashier/printDetail/'.$retur->id) }}')">
                            <i class="fa fa-print"></i>
                            <span>Print</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @foreach($details as $detail)
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="row">
                    <div class="form-group col">
                        @if($detail->foto)
                            <img src={{ asset('storage/' . $detail->foto) }} style="width:75%;"/>
                        @else
                            <img src={{ asset('images/flslogo.jpg') }} style="width:75%;"/>
                        @endif
                    </div>
                    <div class="form-group col">
                        <div class="col text-left" style="padding:0;">
                            <h4 style="font-weight:bold">{{ $detail->nama_produk }}</h4>
                        </div>
                        <hr>
                        <div class="row text-left">
                            <div class="col-6">Kuantitas Barang Yang Diretur</div>
                            <div class="col-1">:</div>
                            <div class="col-2">{{ number_format($detail->jumlah, 0, ',', '.') }} pcs</div>
                        </div>
                        <div class="row text-left">
                            <div class="col-6">Harga Satuan</div>
                            <div class="col-1">:</div>
                            <div class="col-2">Rp {{ number_format($detail->harga, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('script')
<script>
$(document).ready(function(){
    $('#myTable').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
});

</script>
@endsection