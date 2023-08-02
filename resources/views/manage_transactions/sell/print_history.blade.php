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
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="col text-left">
                    
                </div><hr style="margin:5px;">
                <div class="col text-left" id="logTableDiv">
                    <table id="logTable" class="table table-hover table-light">
                        <thead>
                            <tr>
                                <th scope="col">Kode Transaksi</th>
                                <th scope="col">Total</th>
                                <th scope="col">Diskon</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Metode Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($histories as $history)
                            <tr id="{{ $history->id }}">
                                <td>{{ $history->transaction_code }}</td>
                                <td>Rp. {{ number_format($history->total, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($history->diskon, 0, ',', '.') }}</td>
                                <td>{{ $history->keterangan_diskon }}</td>
                                <td>{{ $history->updated_at->format('d/m/y H:i:s') }}</td>
                                <td>{{ $history->metode_pembayaran }}</td>
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