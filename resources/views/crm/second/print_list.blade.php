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
            @if(auth()->user()->id_group == 1)
            CRM Distributor Dashboard
            @elseif(auth()->user()->user_position != "reseller")
            CRM Reseller Dashboard
            @endif        
        </div>
        <hr style="border-color:black;">
        <div class="row">
            <div class="col-12">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="table-responsive-xl" style="overflow: scroll; ">  
                            <table class="table table-hover table-striped table-light display sortable  text-nowrap" cellspacing="0"  id="myTable" >
                                <thead>
                                    <br>
                                    <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                        <th >ID</th>
                                        @if(auth()->user()->id_group == 1)
                                        <th >Distributor</th>
                                        @elseif(auth()->user()->user_position != "reseller")
                                        <th >Reseller</th>
                                        @endif
                                        <th>Point</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($lists as $list)
                                        <tr>
                                            <td>{{ $list->id }}</td>
                                            <td>{{ $list->firstname }} {{ $list->lastname }}</td>
                                            <td>{{ number_format($list->crm_poin, 0, ',', '.') }}</td>
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
@endsection

@section('script')
<script>

<script>
@endsection