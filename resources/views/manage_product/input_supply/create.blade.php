@extends('templates/main')

@section('css')
<style>
    .upload{
        background-color:rgba(52, 25, 80, 1);
        color:white;
        width:100px;
        border: 1px solid white;
        border-radius: 5px;
        width:150px;
        height:50px;
        
    }
    .text{
        color:rgba(52, 25, 80, 1);
        float: left;
    }
    .textField{
        background-color:white;
        border-radius: 5px;
        text-align:left;
    }
    .textview{
        background-color:white; 
        text-align:left;
        border-radius: 5px;
        padding:10px;
    }
    #tanggal_surat{
        background-color:white;
    }
</style>
@endsection

@section('content')
<div class="container justify text-center">
    <form action="{{ url('/manage_product/input_pasok/supplyhistories') }}" method="post" name="create_form" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-2 text-align:left">
                    <label class="text">Kode Pasok</label>
                </div>
                <div class="col-10">
                    <input type="lastname" class="form-control textField" id="kode_pasok" name="kode_pasok"
                                placeholder="Masukkan Kode Pasok">
                </div>
                
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2 text-align:left">
                    <label class="text">Supplier</label>
                </div>
                <div class="col-10">
                    <div class="textview">
                        <p id="nama_supplier" name="nama_supplier">Pabrik FLS</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                <label for="exampleInputLastName" class="text">Surat Jalan</label>
                </div>
                <div class="col-10">
                <input type="lastname" class="form-control textField" id="surat_jalan" name="surat_jalan"
                        placeholder="Masukkan Surat Jalan">
                </div>
                
            </div>
        </div>

        <div class="form-group row d-flex justify-content-left align-items-left">
            <div class="col-2 text-left">
                <p>Pembelian</p>
            </div>
            <div class="col-10">
                <div class="iq-card">
                    <div class="iq-card-body">
                        
                        <hr style="margin:8px;">
                        <div class="col text-left">
                            <table class="table table-hover table-light table-striped" id="listProduct">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Harga Beli</th>
                                        <th scope="col">Harga Jual</th>
                                        <th scope="col">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="list1">
                                        <td>
                                            <button type='button' class='btn btn-remove' style='color: #D17826;' onclick='deleteRow("list1")'><i class='fas fa-trash'></i>&nbspHapus</button>
                                        </td>
                                        <td>
                                            <select class="form-control id_product" id="id_product" name="id_product" style="height:45px;" onchange="getProductID(this.value, 'list1')">
                                                <option value="">Pilih Varian Parfum</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->product_type->nama_produk }}</option>
                                                @endforeach
                                            </select>
                                            </td>
                                        <td>
                                            <input type="number" class="form-control jumlah" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah Pesanan" onchange="countSubTotal('list1')">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control harga_beli" id="harga_beli" placeholder="Rp 0" readonly="readonly" style="background-color:white">
                                        </td>
                                        <td>
                                            <input type="text"  class="form-control harga_jual" id="harga_jual" placeholder="Rp 0" readonly="readonly" style="background-color:white">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control subtotal" id="subtotal" placeholder="Masukkan Jumlah Pesanan" readonly="readonly">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group ">
                                <input type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" value="+ Tambah" onclick="addRow()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label class="text">Metode Pembayaran</label>
                </div>
                <div class="col-10">
                    <!-- <div class="textview" id=""> -->
                        <select id="metode_pembayaran" name="metode_pembayaran" class="form-control" data-live-search="true">
                            <option value="">Silahkan Pilih Metode Pembayaran</option>
                            <option value="tunai">Tunai</option>
                            <option value="bank">Bank</option>
                        </select>
                    <!-- </div> -->
                </div>
                
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label class="text">Total</label>
                </div>
                <div class="col-10">
                    <div class="textview" id="total">
                        Rp 0
                    </div>
                </div>
                
            </div>
        </div>
        
        
        <div class="form-group text-right">
        <input type="submit" onclick="settingName()" style="background-color:rgba(165,78,182); color:whitesmoke" class="btn btn-primary submit" value="Tambah">
        </div>
    </form>
