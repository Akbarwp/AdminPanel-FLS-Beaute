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
            <h4 style="text-align:center;">Pembelian Toko - {{ $history->nama_toko }} - {{ $history->created_at->format('d/m/y H:i:s') }}</h4>
        <hr style="border-color:black;">

        <div class="col-lg grid-margin">
            <div class="iq-card">
                <div class="iq-card-body">
                    <p class="text-left" style="font-weight:bold">{{ $history->user->firstname }} {{ $history->user->lastname }}</p>
                    <div class="row form-group">
                        <div class="col-sm-3 text-left">Alamat</div>
                        <div class="col-sm-1 text-left">:</div>
                        <div class="col-sm-8 text-left">{{ $history->address }} ({{ $history->latitude }}/{{ $history->longitude }})</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3 text-left">Tanggal</div>
                        <div class="col-sm-1 text-left">:</div>
                        <div class="col-sm-8 text-left">
                            {{ $history->created_at->format('d/m/y H:i:s') }}
                        </div>
                    </div>
                    <table id="mytable" class="table table-hover table-striped table-light"
                        style="text-align:left; word-break: break-all;">
                        <thead>
                            <tr>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $detail)
                                <tr>
                                    <td>{{ $detail->nama_produk }}</td>
                                    <td>{{ $detail->jumlah }} pcs</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg">
            <div class="iq-card">
                <p class="text-left p-3" style="font-weight:bold">Penilaian Pembeli</p>
                <div class="iq-card-body">
                    <div class="row">
                        <div class="col-sm-2 text-left">Nilai</div>
                        <div class="col-sm-1 text-left">:</div>
                        <div class="col-sm-9 text-left">{{ $history->nilai }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 text-left">Saran</div>
                        <div class="col-sm-1 text-left">:</div>
                        <div class="col-sm-9 text-left">{{ $history->saran }}</div>
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