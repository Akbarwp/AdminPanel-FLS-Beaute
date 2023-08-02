@extends('templates/main')

@section('css')

@endsection

@section('content')
<div class="container justify text-left">
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-sm">
                    <h4 style="text-align:left;">{{ $sales->firstname }} {{ $sales->lastname }}</h4>
                </div>
                <div class="col-sm">
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/sales/product/export/'.$sales->id) }}'">
                            <i class="fa fa-file-pdf-o"></i>
                            <span>Export</span></button>
                        <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/sales/product/print/'.$sales->id) }}')">
                        <i class='fa fa-print'></i>Print</button>
                    </div>
            </div>
        </div>
    </div>
    <hr>
    <br>
    <div class="row ">
        <div class="col" >
            <div class="iq-card">
                <div class="iq-card-body">
                    <div class="row">
                        <div class="col-8">
                            <h4>Stock Sales - {{ $sales->firstname }} {{ $sales->lastname }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @if(auth()->user()->user_position != "sales" && auth()->user()->id_group != 1)
                            <button class="btn btn-primary " style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url( '/sales/product/create/stok/'.$sales->id) }}'" style="text-align:left; background-color:rgba(52, 25, 80, 1);">
                                <a style="color: white;">
                                    + Add Stock
                                </a>
                            </button>
                            @endif
                            <button class="btn btn-primary " style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url( '/sales/history/'.$sales->id) }}'" >
                                <a style="color: white;">
                                    History Bonus
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive-xl">
                        <table
                            class="table table-hover table-striped table-light display sortable"
                            cellspacing="0" id="tableSales">
                            <thead>
                                <br>
                                <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Stock</th>
                                    <th>Harga Jual</th>
                                    @if(auth()->user()->user_position != "sales")
                                    <th>Harga Modal</th>
                                    <th>Bonus</th>
                                    <th>Aksi</th>
                                    @endif
                                    <th>History Barang</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->product_type->kode_produk }}</td>
                                    <td>{{ $product->product_type->nama_produk }}</td>
                                    <td>{{ number_format($product->stok, 0, ',', '.') }} pcs</td>
                                    <td>Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                                    @if(auth()->user()->user_position != "sales")
                                    <td>Rp {{ number_format($product->harga_modal, 0, ',', '.') }}</td>
                                    <td>{{ number_format($product->bonus_penjualan, 0, ',', '.') }} %</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit" data-toggle='modal' href="'"
                                        data-target="#editBarang" data-edit="{{ $product->id }}">
                                        <span><i class="fa fa-edit"></i>Edit</span>
                                        </button>
                                    </td>
                                    @endif
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" 
                                        onclick="location.href='{{ url('/sales/history-items/'.$product->id) }}'">
                                        <span><i class="fa fa-eye"></i>History Items</span>
                                        </button>
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
<!-- Modal edit detail sales -->
    <div class="modal fade" id="editBarang" role="dialog" style="border-radius:45px">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form action="{{ url('/sales/product/update') }}" method="post" enctype="multipart/form-data" name="update_form">

                    <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
                        <p id="employeeidname" style="font-weight: bold;">DeusCode</p>
                        <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                    </div>

                    <div class="modal-body">
                        @csrf
                        <div class="col-12" hidden="">
                            <input type="text" name="id">
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Barang</div>
                            <div class="col-1">:</div>
                            <input type="text" name="nama_produk" class="form form-control col-6" readonly>
                        </select>
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Stock</div>
                            <div class="col-1">:</div>
                            <input type="number" name="stok" class="form form-control col-6">
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Harga Jual</div>
                            <div class="col-1">:</div>
                            <input type="number" name="harga_jual" class="form form-control col-6">
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Harga Modal</div>
                            <div class="col-1">:</div>
                            <input type="number" name="harga_modal" class="form form-control col-6" readonly>
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Bonus</div>
                            <div class="col-1">:</div>
                            <input type="number" name="bonus" class="form form-control col-6" readonly>
                        </div>
                        <div class="row text-right">
                            <div class="col-12">
                                <button class="btn btn-primary text-right" onclick="" style="background-color:rgba(165,78,182); color:whitesmoke; text-align:left">
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
$(document).ready(function(){
    $('#tableSales').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
});

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
        url: "{{ url('/sales/product/edit/') }}/" + data_edit,
        success:function(response)
        {
        $('input[name=id]').val(response.product.id);
        $('input[name=nama_produk]').val(response.type.nama_produk);
        $('input[name=stok]').val(response.product.stok);
        $('input[name=bonus]').val(response.product.bonus_penjualan);
        $('input[name=harga_jual]').val(response.product.harga_jual);
        $('input[name=harga_modal]').val(response.product.harga_modal);
        validator.resetForm();
        }
    });
});
</script>
@endsection