</div>

@endsection

@section('script')
<script>
var count=1;
function addRow()
{
    count++;
    var length = document.getElementById("listProduct").rows.length;
    var table = document.getElementById("listProduct");
    var row = table.insertRow(length);
    row.setAttribute("id","list"+count.toString());

    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    cell0.innerHTML = "<button type='button' class='btn btn-remove' style='color: #D17826;' onclick='deleteRow(\"list"+count.toString()+"\")'><i class='fas fa-trash'></i>&nbspHapus</button>";
    cell1.innerHTML = '<select class="form-control id_product" id="id_product" name="id_product" style="height:45px;" onchange="getProductID(this.value, \'list'+count.toString()+'\')"><option value="">Pilih Varian Parfum</option>@foreach($products as $product)<option value="{{ $product->id }}">{{ $product->product_type->nama_produk }}</option>@endforeach</select></td>';
    cell2.innerHTML = '<input type="number" class="form-control jumlah" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah Pesanan" onchange="countSubTotal(\'list'+count.toString()+'\')">';
    cell3.innerHTML = '<input type="text" class="form-control harga_beli" id="harga_beli" placeholder="Rp 0" readonly="readonly" style="background-color:white">';
    cell4.innerHTML = '<input type="text"  class="form-control harga_jual" id="harga_jual" placeholder="Rp 0" readonly="readonly" style="background-color:white">';
    cell5.innerHTML = '<input type="text" class="form-control subtotal" id="subtotal" placeholder="Masukkan Jumlah Pesanan" readonly="readonly">';
}

function deleteRow(x)
{
    var length = document.getElementById("listProduct").rows.length;

    if(length>2)
    {
        var row = document.getElementById(x);
        row.parentNode.removeChild(row);
    }
    countTotal();

}

function getProductID(x, b)
{
    var arrProducts = <?php echo $products; ?>;
    let objProduct = arrProducts.find(o => o.id == x);
    var arrTypes = <?php echo $types; ?>;
    let objType = arrTypes.find(o => o.id == objProduct['id_productType']);

    console.log("aaa");
    console.log(x);
    console.log(arrProducts);
    console.log(objProduct);
    console.log(objProduct['harga_modal']);
    console.log(arrTypes);
    console.log(objType);
    console.log(objType['nama_produk']);
    console.log("bbb");

    var tempBeli = "#" + b + " .harga_beli";
    document.querySelector(tempBeli).value = objProduct['harga_modal'];
    var tempBeli = "#" + b + " .harga_jual";
    document.querySelector(tempBeli).value = objProduct['harga_jual'];
    countSubTotal(b);
}

function countSubTotal(b)
{
    var tempBeli = "#" + b + " .harga_beli";
    var tempJumlah = "#" + b + " .jumlah";

    var subtotal = document.querySelector(tempJumlah).value * document.querySelector(tempBeli).value;

    var tempSub = "#" + b + " .subtotal";
    document.querySelector(tempSub).value = subtotal;

    countTotal();
}

function countTotal()
{
    var total = 0;
    var length = document.getElementById("listProduct").rows.length;
    for(let i=1; i<length; i++)
    {
        var temp = "tr:nth-of-type(" + i.toString() + ") .subtotal";
        total += parseInt(document.querySelector(temp).value);
    }
    document.getElementById('total').innerHTML = "Rp " + total;
}

function settingName()
{
    var length = document.getElementById("listProduct").rows.length;
    for(let i=1; i<length; i++)
    {
        var tempProduct = "tr:nth-of-type(" + i.toString() + ") .id_product";
        document.querySelector(tempProduct).setAttribute("name", "id_product"+i.toString());

        var tempJumlah = "tr:nth-of-type(" + i.toString() + ") .jumlah";
        document.querySelector(tempJumlah).setAttribute("name", "jumlah"+i.toString());

        var tempBeli = "tr:nth-of-type(" + i.toString() + ") .harga_beli";
        document.querySelector(tempBeli).setAttribute("name", "harga_beli"+i.toString());

    }
}

</script>
@endsection