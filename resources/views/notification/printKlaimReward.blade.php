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
            Klaim Reward
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
        <div class="iq-card-body" id="reward{{ $reward->id }}">
            <div class="row" style="padding:8px;">
                <div class="col-sm text-left">
                    <form action="" method="post" name="create_form" enctype="multipart/form-data">
                        <hr>
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
                            <div class="col-sm-8">{{ $reward->created_at->format('j F Y H:m:s') }}</div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <div class="col-sm-3">Status</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-8">Belum Diapprove</div>
                        </div>
                    </form>
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