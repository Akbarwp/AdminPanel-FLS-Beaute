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
                                            Daftar Barang Distributor
                                        @else
                                            Daftar Barang Reseller
                                        @endif
                                    </h4>
                                </div>
                                <div class="col-sm" style="text-align:left;">
                                    @if(auth()->user()->id_group == 1)
                                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/manage_product/distributor/export/') }}'">
                                            <i class="fa fa-file-pdf-o"></i>
                                            <span>Export</span></button>
                                        <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_product/distributor/print/') }}')">
                                            <i class='fa fa-print'></i>Print</button>
                                    @else
                                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/manage_product/reseller/export/') }}'">
                                            <i class="fa fa-file-pdf-o"></i>
                                            <span>Export</span></button>
                                        <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_product/reseller/print/') }}')">
                                            <i class='fa fa-print'></i>Print</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
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
                                                    @if(auth()->user()->id_group == 1)
                                                    <th>Distributor</th>
                                                    @else
                                                    <th>Reseller</th>
                                                    @endif
                                                    <th >Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($lists as $list)
                                                    <tr>
                                                        <td>{{ $list->id }}</td>
                                                        <td>{{ $list->firstname }} {{ $list->lastname }}</td>
                                                        <td>
                                                            @if(auth()->user()->id_group == 1)
                                                            <button class="btn btn-primary btn-sm" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/manage_product/distributor/products/'.$list->id) }}'">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                            @else
                                                            <button class="btn btn-primary btn-sm" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/manage_product/reseller/products/'.$list->id) }}'">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                            @endif
                                                        </td>
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
$(document).ready(function(){
    $('#myTable').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
});

</script>
@endsection