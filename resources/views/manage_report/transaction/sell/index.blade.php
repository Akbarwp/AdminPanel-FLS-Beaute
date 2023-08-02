@extends('templates/main')

@section('css')

@endsection

@section('content')
<div class="container justify text-center">
    <form action="{{ url('/manage_report/transaction/sell/print') }}" method="post" target="_blank">
        @csrf
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex ">
                <div class="col-sm">
                    <h4 style="text-align:left;">Laporan Transaksi Penjualan - {{ date('F Y') }}</h4>
                </div>
                <div class="col-sm">
                    <button type="submit" class="btn btn-primary form-group" style="background-color:rgba(165,78,182); color:whitesmoke" value="export" name="type">
                        <i class="fa fa-file-pdf-o"></i>
                        <span>Export</span>
                    </button>
                    <button type="submit" class="btn btn-primary form-group" style="background-color:rgba(165,78,182); color:whitesmoke" value="print" name="type">
                        <i class="fa fa-print"></i>
                        <span>Print</span>
                    </button>
                </div>
                <div class="col-sm">
                </div>
            </div>
        </div>
    </div>

    <div class="iq-card">
        <div class="iq-card-body">
        <div class="row align-items-center">
                <div class="col-md-5 text-left">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                        </div>
                        <input class="form-control form-control-sm" id="min" name="min" placeholder="Tanggal Awal" type="text" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-5 text-left">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                        </div>
                        <input class="form-control form-control-sm" id="max" name="max" placeholder="Tanggal Akhir" type="text" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" type="button" id="search">Cari</button>
                </div>
            </div>
            <br>
            <div class="col text-left">
                
            </div>
            <div class="col text-left" id="logTableDiv">
                <table id="logTable" class="table table-hover table-light">
                    <thead>
                        <tr>
                            <th scope="col">Kode Transaksi</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Total</th>
                            @if($owner->user_position == "superadmin_distributor" || $owner->user_position == "reseller")
                            <th scope="col">Diskon</th>
                            @endif
                            <th scope="col">Tanggal</th>
                            @if($owner->user_position != "sales")
                            <th scope="col">Metode Pembayaran</th>
                            @endif
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        @php
                            $type="beli";
                            if($owner->user_position == "sales")
                            {
                                $customerName = $transaction->nama_toko;
                                $code = $transaction->id;
                            }
                            else if($owner->user_position == "reseller")
                            {
                                $customerName = $transaction->nama_pembeli;
                                $code = $transaction->transaction_code;
                            }
                            else
                            {
                                $customer = \App\Models\User::where('id', $transaction->id_owner)->first();
                                $customerName = $customer->firstname.' '.$customer->lastname;
                                $code = $transaction->transaction_code;
                            }
                        @endphp
                        <tr id="{{ $transaction->id }}">
                            <td>{{ $code }}</td>
                            <td>{{ $customerName }}</td>
                            <td>Rp. {{ number_format($transaction->total, 0, ',', '.') }}</td>
                            <td>-</td>
                            <td>{{ $transaction->updated_at->format('d/m/y H:i:s') }}</td>
                            @if($owner->user_position != "sales")
                            <td>{{ $transaction->metode_pembayaran }}</td>
                            @endif
                            <td class="col-2">
                                <div class="col text-left">
                                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_report/transaction/sell/print_detail/'.$transaction->id.'/'.$type) }}')">
                                        <span><i class="fa fa-edit"></i>Print</span>
                                    </button>
                                    <button type="button" class="btn btn-link carousel" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="functionDetail({{ $transaction->id }})">
                                        <span><i class="fa fa-angle-down"></i></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        {{-- KHUSUS DISTRIBUTOR ADA 2 MACAM TRANSAKSI (KASIR+RESELLER BELI)--}}
                        @if($owner->user_position == "superadmin_distributor")
                        @foreach($transactions2 as $transaction)
                        @php
                            $type="kasir";
                            $customerName = $transaction->nama_pembeli;
                            $code = $transaction->transaction_code;
                        @endphp
                        <tr id="khusus{{ $transaction->id }}">
                            <td>{{ $code }}</td>
                            <td>{{ $customerName }}</td>
                            <td>Rp. {{ number_format($transaction->total, 0, ',', '.') }}</td>
                            @if($owner->user_position == "superadmin_distributor" || $owner->user_position == "reseller")
                            <td>Rp. {{ number_format($transaction->diskon, 0, ',', '.') }}</td>
                            @endif
                            <td>{{ $transaction->updated_at->format('d/m/y H:i:s') }}</td>
                            <td>{{ $transaction->metode_pembayaran }}</td>
                            <td class="col-2">
                                <div class="col text-left">
                                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_report/transaction/sell/print_detail/'.$transaction->id.'/'.$type) }}')">
                                        <span><i class="fa fa-edit"></i>Print</span>
                                    </button>
                                    <button type="button" class="btn btn-link carousel" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="functionDetail2({{ $transaction->id }})">
                                        <span><i class="fa fa-angle-down"></i></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <br>
                <h4>Total : Rp. <span id="totalAll"></span></h4>
            </div>
        </div>
    </div>
    </form>
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
    console.log("format");
    var transactions = {!! json_encode($transactions->toArray()) !!};
    var details = {!! json_encode($details->toArray()) !!};
    const indexTransaction = transactions.findIndex(item => item.id == id);

    let datas = [];
    var found = details.find(function (element) {
        if(element['id_transaction'] == id)
        {
            datas.push(element);
        }
    });
    
    // `d` is the original data object for the row
    $output=
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

function format2(d, id) {
    console.log("format");
    var transactions = {!! json_encode($transactions2->toArray()) !!};
    var details = {!! json_encode($details2->toArray()) !!};
    const indexTransaction = transactions.findIndex(item => item.id == id);

    let datas = [];
    var found = details.find(function (element) {
        if(element['id_transaction'] == id)
        {
            datas.push(element);
        }
    });
    
    // `d` is the original data object for the row
    $output=
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

function functionDetail2(id)
{
    var table=$('#logTable').DataTable();
    var id = id;
    var temp ="#khusus"
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

        row.child(format2(row.data(), id)).show();
        tr.addClass('shown');
    }
}

$(document).ready(function () {
    var table=$('#logTable').DataTable({
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
        url:'{{ url("/manage_report/transaction/sell/get_date") }}',
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

</script>
@endsection