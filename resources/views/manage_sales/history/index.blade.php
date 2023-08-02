@extends('templates/main')

@section('css')

@endsection

@section('content')

<div class="container justify text-left">
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-sm">
                    <h4 style="text-align:left;">History Bonus</h4>
                </div>
                <div class="col-sm">
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/sales/export-history-bonus/'.$sales->id) }}'">
                            <i class="fa fa-file-pdf-o"></i>
                            <span>Export</span></button>
                        <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/sales/print-history-bonus/'.$sales->id) }}')">
                        <i class='fa fa-print'></i>Print</button>
                    </div>
            </div>
        </div>
    </div>
    <hr>
    <br>
    <div class="row">
        <div class="col-md-3">
            <h4>Bonus Penjualan Saya</h4>
        </div>
        <div class="col-md-1">
            <h4>:</h4>
        </div>
        <div class="col-md-3">
            <h4>Rp. {{ number_format($sales->bonus_penjualan_sales, 0, ',', '.') }}</h4>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="iq-card">
                <div class="iq-card-body ">
                    <div class="row align-items-center">
                        
                        <div class="col-md-5 text-left">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                                </div>
                                <input class="form-control form-control-sm" id="min" name="date" placeholder="Tanggal Awal" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-5 text-left">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                                </div>
                                <input class="form-control form-control-sm" id="max" name="date" placeholder="Tanggal Akhir" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <button class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" type="button" id="search">Cari</button>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="col text-left" id="logTableDiv">
                
                    </div>
                    {{-- <table id="myTable" class="table text-left table-hover table-striped table-light"
                        id="myTable">
                        <thead>
                            <tr>
                                <th>Tanggal Bonus Masuk</th>
                                <th>Jumlah Bonus Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($histories as $history)
                            <tr>
                                <td>
                                    {{ $history->updated_at->format('d/m/y H:i:s') }}
                                </td>
                                <td>{{ number_format($history->total_bonus_penjualan_sales, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function () {
    var date_input = $('input[name="date"]'); //our date input has the name "date"
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    var options = {
        format: 'mm/dd/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    };
    date_input.datepicker(options);

    $.ajax({
        type:'get',
        url:'{{ url("/sales/get_history") }}',
        data: {
            "_token": "{{ csrf_token() }}",
            id_sales: {{ $sales->id }},        
        },
        success:function(data) {
            //console.log(data);
            document.getElementById("logTableDiv").innerHTML = data;
            $('#logTable').DataTable(
                {
                    "oSearch": { "bSmart": false, "bRegex": true },
                    "aaSorting": [],
                });
        },
        error: function(data){
            console.log(data);
        }
    });

    $('#search').click(function () {
        var min = document.getElementById("min").value;
        var max = document.getElementById("max").value;
        
        $.ajax({
            type:'get',
            url:'{{ url("/sales/get_history_date") }}',
            data: {
                "_token": "{{ csrf_token() }}",
                min:min,
                max:max,
                id_sales: {{ $sales->id }},        
            },
            success:function(data) {
                document.getElementById("logTableDiv").innerHTML = data;
                $('#logTable').DataTable(
                    {
                        "oSearch": { "bSmart": false, "bRegex": true },
                        "aaSorting": [],
                    });
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    
});
</script>
@endsection