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
                                <th scope="col">Customer</th>
                                <th scope="col">Total</th>
                                @if($owner->user_position == "reseller" || $owner->user_position == "superadmin_distributor")
                                <th scope="col">Diskon</th>
                                @endif
                                <th scope="col">Tanggal</th>
                                @if($owner->user_position != "sales")
                                <th scope="col">Metode Pembayaran</th>
                                @endif
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            @php
                                if($owner->user_position == "sales")
                                {
                                    $customerName = $transaction->nama_toko;
                                    $code = $transaction->id;
                                }
                                else if($owner->user_position == "reseller")
                                {
                                    $customerName = $transaction->nama_pembeli;
                                    $code = $transaction->transaction_code;
                                }
                                else
                                {
                                    $customer = \App\Models\User::where('id', $transaction->id_owner)->first();
                                    $customerName = $customer->firstname.' '.$customer->lastname;
                                    $code = $transaction->transaction_code;
                                }
                            @endphp
                            <tr>
                                <td>{{ $code }}</td>
                                <td>{{ $customerName }}</td>
                                <td>Rp. {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                @if($owner->user_position == "reseller")
                                <td>Rp. {{ number_format($transaction->diskon, 0, ',', '.') }}</td>
                                @endif
                                @if($owner->user_position == "superadmin_distributor")
                                <td>-</td>
                                @endif
                                <td>{{ $transaction->updated_at->format('d/m/y H:i:s') }}</td>
                                @if($owner->user_position != "sales")
                                <td>{{ $transaction->metode_pembayaran }}</td>
                                @endif
                            </tr>
                            @endforeach

                            @if( $owner->user_position == "superadmin_distributor")
                            @foreach($transactions2 as $transaction)
                            @php
                                $customerName = $transaction->nama_pembeli;
                                $code = $transaction->transaction_code;
                            @endphp
                            <tr id="khusus{{ $transaction->id }}">
                                <td>{{ $code }}</td>
                                <td>{{ $customerName }}</td>
                                <td>Rp. {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($transaction->diskon, 0, ',', '.') }}</td>
                                <td>{{ $transaction->updated_at->format('d/m/y H:i:s') }}</td>
                                <td>{{ $transaction->metode_pembayaran }}</td>
                            </tr>
                            @endforeach
                            @endif
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