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
                                    <h4 style="text-align:left;">CRM Reseller Dashboard</h4>
                                </div>
                                <div class="col-sm" style="text-align:left;">
                                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/list_reseller/export/'.$id) }}'">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span>Export</span>
                                    </button>
                                    
                                    <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/crm/list_reseller/print/'.$id) }}')"><i class='fa fa-print'></i>
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
                                        <div class="row">
                                        </div>
                                        <div class="table-responsive-xl" style="overflow: scroll; ">  
                                            <table class="table table-hover table-striped table-light display sortable  text-nowrap" cellspacing="0"  id="myTable" >
                                                <thead>
                                                    <br>
                                                    <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                        <th >ID</th>
                                                        <th >Reseller</th>
                                                        <th >Point</th>
                                                        <th >Aksi</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($lists as $list)
                                                    <tr>
                                                        <td>{{ $list->id }}</td>
                                                        <td>{{ $list->firstname }} {{ $list->lastname }}</td>
                                                        <td>{{ number_format($list->crm_poin, 0, ',', '.') }}</td>
                                                        <td><button class="btn btn-primary btn-sm" onclick="location.href='{{ url('/crm/omzet/'.$list->id) }}'"><i class="fa fa-eye"></button></td>
                                                    </tr>
                                                    @endforeach
                                                    {{-- <tr>
                                                        <td>R123231</td>
                                                        <td>Reseller  1</td>
                                                        <td>100</td>
                                                        <td><button class="btn btn-primary btn-sm" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/list_reseller/omzet') }}'"><i class="fa fa-eye"></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td>R123231</td>
                                                        <td>Reseller  1</td>
                                                        <td>100</td>
                                                        <td><button class="btn btn-primary btn-sm" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/list_reseller/omzet') }}'"><i class="fa fa-eye"></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td>R123231</td>
                                                        <td>Reseller  1</td>
                                                        <td>100</td>
                                                        <td><button class="btn btn-primary btn-sm" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/list_reseller/omzet') }}'"><i class="fa fa-eye"></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td>R123231</td>
                                                        <td>Reseller  1</td>
                                                        <td>100</td>
                                                        <td><button class="btn btn-primary btn-sm" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/list_reseller/omzet') }}'"><i class="fa fa-eye"></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td>R123231</td>
                                                        <td>Reseller  1</td>
                                                        <td>100</td>
                                                        <td><button class="btn btn-primary btn-sm" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/list_reseller/omzet') }}'"><i class="fa fa-eye"></button></td>
                                                    </tr> --}}
                                                    
                                                </tbody>
                                            </table>
                                        <div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
                                    <button id="btnModalBiodata" onclick="msuccess('remove')" style="background-color:rgba(165,78,182); color:whitesmoke; text-align:left">
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