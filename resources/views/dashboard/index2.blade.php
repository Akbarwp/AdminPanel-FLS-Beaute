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
                                <div class="col-xl-4">
                                    <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/dashboard/export/') }}'">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span>Export</span>
                                    </button>
                                    <button type='button' class='btn btn-primary' onclick="window.open('{{ url('/dashboard/print/') }}')"><i
                                            class='fa fa-print'></i>
                                        <span>Print</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <!-- trial 2 sofbox -->
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                                <div class="iq-card-body pb-0">
                                <div class="rounded-square form-group iq-bg-primary text-center" style="font-size:15px; font-weight:bold; border-radius:5px">Penjualan Parfum</div>
                                
                                <div class="clearfix"></div>
                                <div class="text-center">
                                    <h2 class="mb-0"><span class="counter">{{ number_format($stokPenjualan, 0, ',', '.') }} pcs</span><span></span></h2><br>
                                    <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</span></p>
                                </div>
                                </div>
                                <div id="chart-1"><br><br></div>
                            </div>
                        </div>
                        
                        @if(auth()->user()->user_position != "sales")
                        <div class="col-md-6 col-lg-4">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                                <div class="iq-card-body pb-0">
                                <div class="rounded-square form-group iq-bg-primary text-center" style="font-size:15px; font-weight:bold; border-radius:5px">Pembelian Parfum</div>
                                
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
                                <div class="rounded-square form-group iq-bg-primary text-center" style="font-size:15px; font-weight:bold; border-radius:5px">Pengambilan Parfum</div>
                                
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
                        @endif

                        @if(auth()->user()->id_group != 1)
                        <div class="col-md-6 col-lg-4">
                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                                <div class="iq-card-body pb-0">
                                <div class="rounded-square form-group iq-bg-primary text-center" style="font-size:15px; font-weight:bold; border-radius:5px">Retur</div>
                                
                                <div class="clearfix"></div>
                                <div class="text-center">
                                    <h2 class="mb-0"><span class="counter">{{ number_format($stokRetur, 0, ',', '.') }} pcs</span></h2>
                                </div>
                                <div class="text-center">
                                    <br>
                                    <p class="mb-0 text-secondary line-height"><i class="ri-arrow-down-line text-danger mr-1"></i><span class="text-success">Rp {{ number_format($totalRetur, 0, ',', '.') }}</span></p>
                                </div>
                                </div>
                                <div id="chart-3"></div>
                            </div>
                        </div>
                        @endif
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
                                        Total Stock Parfum:
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

                    @if(auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales")
                    <!-- DISTRIBUTOR + RESELLER -->
                    @php
                        $MAXSHOW = 3;
                    @endphp

                    <div class="row">
                        @if(auth()->user()->id_group == 1)
                        <div class="col-6">
                        @else
                        <div class="col-12">
                        @endif
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="row col-sm" style="font-size:18px; font-weight:bold">
                                        @if(auth()->user()->id_group == 1)
                                        Distributor
                                        @else
                                        Reseller
                                        @endif
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="" style="overflow: scroll; ">
                                                <table
                                                    class="table table-hover table-striped table-light display sortable  text-nowrap"
                                                    cellspacing="0" id="myTable">
                                                    <thead>
                                                        <br>
                                                        <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                            <th class="col-6">
                                                                @if(auth()->user()->id_group == 1)
                                                                Distributor
                                                                @else
                                                                Reseller
                                                                @endif
                                                            </th>
                                                            <th class="col-6">Stok Available</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @php
                                                            if(auth()->user()->id_group == 1)
                                                            {
                                                                $listStoks = $distributorStoks;
                                                            }
                                                            else
                                                            {
                                                                $listStoks = $resellerStoks;
                                                            }
                                                        @endphp
                                                        @foreach($listStoks as $listStok)
                                                        <tr>
                                                            <td class="col-6">{{ $listStok->firstname }} {{ $listStok->lastname }}</td>
                                                            <td class="col-6">{{ number_format($listStok->stok, 0, ',', '.') }} pcs</td>
                                                        </tr>
                                                        @endforeach
                                                        @php
                                                            if($listStoks->count() < $MAXSHOW)
                                                            {
                                                                $tambah = $MAXSHOW - $listStoks->count();
                                                                for($i = 1; $i<=$tambah; $i++)
                                                                {
                                                        @endphp
                                                                    <tr>
                                                                        <td colspan="2">empty</td>
                                                                    </tr>
                                                        @php
                                                                }
                                                            }
                                                        @endphp
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- button show more  -->
                                    @if(auth()->user()->id_group == 1)
                                    <div class="form-group text-right">
                                        <input type="button" class="btn btn-primary submit" onclick="location.href='{{ url('/dashboard/detail/distributor/stok') }}'" value="Show More">
                                    </div>
                                    @else
                                    <div class="form-group text-right">
                                        <input type="button" class="btn btn-primary submit" onclick="location.href='{{ url('/dashboard/detail/reseller/stok') }}'" value="Show More">
                                    </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="" style="overflow: scroll; ">
                                                <table
                                                    class="table table-hover table-striped table-light display sortable  text-nowrap"
                                                    cellspacing="0" id="myTable">
                                                    <thead>
                                                        <br>
                                                        <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                            <th class="col-6">
                                                                @if(auth()->user()->id_group == 1)
                                                                Distributor
                                                                @else
                                                                Reseller
                                                                @endif
                                                            </th>
                                                            <th class="col-6">Total Penjualan</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @php
                                                            if(auth()->user()->id_group == 1)
                                                            {
                                                                $listPenjualans = $distributorPenjualans;
                                                            }
                                                            else
                                                            {
                                                                $listPenjualans = $resellerPenjualans;
                                                            }
                                                        @endphp
                                                        @foreach($listPenjualans as $listPenjualan)
                                                        <tr>
                                                            <td class="col-6">{{ $listPenjualan->firstname }} {{ $listPenjualan->lastname }}</td>
                                                            <td class="col-6">Rp {{ number_format($listPenjualan->totalPenjualan, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @endforeach
                                                        @php
                                                            if($listPenjualans->count() < $MAXSHOW)
                                                            {
                                                                $tambah = $MAXSHOW - $listPenjualans->count();
                                                                for($i = 1; $i<=$tambah; $i++)
                                                                {
                                                        @endphp
                                                                    <tr>
                                                                        <td colspan="2">empty</td>
                                                                    </tr>
                                                        @php
                                                                }
                                                            }
                                                        @endphp
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <!-- button show more  -->
                                    @if(auth()->user()->id_group == 1)
                                    <div class="form-group text-right">
                                        <input type="button" class="btn btn-primary submit" onclick="location.href='{{ url('/dashboard/detail/distributor/penjualan') }}'" value="Show More">
                                    </div>
                                    @else
                                    <div class="form-group text-right">
                                        <input type="button" class="btn btn-primary submit" onclick="location.href='{{ url('/dashboard/detail/reseller/penjualan') }}'" value="Show More">
                                    </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="" style="overflow: scroll; ">
                                                <table
                                                    class="table table-hover table-striped table-light display sortable  text-nowrap"
                                                    cellspacing="0" id="myTable">
                                                    <thead>
                                                        <br>
                                                        <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                            <th class="col-6">
                                                                @if(auth()->user()->id_group == 1)
                                                                Distributor
                                                                @else
                                                                Reseller
                                                                @endif
                                                            </th>
                                                            <th class="col-6">Total Retur</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @php
                                                            if(auth()->user()->id_group == 1)
                                                            {
                                                                $listReturs = $distributorReturs;
                                                            }
                                                            else
                                                            {
                                                                $listReturs = $resellerReturs;
                                                            }
                                                        @endphp
                                                        @foreach($listReturs as $listRetur)
                                                        <tr>
                                                            <td class="col-6">{{ $listRetur->firstname }} {{ $listRetur->lastname }}</td>
                                                            <td class="col-6">Rp {{ number_format($listRetur->totalRetur, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @endforeach
                                                        @php
                                                            if($listReturs->count() < $MAXSHOW)
                                                            {
                                                                $tambah = $MAXSHOW - $listReturs->count();
                                                                for($i = 1; $i<=$tambah; $i++)
                                                                {
                                                        @endphp
                                                                    <tr>
                                                                        <td colspan="2">empty</td>
                                                                    </tr>
                                                        @php
                                                                }
                                                            }
                                                        @endphp
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- button show more  -->
                                    @if(auth()->user()->id_group == 1)
                                    <div class="form-group text-right">
                                        <input type="button" class="btn btn-primary submit" onclick="location.href='{{ url('/dashboard/detail/distributor/retur') }}'" value="Show More">
                                    </div>
                                    @else
                                    <div class="form-group text-right">
                                        <input type="button" class="btn btn-primary submit" onclick="location.href='{{ url('/dashboard/detail/reseller/retur') }}'" value="Show More">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->id_group == 1)
                        <div class="col-6">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="row col-sm" style="font-size:18px; font-weight:bold">
                                        Reseller
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="" style="overflow: scroll; ">
                                                <table
                                                    class="table table-hover table-striped table-light display sortable  text-nowrap"
                                                    cellspacing="0" id="myTable">
                                                    <thead>
                                                        <br>
                                                        <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                            <th class="col-4">Distributor</th>
                                                            <th class="col-4">Reseller</th>
                                                            <th class="col-4">Stok Available</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach($resellerStoks as $resellerStok)
                                                        @php
                                                            $distributor = \App\Models\User::where('id_group', $resellerStok->id_group)->where('user_position', 'superadmin_distributor')->first();                 
                                                        @endphp
                                                        <tr>
                                                            <td class="col-4">{{ $distributor->firstname }} {{ $distributor->lastname }}</td>
                                                            <td class="col-4">{{ $resellerStok->firstname }} {{ $resellerStok->lastname }}</td>
                                                            <td class="col-4">{{ number_format($resellerStok->stok, 0, ',', '.') }} pcs</td>
                                                        </tr>
                                                        @endforeach
                                                        @php
                                                            if($resellerStoks->count() < $MAXSHOW)
                                                            {
                                                                $tambah = $MAXSHOW - $resellerStoks->count();
                                                                for($i = 1; $i<=$tambah; $i++)
                                                                {
                                                        @endphp
                                                                    <tr>
                                                                        <td colspan="3">empty</td>
                                                                    </tr>
                                                        @php
                                                                }
                                                            }
                                                        @endphp
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                   <!-- button show more  -->
                                   <div class="form-group text-right">
                                        <input type="button" class="btn btn-primary submit" onclick="location.href='{{ url('/dashboard/detail/reseller/stok') }}'" value="Show More">
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="" style="overflow: scroll; ">
                                                <table
                                                    class="table table-hover table-striped table-light display sortable  text-nowrap"
                                                    cellspacing="0" id="myTable">
                                                    <thead>
                                                        <br>
                                                        <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                            <th class="col-4">Distributor</th>
                                                            <th class="col-4">Reseller</th>
                                                            <th class="col-4">Total Penjualan</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach($resellerPenjualans as $resellerPenjualan)
                                                        @php
                                                            $distributor = \App\Models\User::where('id_group', $resellerPenjualan->id_group)->where('user_position', 'superadmin_distributor')->first();
                                                        @endphp
                                                        <tr>
                                                            <td class="col-4">{{ $distributor->firstname }} {{ $distributor->lastname }}</td>
                                                            <td class="col-4">{{ $resellerPenjualan->firstname }} {{ $resellerPenjualan->lastname }}</td>
                                                            <td class="col-4">Rp {{ number_format($resellerPenjualan->totalPenjualan, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @endforeach
                                                        @php
                                                            if($resellerPenjualans->count() < $MAXSHOW)
                                                            {
                                                                $tambah = $MAXSHOW - $resellerPenjualans->count();
                                                                for($i = 1; $i<=$tambah; $i++)
                                                                {
                                                        @endphp
                                                                    <tr>
                                                                        <td colspan="3">empty</td>
                                                                    </tr>
                                                        @php
                                                                }
                                                            }
                                                        @endphp
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- button show more  -->
                                    <div class="form-group text-right">
                                        <input type="button" class="btn btn-primary submit" onclick="location.href='{{ url('/dashboard/detail/reseller/penjualan') }}'" value="Show More">
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="" style="overflow: scroll; ">
                                                <table
                                                    class="table table-hover table-striped table-light display sortable  text-nowrap"
                                                    cellspacing="0" id="myTable">
                                                    <thead>
                                                        <br>
                                                        <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                            <th class="col-4">Distributor</th>
                                                            <th class="col-4">Reseller</th>
                                                            <th class="col-4">Total Retur</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach($resellerReturs as $resellerRetur)
                                                        @php
                                                            $distributor = \App\Models\User::where('id_group', $resellerRetur->id_group)->where('user_position', 'superadmin_distributor')->first();
                                                        @endphp
                                                        <tr>
                                                            <td class="col-4">{{ $distributor->firstname }} {{ $distributor->lastname }}</td>
                                                            <td class="col-4">{{ $resellerRetur->firstname }} {{ $resellerRetur->lastname }}</td>
                                                            <td class="col-4">Rp {{ number_format($resellerRetur->totalRetur, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @endforeach
                                                        @php
                                                            if($resellerReturs->count() < $MAXSHOW)
                                                            {
                                                                $tambah = $MAXSHOW - $resellerReturs->count();
                                                                for($i = 1; $i<=$tambah; $i++)
                                                                {
                                                        @endphp
                                                                    <tr>
                                                                        <td colspan="3">empty</td>
                                                                    </tr>
                                                        @php
                                                                }
                                                            }
                                                        @endphp
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                     <!-- button show more  -->
                                     <div class="form-group text-right">
                                        <input type="button" class="btn btn-primary submit" onclick="location.href='{{ url('/dashboard/detail/reseller/retur') }}'" value="Show More">
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>

</script>
@endsection