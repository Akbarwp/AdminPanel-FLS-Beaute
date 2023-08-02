@extends('templates/main')

@section('css')

@endsection

@section('content')
<div class="container justify text-center">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between">
            <div class="container">
                <!-- <div class="row d-flex justify-content-between"> -->
                <div class="row d-flex ">
                    <div class="col-sm">
                        <h4 style="text-align:left;">List Distributor</h4>
                    </div>
                    <div class="col-sm">
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/sales/list_distributor/export') }}'">
                            <i class="fa fa-file-pdf-o"></i>
                            <span>Export</span></button>
                        <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/sales/list_distributor/print') }}')">
                        <i class='fa fa-print'></i>Print</button>
                    </div>
                    <div class="col-md-3 text-left">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="iq-card">
        <div class="iq-card-body">
            <table id="mytable" class="table table-hover table-striped table-light" style="text-align:left">
                <thead>
                    <tr>
                        <th scope="col">Id Distributor</th>
                        <th scope="col">Nama Distributor</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($distributors as $distributor)
                        <tr>
                            <td>{{ $distributor->id }}</td>
                            <td>{{ $distributor->firstname }} {{ $distributor->lastname }}</td>
                            <td><button class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke"
                                    onclick="location.href='{{ url('/sales/index/'.$distributor->id_group) }}'"><i
                                        class="fa fa-eye"></i></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function () {
    $('#mytable').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
});
</script>
@endsection