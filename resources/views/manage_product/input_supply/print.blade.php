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
            Input Pasok Barang
        </div>
        <hr style="border-color:black;">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12 grid-margin">
            <div class="iq-card">
                <div class="iq-card-body">
                    <!-- <p style="font-weight:bold; font-size: 20px; text-align:left;"></p> -->
                    <br>
                    <table id="mytable" class="table table-hover table-striped table-light "
                    style="text-align:left">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Kode Pasok</th>
                                <th scope="col">Nama Pasok</th>
                                <th scope="col">Total Pasok</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalPembelian = 0;
                            @endphp
                            @foreach($histories as $history)
                                <tr>
                                    <td>{{ $history->created_at->format('j F Y H:m:s') }}</td>
                                    <td>{{ $history->kode_pasok }}</td>
                                    <td>{{ $history->nama_supplier }}</td>
                                    <td>Rp {{ number_format($history->total, 0, ',', '.') }}</td>
                                    <td>{{ $history->nama_input }}</td>
                                </tr>
                                @php
                                $totalPembelian += $history->total;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row form-group">
                        <div class="col-sm-3 text-left">Total Pembelian Pasok Barang</div>
                        <div class="col-sm-1 text-left">:</div>
                        <div class="col-sm-8 text-left">Rp. {{ number_format($totalPembelian, 0, ',', '.') }}</div>
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