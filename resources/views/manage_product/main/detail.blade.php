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
                <h4 style="text-align:left;">{{ $product->product_type->nama_produk }}</h4>
            </div>
            <div class="col-sm" style="text-align:left;">
                {{-- <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/manage_product/exportDetailXlsx/'.$product->id) }}'">
                    <i class="fa fa-file-excel-o"></i>
                    <span>Export</span>
                </button> --}}
                <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/manage_product/exportDetail/'.$product->id) }}'">
                    <i class="fa fa-file-pdf-o"></i>
                    <span>Export</span>
                </button>
                <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_product/printDetail/'.$product->id) }}')"><i class='fa fa-print'></i>Print</button>
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
                        @if(auth()->user()->user_position == "reseller")
                            <th>Tanggal Keluar</th>
                            <th>No Transaksi</th>
                            <th>Jumlah barang Keluar</th>
                        @else
                            <th>Tanggal Keluar</th>
                            <th>Admin</th>
                            <th>No Transaksi</th>
                            <th>Jumlah barang Keluar</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @foreach($keluar as $k)
                        <tr>
                            @if(auth()->user()->user_position == "reseller")
                                <td>{{ $k->created_at->format('d/m/y H:i:s') }}</td>
                                <td>{{ $k->nama_toko }}</td>
                                <td>{{ number_format($k->jumlah_produk, 0, ',', '.') }} pcs</td>
                            @else
                                <td>{{ $k->updated_at->format('d/m/y H:i:s') }}</td>
                                <td>{{ $k->nama_approve }}</td>
                                <td>{{ $k->transaction_code }}</td>
                                <td>{{ number_format($k->jumlah, 0, ',', '.') }} pcs</td>
                            @endif
                        </tr>
                    @endforeach
                    @if(auth()->user()->id_group != 1)
                        @foreach($keluarKasir as $k)
                            <tr>
                                @if(auth()->user()->user_position == "reseller")
                                    <td>{{ $k->updated_at->format('d/m/y H:i:s') }}</td>
                                    <td>{{ $k->transaction_code }}</td>
                                    <td>{{ number_format($k->jumlah, 0, ',', '.') }} pcs</td>
                                @else
                                    <td>{{ $k->updated_at->format('d/m/y H:i:s') }}</td>
                                    <td>{{ $k->nama_input }}</td>
                                    <td>{{ $k->transaction_code }}</td>
                                    <td>{{ number_format($k->jumlah, 0, ',', '.') }} pcs</td>
                                @endif
                            </tr>
                        @endforeach
                        @if(auth()->user()->user_position != "reseller")
                            @foreach($keluarStokSales as $k)
                            @php
                                $produkSales = \App\Models\Product::where('id', $k->id_product)->first();
                            @endphp
                            @if($produkSales->id_productType == $product->id_productType)
                                <tr>
                                    <td>{{ $k->created_at->format('d/m/y H:i:s') }}</td>
                                    <td>{{ $k->nama_input }}</td>
                                    <td>stok sales</td>
                                    <td>{{ number_format($k->jumlah, 0, ',', '.') }} pcs</td>
                                </tr>
                            @endif
                            @endforeach
                        @endif
                    @endif
                    @foreach($keluarRetur as $k)
                        <tr>
                            <td>{{ $k->updated_at->format('d/m/y H:i:s') }}</td>
                            <td>{{ $k->nama_input }}</td>
                            <td>{{ $k->surat_keluar }}</td>
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
                        @if(auth()->user()->id_group == 1)
                        <th>Tanggal Masuk</th>
                        <th>Admin</th>
                        <th>Kode Pasok</th>
                        <th>Jumlah barang Masuk</th>
                        @elseif(auth()->user()->user_position == "reseller")
                        <th>Tanggal Masuk</th>
                        <th>No. Transaksi</th>
                        <th>Jumlah barang Masuk</th>
                        @else
                        <th>Tanggal Masuk</th>
                        <th>Admin</th>
                        <th>No. Transaksi</th>
                        <th>Jumlah barang Masuk</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    
                    @foreach($masuk as $m)
                    <tr>
                        @if(auth()->user()->id_group == 1)
                        <td>{{ $m->updated_at->format('d/m/y H:i:s') }}</td>
                        <td>{{ $m->nama_input }}</td>
                        <td>{{ $m->kode_pasok }}</td>
                        <td>{{ number_format($m->jumlah, 0, ',', '.') }} pcs</td>
                        @elseif(auth()->user()->user_position == "reseller")
                        <td>{{ $m->updated_at->format('d/m/y H:i:s') }}</td>
                        <td>{{ $m->transaction_code }}</td>
                        <td>{{ number_format($m->jumlah, 0, ',', '.') }} pcs</td>
                        @else
                        <td>{{ $m->updated_at->format('d/m/y H:i:s') }}</td>
                        <td>{{ $m->nama_input }}</td>
                        <td>{{ $m->transaction_code }}</td>
                        <td>{{ number_format($m->jumlah, 0, ',', '.') }} pcs</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- @canany(['superadmin_pabrik','superadmin_distributor'])
    <div class="iq-card">
        <div class="iq-card-body">
            <h5 style="text-align:left;font-weight:bold;">Barang Hilang</h5>
            <table
                class="table table-hover table-striped table-light display sortable text-nowrap text-left"
                cellspacing="0" id="myTable3">
                <thead>
                    <br>
                    <tr id="_judul" onkeyup="_filter()" id="myFilter">
                        <th>Tanggal Barang Hilang</th>
                        <th>Admin</th>
                        <th>Jumlah Barang Hilang</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($hilang as $h)
                    <tr>
                        <td>{{ $h->updated_at->format('d/m/y H:i:s') }}</td>
                        <td>{{ $h->nama_input }}</td>
                        <td>{{ number_format($h->stok_hilang, 0, ',', '.') }} pcs</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endcan --}}
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