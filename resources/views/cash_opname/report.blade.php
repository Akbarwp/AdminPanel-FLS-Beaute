@extends('templates/main')

@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="mt-3">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <div class="container">
                                <div class="row d-flex">
                                    <div class="col-xl-5 form-group" style="text-align:left;">
                                        <h4 style="text-align:left;">Laporan Open Close Cast</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-12 grid-margin ">
                                <div class="iq-card">
                                    <div class="iq-card-body">
                                        <div class="table-responsive-xl" style="overflow: scroll;">
                                            <table
                                                class="table table-hover table-striped table-light display sortable text-nowrap"
                                                cellspacing="0" id="myTable">
                                                <thead>
                                                    <br>
                                                    <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Nama Distributor</th>
                                                        <th>Open Cash</th>
                                                        <th>Total Transaksi</th>
                                                        <th>Close cash</th>
                                                        <th>Selisih</th>
                                                        <th>Keterangan</th>
                                                        {{-- <th></th> --}}
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($opnames as $key => $opname)
                                                        @php
                                                            if (!$opname->cash_akhir) {
                                                                $keterangan = 'Belum ditutup';
                                                            } elseif ($opname->cash_akhir > $opname->total_transaksi) {
                                                                $keterangan = "Untung Rp. $opname->selisih";
                                                            } elseif ($opname->cash_akhir < $opname->total_transaksi) {
                                                                $keterangan = "Rugi Rp. $opname->selisih";
                                                            } else {
                                                                $keterangan = 'Break-even point';
                                                            }
                                                            
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ date('d / M / Y', strtotime($opname->created_at)) }}</td>
                                                            <td>{{ $opname->nama_distributor }}</td>
                                                            <td>{{ $opname->cash_awal }}</td>
                                                            <td>{{ $opname->total_transaksi }}</td>
                                                            <td>{{ $opname->cash_akhir }}</td>
                                                            <td>{{ $opname->selisih }}</td>
                                                            <td>{{ $keterangan }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div>
                                            </div>
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
                $(document).ready(function() {
                    $('#myTable').DataTable({
                        "oSearch": {
                            "bSmart": false,
                            "bRegex": true
                        },
                    });
                });
            </script>
        @endsection
