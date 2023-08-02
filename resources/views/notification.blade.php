@extends('templates/main')

@section('css')

@endsection

@section('content')
<div class="container justify text-center">
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex ">
                <div class="col-5" style="text-align:left;">
                    <h4 style="text-align:left;">Notifikasi</h4>
                </div>
            </div>
        </div>
    </div>
    <hr>

@if(auth()->user()->user_position == "sales")
    <!-- notifikasi sales submit add stock--> 
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex ">
                <div class="col-5" style="text-align:left;">
                    <h4 style="text-align:left;">Notifikasi Stok</h4>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @foreach($terima_stoks as $terima_stok)
    <div class="iq-card">
        <div class="iq-card-header">
            <div class="row justify-content-between align-items-center" style="padding:8px;">
                <div class="col-sm text-left">
                    <p style="font-weight:bold;font-size:20px;">Add Stock Sales - {{ $terima_stok->created_at->format('j F Y H:i:s') }}</p>
                    <p style="color:grey;"></p>
                </div>
                <div class="col-sm text-right">
                    <button type="button" class="btn btn-link" onclick="#" data-toggle="collapse" data-target='#terima{{ $terima_stok->id }}' aria-expanded="false" aria-controls="tr1">
                        <span><i class="fa fa-angle-down"></i></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="iq-card-body collapse" id="terima{{ $terima_stok->id }}">
            <div class="col text-left">
                <label class="labelclass">Daftar stok yang diterima</label>
            </div><hr style="margin:8px;">
            <div class="col text-left">
                <table class="table table-hover table-light">
                    <thead>
                        <tr>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga Jual</th>
                            <th scope="col">Nilai Total</th>
                        </tr>
                    </thead>
                    <tbody id="shopCart">
                        @php
                            $details = \App\Models\SalesStokDetail::where('id_sales_stok', $terima_stok->id)->get();
                        @endphp

                        @foreach($details as $detail)
                        <tr>
                            <td>{{ $detail->nama_produk }}</td>
                            <td>{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->total, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row d-flex justify-content-right align-items-right">
                <div class="col-sm text-right">
                    <button type="button" class=" btn btn-primary" onclick="window.location.href='{{ url('/terima_stok/approve/'.$terima_stok->id) }}'">
                        <span>Accept</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endif

    <!-- notifikasi POINT SUDAH CUKUP UNTUK CLAIM REWARD --> 
@if(auth()->user()->id_group != 1)
@if($rewards->count() > 0)
    <div class="iq-card">
        <div class="iq-card-header">
            <div class="row justify-content-between align-items-center" style="padding:8px;">
                <div class="col-sm text-left">
                    <p style="font-weight:bold;font-size:20px;">Cek Hadiahmu Sekarang!</p>
                    <p style="color:grey;"></p>
                </div>
                <div class="col-sm text-right">
                    <button type="button" class="btn btn-link" onclick="#" data-toggle="collapse" data-target="#tr1" aria-expanded="false" aria-controls="tr1">
                        <span><i class="fa fa-angle-down"></i></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="iq-card-body collapse" id="tr1">
            <div class="row" style="padding:8px;">
                <div class="col-sm text-left">
                    <p>Kamu Berkesempatan Untuk Memiliki Reward Hadiah Berdasarkan Reward Di Bawah Ini Lho!!!</p>
                </div>
            </div>
            <hr>
        <div class="iq-card">

            <div class="iq-card-body">
                <div class="row">
                    <div class="col-md-2">
                        <h4>Point Saya</h4>
                    </div>
                    <div class="col-md-1">
                        <h4>:</h4>
                    </div>
                    <div class="col-md-3">
                        <h4>{{ number_format($owner->crm_poin, 0, ',', '.') }}</h4>
                    </div>
                
                </div>
                <hr>
                <table id="mytable" class="table table-hover table-striped table-light text-nowrap"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Reward</th>
                            <th>Point</th>
                            <th>Claim</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($rewards as $reward)
                        <tr>
                            <td class="w-25">
                                <img src={{ asset('storage/' . $reward->image) }} alt=profile-img
                                    class="img-fluid img-thumbnail" style="width:75%;"/>
                            <td class="align-middle">
                                {{ $reward->reward }}
                            </td >
                            <td class="align-middle">{{ number_format($reward->poin, 0, ',', '.') }}</td>
                            @if(auth()->user()->id == $owner->id)
                            <td class="align-middle">
                                <div class="form-group" style="align-items:center" >
                                    <button type="button" data-toggle='modal'
                                        data-target='#modalaccreward' data-edit="{{ $reward->id }}" class="btn btn-primary btn-accreward"><i class="fa fa-envelope-open"></i>Claim
                                    </button>
                                </div>
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

<!-- Modal acc -->
<div class="modal fade" id="modalaccreward" role="dialog" style="border-radius:45px">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="{{ url('/notification/claim_reward/'.$owner->id) }}" method="post" enctype="multipart/form-data" name="update_form">
                <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
                    <p id="employeeidname" style="font-weight: bold;">Klaim Hadiah</p>
                    <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                </div>

                <div class="modal-body">
                    @csrf
                    <div class="col-12" hidden="">
                        <input type="text" name="id_reward">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm align-items-center">
                                <label for="exampleInputFirstName" style="color:black" id="keterangan"></label>
                            </div>                                
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-items-right">
                        <div class="btn-action" >
                            <button type="submit" class="btn-danger d-flex justify-content-center align-items-center" style="height:35px; width:100px">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endif

    <!-- notifikasi acc claim reward -->
@if(auth()->user()->id_group == 1)
    @if($reward_pending->count())
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex ">
                <div class="col-5" style="text-align:left;">
                    <h4 style="text-align:left;">Notifikasi Reward</h4>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @foreach($reward_pending as $reward)
    <div class="iq-card">
        <div class="iq-card-header">
            <div class="row justify-content-between align-items-center" style="padding:8px;">
                <div class="col-sm text-left">
                    <p style="font-weight:bold;font-size:20px;">Claim Reward - {{ $reward->owner->firstname }} {{ $reward->owner->lastname }}</p>
                    <p style="color:grey;"></p>
                </div>
                <div class="col-sm text-right">
                    <button type="button" class="btn btn-link" onclick="#" data-toggle="collapse" data-target="#reward{{ $reward->id }}" aria-expanded="false" aria-controls="tr1">
                        <span><i class="fa fa-angle-down"></i></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="iq-card-body collapse" id="reward{{ $reward->id }}">
            <div class="row" style="padding:8px;">
                <div class="col-sm text-left">
                    <form action="" method="post" name="create_form" enctype="multipart/form-data">
                        <div class="row form-group">
                            <div class="col-sm-3">Gambar </div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8">
                                <img src={{ asset('storage/' . $reward->image) }} alt=profile-img
                                    class="img-fluid img-thumbnail" style="width:25%;"/></div>
                        </div><hr>
                        <div class="row form-group">
                            <div class="col-sm-3">Reward</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8">{{ $reward->reward }} {{ $reward->detail }}</div>
                        </div><hr>
                        
                        <div class="row form-group">
                            <div class="col-sm-3">Harga Reward</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8">{{ number_format($reward->poin, 0, ',', '.') }}</div>
                        </div><hr>
                        <div class="row form-group">
                            <div class="col-sm-3">Sisa Poin</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8">{{ number_format($reward->sisa_poin, 0, ',', '.') }}</div>
                        </div><hr>
                        <div class="row form-group">
                            <div class="col-sm-3">Tanggal Claim Reward</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8">{{ $reward->created_at->format('j F Y H:i:s') }}</div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <div class="col-sm-3">Status</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8">Belum Diapprove</div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm text-left"><button type='button' class='btn btn-primary' onclick="window.location.href='{{ url('/notification/printKlaimReward/'.$reward->id) }}'"><i class='fa fa-print'></i>
                                Print</button></div>
                            @if(auth()->user()->acc_reward == 1)
                            <div class="col-sm text-right"><button type="button" class="btn btn-primary" onclick="window.location.href='{{ url('/claim_reward/approve/'.$reward->id) }}'">Approve</button></div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
@endif

    
    <!-- notifikasi transaksi -->
@if(auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales")
    @if($transaksi_pending->count())
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex ">
                <div class="col-5" style="text-align:left;">
                    <h4 style="text-align:left;">Notifikasi Pembelian</h4>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @foreach($transaksi_pending as $transaksi)
    <div class="iq-card">
        <div class="iq-card-header">
            <div class="row justify-content-between align-items-center" style="padding:8px;">
                <div class="col-sm text-left">
                    <p style="font-weight:bold;font-size:20px;">Pembelian - {{ $transaksi->owner->firstname }} {{ $transaksi->owner->lastname }}</p>
                    <p style="color:grey;">{{ $transaksi->created_at->format('j F Y H:i:s') }}</p>
                </div>
                <div class="col-sm text-right">
                    <button type="button" class="btn btn-link" onclick="#" data-toggle="collapse" data-target="#transaksi{{ $transaksi->id }}" aria-expanded="false" aria-controls="tr1">
                        <span><i class="fa fa-angle-down"></i></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="iq-card-body collapse" id="transaksi{{ $transaksi->id }}">
            <div class="row" style="padding:8px;">
                <div class="col-sm text-left">
                    <form action="{{ url('/transaction/approve/'.$transaksi->id) }}" method="post" name="create_form" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="row form-group">
                            <table class="table table-hover table-light">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Harga Satuan</th>
                                        <th scope="col">Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $details = \App\Models\TransactionDetail::where('id_transaction', $transaksi->id)->get();
                                        $id_first = 0;
                                        $id_last = 0;
                                        foreach($details as $detail)
                                        {
                                            if($id_first==0){
                                                $id_first = $detail->id;
                                            };
                                            $id_last = $detail->id;
                                        };
                                    @endphp

                                    @foreach($details as $detail)
                                        <div class="form-group">
                                        <tr>
                                            <td>{{ $detail->nama_produk }}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-3" id="jumlah_lama{{ $detail->id }}">
                                                        {{ number_format($detail->jumlah, 0, ',', '.') }}
                                                    </div>
                                                    <div class="col-3">
                                                    @if(auth()->user()->acc_transaksi == 1)
                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#editJumlahBarang.{{ $detail->id }}">
                                                        <span><i class="fa fa-edit"></i></span>
                                                    </button>
                                                        <input type="hidden" class="form-control textField" id="jumlah{{ $detail->id }}" name="jumlah{{ $detail->id }}"
                                                        placeholder="Masukkan Stok Barang" value="{{ $detail->jumlah }}">
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Rp <span id="harga{{ $detail->id }}">{{ number_format($detail->harga, 0, ',', '.') }}</td>
                                            <td>Rp <span id="total{{ $detail->id }}">{{ number_format($detail->total, 0, ',', '.') }}</span></td>
                                        </tr>
                                        </div>
                                        
                                        <!-- modal edit -->
                                        <div class="modal fade" id="editJumlahBarang.{{ $detail->id }}" role="dialog" style="border-radius:45px">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
                                                        <p id="employeeidname" style="font-weight: bold;">EDIT {{ $detail->nama_produk }}</p>
                                                        <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                                                    </div>

                                                    
                                                    <div class="modal-body">
                                                        {{-- <form action="{{ url('/transaction/editDetail/'.$detail->id) }}" method="post" name="create_form" enctype="multipart/form-data">
                                                        @method('put')
                                                        @csrf
                                                        <div class="form-group"> --}}
                                                            <div class="row text-center">
                                                                <div class="col-4">
                                                                    Jumlah barang
                                                                </div>
                                                                <div class="col-1">
                                                                    :
                                                                </div>
                                                                <div class="col-7">
                                                                    <input type="number" id="jumlah_baru{{ $detail->id }}">
                                                                </div>
                                                            </div>
                                                        {{-- </div> --}}
                                                        <br>
                                                        {{-- <div class="form-group"> --}}
                                                            <div class="row text-center">
                                                                <div class="col">
                                                                    <button class="btn btn-secondary text-right" data-dismiss="modal" style="text-align:left">
                                                                        <a style="color: white;">Cancel</a>
                                                                    </button>
                                                                    {{-- <input type="submit" onclick="" class="btn btn-primary submit" value="Submit"> --}}

                                                                    <button class="btn btn-primary text-right" style="text-align:left" data-dismiss="modal" onclick="editJumlahBarangTransaksi('{{ $detail->id }}', {{ $detail->harga }}, {{ $id_first }}, {{ $id_last }})">
                                                                        <a style="color: white;">Submit</a>
                                                                    </button>
                                                                    
                                                                </div>
                                                            </div>
                                                        {{-- </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <tr>
                                        <td>&nbsp</td>
                                        <td>&nbsp</td>
                                        <td style="text-align:right; font-weight:bold">Total</td>
                                        <td style="font-weight:bold">Rp <span id="total_akhir">{{ number_format($transaksi->total, 0, ',', '.') }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><hr>
                        <div class="row form-group">
                            <div class="col-sm-3">Respon Sampai</div>
                            <div class="col-sm-1">:</div>
                            @php
                                $masuk = \Carbon\Carbon::createFromFormat('Y-m-d', $transaksi->tanggal_pesan);
                                $masuk = $masuk->addDays(14);
                                $masuk = \Carbon\Carbon::make($masuk)->format('j F Y');
                            @endphp
                            <div class="col-sm-8">{{ $masuk }}</div>
                            {{-- <div class="col-sm-8">07 Agustus 2022 16:00:00</div> --}}
                        </div><hr>
                        <div class="row form-group">
                            <div class="col-sm-3">Foto</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8"><img></div>
                        </div><hr>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3">Surat</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8">XXXXXXXX</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">Tanggal Surat Masuk</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8">{{ \Carbon\Carbon::make($transaksi->tanggal_pesan)->format('j F Y') }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">Respon Surat Sampai</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8">{{ $masuk }}</div>
                                {{-- <div class="col-sm-8">07 Agustus 2022 16:00:00</div> --}}
                            </div>
                        </div><hr>
                        <div class="row form-group">
                            <div class="col-sm-3">Keterangan</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8">XXXXXXXX</div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm text-left"><button type='button' style="background-color:rgba(165,78,182); color:whitesmoke" class='btn btn-primary' onclick="window.open('{{ url('/transaction/print/'.$transaksi->id) }}')"><i class='fa fa-print'></i>
                                Print</button></div>
                            @if(auth()->user()->acc_transaksi == 1)
                            <div class="col-sm text-right"><button type="submit" style="background-color:rgba(165,78,182); color:whitesmoke" class="btn btn-primary" onclick="">Approve</button></div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
    <!-- notifikasi retur -->
    @if($retur_pending->count())
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex ">
                <div class="col-5" style="text-align:left;">
                    <h4 style="text-align:left;">Notifikasi Retur Pembelian</h4>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @foreach($retur_pending as $retur)
    <div class="iq-card">
        <div class="iq-card-header">
            <div class="row justify-content-between align-items-center" style="padding:8px;">
                <div class="col-sm text-left">
                    <p style="font-weight:bold;font-size:20px;">Retur - {{ $retur->owner->firstname }} {{ $retur->owner->lastname }}</p>
                    <p style="color:grey;">{{ $retur->created_at->format('j F Y H:i:s') }}</p>
                </div>
                <div class="col-sm text-right">
                    <button type="button" class="btn btn-link" onclick="#" data-toggle="collapse" data-target="#retur{{ $retur->id }}" aria-expanded="false" aria-controls="tr1">
                        <span><i class="fa fa-angle-down"></i></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="iq-card-body collapse" id="retur{{ $retur->id }}">
            @php
                $cekSales = false;
                if(\App\Models\ReturHistory::where('id', $retur->id)->first()->owner->user_position == "sales")
                {
                    $cekSales = true;
                }
            @endphp
            <div>
                @if($cekSales)
                @php
                    $transaction = \App\Models\SalesStokHistory::where('id', $retur->id_transaction)->first();
                @endphp
                <p>Tanggal Terima Barang : {{ $transaction->updated_at->format('j F Y H:i:s') }}</p>
                @else
                @if($retur->transaction)
                <p>No Nota : {{ $retur->transaction->transaction_code }}</p>
                <p>Tanggal Transaksi : {{ $retur->transaction->created_at->format('j F Y H:i:s') }}</p>
                @else
                <p><strong>Tidak ada data transaksi(bisa jadi terhapus atau tidak terbuat)</strong></p>
                @endif
                @endif
            </div>
            <div class="row" style="padding:8px;">
                <div class="col-sm text-left">
                    <div class="row form-group">
                    <table class="table table-hover table-light text-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Jumlah Barang</th>
                                <th scope="col">Jumlah Barang yang Diretur</th>
                                <th scope="col">Harga Satuan</th>
                                <th scope="col">Total</th>
                                <th scope="col">Gambar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $details = \App\Models\ReturDetail::where('id_retur', $retur->id)->get();
                            @endphp
                            @foreach($details as $detail)
                                <tr>
                                    <td>{{ $detail->nama_produk }}</td>
                                    @php
                                        if($cekSales)
                                        {
                                            $produkTransaksi = \App\Models\Product::where('id', $detail->id_product)->first();
                                            $detailTransaksi = \App\Models\SalesStokDetail::where('id_sales_stok', $retur->id_transaction)->where('id_product', $produkTransaksi->id)->first();
                                        }
                                        else {
                                            $produkTransaksi = \App\Models\Product::where('id_owner', $retur->id_supplier)->where('id_productType', $detail->product->id_productType)->first();
                                            $detailTransaksi = \App\Models\TransactionDetail::where('id_transaction',$retur->id_transaction)->where('id_product', $produkTransaksi->id)->first();
                                        }
                                    @endphp
                                    <td>{{ number_format($detailTransaksi->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($detail->total, 0, ',', '.') }}</td>
                                    <td>
                                        @if($detail->foto)
                                            <img src={{ asset('storage/' . $detail->foto) }} style="width:75%;"/>
                                        @else
                                            <img src={{ asset('images/astanalogo.jpg') }} style="width:75%;"/>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <hr>
                    <div class="row form-group">
                        <div class="col-sm-3">Keterangan</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">{{ $retur->keterangan }}</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">Status</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">Menunggu konfirmasi</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">Waktu Diapprove</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">-</div>
                        {{-- <div class="col-sm-8">07 September 2022 16:00:00</div> --}}
                    </div>
                    <div class="row form-group">
                        <div class="col-sm text-left"><button type='button' style="background-color:rgba(165,78,182); color:whitesmoke" class='btn btn-primary' onclick="window.open('{{ url('/retur/pembelian/print/'.$retur->id) }}')" ><i class='fa fa-print'></i>
                            Print</button></div>
                        @if(auth()->user()->acc_retur == 1)
                        <div class="col-sm text-right"><button type="button" style="background-color:rgba(165,78,182); color:whitesmoke" class="btn btn-primary" onclick="window.location.href='{{ url('/retur/pembelian/approve/'.$retur->id) }}'">Approve</button></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
    <!-- notifikasi retur -->
    @if($retur_cashier_pending->count())
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex ">
                <div class="col-5" style="text-align:left;">
                    <h4 style="text-align:left;">Notifikasi Retur Penjualan</h4>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @foreach($retur_cashier_pending as $retur_cashier)
    <div class="iq-card">
        <div class="iq-card-header">
            <div class="row justify-content-between align-items-center" style="padding:8px;">
                <div class="col-sm text-left">
                    <p style="font-weight:bold;font-size:20px;">Retur - {{ $retur_cashier->owner->firstname }} {{ $retur_cashier->owner->lastname }}</p>
                    <p style="color:grey;">{{ $retur_cashier->created_at->format('j F Y H:i:s') }}</p>
                </div>
                <div class="col-sm text-right">
                    <button type="button" class="btn btn-link" onclick="#" data-toggle="collapse" data-target="#retur{{ $retur_cashier->id }}" aria-expanded="false" aria-controls="tr1">
                        <span><i class="fa fa-angle-down"></i></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="iq-card-body collapse" id="retur{{ $retur_cashier->id }}">
            @php
                $cekSales = false;
                if(\App\Models\ReturCashierHistory::where('id', $retur_cashier->id)->first()->owner->user_position == "sales")
                {
                    $cekSales = true;
                }
            @endphp
            <div>
                @if($cekSales)
                @php
                    $transaction = \App\Models\SalesStokHistory::where('id', $retur_cashier->id_transaction)->first();
                @endphp
                <p>Tanggal Terima Barang : {{ $transaction->updated_at->format('j F Y H:i:s') }}</p>
                @else
                <p>No Nota : {{ $retur_cashier->transaction->transaction_code }}</p>
                <p>Tanggal Transaksi : {{ $retur_cashier->transaction->created_at->format('j F Y H:i:s') }}</p>
                @endif
            </div>
            <div class="row" style="padding:8px;">
                <div class="col-sm text-left">
                    <div class="row form-group">
                    <table class="table table-hover table-light text-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Jumlah Barang</th>
                                <th scope="col">Jumlah Barang yang Diretur</th>
                                <th scope="col">Harga Satuan</th>
                                <th scope="col">Total</th>
                                <th scope="col">Gambar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $details = \App\Models\ReturCashier::where('id_retur', $retur_cashier->id)->get();
                            @endphp
                            @foreach($details as $detail)
                                <tr>
                                    <td>{{ $detail->nama_produk }}</td>
                                    @php
                                        if($cekSales)
                                        {
                                            $produkTransaksi = \App\Models\Product::where('id', $detail->id_product)->first();
                                            $detailTransaksi = \App\Models\SalesStokDetail::where('id_sales_stok', $retur_cashier->id_transaction)->where('id_product', $produkTransaksi->id)->first();
                                        }
                                        else {
                                            $produkTransaksi = \App\Models\Product::where('id_owner', $retur_cashier->id_supplier)->where('id_productType', $detail->product->id_productType)->first();
                                            $detailTransaksi = \App\Models\TransactionDetailSell::where('id_transaction',$retur_cashier->id_transaction)->where('id_product', $produkTransaksi->id)->first();
                                        }
                                    @endphp
                                    {{-- <td>{{ number_format($detailTransaksi->jumlah, 0, ',', '.') }}</td> --}}
                                    <td></td>
                                    <td>{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($detail->total, 0, ',', '.') }}</td>
                                    <td>
                                        @if($detail->foto)
                                            <img src={{ asset('storage/' . $detail->foto) }} style="width:75%;"/>
                                        @else
                                            <img src={{ asset('images/astanalogo.jpg') }} style="width:75%;"/>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <hr>
                    <div class="row form-group">
                        <div class="col-sm-3">Keterangan</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">{{ $retur_cashier->keterangan }}</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">Status</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">Menunggu konfirmasi</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">Waktu Diapprove</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-8">-</div>
                        {{-- <div class="col-sm-8">07 September 2022 16:00:00</div> --}}
                    </div>
                    <div class="row form-group">
                        <div class="col-sm text-left"><button type='button' class='btn btn-primary' onclick="window.open('{{ url('/retur/penjualan/print/'.$retur_cashier->id) }}')" ><i class='fa fa-print'></i>
                            Print</button></div>
                        @if(auth()->user()->acc_retur == 1)
                        <div class="col-sm text-right"><button type="button" class="btn btn-primary" onclick="window.location.href='{{ url('/retur/penjualan/approve/'.$retur_cashier->id) }}'">Approve</button></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
@endif

    <!-- notifikasi pengingat stok -->
    @if($produk_sedikit->count())
    <hr>
    <div class="iq-card">
        <div class="iq-card-header">
            <div class="row justify-content-between align-items-center" style="padding:8px;">
                <div class="col-sm text-left">
                    <p style="font-weight:bold;font-size:20px;">Pengingat Stock</p>
                    {{-- <p style="color:grey;">07 Agustus 2022 13:50:10</p> --}}
                </div>
                <div class="col-sm text-right">
                    <button type="button" class="btn btn-link" onclick="#" data-toggle="collapse" data-target="#stok" aria-expanded="false" aria-controls="tr1">
                        <span><i class="fa fa-angle-down"></i></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="iq-card-body collapse" id="stok">
            <div class="row" style="padding:8px;">
                <div class="col-sm text-left">
                    <div class="row form-group">
                        <table class="table table-hover table-striped table-light" style="text-align:left" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produk_sedikit as $produk)
                                    <tr>
                                        <td>{{ $produk->product_type->nama_produk }}</td>
                                        <td>{{ $produk->stok }}</td>
                                        <td>{{ $produk->updated_at->format('d/m/y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="row form-group">
                        @if(auth()->user()->id_group == 1)
                            @if(auth()->user()->pasok_barang == 1)
                            <div class="col-sm text-right"><button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_product/input_pasok/supplyhistories/create') }}')">Stock Barang</button></div>
                            @endif
                        @else
                            @if(auth()->user()->input_pos == 1)
                            <div class="col-sm text-right"><button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_transactions/transaction') }}')">Stock Barang</button></div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> 
    @endif        
    {{-- Notif claim reward --}}
</div>
@endsection

@section('script')
<script>
@if ($message = Session::get('claim_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

@if ($message = Session::get('approve_transaction_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

@if ($message = Session::get('approve_transaction_failed'))
    swal(
        "Transaksi Gagal!",
        "{{ $message }}",
        "error"
    );
@endif
    
@if ($message = Session::get('approve_claim_reward_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

@if ($message = Session::get('approve_terima_stok'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function editJumlahBarangTransaksi(id, harga, id_first, id_last)
{
    document.getElementById('jumlah_lama'+id).innerHTML = document.getElementById('jumlah_baru'+id).value;
    document.getElementById('jumlah'+id).value = document.getElementById('jumlah_baru'+id).value;
    totalHarga = document.getElementById('jumlah_baru'+id).value * harga;
    document.getElementById('total'+id).innerHTML = number_format(totalHarga, 0, ',', '.');

    total = 0;
    for (let i = id_first; i <= id_last; i++) {
        tempj = document.getElementById('jumlah_lama'+i).innerHTML;
        j = parseInt(tempj.replace(/\./g, ""));
        tempH = document.getElementById('harga'+i).innerHTML;
        h = parseInt(tempH.replace(/\./g, ""));
        total += j * h;
    }
    document.getElementById('total_akhir').innerHTML = number_format(total, 0, ',', '.');

}

$(document).on('click', '.btn-accreward', function(){
    var data_edit = $(this).attr('data-edit');
    $.ajax({
        method: "GET",
        url: "{{ url('/crm/omzet/get_reward') }}/" + data_edit,
        success:function(response)
        {
            $('input[name=id_reward]').val(response.reward.id);
            document.getElementById("keterangan").innerHTML = "Apakah anda yakin klaim hadiah "+response.reward.reward+" ?";
            validator.resetForm();
        }
    });
});
</script>
@endsection