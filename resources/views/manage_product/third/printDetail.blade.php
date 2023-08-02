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
            Daftar Reseller {{ $distributor->firstname }} {{ $distributor->lastname }}
        </div>
        <hr style="border-color:black;">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12 grid-margin ">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <!-- <p style="font-weight:bold; font-size: 20px; text-align:left;">Daftar Reseller {{ $distributor->firstname }} {{ $distributor->lastname }}</p> -->
                        <br>
                        <div class="table-responsive-xl">
                    <table
                        class="table table-hover table-striped table-light display sortable text-nowrap"
                        cellspacing="0" id="myTable">
                        <thead>
                            <br>
                            <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                <th>ID</th>
                                <th>Nama Reseller</th>
                                <th>Alamat</th>
                                <th>Kota</th>
                                <th>Waktu Join</th>
                                <th>Stock Produk</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $allStok=0;
                            @endphp
                            @foreach($resellers as $reseller)
                                <tr>
                                    <td>{{ $reseller->id }}</td>
                                    <td>{{ $reseller->firstname }} {{ $reseller->lastname }}</td>
                                    <td>{{ $reseller->address }}</td>
                                    <td>{{ $reseller->city->name }}</td>
                                    <td>{{ $reseller->created_at->format('j F Y') }}</td>
                                    <td>{{ number_format($reseller->stock, 0, ',', '.') }} pcs</td>
                                </tr>
                                @php
                                    $allStok+=$reseller->stock;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>

                </div>
                        <div class="row form-group text-left">
                            <div class="col-sm-5" style="font-weight:bold">Total Reseller</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-6">{{ $resellers->count() }} Reseller</div>
                        </div>
                        <div class="row form-group text-left" >
                            <div class="col-sm-5" style="font-weight:bold">Total Stock Produk Seluruh Reseller</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-6">{{ number_format($allStok, 0, ',', '.') }} pcs</div>
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