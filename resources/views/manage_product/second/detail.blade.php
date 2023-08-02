@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div class="container">
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-4" style="text-align:left;">
                                    <h4 style="text-align:left;">
                                        @if(auth()->user()->id_group == 1)
                                            Daftar Barang Distributor
                                        @else
                                            Daftar Barang Reseller
                                        @endif
                                        - {{ $owner->firstname }} {{ $owner->lastname }}
                                    </h4>
                                </div>
                                <div class="col-sm">
                                    @if(auth()->user()->id_group == 1)
                                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/manage_product/distributor/export/'.$owner->id) }}'">
                                            <i class="fa fa-file-pdf-o"></i>
                                            <span>Export</span></button>
                                        <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_product/distributor/print/'.$owner->id) }}')">
                                            <i class='fa fa-print'></i>Print</button>
                                    @else
                                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/manage_product/reseller/export/'.$owner->id) }}'">
                                            <i class="fa fa-file-pdf-o"></i>
                                            <span>Export</span></button>
                                        <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_product/reseller/print/'.$owner->id) }}')">
                                            <i class='fa fa-print'></i>Print</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-12 grid-margin ">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="row col-sm" style="font-size:18px; font-weight:bold">
                                        Available Stock
                                    </div>
                                    <hr>
                                    <div class="col-xl-12" style="font-size:14px;">
                                        <div class="row">
                                            <div class="col-xl-7" style="font-weight:600">
                                                Total Stock Parfum:
                                            </div>
                                            <div class="col-xl-5">
                                                {{ number_format($totalStok, 0, ',', '.') }} pcs
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-7" style="font-weight:600">
                                                Total Nilai Stok:
                                            </div>
                                            <div class="col-xl-5">
                                                Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="table-responsive-xl" style="overflow: scroll; ">
                                        <table
                                            class="table table-hover table-striped table-light display sortable text-nowrap"
                                            cellspacing="0" id="myTable">
                                            <thead>
                                                <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                    <th>ID</th>
                                                    <th>Barang</th>
                                                    <th>Stok</th>
                                                    <th>Harga Jual</th>
                                                    <th>Harga Modal</th>
                                                    <th>Nilai Total</th>
                                                    <th>Keterangan</th>
                                                    @if(auth()->user()->edit_barang == 1)
                                                    <th></th>
                                                    @endif
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($products as $product)
                                                    <tr>
                                                        <td>{{ $product->product_type->kode_produk }}</td>
                                                        <td>{{ $product->product_type->nama_produk }}</td>
                                                        <td>{{ number_format($product->stok, 0, ',', '.') }} pcs</td>
                                                        <td>Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                                                        <td>Rp {{ number_format($product->harga_modal, 0, ',', '.') }}</td>
                                                        <td>Rp {{ number_format($product->stok * $product->harga_modal, 0, ',', '.') }}</td>
                                                        <td>{{ $product->keterangan }}</td>
                                                        @if(auth()->user()->edit_barang == 1)
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-warning" onclick="location.href='{{ url('/manage_product/distributor/products/edit/'.$product->id) }}'">
                                                            <span><i class="fa fa-edit"></i>Edit</span>
                                                            </button>
                                                        </td>
                                                        @endif
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
    </div>
</div>
@endsection

@section('script')
<script>
@if ($message = Session::get('update_success'))
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