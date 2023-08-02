@extends('templates/main')

@section('css')

@endsection

@section('content')
<div class="container justify text-center">
    <div class="col-sm">
        <form action="{{ url('/sales/store_tracking') }}" class="form-horizontal" method="post" name="create_form" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label class="control-label col-sm-2 align-self-center mb-0 labelclass">Id Reseller</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="id_reseller" name="id_reseller" placeholder="Masukkan Id Reseller" readonly value="{{ auth()->user()->id }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2 align-self-center mb-0 labelclass">Nama Toko</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nama_toko') is-invalid @enderror" id="nama_toko" name="nama_toko" placeholder="Masukkan Nama Toko" value="{{ old('nama_toko') }}">
                    @error('nama_toko')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-sm-2 align-self-center mb-0 labelclass">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="alamat" name="address" placeholder="Masukkan Alamat" value="{{ old('address') }}">
                    @error('address')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-group row">
                <label class="control-label col-sm-2 align-self-center mb-0 labelclass">Lokasi</label>
                <div class="col-sm-3">
                    <button type="button" class="btn btn-warning btn-success d-flex justify-content-center align-items-center" onclick="getLocation()">
                        <span>Klik Lokasi</span>
                    </button>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-sm-2 align-self-center mb-0 labelclass"></label>
                <div class="col-sm">
                    <div class="row text-left">
                        <div class="col-sm-3">
                            <label class="control-label align-self-center mb-0 labelclass">Longtitude:</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" placeholder="0" readonly="readonly" value="{{ old('longitude') }}">
                            @error('longitude')
                            <div class="invalid-feedback text-left">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-sm-3">
                            <label class="control-label align-self-center mb-0 labelclass">Latitude:</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" placeholder="0" readonly="readonly" value="{{ old('latitude') }}">
                            @error('latitude')
                            <div class="invalid-feedback text-left">{{ $message }}</div>
                            @enderror
                        </div>
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
                                    <table class="table table-hover table-light" id="listProduct">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Nama Barang</th>
                                                <th scope="col">Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="list1">
                                                <td>
                                                    <button type='button' class='btn btn-remove' 
                                                        style='color: #D17826;' onclick='deleteRow("list1")'>
                                                        <i class='fas fa-trash'></i>&nbspHapus
                                                    </button>
                                                </td>
                                                <td>
                                                    <select class="form-control id_produk " id="id_produk" name="id_produk1" style="height:45px;" onchange="getProductID(this.value, 'list1')">
                                                        <option value="">Pilih Varian Parfum</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" >{{ $product->product_type->nama_produk }}</option>
                                                        @endforeach
                                                    </select>
                                                    
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control jumlah_produk " id="jumlah_produk" name="jumlah_produk1" placeholder="Masukkan Jumlah Pesanan" value="{{ old('jumlah_produk1') }}">
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                    <div class="form-group ">
                                        <input type="button" class="btn btn-primary submit" value="+ Tambah" onclick="addRow()">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2 align-self-center mb-0 labelclass">Nilai</label>
                <div class="col-sm-10">
                    <select id="nilai" name="nilai" class="form-control selectpicker @error('nilai') is-invalid @enderror">
                        <option value="">Silahkan Pilih Nilai</option>
                        <option value="Sangat Baik" {{ old('nilai') == "Sangat Baik" ? "selected" : "" }}>Sangat Baik</option>
                        <option value="Baik" {{ old('nilai') == "Baik" ? "selected" : "" }}>Baik</option>
                        <option value="Kurang Baik" {{ old('nilai') == "Kurang Baik" ? "selected" : "" }}>Kurang Baik</option>
                        <option value="Sangat Tidak Baik" {{ old('nilai') == "Sangat Tidak Baik" ? "selected" : "" }}>Sangat Tidak Baik</option>
                    </select>
                    @error('nilai')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2 align-self-center mb-0 labelclass">Saran</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('saran') is-invalid @enderror" id="saran" name="saran" placeholder="Masukkan Saran">
                    @error('saran')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group text-right">
                <input type="submit" onclick="settingName()" class="btn btn-primary submit" value="Submit">
            </div>
        </form>
    </div>  
</div>
@endsection

@section('script')
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>
@if ($message = Session::get('create_failed'))
    swal(
        "Transaksi Gagal!",
        "{{ $message }}",
        "error"
    );
