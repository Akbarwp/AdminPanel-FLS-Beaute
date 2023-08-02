@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="container justify text-center">
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-sm">
                    <h4 style="text-align:left;">Detail Pasok {{ $history->kode_pasok }}</h4>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('manage_product/input_pasok/detail/export/'.$history->id) }}'">
                        <i class="fa fa-file-pdf-o" ></i>
                        <span>Export</span>
                    </button>
                    <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('manage_product/input_pasok/detail/print/'.$history->id) }}')"><i class='fa fa-print'></i>
                        Print</button>
                </div>
                <div class="col-sm text-right">
                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke"
                        onclick="location.href='{{ url('/manage_product/input_pasok/supplyhistories/create') }}'">
                        <span>+ Add</span>
                    </button>
                </div>
                
            </div>
            
        </div>
    </div>
    <hr>
    @if($details->count())
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
    @else
    <p class="text-center fs-4">No detail found</p>
    @endif
</div>
@endsection

@section('script')
<script>

</script>
@endsection