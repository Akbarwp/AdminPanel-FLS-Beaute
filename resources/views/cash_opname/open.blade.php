@extends('templates/main')

@section('css')
@endsection

@section('content')
    <div class="container">
        <h3 class="mt-4">Buka Cash</h3>
        @if (!$opname)
            <form class="mt-5" action="{{ url('/cash_opname') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label" style="font-weight: bold">Nama Kasir</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_distributor" class="form-control"
                            value="{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label" style="font-weight: bold">Buka Cash</label>
                    <div class="col-sm-10">
                        <input type="text" value="0" class="form-control" name="cash_awal" id="cash_awal"
                            placeholder="Input Cash" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-simpan btn-primary float-right" style="background-color:rgba(165,78,182); color:whitesmoke">Submit</button>
            </form>
        @endif
    </div>
@endsection

@section('script')
    <script>
        @if ($message = Session::get('create_failed'))
            swal(
                "Buka Cash Gagal",
                "{{ $message }}",
                "error"
            );
        @endif

        @if ($message = Session::get('create_success'))
            swal(
                "Buka Cash Berhasil",
                "{{ $message }}",
                "success"
            );
        @endif
        @if (!Session::get('create_success'))
            @if ($opname && ($opname->status == 1 || $opname->status == 2))
                swal(
                    "Buka Cash Tidak Tersedia",
                    "Anda sudah melakukan buka cash hari ini",
                    "warning"
                );
            @endif
        @endif


        $('#cash_awal').keyup(function(e) {
            $('#cash_awal').val(formatRupiah(this.value));
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
            $('#cash_awal').val(parseInt($('#cash_awal').val().replace(/,.*|[^0-9]/g, '')))
        })
    </script>
@endsection
