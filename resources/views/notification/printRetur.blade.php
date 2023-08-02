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
        Retur
    </div>
    <hr style="border-color:black;">

    <div class="iq-card">
        <div class="iq-card-header">
            <div class="row justify-content-between align-items-center" style="padding:8px;">
                <div class="col-sm text-left">
                    <p style="font-weight:bold;font-size:20px;">Retur - {{ $peretur->firstname }} {{ $peretur->lastname }}</p>
                    <p style="color:grey;">{{ $retur->created_at->format('d/m/y H:i:s') }}</p>
                    <br>
                    @if($peretur->user_position == "sales")
                    <p style="color:grey;">Tanggal Terima : {{ $transaction->updated_at->format('d/m/y H:i:s') }}</p>
                    @else
                    <p style="color:grey;">No Nota : {{ $transaction->transaction_code }}</p>
                    <p style="color:grey;">Tanggal Transaksi : {{ $transaction->created_at->format('d/m/y H:i:s') }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="iq-card-body">
            <div class="row" style="padding:8px;">
                <div class="col-sm text-left">
                    <div class="row form-group">
                    <table class="table table-hover table-light text-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Jumlah Barang</th>
                                <th scope="col">Harga Satuan</th>
                                <th scope="col">Total</th>
                                <th scope="col">Jumlah Barang yang Diretur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $detail)
                                <tr>
                                    <td>{{ $detail->nama_produk }}</td>
                                    @php
                                        if($peretur->user_position == "sales")
                                        {
                                            $produkTransaksi = \App\Models\Product::where('id_owner', $retur->id_owner)->where('id_productType', $detail->product->id_productType)->first();
                                            $detailTransaksi = \App\Models\SalesStokDetail::where('id_sales_stok',$retur->id_transaction)->where('id_product', $produkTransaksi->id)->first();
                                        }
                                        else
                                        {
                                            $produkTransaksi = \App\Models\Product::where('id_owner', $retur->id_supplier)->where('id_productType', $detail->product->id_productType)->first();
                                            $detailTransaksi = \App\Models\TransactionDetail::where('id_transaction',$retur->id_transaction)->where('id_product', $produkTransaksi->id)->first();
                                        }
                                    @endphp
                                    <td>{{ number_format($detailTransaksi->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($detail->total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>

                    <div class="row form-group" style="font-weight:bold;">
                        <div class="col-sm-3">Total</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">Rp. {{ number_format($retur->total, 0, ',', '.') }}</div>
                    </div>

                    <hr>
                    <div class="row form-group">
                        <div class="col-sm-3">Keterangan</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">XXXXXXXX</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">Status</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">Sudah di approve</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">Waktu Diapprove</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">07 September 2022 16:00:00</div>
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