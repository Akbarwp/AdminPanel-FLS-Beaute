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
                    <h4 style="text-align:left;">Riwayat Transaksi</h4>
                </div>
            </div>
            <form action="{{ url('/manage_transaction/buy/history/print/') }}" method="post" target="_blank">
                @csrf
                <div class="row mt-3 d-flex flex-row">
                    <div class="col-sm d-flex align-items-end justify-content-center">
                        <button type="submit" class="btn btn-primary form-group mr-3" style="background-color:rgba(165,78,182); color:whitesmoke"> 
                            <i class="fa fa-edit"></i>
                            <span>Print History</span>
                        </button>
                        <button type="button" class="btn btn-primary form-group mr-3" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('manage_transaction/buy/history/export/') }}'">
                            <i class="fa fa-file-pdf-o"></i>
                            <span>Export</span>
                        </button>
                    </div>
                    <div class="col-sm">
                        <h6>Min Date:</h6>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                            </div>
                            <input class="form-control form-control-sm" id="min" name="min" placeholder="Pilih Tanggal" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm">
                        <h6>Max Date:</h6>
                        <div class="input-group form-group">
                            
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                            </div>
                            <input class="form-control form-control-sm" id="max" name="max" placeholder="Pilih Tanggal" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm d-flex align-items-end justify-content-center">
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" id="search">
                            <i class="fa fa-search"></i>
                            <span>Search</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <hr>
    
    <div class="iq-card">
        <div class="iq-card-body">
            <div class="col text-left">
                
            </div><hr style="margin:5px;">
            <div class="col text-left" id="logTableDiv">
                <table id="logTable" class="table table-hover table-light">
                    <thead>
                        <tr>
                            <th scope="col">Kode Transaksi</th>
                            <th scope="col">Distributor</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Metode Pembayaran</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $history)
                        <tr id="{{ $history->id }}">
                            <td>{{ $history->transaction_code }}</td>
                            <td>
                                {{-- @if($history->id_distributor == 1)
                                    Pabrik
                                @else --}}
                                    {{ $history->distributor->firstname }} {{ $history->distributor->lastname }}
                                {{-- @endif --}}
                            </td>
                            <td>Rp. {{ number_format($history->total, 0, ',', '.') }}</td>
                            <td class="col-1">
                                @if($history->status_pesanan == 1)
                                    Sukses
                                @else
                                    Menunggu Konfirmasi
                                @endif
                            </td>
                            <td>{{ $history->updated_at->format('d/m/y H:i:s') }}</td>
                            <td>{{ $history->metode_pembayaran }}</td>
                            <td class="col-2">
                                <div class="col text-left">
                                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_transaction/buy/history/print_detail/'.$history->id) }}')">
                                        <span><i class="fa fa-edit"></i>Print</span>
                                    </button>
                                    <button type="button" class="btn btn-link carousel" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="functionDetail({{ $history->id }})">
                                        <span><i class="fa fa-angle-down"></i></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <h4>Total : Rp. <span id="totalAll"></span></h4>
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

function format(d, id) {
    var histories = {!! json_encode($histories->toArray()) !!};
    var details = {!! json_encode($details->toArray()) !!};
    const indexHistory = histories.findIndex(item => item.id == id);

    let datas = [];
    var found = details.find(function (element) {
        if(element['id_transaction'] == id)
        {
            datas.push(element);
        }
    });
    
    // `d` is the original data object for the row
    $output='<div class="row d-flex justify-content-center align-items-center">'+
            '<div class="col-sm text-right">'+
                '<p>Jumlah Barang : '+histories[indexHistory]['jumlah_barang']+'</p>'+
            '</div>'+
        '</div>'+
        '<table class="table table-hover table-light">'+
            '<tbody>';
                let count =0;
                datas.forEach(function(data) {
                    count+=1;
                    $output+=
                    '<tr>'+
                        '<td class="align-middle">'+count+'</td>'+
                        '<td class="align-middle">'+data['nama_produk']+'</td>'+
                        '<td class="align-middle">'+
                            '<div class="col-sm text-left">'+
                                '<p style="font-weight:500;font-size:12px;color:grey;">Jumlah</p>'+
                                '<p style="font-weight:500;">'+number_format(data['jumlah'], 0, ',', '.')+' pcs</p>'+
                            '</div>'+
                        '</td>'+
                        '<td class="align-middle">'+
                            '<div class="col-sm text-left">'+
                                '<p style="font-weight:500;font-size:12px;color:grey;">Harga</p>'+
                                '<p style="font-weight:500;">Rp. '+number_format(data['harga'], 0, ',', '.')+'</p>'+
                            '</div>'+
                        '</td>'+
                        '<td class="align-middle">'+
                            '<div class="col-sm text-left">'+
                                '<p style="font-weight:500;font-size:12px;color:grey;">Total</p>'+
                                '<p style="font-weight:500;">Rp. '+number_format(data['total'], 0, ',', '.')+'</p>'+
                            '</div>'+
                        '</td>'+
                    '</tr>';
                });
                
            $output+='</tbody>'+
        '</table>'
    ;
    return($output);
    }  

