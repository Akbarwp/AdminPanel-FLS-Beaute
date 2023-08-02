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
                                    <h4 style="text-align:left;">Setting Sales</h4>
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
                                                <th>Bonus</th>
                                                <th>Harga Jual</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($products as $product)
                                            <tr>
                                                <td>{{ $product->product_type->nama_produk }}</td>
                                                <td>{{ number_format($product->bonus, 0, ',', '.') }} %</td>
                                                <td>Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-warning btn-edit" data-toggle='modal' href="'"
                                                        data-target="#editBonus" data-edit="{{ $product->id }}">
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
    <div class="modal fade" id="editBonus" role="dialog" style="border-radius:45px">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form action="{{ url('/sales/setting_bonus/update') }}" method="post" enctype="multipart/form-data" name="update_form">

                    <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
                        <p id="employeeidname" style="font-weight: bold;">Edit Bonus dan Harga Jual Barang</p>
                        <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                    </div>

                    <div class="modal-body">
                        @csrf
                        <div class="col-12" hidden="">
                            <input type="text" name="id">
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Produk</div>
                            <div class="col-1">:</div>
                            <input type="text" name="nama_produk" class="form form-control col-6" readonly>
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Bonus (%)</div>
                            <div class="col-1">:</div>
                            <input type="number" name="bonus" class="form form-control col-6">
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Harga Jual</div>
                            <div class="col-1">:</div>
                            <input type="number" name="harga_jual" class="form form-control col-6">
                        </div>
                        <hr>
                        <div class="row text-right">
                            <div class="col-12">
                                <button class="btn btn-primary text-right" onclick="" style="text-align:left" type="submit">
                                    <a style="color: white;">
                                        Edit
                                </a>
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
        url: "{{ url('/sales/setting_bonus/edit') }}/" + data_edit,
        success:function(response)
        {
        $('input[name=id]').val(response.product.id);
        $('input[name=nama_produk]').val(response.type.nama_produk);
        $('input[name=bonus]').val(response.product.bonus);
        $('input[name=harga_jual]').val(response.product.harga_jual);
        validator.resetForm();
        }
    });
});
</script>
@endsection