@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="container justify text-center">
    <div class="row align-items-center">
        <div class="col-md-4 text-left">
            <h4>History Point - {{ $owner->firstname }} {{ $owner->lastname }}</h4>
        </div>
        <div class="col-md-5">
            <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/export-history/'.$owner->id) }}'">
                <i class="fa fa-file-pdf-o"></i>
                <span>Export</span>
            </button>
        
            <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/crm/print-history/'.$owner->id) }}')"><i
                    class='fa fa-print'></i>
                Print</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <div class="iq-card">
                <div class="iq-card-body ">
                    <table id="myTable" class="table text-left table-hover table-striped table-light"
                        id="myTable">
                        <thead>
                            <tr>
                                <th>Tanggal Claim</th>
                                <th>Point Keluar</th>
                                <th>Point Masuk</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($owner->user_position != "reseller" && $owner->user_position != "sales")
                            @foreach($resets as $history)
                                @php
                                    $total_reseller_beli = \App\Models\TransactionHistory::where('id_distributor', $owner->id)->where('status_pesanan', 1)->where('id_reset_poin_crm', $history->id)->sum('total_crm_poin_distributor');
                                    $total_sells = \App\Models\TransactionHistorySell::where('id_group', $owner->id_group)->where('id_reset_poin_crm_distributor', $history->id)->sum('total_crm_poin_distributor');
                                    $total_tracking = \App\Models\TrackingSalesHistory::where('id_group', $owner->id_group)->where('id_reset_poin_crm_distributor', $history->id)->sum('total_crm_poin_distributor');
                                    $totalMasuk = $total_reseller_beli + $total_sells + $total_tracking;

                                    $totalKeluar = \App\Models\CrmClaimRewardHistory::where('id_owner', $owner->id)->where('status', 1)->where('id_reset_poin_crm', $history->id)->sum('poin');
                                @endphp
                                <tr>
                                    <td>{{ $history->updated_at->format('d/m/y H:i:s') }}</td>
                                    <td>{{ number_format($totalKeluar, 0, ',', '.') }}</td>
                                    <td>{{ number_format($totalMasuk, 0, ',', '.') }}</td>
                                    <td>Reset Poin</td>
                                </tr>
                            @endforeach
                            @foreach($reseller_beli as $history)
                            <tr>
                                <td>{{ $history->updated_at->format('d/m/y H:i:s') }}</td>
                                <td>-</td>
                                <td>{{ number_format($history->crm_poin_distributor, 0, ',', '.') }}</td>
                                <td><b>Pembelian reseller</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                            @endforeach
                            @foreach($jual_kasir as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                <td>-</td>
                                <td>{{ number_format($history->crm_poin_distributor, 0, ',', '.') }}</td>
                                <td><b>Penjualan kasir</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                            @endforeach
                            @foreach($reseller_jual as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                <td>-</td>
                                <td>{{ number_format($history->crm_poin_distributor, 0, ',', '.') }}</td>
                                <td><b>Penjualan reseller</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                            @endforeach
                            @foreach($tracking_sales as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                <td>-</td>
                                <td>{{ number_format($history->crm_poin_distributor, 0, ',', '.') }}</td>
                                <td><b>Penjualan Tracking</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                            @endforeach
                            @endif

                            @if($owner->user_position == "reseller")
                            @foreach($resets as $history)
                                @php
                                    $totalMasuk = \App\Models\TransactionHistorySell::where('id_owner', $owner->id)->where('id_reset_poin_crm', $history->id)->sum('total_crm_poin_reseller');

                                    $totalKeluar = \App\Models\CrmClaimRewardHistory::where('id_owner', $owner->id)->where('status', 1)->where('id_reset_poin_crm', $history->id)->sum('poin');
                                @endphp
                                <tr>
                                    <td>{{ $history->updated_at->format('d/m/y H:i:s') }}</td>
                                    <td>{{ number_format($totalKeluar, 0, ',', '.') }}</td>
                                    <td>{{ number_format($totalMasuk, 0, ',', '.') }}</td>
                                    <td>Reset Poin</td>
                                </tr>
                            @endforeach
                            @foreach($jual_kasir as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                <td>-</td>
                                <td>{{ number_format($history->crm_poin_reseller, 0, ',', '.') }}</td>
                                <td><b>Penjualan kasir</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                            @endforeach
                            @endif

                            @if($owner->user_position == "sales")
                            @foreach($resets as $history)
                                @php
                                    $totalMasuk = \App\Models\TrackingSalesHistory::where('id_reseller', $owner->id)->where('id_reset_poin_crm', $history->id)->sum('total_crm_poin_sales');

                                    $totalKeluar = \App\Models\CrmClaimRewardHistory::where('id_owner', $owner->id)->where('status', 1)->where('id_reset_poin_crm', $history->id)->sum('poin');
                                @endphp
                                <tr>
                                    <td>{{ $history->updated_at->format('d/m/y H:i:s') }}</td>
                                    <td>{{ number_format($totalKeluar, 0, ',', '.') }}</td>
                                    <td>{{ number_format($totalMasuk, 0, ',', '.') }}</td>
                                    <td>Reset Poin</td>
                                </tr>
                            @endforeach
                            @foreach($jual_tracking as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/y H:i:s') }}</td>
                                <td>-</td>
                                <td>{{ number_format($history->crm_poin_sales, 0, ',', '.') }}</td>
                                <td><b>Penjualan Tracking</b> {{ $history->nama_produk }} sebanyak {{ number_format($history->jumlah, 0, ',', '.') }} pcs</td>
                            </tr>
                            @endforeach
                            @endif

                            @foreach($claim_reward_history as $history)
                            <tr>
                                <td>
                                    {{ $history->updated_at->format('d/m/y H:i:s') }}
                                </td>
                                <td>{{ number_format($history->poin, 0, ',', '.') }}</td>
                                <td>-</td>
                                <td><b>Claim</b> reward {{ $history->reward }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>
<script>
$(document).ready(function(){
    $.fn.dataTable.moment( 'DD/MM/YY HH:mm:ss' );

    $(document).ready(function(){
        $('#myTable').DataTable({   
            "oSearch": { "bSmart": false, "bRegex": true },
            "columnDefs": [{ "orderDataType": "date-time", "targets": [0] }],
            "order": [[ 0, "desc" ]],
        });
    });
});
</script>
@endsection