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
            <div class="iq-card-body">
                <!-- <p style="font-weight:bold; font-size: 20px; text-align:left;">Laporan Pegawai</p> -->
                <br>
                <table class="table table-hover table-striped table-light text-nowrap" style="text-align:left" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Posisi</th>
                            <th scope="col">Aktifitas Pasok</th>
                            <th scope="col">Aktifitas Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawais as $pegawai)
                            <tr>
                                <td class='jname full-body'>
                                    @if($pegawai->image)
                                        <img src={{ asset('storage/' . $pegawai->image) }} alt=profile-img class="avatar-50 roundimg" img-fluid/>
                                    @else
                                        <img src={{ asset('images/manage_account/users/11.png') }} alt=profile-img class="avatar-50 roundimg" img-fluid/>
                                    @endif
                                    {{ $pegawai->firstname }} {{ $pegawai->lastname }}
                                </td>
                                <td>{{ $pegawai->email }}</td>
                                <td>{{ $pegawai->user_position }}</td>
                                @if(auth()->user()->id_group == 1)
                                <td>
                                    @php
                                        $countPembelian = \App\Models\SupplyHistory::where('id_input',$pegawai->id)->count();
                                    @endphp
                                    {{ $countPembelian }} x
                                </td>
                                <td>
                                    @php
                                        $countPenjualan = \App\Models\TransactionHistory::where('id_approve',$pegawai->id)->count();
                                    @endphp
                                    {{ $countPenjualan }} x
                                </td>
                                @else
                                    <td>
                                        @php
                                            $countPembelian = \App\Models\TransactionHistory::where('id_input',$pegawai->id)->count();
                                        @endphp
                                        {{ $countPembelian }} x
                                    </td>
                                    <td>
                                        @php
                                            $countPenjualan = \App\Models\TransactionHistory::where('id_approve',$pegawai->id)->count();
                                            $countPenjualanKasir = \App\Models\TransactionHistorySell::where('id_input',$pegawai->id)->count();
                                            $countPenjualanTracking = \App\Models\TrackingSalesHistory::where('id_reseller',$pegawai->id)->count();
                                        @endphp
                                        {{ $countPenjualan+$countPenjualanKasir+$countPenjualanTracking }} x
                                    </td>
                                @endif
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