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
            Detail Transaksi - {{ date("d F Y") }}
        </div>
        <hr style="border-color:black;">
            <div class="container justify text-center">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="col text-left">
                            
                            <div class="row form-group">
                                <div class="col-sm-3">Kode Transaksi</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8" id="kodeTransaksi"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3">Distributor</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8" id="distributor"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3">Total</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8" id="total"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3">Status</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8" id="status"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3">Tanggal</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-8" id="tanggal"></div>
                            </div>

                            <div class="col text-left" id="logTableDiv">
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

$(document).ready(function () {
    $.ajax({
        type:'get',
        url:'{{ url("/manage_transaction/transaction_history/get_history_print_data") }}',
        data: {
            "_token": "{{ csrf_token() }}",
            id: {{ $id }}        
        },
        success:function(data) {
            //console.log(data);
            var status 
            if(data[0][0]['status_pesanan'] == 0)
            {
                status = "Menunggu Konfirmasi";
            }
            else
            {
                status = "Sukses";
            }

            document.getElementById("kodeTransaksi").innerHTML = data[0][0]['transaction_code'];
            document.getElementById("distributor").innerHTML = data[1][0]['firstname'] +" "+ data[1][0]['lastname'];
            document.getElementById("total").innerHTML = "Rp " + number_format(data[0][0]['total'], 0 , ',', '.');
            document.getElementById("status").innerHTML = status;
            document.getElementById("tanggal").innerHTML = data[0][0]['tanggal_pesan'];
        },
        error: function(data){
            console.log(data);
        }
    });

    $.ajax({
        type:'get',
        url:'{{ url("/manage_transaction/transaction_history/get_history_detail_print") }}',
        data: {
            "_token": "{{ csrf_token() }}",
            id: {{ $id }}           
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