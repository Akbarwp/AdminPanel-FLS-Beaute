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
                                    <div class="col-md-3 text-left" style="text-align:left;">
                                        @canany('group_pusat')
                                            <h4 style="text-align:left;">Daftar Barang Pusat</h4>
                                        @endcan
                                        @can('group_distributor')
                                            <h4 style="text-align:left;">Daftar Barang Distributor</h4>
                                        @endcan
                                        @can('reseller')
                                            <h4 style="text-align:left;">Daftar Barang Reseller</h4>
                                        @endcan
                                    </div>
                                    <div class="col-md-6" style="text-align:center;">
                                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke"
                                            onclick="window.location.href='{{ url('/manage_product/export/' . auth()->user()->id) }}'">
                                            <i class="fa fa-file-pdf-o"></i>
                                            <span>Export</span>
                                        </button> 
                                         @if(auth()->user()->id_group == 1)
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importExcel" style="background-color:rgba(165,78,182); color:whitesmoke">
                                            <i class="fa fa-file-excel-o"></i>
                                            Import
                                        </button>
                                        @endif

                                        <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke"
                                            onclick="window.open('{{ url('/manage_product/print/' . auth()->user()->id) }}')"><i
                                                class='fa fa-print'></i>
                                            Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-12 grid-margin ">
                                <div class="iq-card">
                                    <div class="iq-card-body">
                                         @if (isset($errors)&& $errors->any())
                                            <div class="alert alert-danger">
                                                @foreach ($errors->all() as $error)
                                                {{$error}}<br>
                                                @endforeach
                                            </div>
                                        @endif 
                                        <div class="table-responsive-xl" style="overflow: scroll;">
                                            <table
                                                class="table table-hover table-striped table-light display sortable text-nowrap"
                                                cellspacing="0" id="myTable">
                                                <thead>
                                                    <br>
                                                    <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                        <th>ID</th>
                                                        <th>Barang</th>
                                                        <th>Kategori</th>
                                                        {{-- <th>Jenis Barang</th> --}}
                                                        <th>Lokasi Barang</th>
                                                        {{-- <th>Kualitas Barang</th> --}}
                                                        <th>Stok</th>
                                                        <th>Harga Jual</th>
                                                        <th>Harga Modal</th>
                                                        <th>Nilai Total</th>
                                                        <th>Keterangan</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($products as $product)
                                                        <tr>
                                                            <td>{{ $product->product_type->kode_produk }}</td>
                                                            <td>{{ $product->product_type->nama_produk }}</td>
                                                            <td>{{ $product->category->nama_kategori }}</td>
                                                            {{-- <td>{{ $product->product_type->jenis_barang }}</td> --}}
                                                            <td>{{ $product->lokasi_barang }}</td>
                                                            {{-- <td>{{ $product->product_type->kualitas_barang }}</td> --}}
                                                            <td>{{ number_format($product->stok, 0, ',', '.') }} pcs</td>
                                                            <td>Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                                            </td>
                                                            <td>Rp {{ number_format($product->harga_modal, 0, ',', '.') }}
                                                            </td>
                                                            <td>Rp
                                                                {{ number_format($product->stok * $product->harga_modal, 0, ',', '.') }}
                                                            </td>
                                                            <td>{{ $product->keterangan }}</td>
                                                            <td>
                                                                <button class="btn btn-primary btn-sm" style="background-color:rgba(165,78,182); color:whitesmoke"
                                                                    onclick="location.href='{{ url('/manage_product/products/' . $product->id) }}'">
                                                                    <span><i class="fa fa-eye"></i><span>
                                                                </button>

                                                                @if (auth()->user()->edit_barang == 1) 
                                                                    <button type="button" class="btn btn-sm btn-warning" style="background-color:rgba(165,78,182); color:whitesmoke"
                                                                        onclick="location.href='{{ url('/manage_product/products/' . $product->id . '/edit') }}'">
                                                                        <span><i class="fa fa-edit"></i>Edit</span>
                                                                    </button>
                                                                @endif

                                                                @if (auth()->user()->hapus_barang == 1)
                                                                    <button type="button" class="btn btn-sm btn-danger" style="background-color:rgba(165,78,182); color:whitesmoke"
                                                                        data-toggle="modal"
                                                                        data-target="#deleteDaftarbarang.{{ $product->id }}">
                                                                        <span><i class="fa fa-trash"></i>Delete</span>
                                                                    </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <!-- modal delete -->
                                                        <div class="modal fade" id="deleteDaftarbarang.{{ $product->id }}"
                                                            role="dialog" style="border-radius:45px">
                                                            <div class="modal-dialog">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header"
                                                                        style="background:rgba(52, 25, 80, 1); color:white;">
                                                                        <p id="employeeidname" style="font-weight: bold;">
                                                                            DELETE
                                                                            {{ $product->product_type->nama_produk }}</p>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal"
                                                                            style="color:white;">×</button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <div class="row text-center">
                                                                            <div class="col">
                                                                                Apakah Yakin Menghapus
                                                                                {{ $product->product_type->nama_produk }}?
                                                                            </div>

                                                                        </div>
                                                                        <br>
                                                                        {{-- <form action="{{ url('/manage_product/deleteProduct/'.$product->id) }}" method="get" style="text-align:left"> --}}
                                                                            {{-- @method('delete') --}}
                                                                            {{-- @csrf --}}
                                                                        <div class="row text-center">
                                                                            <div class="col">
                                                                                <button class="btn btn-secondary text-right"
                                                                                    data-dismiss="modal"
                                                                                    style="background-color:rgba(165,78,182); color:whitesmoke; text-align:left">
                                                                                    <a style="color: white;">Cancel</a>
                                                                                </button>
                                                                                <button class="btn btn-danger text-right" style="background-color:rgba(165,78,182); color:whitesmoke"
                                                                                    onclick="window.location.href='{{ url('/manage_product/deleteProduct/' . $product->id) }}'"
                                                                                    style="text-align:left">
                                                                                    <a style="color: white;">Delete</a>
                                                                                </button>

                                                                                {{-- <button type='submit' style="background-color:rgba(165,78,182); color:whitesmoke" class='btn btn-danger' style='color: #D17826;'>
                                                                                    <a style="color: white;">Delete</a></button>
                                                                                 --}}
                                                                            </div>
                                                                        </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
            <!-- Import Excel -->
            <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="post" action="{{route('products.import')}}" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                            </div>
                            <div class="modal-body">
                                {{ csrf_field() }}
                                <label>Pilih file excel</label>
                                <div class="form-group">
                                    <input type="file" name="import_excel" required="required">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @endsection

        @section('script')
            <script>
                @if ($message = Session::get('create_success'))
                    swal(
                        "Berhasil!",
                        "{{ $message }}",
                        "success"
                    );
                @endif

                @if ($message = Session::get('update_success'))
                    swal(
                        "Berhasil!",
                        "{{ $message }}",
                        "success"
                    );
                @endif

                @if ($message = Session::get('import_success'))
                    swal(
                        "Berhasil!",
                        "{{ $message }}",
                        "success"
                    );
                @endif

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
