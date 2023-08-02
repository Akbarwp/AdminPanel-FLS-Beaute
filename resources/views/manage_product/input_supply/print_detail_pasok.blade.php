@extends('templates/print')

@section('css')

@endsection

@section('content')
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <img src="{{ asset('images/flslogo.jpg') }}" style="width:25%">
            </div>
            <div class="col-sm-7">
                <div class="d-flex justify-content-end" style="font-weight:bold">
                    PT ANDARA CANTIKA
                </div>
                <div class="d-flex justify-content-end">
                    Pergudangan Bumi Benowo Sukses Sejahtera Tbk
                </div>
                <div class="d-flex justify-content-end">
                    Jl. Raya Gelora Bung Tomo No. 8, Surabaya, Jawa Timur
                </div>
                <div class="d-flex justify-content-end">
                    Email: flsbeautyofficial@gmail.com
                </div>
            </div>
        </div>
        <hr style="border-color:black;">
        <div class="row d-flex justify-content-center" style="font-weight:bold; font-size:24px">
            Detail Pasok - {{ $history->kode_pasok }}
        </div>
        <hr style="border-color:black;">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12 grid-margin">
            <div class="iq-card">
        <div class="iq-card-body">
            <table id="mytable" class="table table-hover table-striped table-light">
                <thead style="text-align:left">
                    <tr>
                        <th scope="col">Kode</th>
                        <th scope="col">Nama barang</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Harga Beli</th>
                        <th scope="col">Harga Jual</th>
                        <th scope="col">Subtotal</th>
                    </tr>
                </thead>
                <tbody style="text-align:left">
                    @php
                        $total=0;
                    @endphp
                    @foreach($details as $detail)
                        <tr>
                            {{-- <td>{{ $detail->product->product_type }}</td> --}}
                            <td>{{ $detail->product->product_type->kode_produk }}</td>
                            <td>{{ $detail->product->product_type->nama_produk }}</td>
                            <td>{{ number_format($detail->jumlah, 0, ',', '.') }} pcs</td>
                            <td>Rp {{ number_format($detail->product->harga_modal, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->product->harga_jual, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->jumlah * $detail->product->harga_modal, 0, ',', '.') }}</td>
                        </tr>
                        @php
                        $total+=$detail->jumlah * $detail->product->harga_modal;
                        @endphp
                    @endforeach
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align:right">Total</td>
                        <td>Rp @php echo number_format($total, 0, ',', '.') @endphp</td>
                    </tr>
                </tbody>
            </table>
            </div>

        </div>
    </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>

<script>
@endsection