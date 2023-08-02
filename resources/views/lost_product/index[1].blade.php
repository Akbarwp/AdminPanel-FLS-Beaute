@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="container justify text-center">
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 text-left">
                    <h4>Laporan Barang Hilang</h4>
                </div>
                <div class="col-md-6">

                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/report_product/lostproducts/export/') }}'">
                        <i class="fa fa-file-pdf-o"></i>
                        <span>Export</span>
                    </button>
                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/report_product/lostproducts/print/') }}')">
                        <i class="fa fa-print"></i>
                        <span>Print</span>
                    </button>
                </div>
                <div class="col-md-3 text-right">
                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/report_product/lostproducts/create') }}'">
                        <span>+ Add</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="iq-card">
        <div class="iq-card-body">
            <div class="col text-left">
                <table id="mytable" class="table table-hover table-light">
                    <thead>
                        <tr>
                            <th scope="col">Kode Barang</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Sisa Barang</th>
                            <th scope="col">Stok Real</th>
                            <th scope="col">Barang Hilang</th>
                            <th scope="col">Kerugian</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lost_products as $lost_product)
                            <tr>
                                <td>{{ $lost_product->product->product_type->kode_produk }}</td>
                                <td>{{ $lost_product->nama_produk }}</td>
                                <td>{{ $lost_product->stok_sisa }} pcs</td>
                                <td>{{ $lost_product->stok_real }} pcs</td>
                                <td>{{ $lost_product->stok_hilang }} pcs</td>
                                <td>Rp. {{ $lost_product->total_kerugian }}</td>
                                <td>
                                    <div class="col text-left">
                                        <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/report_product/lostproducts/printDetail/'.$lost_product->id) }}')"><i class='fa fa-print'></i>
                                        Print</button>
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

$(document).ready(function(){
    $('#myTable').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
});

</script>
@endsection