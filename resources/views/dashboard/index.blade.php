@extends('templates/main')

@section('css')

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="mt-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between">
                        <div class="container">
                            <div class="row d-flex">
                                <div class="col-xl-5 form-group" style="text-align:left;">
                                    <h4 style="text-align:left;">Dashboard</h4>
                                </div>
                                {{-- <div class="col-xl-4">
                                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/dashboard/export/') }}'">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span>Export</span>
                                    </button>
                                    <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/dashboard/print/') }}')"><i
                                            class='fa fa-print'></i>
                                        <span>Print</span>
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <hr>
                    <!-- trial 2 sofbox -->
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                                <div class="iq-card-body pb-0">
                                <div class="rounded-square form-group text-center" style="background-color:rgba(165,78,182); color:whitesmoke; font-size:15px; font-weight:bold; border-radius:5px">Total Omset Bulanan</div>
                                
                                <div class="clearfix"></div>
                                <div class="text-center">
                                    <h2 class="mb-0"><i class="ri-arrow-up-line text-success mr-1"></i><span class="">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</span><span></span></h2><br>
                                </div>
                                </div>
                                <div id="chart-1"></div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                                <div class="iq-card-body pb-0">
                                <div class="rounded-square form-group text-center" style="background-color:rgba(165,78,182); color:whitesmoke; font-size:15px; font-weight:bold; border-radius:5px">Total Transaksi Penjualan</div>
                                
                                <div class="clearfix"></div>
                                <div class="text-center">
                                    <h2 class="mb-0"><span class="counter">{{ number_format($totalTransPenjualan, 0, ',', '.') }}</span><span></span></h2><br>
                                </div>
                                </div>
                                <div id="chart-1"><br><br></div>
                            </div>
                        </div>
                        
                        {{-- @if(auth()->user()->user_position != "sales")
                        <div class="col-md-6 col-lg-4">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                                <div class="iq-card-body pb-0">
                                <div class="rounded-square form-group text-center" style="background-color:rgba(165,78,182); color:whitesmoke; font-size:15px; font-weight:bold; border-radius:5px">Transaksi Pembelian</div>
                                
                                <div class="clearfix"></div>
                                <div class="text-center">
                                    <h2 class="mb-0"><span class="counter">{{ number_format($stokPembelian, 0, ',', '.') }} pcs</span></h2>
                                </div>
                                <div class="text-center">
                                    <br>
                                    <p class="mb-0 text-secondary line-height"><i class="ri-arrow-down-line text-danger mr-1"></i><span class="text-success">Rp {{ number_format($totalPembelian, 0, ',', '.') }}</span></p>
                                </div>
                                </div>
                                <div id="chart-3"></div>
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 col-lg-4">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                                <div class="iq-card-body pb-0">
                                <div class="rounded-square form-group text-center" style="background-color:rgba(165,78,182); color:whitesmoke; font-size:15px; font-weight:bold; border-radius:5px">Pengambilan Kosmetik</div>
                                
                                <div class="clearfix"></div>
                                <div class="text-center">
                                    <h2 class="mb-0"><span class="counter">{{ number_format($stokPengambilan, 0, ',', '.') }} pcs</span></h2>
                                </div>
                                <div class="text-center">
                                    <br>
                                    <p class="mb-0 text-secondary line-height"><i class="ri-arrow-down-line text-danger mr-1"></i><span class="text-success">Rp {{ number_format($totalPengambilan, 0, ',', '.') }}</span></p>
                                </div>
                                </div>
                                <div id="chart-3"></div>
                            </div>
                        </div>
                        @endif --}}

                        {{-- @if(auth()->user()->id_group != 1) --}}
                        <div class="col-md-6 col-lg-4">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                                <div class="iq-card-body pb-0">
                                <div class="rounded-square form-group text-center" style="background-color:rgba(165,78,182); color:whitesmoke; font-size:15px; font-weight:bold; border-radius:5px">Retur</div>
                                
                                <div class="clearfix"></div>
                                <div class="text-center">
                                    <h2 class="mb-0"><span class="counter">{{ number_format($totalTransRetur, 0, ',', '.') }}</span></h2>
                                </div>
                                {{-- <div class="text-center">
                                    <br>
                                    <p class="mb-0 text-secondary line-height"><i class="ri-arrow-down-line text-danger mr-1"></i><span class="text-success">Rp {{ number_format($totalRetur, 0, ',', '.') }}</span></p>
                                </div> --}}
                                </div>
                                <div id="chart-3"></div>
                            </div>
                        </div>
                        {{-- @endif --}}
                    </div>

                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="row col-sm" style="font-size:18px; font-weight:bold">
                                Available Stock
                            </div>
                            <hr>
                            <div class="col-xl-12" style="font-size:14px;">
                                <div class="row">
                                    <div class="col-xl-7" style="font-weight:600">
                                        Total Stock Cosmetik:
                                    </div>
                                    <div class="col-xl-5">
                                        {{ number_format($stok, 0, ',', '.') }} pcs
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive-xl" style="overflow: scroll; ">
                                <table
                                    class="table table-hover table-striped table-light display sortable  text-nowrap"
                                    cellspacing="0" id="myTable">
                                    <thead>
                                        <br>
                                        <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                            <th>Barang</th>
                                            <th>Stok</th>
                                            <th>Nilai Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->nama_produk }}</td>
                                            <td>{{ number_format($product->stok, 0, ',', '.') }} pcs</td>
                                            <td>Rp {{ number_format($product->stok*$product->harga_modal, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- @if(auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") --}}
                    <!-- DISTRIBUTOR + RESELLER -->
                    @php
                        $MAXSHOW = 3;
                    @endphp

                    <div class="row">
                        {{-- @if(auth()->user()->id_group == 1)
                        <div class="col-12">
                        @else --}}
                        <div class="col-12">
                        {{-- @endif --}}
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="row col-sm" style="font-size:18px; font-weight:bold; margin-bottom: 20px">
                                        Riwayat Penjualan
                                    </div>
                                <div class="row align-items-center">
                                        <div class="col-md-5 text-left">
                                            <div class="input-group form-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                                                </div>
                                                <input class="form-control form-control-sm" id="minPjl" name="minPjl" placeholder="Tanggal Awal" type="text" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-left">
                                            <div class="input-group form-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                                                </div>
                                                <input class="form-control form-control-sm" id="maxPjl" name="maxPjl" placeholder="Tanggal Akhir" type="text" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" type="button" id="searchPenjualan">Cari</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col text-left">
                                        
                                    </div>
                                    <div class="col text-left" id="logTableDiv">
                                        <table id="logTablePjl" class="table table-hover table-light">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Kode Transaksi</th>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Total</th>
                                                    {{-- @if($ownerPjl->user_position == "superadmin_distributor" || $ownerPjl->user_position == "reseller") --}}
                                                    <th scope="col">Diskon</th>
                                                    {{-- @endif --}}
                                                    <th scope="col">Tanggal</th>
                                                    @if($ownerPjl->user_position != "sales")
                                                    <th scope="col">Metode Pembayaran</th>
                                                    @endif
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transactionsPjl as $transaction)
                                                @php
                                                    $type="beli";
                                                    if($ownerPjl->user_position == "sales")
                                                    {
                                                        $customerName = $transaction->nama_toko;
                                                        $code = $transaction->id;
                                                    }
                                                    else if($ownerPjl->user_position == "reseller")
                                                    {
                                                        $customerName = "Transaksi Kasir";
                                                        $code = $transaction->transaction_code;
                                                    }
                                                    else
                                                    {
                                                        $customer = \App\Models\User::where('id', $transaction->id_owner)->first();
                                                        // $customerName = $customer->firstname.' '.$customer->lastname;
                                                        $customerName = $transaction->nama_input;
                                                        $code = $transaction->transaction_code;
                                                    }
                                                @endphp
                                                <tr id="{{ $transaction->id }}">
                                                    <td>{{ $code }}</td>
                                                    <td>{{ $customerName }}</td>
                                                    <td>Rp. {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                                    <td>-</td>
                                                    <td>{{ $transaction->updated_at->format('d/m/y H:i:s') }}</td>
                                                    @if($ownerPjl->user_position != "sales")
                                                    <td>{{ $transaction->metode_pembayaran }}</td>
                                                    @endif
                                                    <td class="col-2">
                                                        <div class="col text-left">
                                                            <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_report/transaction/sell/print_detail/'.$transaction->id.'/'.$type) }}')">
                                                                <span><i class="fa fa-edit"></i>Print</span>
                                                            </button>
                                                            <button type="button" class="btn btn-link carousel" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="functionDetailPjl({{ $transaction->id }})">
                                                                <span><i class="fa fa-angle-down"></i></span>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                        
                                                {{-- KHUSUS DISTRIBUTOR ADA 2 MACAM TRANSAKSI (KASIR+RESELLER BELI)--}}
                                                @if($ownerPjl->user_position == "superadmin_distributor")
                                                @foreach($transactionsPjl2 as $transaction)
                                                @php
                                                    $type="kasir";
                                                    $customerName = $transaction->nama_pembeli;
                                                    $code = $transaction->transaction_code;
                                                @endphp
                                                <tr id="khusus{{ $transaction->id }}">
                                                    <td>{{ $code }}</td>
                                                    <td>{{ $customerName }}</td>
                                                    <td>Rp. {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                                    {{-- @if($ownerPjl->user_position == "superadmin_distributor" || $ownerPjl->user_position == "reseller") --}}
                                                    <td>Rp. {{ number_format($transaction->diskon, 0, ',', '.') }}</td>
                                                    {{-- @endif --}}
                                                    <td>{{ $transaction->updated_at->format('d/m/y H:i:s') }}</td>
                                                    <td>{{ $transaction->metode_pembayaran }}</td>
                                                    <td class="col-2">
                                                        <div class="col text-left">
                                                            <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_report/transaction/sell/print_detail/'.$transaction->id.'/'.$type) }}')">
                                                                <span><i class="fa fa-edit"></i>Print</span>
                                                            </button>
                                                            <button type="button" class="btn btn-link carousel" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="functionDetailPjl2({{ $transaction->id }})">
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
                                        <h4>Total : Rp. <span id="totalAllPjl"></span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- @if(auth()->user()->id_group == 1)
                        <div class="col-12">
                        @else --}}
                        <div class="col-12">
                        {{-- @endif --}}
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="row col-sm" style="font-size:18px; font-weight:bold; margin-bottom: 20px">
                                    Riwayat Pembelian
                                </div>
                            <div class="row align-items-center">
                                    <div class="col-md-5 text-left">
                                        <div class="input-group form-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                                            </div>
                                            <input class="form-control form-control-sm" id="minPbl" name="minPbl" placeholder="Tanggal Awal" type="text" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-left">
                                        <div class="input-group form-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                                            </div>
                                            <input class="form-control form-control-sm" id="maxPbl" name="maxPbl" placeholder="Tanggal Akhir" type="text" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <button class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" type="button" id="searchPembelian">Cari</button>
                                    </div>
                                </div>
                                <br>
                                <div class="col text-left">
                                    
                                </div>
                                <div class="col text-left" id="logTableDiv">
                                    <table id="logTablePbl" class="table table-hover table-light">
                                        <thead>
                                            <tr>
                                                <th scope="col">Kode Transaksi</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Metode Pembayaran</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transactionsPbl as $transaction)
                                            @php
                                                if($ownerPbl->user_position == "superadmin_pabrik")
                                                {
                                                    $code = $transaction->kode_pasok;
                                                }
                                                else
                                                {
                                                    $code = $transaction->transaction_code;
                                                }
                                            @endphp
                                            <tr id="{{ $transaction->id }}">
                                                <td>{{ $code }}</td>
                                                <td>Rp. {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                                <td>{{ $transaction->updated_at->format('d/m/y H:i:s') }}</td>
                                                <td>{{ $transaction->metode_pembayaran }}</td>
                                                <td class="col-2">
                                                    <div class="col text-left">
                                                        @if($ownerPbl->user_position == "superadmin_pabrik")
                                                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_report/transaction/buy/print_detail/'.$transaction->id.'/pasok') }}')">
                                                            <span><i class="fa fa-edit"></i>Print</span>
                                                        </button>
                                                        @else
                                                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_report/transaction/buy/print_detail/'.$transaction->id.'/beli') }}')">
                                                            <span><i class="fa fa-edit"></i>Print</span>
                                                        </button>
                                                        @endif
                                                        <button type="button" class="btn btn-link carousel" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="functionDetailPbl({{ $transaction->id }})">
                                                            <span><i class="fa fa-angle-down"></i></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <h4>Total : Rp. <span id="totalAllPbl"></span></h4>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                    {{-- @endif --}}
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

    // RIWAYAT PENJUALAN
    function formatPjl(d, id) {
        console.log("formatPjl");
        var transactions = {!! json_encode($transactionsPjl->toArray()) !!};
        var details = {!! json_encode($detailsPjl->toArray()) !!};
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

    function functionDetailPjl(id)
    {
        var table=$('#logTablePjl').DataTable();
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

            row.child(formatPjl(row.data(), id)).show();
            tr.addClass('shown');
        }
    }

    function formatPjl2(d, id) {
        console.log("formatPjl");
        var transactions = {!! json_encode($transactionsPjl2->toArray()) !!};
        var details = {!! json_encode($detailsPjl2->toArray()) !!};
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

    function functionDetailPjl2(id)
    {
        var table=$('#logTablePjl').DataTable();
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

            row.child(formatPjl2(row.data(), id)).show();
            tr.addClass('shown');
        }
    }

    $(document).ready(function () {
        var table=$('#logTablePjl').DataTable({
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
                $("#totalAllPjl").html(number_format(pageTotal, 0, ',', '.'));
            },
        });
        var date_input_min = $('input[name="minPjl"]'); //our date input has the name "date"
        var date_input_max = $('input[name="maxPjl"]'); //our date input has the name "date"
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

    $('#searchPenjualan').click(function () {
        var min = document.getElementById("minPjl").value;
        var max = document.getElementById("maxPjl").value;
        
        $.ajax({
            type:'get',
            url:'{{ url("/dashboard/penjualan") }}',
            data: {
                "_token": "{{ csrf_token() }}",
                min:min,
                max:max
            },
            success:function(data) {
                //console.log(data);
                document.getElementById("logTableDiv").innerHTML = data;
                $('#logTablePjl').DataTable(
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
                        $("#totalAllPjl").html(number_format(pageTotal, 0, ',', '.'));
                    },
                });
            },
            error: function(data){
                console.log(data);
            }
        });
    });

    // RIWAYAT PEMBELIAN
    function formatPbl(d, id) {
        console.log("formatPbl");
        var transactions = {!! json_encode($transactionsPbl->toArray()) !!};
        var details = {!! json_encode($detailsPbl->toArray()) !!};
        const indexTransaction = transactions.findIndex(item => item.id == id);

        let datas = [];
        var found = details.find(function (element) {
            if("{{ auth()->user()->id_group }}" == "1")
            {
                if(element['id_supply'] == id)
                {
                    datas.push(element);
                }
            }
            else
            {
                if(element['id_transaction'] == id)
                {
                    datas.push(element);
                }
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

    function functionDetailPbl(id)
    {
        var table=$('#logTablePbl').DataTable();
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

            row.child(formatPbl(row.data(), id)).show();
            tr.addClass('shown');
        }
    }

    $(document).ready(function () {
        var table=$('#logTablePbl').DataTable({
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
                    .column(1)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
    
                // Total over this page
                pageTotal = api
                    .column(1, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
    
                // Update footer
                $("#totalAllPbl").html(number_format(pageTotal, 0, ',', '.'));
            },
        });
        var date_input_min = $('input[name="minPbl"]'); //our date input has the name "date"
        var date_input_max = $('input[name="maxPbl"]'); //our date input has the name "date"
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

    $('#searchPembelian').click(function () {
        console.log("search");
        var min = document.getElementById("minPbl").value;
        var max = document.getElementById("maxPbl").value;
        
        $.ajax({
            type:'get',
            url:'{{ url("/dashboard/pembelian") }}',
            data: {
                "_token": "{{ csrf_token() }}",
                min:min,
                max:max        
            },
            success:function(data) {
                //console.log(data);
                console.log("berhasil");
                document.getElementById("logTableDiv").innerHTML = data;
                $('#logTablePbl').DataTable(
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
                            .column(1)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
            
                        // Total over this page
                        pageTotal = api
                            .column(1, { page: 'current' })
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
            
                        // Update footer
                        $("#totalAllPbl").html(number_format(pageTotal, 0, ',', '.'));
                    },
                });
            },
            error: function(data){
                console.log("gagal");

                console.log(data);
            }
        });
    });

</script>
@endsection