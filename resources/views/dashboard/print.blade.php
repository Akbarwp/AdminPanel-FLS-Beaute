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
            @if($owner->id_group == 1)
            Stock Barang Pusat - {{ date('F Y') }}
            @else
            Stock Barang {{ $owner->firstname }} {{ $owner->lastname }} - {{ date('F Y') }}
            @endif
        </div>
        <hr style="border-color:black;">
        <div class="container justify text-center">
            <!-- dashboard pabrik -->
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 grid-margin">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="table-responsive-xl" style="overflow: scroll; ">
                                <table
                                    class="table table-hover table-striped table-light display sortable  text-nowrap"
                                    cellspacing="0" id="myTable">
                                    <thead>
                                        <br>
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
                                        @php
                                            $totalNilaiStok = 0;
                                        @endphp
                                        @foreach($products as $product)
                                            <tr>
                                                <td>{{ $product->product_type->kode_produk }}</td>
                                                <td>{{ $product->product_type->nama_produk }}</td>
                                                <td>{{ number_format($product->stok, 0, ',', '.') }} pcs</td>
                                                <td>Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($product->harga_modal, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($product->stok * $product->harga_modal, 0, ',', '.')}}</td>
                                                <td>{{ $product->keterangan }}</td>
                                            </tr>
                                            @php
                                                $totalNilaiStok += ($product->stok * $product->harga_modal)
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Stok</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ number_format($stock, 0, ',', '.') }} pcs</div>
                            </div>
                            <div class="row form-group text-left" >
                                <div class="col-sm-5" style="font-weight:bold">Total Nilai Stok</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</div>
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

<script>
@endsection