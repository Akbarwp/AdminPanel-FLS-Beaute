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
            Detail Transaksi - {{ date("d F Y") }}
        </div>
        <hr style="border-color:black;">
        <div class="container justify text-center">
            <div class="iq-card">
                <div class="iq-card-body">
                    <div class="col text-left">
                        
                        <div class="row form-group">
                            <div class="col-sm-3">Kode Transaksi</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8" id="kodeTransaksi">{{ $history->transaction_code }}</div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">Distributor</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8" id="distributor">
                                @if(auth()->user()->user_position != "reseller")
                                    Pabrik
                                @else
                                    {{ $history->distributor->firstname }} {{ $history->distributor->lastname }}
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">Total</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8" id="total">Rp. {{ number_format($history->total, 0, ',', '.') }}</div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">Status</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8" id="status">
                                @if($history->status_pesanan == 1)
                                    Sukses
                                @else
                                    Menunggu Konfirmasi
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">Tanggal</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8" id="tanggal">{{ $history->updated_at->format('d/m/y H:i:s') }}</div>
                        </div>

                        <div class="col text-left" id="logTableDiv">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-sm text-right">
                                    <p>Jumlah Barang : {{ $history->jumlah_barang }}</p>
                                </div>
                            </div>
                            <table class="table table-hover table-light">
                                <tbody>
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach($details as $detail)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        <td class="align-middle">{{ $count }}</td>
                                        <td class="align-middle">{{ $detail->nama_produk }}</td>
                                        <td class="align-middle">
                                            <div class="col-sm text-left">
                                                <p style="font-weight:500;font-size:12px;color:grey;">Jumlah</p>
                                                <p style="font-weight:500;">{{ number_format($detail->jumlah, 0, ',', '.') }} pcs</p>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="col-sm text-left">
                                                <p style="font-weight:500;font-size:12px;color:grey;">Harga</p>
                                                <p style="font-weight:500;">Rp. {{ number_format($detail->harga, 0, ',', '.') }}</p>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="col-sm text-left">
                                                <p style="font-weight:500;font-size:12px;color:grey;">Total</p>
                                                <p style="font-weight:500;">Rp. {{ number_format($detail->total, 0, ',', '.') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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