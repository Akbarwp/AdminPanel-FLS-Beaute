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
            <h4 style="text-align:left;">History '{{ $product->product_type->nama_produk }}' {{ $owner->firstname }} {{ $owner->lastname }}</h4>
        </div>
        <hr style="border-color:black;">
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
</div>

@endsection

@section('script')
<script>

<script>
@endsection