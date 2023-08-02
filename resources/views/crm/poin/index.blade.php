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
                                    <h4 style="text-align:left;">Poin Per Barang</h4>
                                </div>
                                <div class="col-md-5">
                                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/poin/export-poin') }}'">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span>Export</span>
                                    </button>
                                    <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/crm/poin/print-poin') }}')"><i
                                            class='fa fa-print'></i>
                                        Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <table class="table table-hover table-striped table-light display sortable" cellspacing="0" id="tableSales">
                                        <thead>
                                            <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                <th>Produk</th>
                                                <th>Point Distributor</th>
                                                <th>Point Distributor-Reseller</th>
                                                <th>Point Reseller</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($poins as $poin)
                                            <tr>
                                                <td>{{ $poin->product_type->nama_produk }}</td>
                                                <td>{{ $poin->distributor_jual }}</td>
                                                <td>{{ $poin->distributor_reseller_jual }}</td>
                                                <td>{{ $poin->reseller_jual }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-warning btn-edit" data-toggle='modal'
                                                        data-target="#editPoin" data-edit="{{ $poin->id }}">
                                                        <span><i class="fa fa-edit"></i>Edit</span>
                                                    </button>
                                                </td>
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
</div>


    <!-- Modal edit detail sales -->
    <div class="modal fade" id="editPoin" role="dialog" style="border-radius:45px">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form action="{{ url('/crm/poin/update') }}" method="post" enctype="multipart/form-data" name="update_form">
                    <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
                        <p id="employeeidname" style="font-weight: bold;">Edit Point Daftar Barang</p>
                        <button type="button" class="close" data-dismiss="modal" style="background-color:rgba(165,78,182); color:whitesmoke">×</button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="col-12" hidden="">
                            <input type="text" name="id">
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Produk</div>
                            <div class="col-1">:</div>
                            <input type="text" class="form form-control col-6" readonly value="PARFUM ASTANA 123" name="nama_produk">
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Point Distributor</div>
                            <div class="col-1">:</div>
                            <input type="number" class="form form-control col-6" name="distributor_jual">
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Point Distributor-Reseller</div>
                            <div class="col-1">:</div>
                            <input type="number" class="form form-control col-6" name="distributor_reseller_jual">
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Point Reseller</div>
                            <div class="col-1">:</div>
                            <input type="number" class="form form-control col-6" name="reseller_jual">
                        </div>
                        <div class="row text-right">
                            <div class="col-12">
                                <button class="btn btn-primary text-right" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="" style="text-align:left" type="submit">
                                    <a style="color: white;">Edit</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
@if ($message = Session::get('update_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

$(document).on('click', '.btn-edit', function(){
    var data_edit = $(this).attr('data-edit');
    $.ajax({
        method: "GET",
        url: "{{ url('/crm/poin/edit') }}/" + data_edit,
        success:function(response)
        {
        $('input[name=id]').val(response.poin.id);
        $('input[name=nama_produk]').val(response.type.nama_produk);
        $('input[name=distributor_jual]').val(response.poin.distributor_jual);
        $('input[name=distributor_reseller_jual]').val(response.poin.distributor_reseller_jual);
        $('input[name=reseller_jual]').val(response.poin.reseller_jual);
        validator.resetForm();
        }
    });
});
</script>
@endsection