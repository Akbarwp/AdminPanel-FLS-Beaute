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
            <h4>CRM - {{ $owner->firstname }} {{ $owner->lastname }}</h4>
        </div>
        <hr style="border-color:black;">
        <div class="row">
            <div class="col-12">
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
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