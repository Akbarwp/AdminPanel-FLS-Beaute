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
        <form action="{{ url('/manage_product/products/') }}" method="post" name="create_form">
            @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col-2 text-align:left">
                        <label class="text">Kode Barang</label>
                    </div>
                    <div class="col-10">
                        <input type="text" class="form-control textField" id="kode_produk" name="kode_produk"
                            placeholder="Masukkan Kode Barang">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2 text-align:left">
                        <label class="text">Nama Barang</label>
                    </div>
                    <div class="col-10">
                        <input type="text" class="form-control textField" id="nama_produk" name="nama_produk"
                            placeholder="Masukkan Nama Barang">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2 text-align:left">
                        <label class="text">Kategori Barang</label>
                    </div>
                    <div class="col-10">
                        <select name="id_category" class="form-control" required>
                            <option value="">Pilih Kategori Barang</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{-- <div class="form-group">
                <div class="row">
                    <div class="col-2 text-align:left">
                        <label class="text">Jenis Barang</label>
                    </div>
                    <div class="col-10">
                        <input type="text" class="form-control" placeholder="Masukan Jenis Barang" name="jenis_barang"
                            required>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="form-group">
                <div class="row">
                    <div class="col-2 text-align:left">
                        <label class="text">Lokasi Barang</label>
                    </div>
                    <div class="col-10">
                        <input type="text" class="form-control" placeholder="Masukan Jenis Barang" name="lokasi_barang"
                            required>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="form-group">
                <div class="row">
                    <div class="col-2 text-align:left">
                        <label class="text">Kualitas Barang</label>
                    </div>
                    <div class="col-10">
                        <select name="kualitas_barang" class="form-control" required>
                            <option value="">Pilih Kualitas Barang</option>
                            <option value="Rendah">Rendah</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </div>
                </div>
            </div> --}}

            <div class="form-group">
                <div class="row">
                    <div class="col-2 text-align:left">
                        <label class="text">Stok Barang</label>
                    </div>
                    <div class="col-10">
                        <input type="text" class="form-control textField" id="stok" name="stok"
                            placeholder="Masukkan Stok Barang">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2 text-align:left">
                        <label class="text">Harga Jual</label>
                    </div>
                    <div class="col-10">
                        <input type="text" class="form-control textField" id="harga_jual" name="harga_jual"
                            placeholder="Masukkan Harga Jual (per pcs)">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2 text-align:left">
                        <label class="text">Harga Modal</label>
                    </div>
                    <div class="col-10">
                        <input type="text" class="form-control textField" id="harga_modal" name="harga_modal"
                            placeholder="Masukkan Harga Modal (per pcs)">
                    </div>
                </div>
            </div>
            {{-- <div class="form-group">
            <div class="row">
                <div class="col-2 text-align:left">
                    <label class="text">Keterangan</label>
                </div>
                <div class="col-10">
                    <input type="text" class="form-control textField" id="keterangan" name="keterangan"
                        placeholder="Masukkan Keterangan Barang">
                </div>
            </div>
        </div> --}}

            <div class="form-group text-right">
                <input type="submit" onclick="" class="btn btn-primary submit btn-simpan" style="background-color:rgba(165,78,182); color:whitesmoke" value="Submit">
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        @if ($message = Session::get('create_failed'))
            swal(
                "",
                "{{ $message }}",
                "error"
            );
        @endif


        $('#stok').keyup(function(e) {
            $('#stok').val(formatRupiah(this.value));
        });
        $('#harga_jual').keyup(function(e) {
            $('#harga_jual').val(formatRupiah(this.value));
        });
        $('#harga_modal').keyup(function(e) {
            $('#harga_modal').val(formatRupiah(this.value));
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split('.'),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
        }

        $(document).on('click', '.btn-simpan', function() {
            $('#stok').val(parseInt($('#stok').val().replace(/,.*|[^0-9]/g, '')))
            $('#harga_jual').val(parseInt($('#harga_jual').val().replace(/,.*|[^0-9]/g, '')))
            $('#harga_modal').val(parseInt($('#harga_modal').val().replace(/,.*|[^0-9]/g, '')))
        })
    </script>
@endsection
