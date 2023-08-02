@extends('templates/main')

@section('css')
    <style>
        .upload {
            background-color: rgba(52, 25, 80, 1);
            color: white;
            width: 100px;
            border: 1px solid white;
            border-radius: 5px;
            width: 150px;
            height: 50px;

        }

        .text {
            color: rgba(52, 25, 80, 1);
            float: left;
        }

        .textField {
            background-color: white;
            border-radius: 5px;
            text-align: left;
        }

        .textview {
            background-color: white;
            text-align: left;
            border-radius: 5px;
            padding: 10px;
        }

        #date {
            background-color: white;
        }
    </style>
@endsection

@section('content')
    <div class="container justify text-center">
        <form action="{{ url('/manage_product/category/' . $category->id) }}" method="post" name="create_form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <div class="row">
                    <div class="col-2 text-align:left">
                        <label class="text">Nama Kategori</label>
                    </div>
                    <div class="col-10">
                        <input type="text" class="form-control textField" id="nama_kategori" name="nama_kategori"
                            placeholder="Masukkan Nama Kategori" value="{{ $category->nama_kategori }}">
                    </div>
                </div>
            </div>

            <div class="form-group text-right">
                <input type="submit" onclick="" class="btn btn-primary submit btn-simpan" style="background-color:rgba(165,78,182); color:whitesmoke" value="Update">
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        @if ($message = Session::get('update_failed'))
            swal(
                "",
                "{{ $message }}",
                "error"
            );
        @endif
    </script>
@endsection
