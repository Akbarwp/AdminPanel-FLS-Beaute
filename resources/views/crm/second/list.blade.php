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
                                    <h4 style="text-align:left;">
                                        @if(auth()->user()->id_group == 1)
                                        CRM Distributor Dashboard
                                        @elseif(auth()->user()->user_position != "reseller")
                                        CRM Reseller Dashboard
                                        @endif
                                    </h4>
                                </div>
                                <div class="col-sm" style="text-align:left;">
                                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/list/export') }}'">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span>Export</span>
                                    </button>
                                    
                                    <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/crm/list/print') }}')"><i class='fa fa-print'></i>
                                    Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    
                    {{-- <div class="row d-flex justify-content-end align-items-center form-group">

                        <div class="col-4">
                            <select class="form-control"
                                style="border-radius:15px; height:45px; background-color:rgb(52,25,80); color:white">
                                <option value="department">Cluster</option>
                                <option value="clusterA">Cluster A</option>
                                <option value="clusterB">Cluster B</option>
                                <option value="clusterC">Cluster C</option>
                            </select>
                        </div>
                    </div> --}}

                    <div class="row d-flex justify-content-center align-items-center">  
                        <div class="col-12 grid-margin ">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    @if(auth()->user()->id_group == 1 && auth()->user()->user_position == "superadmin_pabrik")
                                    <div class="row ">
                                        <div class="col-3">
                                            <b>Reset Point All Distributor</b>
                                        </div>
                                        <div class="col-1">
                                            :
                                        </div>
                                        <div class="col-3">
                                            <button class="btn btn-danger" style="background-color:rgba(165,78,182); color:whitesmoke" data-toggle='modal'
                                                data-target="#modalreset">RESET</button>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="table-responsive-xl" style="overflow: scroll; ">  
                                        <table class="table table-hover table-striped table-light display sortable  text-nowrap" cellspacing="0"  id="myTable" >
                                            <thead>
                                                <br>
                                                <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                    <th >ID</th>
                                                    @if(auth()->user()->id_group == 1)
                                                    <th >Distributor</th>
                                                    @elseif(auth()->user()->user_position != "reseller")
                                                    <th >Reseller</th>
                                                    @endif
                                                    <th>Point</th>
                                                    <th >Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($lists as $list)
                                                <tr>
                                                    <td>{{ $list->id }}</td>
                                                    <td>{{ $list->firstname }} {{ $list->lastname }}</td>
                                                    <td>{{ number_format($list->crm_poin, 0, ',', '.') }}</td>
                                                    <td><button class="btn btn-primary btn-sm" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/omzet/'.$list->id) }}'"><i class="fa fa-eye"></button></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    <div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Reset -->
                    <div class="modal fade" id="modalreset" role="dialog" style="border-radius:45px">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
                                    <p id="employeeidname" style="font-weight: bold;">Konfirmasi Menghapus Seluruh Point Distributor</p>
                                    <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <h6><b>Apakah Anda Yakin Untuk Reset Semua Point Distributor?</b></h6>
                                            </div>
                                            
                                        </div>
                                        <br>
                                        <div class="row d-flex justify-content-center align-items-right">
                                            <div class="btn-action" >
                                                <label class="btn-danger d-flex justify-content-center align-items-center" style="height:35px; width:100px" onclick="location.href='{{ url('/crm/reset_poin/distributor') }}'">
                                                    Accept
                                                </label>
                                            </div>
                                            &nbsp&nbsp
                                            <div class="btn-action" >
                                                <label class="btn-secondary d-flex justify-content-center align-items-center" style="height:35px; width:100px" data-dismiss="modal">
                                                    Cancel
                                                </label>
                                            </div>
                                        </div>
                                    </div>
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
@if ($message = Session::get('reset_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

$(document).ready(function(){
    $('#myTable').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
});
</script>
@endsection