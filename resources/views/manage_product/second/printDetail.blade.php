@extends('templates/print')

@section('css')

@endsection

@section('content')
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <img src="{{ asset('images/flslogo.jpg') }}" style="width:25%">
            </div>
            <div class="col-sm-7">
                <div class="d-flex justify-content-end" style="font-weight:bold">
                    PT ANDARA CANTIKA
                </div>
                <div class="d-flex justify-content-end">
                    Pergudangan Bumi Benowo Sukses Sejahtera Tbk
                </div>
                <div class="d-flex justify-content-end">
                    Jl. Raya Gelora Bung Tomo No. 8, Surabaya, Jawa Timur
                </div>
                <div class="d-flex justify-content-end">
                    Email: flsbeautyofficial@gmail.com
                </div>
            </div>
        </div>
        <hr style="border-color:black;">
        <div class="row d-flex justify-content-center" style="font-weight:bold; font-size:24px">
            @if(auth()->user()->id_group == 1)
                Daftar Barang Distributor
            @else
                Daftar Barang Reseller
            @endif
            - {{ $owner->firstname }} {{ $owner->lastname }}
        </div>
        <hr style="border-color:black;">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12 grid-margin">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <!-- <p style="font-weight:bold; font-size: 20px; text-align:left;">
                            @if(auth()->user()->id_group == 1)
                                Daftar Barang Distributor
                            @else
                                Daftar Barang Reseller
                            @endif
                            - {{ $owner->firstname }} {{ $owner->lastname }}
                        </p> -->
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

@endsection

@section('script')
<script>

<script>
@endsection