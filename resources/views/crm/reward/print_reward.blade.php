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
            Reward Distributor & Resller
        </div>
        <hr style="border-color:black;">
        <div class="row">
            <div class="col-12">
            <div class="iq-card">
                <div class="iq-card-body">
                    <div class="row d-flex justify-content-between m-1">
                        <h4>Reward Distributor</h4>
                    </div>
                    
                    <div class="table-responsive-xl">
                        
                        <table
                            class="table table-hover table-striped table-light display sortable"
                            cellspacing="0" id="tableDistributor">
                            <thead>
                                <br>
                                <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                    <th>ID</th>
                                    <th>Reward</th>
                                    <th>Point</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($distributor_rewards as $reward)
                                <tr>
                                    <td>{{ $reward->id }}</td>
                                    <td>{{ $reward->reward }}</td>
                                    <td>{{ $reward->poin }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div>
                        </div>
                    </div>

                </div>
            </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
            <div class="iq-card">
                <div class="iq-card-body">
                    <div class="row d-flex justify-content-between m-1">
                        <h4>Reward Reseller</h4>
                    </div>
                    
                    <div class="table-responsive-xl">
                        
                        <table
                            class="table table-hover table-striped table-light display sortable"
                            cellspacing="0" id="tableDistributor">
                            <thead>
                                <br>
                                <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                    <th>ID</th>
                                    <th>Reward</th>
                                    <th>Point</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($reseller_rewards as $reward)
                                <tr>
                                    <td>{{ $reward->id }}</td>
                                    <td>{{ $reward->reward }}</td>
                                    <td>{{ $reward->poin }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div>
                        </div>
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