function functionDetail(id)
{
    console.log("masuk");
    var table=$('#logTable').DataTable();
    var id = id;
    var temp ="#"
    temp += id.toString();
    var tr = $(temp);
    var row = table.row(tr);
    if (row.child.isShown()) {
        // This row is already open - close it
        console.log("close");

        row.child.hide();
        tr.removeClass('shown');
    } else {
        // Open this row
        console.log("show");

        row.child(format(row.data(), id)).show();
        tr.addClass('shown');
    }
}

$(document).ready(function () {
    var table = $('#logTable').DataTable({
        // columns: [
        //     { data: "Kode Transaksi" },
        //     { data: "Distributor" },
        //     { data: "Total", className: "sum" },
        //     { data: "Status"},
        //     { data: "Tanggal"},
        //     { data: "Metode Pembayaran"},
        //     { data: ""},
        // ],
        "oSearch": { "bSmart": false, "bRegex": true },
        "aaSorting": [],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
 
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\Rp. .]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
 
            // Total over all pages
            total = api
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Total over this page
            pageTotal = api
                .column(2, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Update footer
            $("#totalAll").html(number_format(pageTotal, 0, ',', '.'));
        },
    });

    var date_input_min = $('input[name="min"]'); //our date input has the name "date"
    var date_input_max = $('input[name="max"]'); //our date input has the name "date"
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    var options = {
        format: 'mm/dd/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    };
    date_input_min.datepicker(options);
    date_input_max.datepicker(options);
});

$('#search').click(function () {
        var min = document.getElementById("min").value;
        var max = document.getElementById("max").value;
        
        $.ajax({
            type:'get',
            url:'{{ url("/manage_transaction/buy/history/get_date") }}',
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
                    // columns: [
                    //     { data: "Kode Transaksi" },
                    //     { data: "Distributor" },
                    //     { data: "Total", className: "sum" },
                    //     { data: "Status"},
                    //     { data: "Tanggal"},
                    //     { data: "Metode Pembayaran"},
                    //     { data: ""},
                    // ],
                    "oSearch": { "bSmart": false, "bRegex": true },
                    "aaSorting": [],
                    footerCallback: function (row, data, start, end, display) {
                        var api = this.api();
            
                        // Remove the formatting to get integer data for summation
                        var intVal = function (i) {
                            return typeof i === 'string' ? i.replace(/[\Rp. .]/g, '') * 1 : typeof i === 'number' ? i : 0;
                        };
            
                        // Total over all pages
                        total = api
                            .column(2)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
            
                        // Total over this page
                        pageTotal = api
                            .column(2, { page: 'current' })
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
            
                        // Update footer
                        $("#totalAll").html(number_format(pageTotal, 0, ',', '.'));
                        
                    },
                });
            },
            error: function(data){
                console.log(data);
            }
        });
    });

function printHistory()
{
    var min = document.getElementById("min").value;
    var max = document.getElementById("max").value;
    console.log(min);
    $link = "{{ url('/manage_transaction/buy/history/print/'" +min;
    window.open($link);
}
</script>
@endsection