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
        Stock Sales - {{ $sales->firstname }} {{ $sales->lastname }}
        </div>
        <hr style="border-color:black;">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12 grid-margin ">
                <div class="iq-card-body">
                    <div class="table-responsive-xl">
                        <table
                            class="table table-hover table-striped table-light display sortable"
                            cellspacing="0" id="tableSales">
                            <thead>
                                <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Stock</th>
                                    <th>Harga Jual</th>
                                    @if(auth()->user()->user_position != "sales")
                                    <th>Harga Modal</th>
                                    <th>Bonus</th>
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
                                    @if(auth()->user()->user_position != "sales")
                                    <td>Rp {{ number_format($product->harga_modal, 0, ',', '.') }}</td>
                                    <td>{{ number_format($product->bonus_penjualan, 0, ',', '.') }} %</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div>
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