@extends('templates/main')

@section('css')
<style>
    .upload{
        background-color:rgba(52, 25, 80, 1);
        color:white;
        width:100px;
        border: 1px solid white;
        border-radius: 5px;
        width:150px;
        height:50px;
        
    }
    .text{
        color:rgba(52, 25, 80, 1);
        float: left;
    }
    .textField{
        background-color:white;
        border-radius: 5px;
        text-align:left;
    }
</style>
@endsection

@section('content')
<div class="container justify text-center">
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-sm">
                    <h4 style="text-align:left;">Riwayat Transaksi Jual</h4>
                </div>
            </div>
            <div class="row mt-3 d-flex flex-row">
                <div class="col-sm d-flex align-items-end justify-content-center">
                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_transaction/transaction_history_sell/print/'.auth()->user()->id) }}')">
                        <i class="fa fa-edit"></i>
                        <span>Print History</span>
                    </button>
                </div>
                <div class="col-sm">
                    <h6>Min Date:</h6>
                    <div class="input-group">
                        
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                        </div>
                        <input class="form-control form-control-sm" id="min" name="date" placeholder="Pilih Tanggal" type="text" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm">
                    <h6>Max Date:</h6>
                    <div class="input-group">
                        
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                        </div>
                        <input class="form-control form-control-sm" id="max" name="date" placeholder="Pilih Tanggal" type="text" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm d-flex align-items-end justify-content-center">
                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" id="search">
                        <i class="fa fa-search"></i>
                        <span>Search</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    
    <div class="iq-card">
        <div class="iq-card-body">
            <div class="col text-left">
                
            <div class="col text-left" id="logTableDiv">
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- datatable -->
    <link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css" rel="stylesheet" crossorigin="anonymous">
    {{-- <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script> --}}
    <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet">
    {{-- <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script> --}}

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>


    <script  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script  src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script  src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script  src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/r-2.3.0/datatables.min.css"/>
 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/r-2.3.0/datatables.min.js"></script>

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
        url:'{{ url("/manage_transaction/transaction_history_sell/get_history_sell") }}',
        data: {
            "_token": "{{ csrf_token() }}"        
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
            url:'{{ url("/manage_transaction/transaction_history_sell/get_history_sell_date") }}',
            data: {
                "_token": "{{ csrf_token() }}",
                min:min,
                max:max        
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
    });
});


</script>
@endsection