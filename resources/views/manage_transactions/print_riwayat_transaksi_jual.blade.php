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
            Riwayat Transaksi Jual - {{ date("d F Y") }}
        </div>
        <hr style="border-color:black;">
            <div class="container justify text-center">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="col text-left">
                            <!-- <p style="font-weight:bold; font-size: 20px; text-align:left;">Riwayat Transaksi Jual - {{ date("d F Y") }}</p> -->
                            <br>
                            <div class="col text-left" id="logTableDiv">
                            </div>
                            {{-- <table class="table table-hover table-light">
                                <thead>
                                    <tr>
                                        <th scope="col">Kode Transaksi</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Bayar</th>
                                        <th scope="col">Kembali</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>T15072022101</td>
                                        <td>Nama Customer</td>
                                        <td>Rp. 50.000</td>
                                        <td>- Rp. 50.000</td>
                                        <td>Rp. 0</td>
                                    </tr>
                                    <tr>
                                        <td>T15072022103</td>
                                        <td>Nama Customer 2</td>
                                        <td>Rp. 100.000</td>
                                        <td>- Rp. 100.000</td>
                                        <td>Rp. 0</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row form-group">
                                <div class="col-sm-3">Total Pemasukan</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8">Rp. 150.000</div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function () {

    $.ajax({
        type:'get',
        url:'{{ url("/manage_transaction/transaction_history_sell/get_history_sell_print") }}',
        data: {
            "_token": "{{ csrf_token() }}"        
        },
        success:function(data) {
            //console.log(data);
            document.getElementById("logTableDiv").innerHTML = data;
        },
        error: function(data){
            console.log(data);
        }
    });
});
</script>
@endsection