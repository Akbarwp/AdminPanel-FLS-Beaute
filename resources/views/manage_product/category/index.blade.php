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
                                    <div class="col text-left" style="text-align:left;">
                                        <h4 style="text-align:left;">Daftar Kategori Barang</h4>
                                    </div>
                                    <div class="col-md-6" style="text-align:center;">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importExcel" style="background-color:rgba(165,78,182); color:whitesmoke">
                                            <i class="fa fa-file-excel-o"></i>
                                            Import
                                        </button>
                                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke"
                                            onclick="window.location.href='{{ url('/manage_product/category/export') }}'">
                                            <i class="fa fa-file-pdf-o"></i>
                                            <span>Export</span>
                                        </button>
                                    </div>
                                    <div class="col" style="text-align:right;">
                                        <a href="{{ url('/manage_product/category/create') }}" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke">
                                            <span>Tambah Kategori</span>
                                        </a>
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
                                                        <th>Kategori</th>
                                                        <th></th>
                                                        {{-- <th></th> --}}
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($categories as $key => $category)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $category->nama_kategori }}</td>
                                                            <td width="20%">
                                                                <button type="button" class="btn btn-sm btn-warning" style="background-color:rgba(165,78,182); color:whitesmoke"
                                                                    onclick="location.href='{{ url('/manage_product/category/' . $category->id . '/edit') }}'">
                                                                    <span><i class="fa fa-edit"></i>Edit</span>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-danger" style="background-color:rgba(165,78,182); color:whitesmoke"
                                                                    data-toggle="modal"
                                                                    data-target="#deleteDaftarCategory.{{ $category->id }}">
                                                                    <span><i class="fa fa-trash"></i>Delete</span>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <div class="modal fade"
                                                            id="deleteDaftarCategory.{{ $category->id }}" role="dialog"
                                                            style="border-radius:45px">
                                                            <div class="modal-dialog">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <form
                                                                        action="{{ url('/manage_product/category/' . $category->id . '/delete') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <div class="modal-header"
                                                                            style="background:rgba(52, 25, 80, 1); color:white;">
                                                                            <p id="employeeidname"
                                                                                style="font-weight: bold;">
                                                                                DELETE {{ $category->nama_kategori }}
                                                                            </p>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                style="color:white;">×</button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <div class="row text-center">
                                                                                <div class="col">
                                                                                    Apakah Yakin Menghapus
                                                                                    {{ $category->nama_kategori }}?
                                                                                </div>

                                                                            </div>
                                                                            <br>
                                                                            <div class="row text-center">
                                                                                <div class="col">
                                                                                    <button
                                                                                        class="btn btn-secondary text-right"
                                                                                        data-dismiss="modal"
                                                                                        style="background-color:rgba(165,78,182); color:whitesmoke; text-align:left">
                                                                                        <a style="color: white;">Cancel</a>
                                                                                    </button>
                                                                                    <button
                                                                                        class="btn btn-danger text-right"
                                                                                        style="background-color:rgba(165,78,182); color:whitesmoke; text-align:left">
                                                                                        <a style="color: white;">Delete</a>
                                                                                    </button>
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
                <form method="post" action="{{route('category.import')}}" enctype="multipart/form-data">
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
                            <button type="submit" class="btn btn-primary">Import</button>
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

            @if ($message = Session::get('delete_success'))
                swal(
                    "Berhasil!",
                    "{{ $message }}",
                    "success"
                );
            @endif

            @if ($message = Session::get('delete_error'))
                swal(
                    "Hapus Kategori Gagal!",
                    "{{ $message }}",
                    "error"
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
