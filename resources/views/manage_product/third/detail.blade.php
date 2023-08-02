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
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-4" style="text-align:left;">
                                    <h4 style="text-align:left;">Daftar Barang Reseller</h4>
                                </div>
                                <div class="col-sm" style="text-align:left;">
                                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/manage_product/distributor_reseller/export/'.$distributor->id) }}'">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span>Export</span>
                                    </button>
                                    <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_product/distributor_reseller/print/'.$distributor->id) }}')">
                                        <i class='fa fa-print'></i>Print</button>
                                </div>
                                <!-- <div class="col-sm text-right">
                                    <button type="button" class="btn btn-primary"
                                        onclick="location.href='kelolaBarang_daftarBarangResellerAdd.php'">
                                        <span>+ Add</span>
                                    </button>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <hr>

                    @if($resellers->count())

                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-12 grid-margin ">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                <div class="col-12">
                                    <p style="font-size:20px; font-weight:bold">Reseller {{ $distributor->firstname }} {{ $distributor->lastname }}</p>
                                </div>
                                    <div class="table-responsive-xl" style="overflow: scroll; ">
                                        <table
                                            class="table table-hover table-striped table-light display sortable"
                                            cellspacing="0" id="myTable">
                                            <thead>
                                                <br>
                                                <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                    <th>Aksi</th>
                                                    <th>ID</th>
                                                    <th>Nama Reseller</th>
                                                    <th>Alamat</th>
                                                    <th>Kota</th>
                                                    <th>Waktu Join</th>
                                                    <th>Stock Produk</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($resellers as $reseller)
                                                    <tr>
                                                        <td>
                                                            <button type="button" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/manage_product/distributor_reseller/products/chart/'.$reseller->id) }}'" class="btn btn-primary">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        </td>
                                                        <td>{{ $reseller->id }}</td>
                                                        <td>{{ $reseller->firstname }} {{ $reseller->lastname }}</td>
                                                        <td>{{ $reseller->address }}</td>
                                                        <td>{{ $reseller->city->name }}</td>
                                                        <td>{{ $reseller->created_at->format('j F Y') }}</td>
                                                        <td>{{ number_format($reseller->stock, 0, ',', '.') }} pcs</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <p class="text-center fs-4">No reseller found</p>
                    @endif

                    <!-- Modal Remove Account -->
                    <div class="modal fade" id="mmMyModal" role="dialog" style="border-radius:45px">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
                                <p id="employeeidname" style="font-weight: bold;">DeusCode</p>
                                <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                            </div>

                            <div class="modal-body">
                                <button id="btnModalBiodata" onclick="msuccess('remove')" style="text-align:left">
                                    <a style="color: rgba(3, 15, 39, 1);">
                                        <i class='fas fa-edit'></i>&nbspRemove Akun</a></button>
                                <hr>
                                
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
$(document).ready(function(){
    $('#myTable').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
});
</script>
@endsection