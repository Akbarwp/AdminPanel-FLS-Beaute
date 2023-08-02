@extends('templates/print')

@section('css')

@endsection

@section('content')

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

<div class="container justify text-center">
    <div class="row align-items-center">
        <div class="col-md-4 text-left">
            <h4>History Point </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="iq-card">
                <div class="iq-card-body">
                    <table class="table table-hover table-striped table-light display sortable" cellspacing="0" id="tableSales">
                        <thead>
                            <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                <th>Produk</th>
                                <th>Point Distributor</th>
                                <th>Point Distributor-Reseller</th>
                                <th>Point Reseller</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($poins as $poin)
                                <tr>
                                    <td>{{ $poin->product_type->nama_produk }}</td>
                                    <td>{{ $poin->distributor_jual }}</td>
                                    <td>{{ $poin->distributor_reseller_jual }}</td>
                                    <td>{{ $poin->reseller_jual }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div></div>
@endsection

@section('script')
<script>

<script>
@endsection