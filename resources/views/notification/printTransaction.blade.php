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
            Invoice
        </div>
        <hr style="border-color:black;">
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-2">
                        Kepada
                    </div>
                    <div class="col-2">
                        :
                    </div>
                    <div class="col-8">
                        {{ $pembeli->firstname }} {{ $pembeli->lastname }}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-2">
                        NO INV
                    </div>
                    <div class="col-2">
                        :
                    </div>
                    <div class="col-8">
                        {{ $transaction->transaction_code }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-2">
                        Alamat
                    </div>
                    <div class="col-2">
                        :
                    </div>
                    <div class="col-8">
                        {{ $pembeli->address }}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-2">
                        Tanggal
                    </div>
                    <div class="col-2">
                        :
                    </div>
                    <div class="col-8">
                        {{ $transaction->created_at->format('d/m/y H:i:s') }}
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="container justify text-center">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <br>
                        <table id="myTable" class="table text-left" >
                            <thead>
                                <tr class="text-center" style="background-color:grey">
                                    <th >NAMA BARANG</th>
                                    <th scope="col">JUMLAH</th>
                                    <th scope="col">HARGA SAT</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($details as $detail)
                                    <tr>
                                        <td>{{ $detail->nama_produk }}</td>
                                        <td>{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="border:2px solid black">&nbsp</td>
                                    <td style="border:2px solid black">&nbsp</td>
                                    <td style="border:2px solid black; font-weight:bold">Total</td>
                                    <td style="border:2px solid black; font-weight:bold">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="hilang" >&nbsp</td>
                                    <td class="hilang hilang-right">&nbsp</td>
                                    <td style="border:2px solid black; font-weight:bold">Diskon</td>
                                    <td style="border:2px solid black; font-weight:bold">Rp 0</td>
                                </tr>
                                <tr>
                                    <td class="hilang">&nbsp</td>
                                    <td class="hilang hilang-right">&nbsp</td>
                                    <td style="border:2px solid black; font-weight:bold">Ongkir</td>
                                    <td style="border:2px solid black; font-weight:bold">Rp 0</td>
                                </tr>
                                <tr>
                                    <td class="hilang">&nbsp</td>
                                    <td class="hilang hilang-right">&nbsp</td>
                                    <td style="border:2px solid black; font-weight:bold">Total Keseluruhan</td>
                                    <td style="border:2px solid black; font-weight:bold">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="bank col-6">
            <div class="row">
                Pembayaran Transfer :
            </div>
            <div class="row" style="font-weight:bold">
                BANK : BCA
            </div>
            <div class="row" style="font-weight:bold">
                NO Rek. 7902197888
            </div>
            <div class="row" style="font-weight:bold">
                AN : Fanny Lia Sutanto QQ Astarina Yulinda Wydiani SE
            </div>
            <div class="row" style="font-weight:bold">
                Cabang Gresik - Jawa Timur
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

<script>
@endsection