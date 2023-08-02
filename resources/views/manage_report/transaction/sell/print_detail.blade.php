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
            Detail Transaksi
        </div>
        <hr style="border-color:black;">
            <div class="container justify text-center">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="col text-left">
                            <!-- <p style="font-weight:bold; font-size: 20px; text-align:left;">Detail Transaksi</p> -->
                            <br>
                            <div class="row form-group">
                                <div class="col-sm-3">Kode Transaksi</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8" id="kodeTransaksi">
                                    @php
                                        if($owner->user_position == "sales")
                                        {
                                            $code = $transaction->id;
                                        }
                                        else
                                        {
                                            $code = $transaction->transaction_code;
                                        }
                                    @endphp
                                    {{ $code }}
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3">Customer</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8" id="customer">{{ $customer }}</div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3">Total</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8" id="total">{{ number_format($transaction->total, 0, ',', '.') }}</div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3">Tanggal</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8" id="tanggal">{{ $transaction->updated_at->format('d/m/y H:i:s') }}</div>
                            </div>

                            <div class="col text-left" id="logTableDiv">
                                <table id="logTable" class="table table-hover table-light">
                                    <tbody>
                                        @php
                                            $ctr = 1
                                        @endphp
                                        @foreach($details as $detail)
                                        <tr>
                                            <td class="align-middle">{{ $ctr }}</td>
                                            <td class="align-middle">{{ $detail->nama_produk }}</td>
                                            <td class="align-middle">
                                                <div class="col-sm text-left">
                                                    <p style="font-weight:500;font-size:12px;color:grey;">Jumlah</p>
                                                    <p style="font-weight:500;">{{ $detail->jumlah }} pcs</p>	
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
                                        @php
                                            $ctr++;
                                        @endphp
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
</div>
@endsection

@section('script')
<script>

<script>
@endsection