@extends('templates/main')

@section('css')
<style>
.tambahAkun{
    background-color:rgba(52, 25, 80, 1);
}
</style>
@endsection

@section('content')
<div class="container justify text-center">
    <h4 style="text-align:left;">Buat Laporan Barang Hilang</h4>
    <hr>
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
            <div style="padding-top:32px;" class="iq-header-title container">
                <div class="col-sm">
                    <form class="form-horizontal" action="{{ url('/report_product/lostproducts/') }}" method="post" name="create_form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-sm-2 align-self-center mb-0 labelclass">Barang:</label>
                            <div class="col-sm-10">
                                <select id="id_product" name="id_product" class="form-control selectpicker" data-live-search="true"  onchange="getProductID(this.value)">
                                    <option value="">Silahkan Pilih Barang</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_type->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-2 align-self-center mb-0 labelclass">Stok Real:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="stok_real" name="stok_real" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-2 align-self-center mb-0 labelclass">Sisa Barang:</label>
                            <div class="col-sm-10">
                            <input type="number" class="form-control" id="stok_sisa" name="stok_sisa" placeholder="Masukkan Jumlah Barang" onkeyup="countBarang(this.value)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-2 align-self-center mb-0 labelclass">Barang Hilang:</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="stok_hilang" name="stok_hilang" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-2 align-self-center mb-0 labelclass">Kerugian:</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="total_kerugian" name="total_kerugian" readonly>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <div class="col-sm text-right">
                                <input type="submit" class="btn btn-primary" value="Tambah">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function getProductID(x)
{
    var arrProducts = <?php echo $products; ?>;
    let objProduct = arrProducts.find(o => o.id == x);

    console.log(objProduct['stok']);
    document.querySelector("#stok_real").value = objProduct['stok'];
}

function countBarang(sisa)
{
    var arrProducts = <?php echo $products; ?>;
    let objProduct = arrProducts.find(o => o.id == document.querySelector("#id_product").value);

    document.querySelector("#stok_hilang").value = document.querySelector("#stok_real").value - sisa;
    document.querySelector("#total_kerugian").value = document.querySelector("#stok_hilang").value * objProduct['harga_modal'];
}

</script>
@endsection