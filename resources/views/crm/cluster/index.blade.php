@extends('templates/main')

@section('css')
<style>
    hr {
            border: none;
            height: 2px;
            color: #333;
            background-color: #333;
        }
</style>
@endsection

@section('content')
<div class="container justify text-center">

    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-sm">
                    <h4 style="text-align:left;">Cluster</h4>
                </div>
                <div class="col-md-5">
                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke">
                        <i class="fa fa-file-pdf-o"></i>
                        <span>Export</span>
                    </button>
                    <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/crm/cluster/print-cluster') }}')"><i
                            class='fa fa-print'></i>
                        Print</button>
                </div>
            </div>
        </div>
    </div>
    <hr>
<div class="row ">
    <div class="col">
            <div class="iq-card">
                <div class="iq-card-body">
                        <div class="row d-flex justify-content-between m-1">
                            <h4>Reward Distributor</h4>
                        </div>
                    <div class="table-responsive-xl">
                        <table
                            class="table table-hover table-striped table-light display sortable "
                            cellspacing="0" id="tableDistributor">
                            <thead>
                                <br>
                                <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                    <th>Cluster</th>
                                    <th>Discount</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>10%</td>
                                    <td>
                                        <button type='button' class='btn btn-edit' onclick="location.href='{{ url('/crm/cluster/edit/') }}'"  style='color: #FDBE33;'>
                                            <i class='fas fa-edit'></i>&nbspEdit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>8%</td>
                                    <td>
                                        <button type='button' class='btn btn-edit' onclick="location.href='{{ url('/crm/cluster/edit/') }}'"  style='color: #FDBE33;'>
                                            <i class='fas fa-edit'></i>&nbspEdit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>6%</td>
                                    <td>
                                        <button type='button' class='btn btn-edit' onclick="location.href='{{ url('/crm/cluster/edit/') }}'"  style='color: #FDBE33;'>
                                            <i class='fas fa-edit'></i>&nbspEdit</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="row ">
    <div class="col">
        <div class="iq-card">
            <div class="iq-card-body">
                    <div class="row d-flex justify-content-between m-1">
                        <h4>Reward Reseller</h4>
                    </div>
                <div class="table-responsive-xl">
                    <table
                        class="table table-hover table-striped table-light display sortable "
                        cellspacing="0" id="tableReseller">
                        <thead>
                            <br>
                            <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                <th>Cluster</th>
                                <th>Discount</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>A</td>
                                <td>10%</td>
                                <td>
                                    <button type='button' class='btn btn-edit' onclick="location.href='{{ url('/crm/cluster/edit/') }}'"  style="background-color:rgba(165,78,182); color:whitesmoke">
                                        <i class='fas fa-edit'></i>&nbspEdit</button>
                                </td>
                            </tr>
                            <tr>
                                <td>B</td>
                                <td>8%</td>
                                <td>
                                    <button type='button' class='btn btn-edit' onclick="location.href='{{ url('/crm/cluster/edit/') }}'"  style="background-color:rgba(165,78,182); color:whitesmoke">
                                        <i class='fas fa-edit'></i>&nbspEdit</button>
                                </td>
                            </tr>
                            <tr>
                                <td>C</td>
                                <td>6%</td>
                                <td>
                                    <button type='button' class='btn btn-edit'  onclick="location.href='{{ url('/crm/cluster/edit/') }}'"  style="background-color:rgba(165,78,182); color:whitesmoke">
                                        <i class='fas fa-edit'></i>&nbspEdit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
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
    // $('#myTable').DataTable();
    var table=$('#tableDistributor').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
});

$(document).ready(function(){
    // $('#myTable').DataTable();
    var table=$('#tableReseller').DataTable({
        "oSearch": { "bSmart": false, "bRegex": true },
    });
});
</script>
@endsection