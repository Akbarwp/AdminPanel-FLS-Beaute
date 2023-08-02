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
            List Distributor
        </div>
        <hr style="border-color:black;">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12 grid-margin ">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="table-responsive-xl" >  
                            <table class="table table-hover table-striped table-light display sortable  text-nowrap" cellspacing="0"  id="myTable" >
                                <thead>
                                    <th scope="col">Id Distributor</th>
                                    <th scope="col">Nama Distributor</th>
                                </thead>
                                <tbody>
                                    @foreach($distributors as $distributor)
                                        <tr>
                                            <td>{{ $distributor->id }}</td>
                                            <td>{{ $distributor->firstname }} {{ $distributor->lastname }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        <div>
                        <div class="row form-group text-left">
                            <div class="col-sm-5" style="font-weight:bold">Total Distributor</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-6">{{ $distributors->count() }}
                            </div>
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