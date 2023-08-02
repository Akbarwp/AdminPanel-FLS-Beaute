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
            @if($user == "distributor")
                Distributor
            @elseif($user == "reseller")
                Reseller
            @endif
                - 
            @if($type == "stok")
                Available Stock
            @elseif($type == "penjualan")
                Total Penjualan
            @elseif($type == "retur")
                Total Retur
            @endif
        </div>
        <hr style="border-color:black;">
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-2">
                        Kepada
                    </div>
                    <div class="col-2">
                        :
                    </div>
                    <div class="col-8">
                        
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-2">
                        NO INV
                    </div>
                    <div class="col-2">
                        :
                    </div>
                    <div class="col-8">
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-2">
                        Alamat
                    </div>
                    <div class="col-2">
                        :
                    </div>
                    <div class="col-8">
                        
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-2">
                        Tanggal
                    </div>
                    <div class="col-2">
                        :
                    </div>
                    <div class="col-8">
                        
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="row col-sm" style="font-size:18px; font-weight:bold">
                </div>
                <hr>
                <div class="table-responsive-xl" style="overflow: scroll; ">
                    <table
                        class="table table-hover table-striped table-light display sortable  text-nowrap"
                        cellspacing="0" id="myTable">
                        <thead>
                            <br>
                            <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                <th>Distributor</th>

                                @if($user=="reseller")
                                <th>Reseller</th>
                                @endif

                                @if($type=="stok")
                                <th>Stok Available</th>
                                @elseif($type=="penjualan")
                                <th>Total Penjualan</th>
                                @elseif($type=="retur")
                                <th>Total Retur</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($datas as $data)
                            <tr>
                                @if($user=="reseller")
                                @php
                                    $distributor = \App\Models\User::where('id_group', $data->id_group)->where('user_position', 'superadmin_distributor')->first();
                                @endphp
                                <td>{{ $distributor->firstname }} {{ $distributor->lastname }}</td>
                                @endif

                                <td>{{ $data->firstname }} {{ $data->lastname }}</td>

                                @if($type=="stok")
                                <td>{{ number_format($data->stok, 0, ',', '.') }} pcs</td>
                                @elseif($type=="penjualan")
                                <td>Rp {{ number_format($data->totalPenjualan, 0, ',', '.') }}</td>
                                @elseif($type=="retur")
                                <td>Rp {{ number_format($data->totalRetur, 0, ',', '.') }}</td>
                                @endif
                            </tr>
                            @endforeach
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