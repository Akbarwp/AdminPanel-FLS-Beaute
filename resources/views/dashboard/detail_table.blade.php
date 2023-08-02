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
                            <div class="row d-flex ">
                                <div class="col-xl-5 form-group" style="text-align:left;">
                                    <h4 style="text-align:left;">Detail</h4>
                                </div>
                                <div class="col-xl-4">
                                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/dashboard/detail/export-detail/'.$user.'/'.$type) }}'">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span>Export</span>
                                    </button>
                                    <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/dashboard/detail/print-detail/'.$user.'/'.$type) }}')"><i
                                            class='fa fa-print'></i>
                                        <span>Print</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="row col-sm" style="font-size:18px; font-weight:bold">
                                @if($user == "distributor")
                                    Distributor
                                @elseif($user == "reseller")
                                    Reseller
                                @endif
                                 - 
                                @if($type == "stok")
                                    Available Stock
                                @elseif($type == "penjualan")
                                    Total Penjualan
                                @elseif($type == "retur")
                                    Total Retur
                                @endif
                            </div>
                            <hr>
                            <div class="table-responsive-xl" style="overflow: scroll; ">
                                <table
                                    class="table table-hover table-striped table-light display sortable  text-nowrap"
                                    cellspacing="0" id="myTable">
                                    <thead>
                                        <br>
                                        <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                            <th>Distributor</th>

                                            @if($user=="reseller")
                                            <th>Reseller</th>
                                            @endif

                                            @if($type=="stok")
                                            <th>Stok Available</th>
                                            @elseif($type=="penjualan")
                                            <th>Total Penjualan</th>
                                            @elseif($type=="retur")
                                            <th>Total Retur</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($datas as $data)
                                        <tr>
                                            @if($user=="reseller")
                                            @php
                                                $distributor = \App\Models\User::where('id_group', $data->id_group)->where('user_position', 'superadmin_distributor')->first();
                                            @endphp
                                            <td>{{ $distributor->firstname }} {{ $distributor->lastname }}</td>
                                            @endif

                                            <td>{{ $data->firstname }} {{ $data->lastname }}</td>

                                            @if($type=="stok")
                                            <td>{{ number_format($data->stok, 0, ',', '.') }} pcs</td>
                                            @elseif($type=="penjualan")
                                            <td>Rp {{ number_format($data->totalPenjualan, 0, ',', '.') }}</td>
                                            @elseif($type=="retur")
                                            <td>Rp {{ number_format($data->totalRetur, 0, ',', '.') }}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

</script>
@endsection