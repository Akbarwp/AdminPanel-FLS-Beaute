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
                <table id="myTable" class="table table-hover table-striped table-light text-left text-nowrap" >
                    <thead>
                        <tr id="_judul" onkeyup="_filter()" id="myFilter">
                            <th scope="col">No Nota</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">No Surat Keluar</th>
                            <th scope="col">Tanggal Retur</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($returs as $retur)
                            <tr>
                                @if(auth()->user()->user_position == "superadmin_pabrik")
                                <td scope="col">{{ $retur->pasok->kode_pasok }}</td>
                                @else
                                <td scope="col">{{ $retur->transaction->transaction_code }}</td>
                                @endif
                                <td scope="col">
                                    @if($retur->id_supplier == 0)
                                    Pabrik Astana
                                    @else
                                    {{ $retur->supplier->firstname }} {{ $retur->supplier->lastname }} 
                                    @endif
                                </td>
                                <td scope="col">{{ $retur->surat_keluar }}</td>
                                <td scope="col">{{ $retur->updated_at->format('d/m/y H:i:s') }}</td>
                                <td scope="col">{{ $retur->keterangan }}</td>
                                <td scope="col">
                                    @if($retur->status_retur == 0)
                                        Menunggu Konfirmasi
                                    @else
                                        Retur Sukses
                                    @endif
                                </td>
                                <td scope="col">Rp. {{ number_format($retur->total, 0, ',', '.') }}</td>
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