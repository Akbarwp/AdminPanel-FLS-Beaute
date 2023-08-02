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
            <p style="font-weight:bold; font-size: 20px; text-align:left;">
                @can('superadmin_pabrik')
                Retur Pabrik ke Supplier
                @endcan
                @can('superadmin_distributor')
                Retur Distributor ke Pabrik
                @endcan
                @can('reseller')
                Retur Reseller ke Distributor
                @endcan
            </p>
        </div>
        <hr style="border-color:black;">

        <div class="iq-card">
            <div class="iq-card-body">
                
                <table class="text-left">
                    <tr>
                        <td>No Nota</td>
                        <td>:</td>
                        <td>
                            @if(auth()->user()->user_position == "superadmin_pabrik")
                            {{ $retur->pasok->kode_pasok }}
                            @else
                            {{ $retur->transaction->transaction_code }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Supplier</td>
                        <td>:</td>
                        <td>
                            @if($retur->id_supplier == 0)
                            Pabrik Astana
                            @else
                            {{ $retur->supplier->firstname }} {{ $retur->supplier->lastname }} 
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>No Surat Keluar</td>
                        <td>:</td>
                        <td>{{ $retur->surat_keluar }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Retur</td>
                        <td>:</td>
                        <td>{{ $retur->updated_at->format('d/m/y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>{{ $retur->keterangan }}</td>
                    </tr>
                </table>
                <hr>
                <table id="myTable" class="table table-hover table-striped table-light text-left text-nowrap" >
                    <thead>
                        <tr id="_judul" onkeyup="_filter()" id="myFilter">
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Kuantitas Barang yang Diretur</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Harga Total</th>
                            <th scope="col">Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($details as $detail)
                            <tr>
                                <td scope="col">{{ $detail->nama_produk }}</td>
                                <td scope="col">{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                <td scope="col">Rp. {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td scope="col">Rp. {{ number_format($detail->jumlah*$detail->harga, 0, ',', '.') }}</td>
                                <td scope="col" class="w-25">
                                    @if($detail->foto)
                                        <img src={{ asset('storage/' . $detail->foto) }} style="width:75%;" class="img-thumbnail"/>
                                    @else
                                        <img src={{ asset('images/astanalogo.jpg') }} style="width:75%;" class="img-thumbnail"/>
                                    @endif    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
                <div class="row form-group">
                    <div class="col-sm-3 text-left">Total Retur</div>
                    <div class="col-sm-1 text-left">:</div>
                    <div class="col-sm-8 text-left">Rp. {{ number_format($retur->total, 0, ',', '.') }}</div>
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