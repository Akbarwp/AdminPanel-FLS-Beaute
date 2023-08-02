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
                    <!-- <p style="font-weight:bold; font-size: 20px; text-align:left;"></p> -->
                    <br>
                    <div class="row form-group">
                        <div class="col-sm-3">Kode Barang</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">{{ $lost_product->product->product_type->kode_produk }}</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">Nama Barang</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">{{ $lost_product->nama_produk }}</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">Sisa Barang</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">{{ $lost_product->stok_sisa }} pcs</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">Stok Real</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">{{ $lost_product->stok_real }} pcs</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">Barang Hilang</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">{{ $lost_product->stok_hilang }} pcs</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">Harga Barang</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">Rp. {{ $lost_product->harga_modal }}</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">Kerugian</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">Rp. {{ $lost_product->total_kerugian }}</div>
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