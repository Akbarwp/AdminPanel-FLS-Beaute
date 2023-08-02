@extends('templates/print')

@section('css')

@endsection

@section('content')
<div class="wrapper">
    <div class="container ">
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
            Laporan Barang Hilang
        </div>
        <hr style="border-color:black;">
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="col text-left">
                    <!-- <p style="font-weight:bold; font-size: 20px; text-align:left;">Laporan Barang Hilang</p> -->
                    <br>
                    <table class="table table-hover table-light">
                        <thead>
                            <tr>
                                <th scope="col">Kode Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Sisa Barang</th>
                                <th scope="col">Stok Real</th>
                                <th scope="col">Barang Hilang</th>
                                <th scope="col">Kerugian</th>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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