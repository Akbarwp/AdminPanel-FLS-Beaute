@extends('templates/print')

@section('css')

@endsection

@section('content')
<div class="wrapper">
    <div class="container ">
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
            Laporan Pegawai
        </div>
        <hr style="border-color:black;">
        <div class="iq-card">
            <div class="iq-card-body row">
                <div class="row justify-content-center align-items-center" style="padding:8px;">
                    <div class="col-sm">
                        @if($user->image)
                            <img src={{ asset('storage/' . $user->image) }} alt=profile-img class="avatar-50 roundimg" img-fluid/>
                        @else
                            <img src={{ asset('images/manage_account/users/11.png') }} alt=profile-img class="avatar-50 roundimg" img-fluid/>
                        @endif                
                    </div>
                    <div class="col-sm text-left">
                        <p style="font-weight:500;">{{ $user->firstname }} {{ $user->lastname }}</p>
                        <p style="color:grey; font-weight:500;s">{{ $user->email }}</p>
                        <p style="color:grey;">{{ $user->user_position }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-card">
            <div class="iq-card-body">
            <p style="font-weight:bold; font-size: 20px; text-align:left;">Laporan Pegawai Pembelian</p>
                <div class="row justify-content-center align-items-center" style="padding:8px;">
                    <div class="col-sm">
                        <table id="mytable" class="table table-hover table-striped table-light" style="text-align:left;">
                            <thead>
                                <tr>
                                    @if(auth()->user()->id_group == 1)
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Kode Pasok</th>
                                    <th scope="col">Surat Jalan</th>
                                    <th scope="col">Total</th>
                                    @else
                                    <th scope='col'>Tanggal</th>
                                    <th scope='col'>Kode Transaksi</th>
                                    <th scope='col'>Total</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $countPembelian = 0;
                                @endphp
                                @if(auth()->user()->id_group == 1)
                                    @foreach ($pembelians as $pembelian)
                                        <tr>
                                            <td scope='col'>{{ $pembelian->created_at->format('d/m/y H:i:s') }}</td>
                                            <td scope='col'>{{ $pembelian->kode_pasok }}</td>
                                            <td scope='col'>{{ $pembelian->nama_supplier }}</td>
                                            <td scope='col'>{{ $pembelian->surat_jalan }}</td>
                                            <td scope='col'>{{ number_format($pembelian->total, 0, ',', '.') }}</td>
                                        </tr>
                                        @php
                                        $countPembelian += $pembelian->total;
                                        @endphp
                                    @endforeach
                                @else
                                    @foreach ($pembelians as $pembelian)
                                        <tr>
                                            <td scope='col'>{{ $pembelian->updated_at->format('d/m/y H:i:s') }}</td>
                                            <td scope='col'>{{ $pembelian->transaction_code }}</td>
                                            <td scope='col'>{{ number_format($pembelian->total, 0, ',', '.') }}</td>
                                        </tr>
                                        @php
                                        $countPembelian += $pembelian->total;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="row form-group">
                            <div class="col-sm-3 text-left" style="font-weight:bold">Total Pembelian</div>
                            <div class="col-sm-1 text-left">:</div>
                            <div class="col-sm-8 text-left">Rp {{ number_format($countPembelian, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="iq-card">
            <div class="iq-card-body">
            <p style="font-weight:bold; font-size: 20px; text-align:left;">Laporan Pegawai Penjualan</p>
                <div class="row justify-content-center align-items-center" style="padding:8px;">
                    <div class="col-sm">
                        <table id="mytable" class="table table-hover table-striped table-light" style="text-align:left;">
                            <thead>
                                <tr>
                                    <th scope='col'>Tanggal</th>
                                    <th scope='col'>Kode Transaksi</th>
                                    <th scope='col'>Nama Customer</th>
                                    <th scope='col'>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $countPenjualan=0;
                                @endphp
                                @foreach ($juals as $jual)
                                    @php
                                        $countPenjualan += $jual->total;
                                        $customer = \App\Models\User::where('id', $jual->id_owner)->first();
                                    @endphp
                                    <tr>
                                        <td scope='col'>{{ $jual->updated_at->format('d/m/y H:i:s') }}</td>
                                        <td scope='col'>{{ $jual->transaction_code }}</td>
                                        <td scope='col'>{{ $customer->firstname }} {{ $customer->lastname }}</td>
                                        <td scope='col'>{{ number_format($jual->total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach

                                @if(auth()->user()->id_group != 1)
                                @foreach($jualKasirs as $jualKasir)
                                    <tr>
                                        <td scope='col'>{{ $jualKasir->updated_at->format('d/m/y H:i:s') }}</td>
                                        <td scope='col'>{{ $jualKasir->transaction_code }}</td>
                                        <td scope='col'>Transaksi Kasir</td>
                                        <td scope='col'>{{ number_format($jualKasir->total, 0, ',', '.') }}</td>
                                    </tr>
                                    @php
                                        $countPenjualan += $jualKasir->total;
                                    @endphp
                                @endforeach

                                @foreach($jualTrackings as $jualTracking)
                                    <tr>
                                        <td scope='col'>{{ $jualTracking->updated_at->format('d/m/y H:i:s') }}</td>
                                        <td scope='col'>{{ $jualTracking->id }}</td>
                                        <td scope='col'>{{ $jualTracking->nama_toko }}</td>
                                        <td scope='col'>{{ number_format($jualTracking->total, 0, ',', '.') }}</td>
                                    </tr>
                                    @php
                                        $countPenjualan += $jualTracking->total;
                                    @endphp
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="row form-group">
                            <div class="col-sm-3 text-left" style="font-weight:bold">Total Transaksi</div>
                            <div class="col-sm-1 text-left">:</div>
                            <div class="col-sm-8 text-left">Rp {{ number_format($countPenjualan, 0, ',', '.') }}</div>
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