@endif

var count;
var kosong;
$(document).ready(function () {
    $('#mytable').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
    count=1;
    kosong = false;
});

var x = document.getElementById("coba");

function getLocation() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    document.getElementById("latitude").value = position.coords.latitude;
    document.getElementById("longitude").value = position.coords.longitude;

    // x.innerHTML = "Latitude: " + position.coords.latitude + 
    // "<br>Longitude: " + position.coords.longitude;
    // window.open("https://maps.google.com/?q="+position.coords.latitude+","+position.coords.longitude);

    // GetAddress(position.coords.latitude, position.coords.longitude);
}


function addRow()
{
    count++;
    // alert(count);
    var length = document.getElementById("listProduct").rows.length;
    var table = document.getElementById("listProduct");
    var row = table.insertRow(length);
    row.setAttribute("id","list"+count.toString());

    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
  
    cell0.innerHTML = "<button type='button' class='btn btn-remove' style='color: #D17826;' onclick='deleteRow(\"list"+count.toString()+"\")'><i class='fas fa-trash'></i>&nbspHapus</button>";
    cell1.innerHTML = "<select class='form-control id_produk' id='id_produk' name='id_produk' style='height:45px;'' onchange='getProductID(this.value, \"list'+count.toString()+'\")'><option value=''>Pilih Varian Parfum</option>@foreach($products as $product)<option value='{{ $product->id }}'>{{ $product->product_type->nama_produk }}</option>@endforeach</select>";
    cell2.innerHTML = '<input type="number" class="form-control jumlah_produk" id="jumlah_produk" name="jumlah_produk" placeholder="Masukkan Jumlah Pesanan" onchange="countSubTotal(\'list'+count.toString()+'\')">';
}

function deleteRow(x)
{
    var length = document.getElementById("listProduct").rows.length;

    if(length>1)
    {
        event.preventDefault();
        var row = document.getElementById(x);
        row.parentNode.removeChild(row);
    }
    if(length === 2)
    {
        count=0;
        kosong=true;
    }
    countTotal();

}

function getProductID(x, b)
{
    // var arrProducts = <?php echo $products; ?>;
    // let objProduct = arrProducts.find(o => o.id == x);
    // var arrTypes = <?php echo $types; ?>;
    // let objType = arrTypes.find(o => o.id == objProduct['id_produkType']);

    // console.log("aaa");
    // console.log(x);
    // console.log(arrProducts);
    // console.log(objProduct);
    // console.log(objProduct['harga_modal']);
    // console.log(arrTypes);
    // console.log(objType);
    // console.log(objType['nama_produk']);
    // console.log("bbb");

    // var tempBeli = "#" + b + " .harga_beli";
    // document.querySelector(tempBeli).value = objProduct['harga_modal'];
    // var tempBeli = "#" + b + " .harga_jual";
    // document.querySelector(tempBeli).value = objProduct['harga_jual'];
    // countSubTotal(b);
}

function settingName()
{
    var length = document.getElementById("listProduct").rows.length;

    // alert(length);
    for(let i=1; i<length; i++)
    {
        if(kosong)
        {
            var tempProduct = "tr:nth-of-type(" + (i+1).toString() + ") .id_produk";
            // alert(tempProduct);
            
            document.querySelector(tempProduct).setAttribute("name", "id_produk"+i.toString());

            // alert("a");

            var tempJumlah = "tr:nth-of-type(" + (i+1).toString() + ") .jumlah_produk";
            // alert(tempJumlah);
            document.querySelector(tempJumlah).setAttribute("name", "jumlah_produk"+i.toString());
        }
        else
        {
            var tempProduct = "tr:nth-of-type(" + i.toString() + ") .id_produk";
            // alert(tempProduct);
            
            document.querySelector(tempProduct).setAttribute("name", "id_produk"+i.toString());

            // alert("a");

            var tempJumlah = "tr:nth-of-type(" + i.toString() + ") .jumlah_produk";
            // alert(tempJumlah);
            document.querySelector(tempJumlah).setAttribute("name", "jumlah_produk"+i.toString());
        }
        

        // var tempBeli = "tr:nth-of-type(" + i.toString() + ") .harga_beli";
        // document.querySelector(tempBeli).setAttribute("name", "harga_beli"+i.toString());

    }
}

</script>
@endsection