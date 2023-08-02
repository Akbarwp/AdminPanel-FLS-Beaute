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
        <p style="font-weight:bold; font-size: 20px; text-align:left;">
            Tracking {{ $sales->firstname }} {{ $sales->lastname }} - {{ date('F Y') }}
        </p>
    </div>
    <hr style="border-color:black;">

    <div class="iq-card">
        <div class="iq-card-body">
            <table id="mytable" class="table table-hover table-striped table-light" style="text-align:left">
                <thead>
                    <tr>
                        <th scope="col">Id Sales</th>
                        <th scope="col">Toko</th>
                        <th scope="col">Lokasi (lat/long)</th>
                        <th scope="col">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                        <tr>
                            <td>{{ $history->id_reseller }}</td>
                            <td>{{ $history->nama_toko }}</td>
                            <td>{{ $history->address }} ({{ $history->latitude }} / {{$history->longitude}})</td>
                            <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
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