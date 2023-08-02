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
            History {{ $user->firstname }} {{ $user->lastname }}
        </div>
        <hr style="border-color:black;">
        <div class="row">
        <div class="col-12">
            <div class="iq-card">
                <div class="iq-card-body ">
                    <table class="table text-left table-hover table-striped table-light" id="myTable">
                        <thead>
                            <tr>
                                <th>Tanggal Edit</th>
                                <th>Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userHistories as $userHistory)
                            <tr>
                                <td>
                                    {{ $userHistory->created_at->format('d/m/y H:i:s') }}
                                </td>
                                <td>{{ $userHistory->kegiatan }}</td>
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
@endsection

@section('script')

@endsection