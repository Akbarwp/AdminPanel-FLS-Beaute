@extends('templates/main')

@section('css')
@endsection

@section('content')
    <div class="container">
        <h3 class="mt-4">Tutup Cash</h3>
        @if ($opname->status == 1)
            <form class="mt-5" action="{{ url('/cash_opname/close/store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label" style="font-weight: bold">Nama Kasir</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_distributor" class="form-control"
                            value="{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label" style="font-weight: bold">Total Transaksi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="total_transaksi" id="total_transaksi"
                            value="{{ $total_transaksi }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label" style="font-weight: bold">Cash Kita</label>
                    <div class="col-sm-10">
                        <input type="text" value="0" class="form-control" name="cash_akhir" id="cash_akhir"
                            placeholder="Input Cash" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label" style="font-weight: bold">Selisih</label>
                    <div class="col-sm-10">
                        <input type="text" value="0" class="form-control" name="selisih" id="selisih" readonly>
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
                "Tutup Cash Berhasil",
                "{{ $message }}",
                "success"
            );
        @endif
        @if (!Session::get('create_success'))
            @if (!$opname)
                swal(
                    "Tutup Cash Tidak Tersedia",
                    "Anda belum melakukan buka cash hari ini",
                    "warning"
                );
            @endif
            @if ($opname->status == 2)
                swal(
                    "Tutup Cash Tidak Tersedia",
                    "Anda sudah melakukan tutup cash hari ini",
                    "warning"
                );
            @endif
        @endif

        $('#cash_akhir').on('input', function() {
            var cashAkhir = $(this).val();
            var total_transaksi = $('#total_transaksi').val();
            // var hasil = Math.abs(total_transaksi - cashAkhir);
            var hasil = cashAkhir - total_transaksi;
            $('#selisih').val(hasil);
        });
    </script>
@endsection
