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
            Daftar Barang Pusat - Keluar - Januari 2022
        </div>
        <hr style="border-color:black;">
        <p style="font-weight:bold; font-size: 20px; text-align:left;">{{ $product->product_type->nama_produk }}</p>
        <div class="iq-card">
            <div class="iq-card-body">
                <!-- <h5 style="text-align:left;font-weight:bold;"></h5> -->
                <table id="myTable"
                    class="table table-hover table-striped table-light display sortable text-left text-nowrap"
                    cellspacing="0">
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
                        @php
                            $totalKeluar=0;
                        @endphp
                        @foreach($keluar as $k)
                            <tr>
                                @if(auth()->user()->user_position == "reseller")
                                    <td>{{ $k->created_at->format('d/m/y H:i:s') }}</td>
                                    <td>{{ $k->nama_toko }}</td>
                                    <td>{{ number_format($k->jumlah_produk, 0, ',', '.') }} pcs</td>
                                    @php
                                        $totalKeluar+=$k->jumlah_produk;
                                    @endphp
                                @else
                                    <td>{{ $k->updated_at->format('d/m/y H:i:s') }}</td>
                                    <td>{{ $k->nama_approve }}</td>
                                    <td>{{ $k->transaction_code }}</td>
                                    <td>{{ number_format($k->jumlah, 0, ',', '.') }} pcs</td>
                                    @php
                                        $totalKeluar+=$k->jumlah;
                                    @endphp
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
                                @php
                                    $totalKeluar+=$k->jumlah;
                                @endphp
                            @endforeach
                        @endif
                        @foreach($keluarRetur as $k)
                            <tr>
                                <td>{{ $k->updated_at->format('d/m/y H:i:s') }}</td>
                                <td>{{ $k->nama_input }}</td>
                                <td>{{ $k->surat_keluar }}</td>
                                <td>{{ number_format($k->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                            @php
                                $totalKeluar+=$k->jumlah;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                <div class="row form-group text-left">
                    <div class="col-sm-5" style="font-weight:bold">Jumlah Barang Keluar</div>
                    <div class="col-sm-1">:</div>
                    <div class="col-sm-6">{{ number_format($totalKeluar, 0, ',', '.') }} pcs</div>
                </div>
            </div>
        </div>

        <div class="iq-card">
            <div class="iq-card-body">
                <h5 style="text-align:left;font-weight:bold;">Daftar Barang Pusat - Masuk - Januari 2022</h5>
                <table class="table table-hover table-striped table-light display sortable text-nowrap text-left"
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
                        @php
                            $totalMasuk=0;
                        @endphp
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
                        @php
                            $totalMasuk+=$m->jumlah;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
                <div class="row form-group text-left">
                    <div class="col-sm-5" style="font-weight:bold">Jumlah Barang Masuk</div>
                    <div class="col-sm-1">:</div>
                    <div class="col-sm-6">{{ number_format($totalMasuk, 0, ',', '.') }} pcs</div>
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