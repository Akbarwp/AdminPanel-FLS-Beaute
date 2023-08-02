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
            History Point
        </div>
        <hr style="border-color:black;">
        <div class="row">
            <div class="col-12">
            <div class="iq-card">
                <div class="iq-card-body ">
                    <table id="myTable" class="table text-left table-hover table-striped table-light"
                        id="myTable">
                        <thead>
                            <tr>
                                <th>Tanggal Claim</th>
                                <th>Point Keluar</th>
                                <th>Point Masuk</th>
                                <th>Sisa Point Saya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($owner->user_position != "reseller" && $owner->user_position != "sales")
                            @foreach($reseller_beli as $history)
                            <tr>
                                <td>{{ $history->updated_at->format('d/m/y H:i:s') }}</td>
                                <td>-</td>
                                <td>{{ number_format($history->crm_poin_distributor, 0, ',', '.') }}</td>
                                <td><b>Pembelian reseller</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                            @endforeach
                            @foreach($jual_kasir as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                <td>-</td>
                                <td>{{ number_format($history->crm_poin_distributor, 0, ',', '.') }}</td>
                                <td><b>Penjualan kasir</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                            @endforeach
                            @foreach($reseller_jual as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                <td>-</td>
                                <td>{{ number_format($history->crm_poin_distributor, 0, ',', '.') }}</td>
                                <td><b>Penjualan reseller</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                            @endforeach
                            @endif

                            @if($owner->user_position == "reseller")
                            @foreach($jual_kasir as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                <td>-</td>
                                <td>{{ number_format($history->crm_poin_reseller, 0, ',', '.') }}</td>
                                <td><b>Penjualan kasir</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                            @endforeach
                            @endif

                            @if($owner->user_position == "sales")
                            @foreach($jual_tracking as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                <td>-</td>
                                <td>{{ number_format($history->crm_poin_sales, 0, ',', '.') }}</td>
                                <td><b>Penjualan Tracking</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                            @endforeach
                            @endif

                            @foreach($claim_reward_history as $history)
                            <tr>
                                <td>
                                    {{ $history->updated_at->format('d/m/y H:i:s') }}
                                </td>
                                <td>{{ number_format($history->poin, 0, ',', '.') }}</td>
                                <td>-</td>
                                <td><b>Claim</b> reward {{ $history->reward }}</td>
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