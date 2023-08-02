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
</style>
<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
  
@endsection

@section('content')
<div class="container justify text-center">
    <h4 style="text-align:left;">Transaksi Jual</h4>
    <hr>

    <div class="iq-card">
        <div class="iq-card-body">
            <div class="col text-left">
                <label class="labelclass">Jual</label>
            </div><hr style="margin:8px;">
            <div class="col text-left">
                <div class="row">
                    <div class="col-lg-4">
                        <label class="labelclass">Form Jual:</label>
                        <select id="listBarang" class="form-control" data-live-search="true">
                            {{-- <option value="0">Silahkan Pilih Barang</option>
                            <option value="1">Barang 1</option>
                            <option value="2">Barang 2</option>
                            <option value="3">Barang 3</option> --}}
                        </select>
                    </div>
                
                    <div class="col-lg-4" >
                        <label class="labelclass">Jumlah:</label>
                        <input type="number" id="jumlah" class="form-control" placeholder="Masukkan Jumlah Barang /pieces">
                    </div>
                    <div class="col-lg-4" >
                        <label class="labelclass"> &nbsp</label>
                        <button type="button" class="form-control btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="addItem()">
                            <span>+ Tambah Barang</span>
                        </button>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="iq-card">
        <div class="iq-card-body">
            <div class="col text-left">
                <label class="labelclass">Daftar Pesanan</label>
            </div><hr style="margin:8px;">
            <div class="col text-left">
                <table class="table table-hover table-light">
                    <thead>
                        <tr>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="shopCart">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="iq-card">
        <div class="iq-card-body">
            <div class="col text-left">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="labelclass">Nama Pembeli</label>
                        <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" placeholder="Masukkan Nama Pembeli">
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="iq-card">
        <div class="iq-card-body">
            <div class="col text-left">
                <label class="labelclass">Metode Pembayaran</label>
            </div><hr style="margin:8px;">
            <div class="col text-left">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="labelclass">Pilih Bank/Tunai:</label>
                        <select id="metode_pembayaran" class="form-control" data-live-search="true" onchange="setMetodePembayaran(this.value)">
                            <option value="">Silahkan Pilih Metode Pembayaran</option>
                            <option value="tunai">Tunai</option>
                            <option value="bank">Bank</option>
                        </select>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="iq-card">
        <div class="iq-card-body">
            <div class="col text-left">
                <label class="labelclass">Diskon</label>
            </div><hr style="margin:8px;">
            <div class="col text-left">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="labelclass">Diskon:</label>
                        <input type="number" id="diskon" class="form-control" placeholder="Masukkan Nominal Diskon" onkeyup="setDiskon(this.value)" value=0>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-lg-12">
                        <label class="labelclass">Keterangan Diskon:</label>
                        <input type="text" id="keterangan_diskon" class="form-control" placeholder="Masukkan Keterangan Diskon">
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="iq-card">
        <div class="iq-card-body row">

            <div class="col" style="padding-right:32px">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm text-left">
                        <p style="font-weight:500;">Kode Transaksi</p>
                    </div>
                    <div class="col-sm text-right">
                        <p id="trsCode"></p>
                    </div>
                </div><hr style="margin:8px;border:none;">
                <div class="row d-flex justify-content-center align-items-center" id='distributorName'>
 
                </div><hr style="margin:8px;border:none;">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm text-left">
                        <p style="font-weight:500;">Nama Pembeli</p>
                    </div>
                    <div class="col-sm text-right">
                        <p id="set_nama_pembeli"></p>
                    </div>
                </div><hr style="margin:8px;border:none;">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm text-left">
                        <p style="font-weight:500;">Metode Pembayaran</p>
                    </div>
                    <div class="col-sm text-right">
                        <p id="set_metode_pembayaran"></p>
                    </div>
                </div><hr style="margin:8px;border:none;">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm text-left">
                        <p style="font-weight:500">Jumlah Barang</p>
                        <p style="font-size:12px;color:grey;font-weight:500" id="subTotBarang">0 barang</p>	
                    </div>
                    <div class="col-sm text-right">
                        {{-- <p id="subTotHarga">Rp. 0</p> --}}
                    </div>
                </div><hr style="margin:8px;border:none;">
                
                {{-- <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm text-left">
                        <p style="font-weight:500">Diskon</p>
                        <!-- <a href="#" style="font-size:12px;font-weight:500;">Ubah Diskon</a>	 -->
                    </div>
                    <div class="col-sm text-right">
                        <div class="row">
                            <div class="col-sm">Rp. 0</div>
                        </div>
                        <div class="row">
                            <div class="col-sm">0%</div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="col" style="padding-right:32px">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm text-left">
                        <p style="font-weight:500">Tanggal</p>
                    </div>
                    <div class="col-sm text-right">
                        <p id='dateNow'></p>
                    </div>
                </div><hr style="margin:8px;border:none;">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm text-left">
                        <p style="font-weight:500">Waktu</p>
                    </div>
                    <div class="col-sm text-right">
                        <p id="timeNow"></p>
                    </div>
                </div><hr>
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm text-left">
                        <p style="font-weight:500">Total Sebelum Diskon</p>
                    </div>
                    <div class="col-sm text-right">
                        <p id="totalSebelumDiskon">Rp. 0</p>
                    </div>
                </div>
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm text-left">
                        <p style="font-weight:500">Total Diskon</p>
                    </div>
                    <div class="col-sm text-right">
                        <p id="totalDiskon">Rp. 0</p>
                    </div>
                </div><hr>
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm text-left">
                        <p style="font-weight:500">Total</p>
                    </div>
                    <div class="col-sm text-right">
                        <p id="totalSetelahDiskon">Rp. 0</p>
                    </div>
                </div><hr style="margin:8px;border:none;">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-sm text-right">
                        <button type="button" class="form-control btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="orderShopCart()">
                            <span>Masukkan Pesanan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Modal edit -->
    <div class="modal fade" id="modaledit" role="dialog" style="border-radius:45px">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background-color:rgba(165,78,182); color:whitesmoke"">
                    <p id="employeeidname" style="font-weight: bold;">Edit Jumlah Barang</p>
                    <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                </div>

                <div class="modal-body">
                        <input type="number" class="form-control" id="qty" value=""/>
                    <hr>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal delete-->
    <div class="modal fade" id="modaldelete" role="dialog" style="border-radius:45px">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background-color:rgba(165,78,182); color:whitesmoke">
                    <p id="employeeidname" style="font-weight: bold;">Hapus Pesanan</p>
                    <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                </div>

                <div class="modal-body">
                    <p class="text-center form-group">Apakah anda yakin akan menghapus pesanan ini?</p>
                    <div class="row">
                        <div class="col text-center">
                            <button type="button" class="btn btn-danger" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="removeData(this.value)" value='' id="btnDelete" data-dismiss="modal">Hapus</button>
                            <button type="button" class="btn btn-secondary" style="background-color:rgba(165,78,182); color:whitesmoke" data-dismiss="modal">Kembali</button>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('script')
@canany(['superadmin_pabrik','reseller'])
<script>
    //getDistributorName
    $.ajax({
        type:'get',
        url:'{{ url("/manage_transaction/transaction_sell/getPenjualName") }}',
        data: {
            "_token": "{{ csrf_token() }}"                
        },
        success:function(data) {
            // console.log(data);
            document.getElementById("distributorName").innerHTML = data;
        },
        error: function(data){
            console.log(data);
        }
    });    
</script>
@endcan

<script>

    var elemen_nama_pembeli = document.getElementById("set_nama_pembeli");
    var nama_pembeli = document.getElementById("nama_pembeli");

    nama_pembeli.addEventListener("input", function() {
        var value_nama_pembeli = nama_pembeli.value;
        elemen_nama_pembeli.innerHTML = value_nama_pembeli;
    });

    function generateCode()
    {
        var latest_transaction = <?php echo json_encode($latest_transaction); ?>;
        var transaction_code = latest_transaction['transaction_code'];
        var kodeTanpaT = transaction_code.substring(1);
        var angka_code = transaction_code.charAt(0);
        kodeTanpaT = parseInt(kodeTanpaT)+1;
        kodeTanpaT = kodeTanpaT.toString();
        transaction_code = angka_code + kodeTanpaT;
        var elemen_trsCode = document.getElementById("trsCode");
        elemen_trsCode.innerHTML = transaction_code;
    }

    generateCode();

    function number_format (number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    //set date and time to the correct timezone
    const date = new Date();
    var dateNow = date.toLocaleString('en-US', {timeZone: 'Asia/Jakarta',});
    var dateNowText = dateNow.substring(0, dateNow.indexOf(','));
    document.getElementById("dateNow").innerHTML = dateNowText;

    var timeNow = date.toLocaleString('en-US', {timeZone: 'Asia/Jakarta', hour: "2-digit",minute: "2-digit", hour12: false});
    document.getElementById("timeNow").innerHTML = timeNow;

    setInterval(function() {
        var second = new Date()
        if(second.getSeconds()==0)
        {
            timeNow = second.toLocaleString('en-US', {timeZone: 'Asia/Jakarta', hour: "2-digit",minute: "2-digit", hour12: false});
            document.getElementById("timeNow").innerHTML = timeNow;
        }
    }, 1 * 1000); 

    //function to load shopping cart
    function loadShopCart()
    {
        var cart = JSON.parse(sessionStorage.getItem("carts"));//no brackets
        var i;
        var cartFromSession = '';
        var totalSebelumDiskon=0;
        for (i = 0; i < cart.length; i++) {
            totalSebelumDiskon+=cart[i][3];
            cartFromSession = cartFromSession + `
            <tr>
                <td>`+cart[i][0]+`</td>
                <td>`+cart[i][1]+`</td>
                <td>Rp. `+number_format(cart[i][2], 0, ',', '.')+`</td>
                <td>Rp. `+number_format(cart[i][3], 0, ',', '.')+`</td>
                <td>
                    <div class="col-12 text-left">
                        <button type="button" class="btn btn-sm btn-warning editButton" id="editBtn" data-toggle="modal" data-target="#modaledit" data-qty=`+cart[i][1]+` data-pos=`+i+` data-idproduk=`+cart[i][4]+`>
                            <span><i class="fa fa-edit"></i>Edit</span>
                        </button>
                    </div>
                </td>
                <td>
                    <div class="col-12 text-left">
                        <button type="button" class="btn btn-sm btn-danger rmButton" data-toggle="modal" data-target="#modaldelete" data-pos=`+i+`>
                            <span><i class="fa fa-trash"></i>Hapus</span>
                        </button>
                    </div>
                </td>
            </tr>`;
        }
        document.getElementById("shopCart").innerHTML = cartFromSession;
        document.getElementById("subTotBarang").innerHTML = cart.length +" Barang";
        document.getElementById("totalSebelumDiskon").innerHTML = "Rp. " + number_format(totalSebelumDiskon, 0, ',', '.');
        $('#totalSebelumDiskon').data('total',totalSebelumDiskon);
    }

    //function to remove a row
    function removeData(position)
    {
        // alert(position);
        var temp =[];

        var cart = JSON.parse(sessionStorage.getItem("carts"));
        var i;
        var ctr=0;
        for (i = 0; i < cart.length; i++) {
            if(i!=position)
                temp[ctr++] = cart[i];
        }
        //console.log(temp);
        sessionStorage.setItem("carts", JSON.stringify(temp));
        loadShopCart();
        setTotalSetelahDiskon();
    }

    //function to edit a row
    function editData(position, qty, data)
    {
        //console.log(data);
        // alert(position);
        var temp =[];

        var cart = JSON.parse(sessionStorage.getItem("carts"));
        var i;
        for (i = 0; i < cart.length; i++) {
            if(i!=position)
                temp[i] = cart[i];
            else
            {
                temp[i] = cart[i];
                temp[i][1] = qty;
                temp[i][2] = data['harga_jual'];
                temp[i][3] = qty * data['harga_jual'];
            }
        }
        sessionStorage.setItem("carts", JSON.stringify(temp));
        loadShopCart();
        setTotalSetelahDiskon();
    }

    //LOAD SHOP CART FROM SESSION STORAGE
    if (sessionStorage.getItem("carts") === null) {
    }else
    {
        loadShopCart();
    }

    //function to add a row
    function addData(namaProduk, qty, data)
    {
        //console.log(data);
        if(sessionStorage.getItem("carts") === null)
        {
            var newCart = [[namaProduk, qty, data['harga_jual'], qty * data['harga_jual'], data['id']]]
            sessionStorage.setItem("carts", JSON.stringify(newCart));
        }
        else
        {
            var temp =[];

            var cart = JSON.parse(sessionStorage.getItem("carts"));
            var i;
            var newLen = cart.length;
            //console.log(cart);

            var exist = false;

            for (i = 0; i < cart.length; i++) {
                if(cart[i][4] == data['id'])
                {
                    temp[i] = cart[i];
                    var tempJumlah = parseInt(temp[i][1]) + parseInt(qty);
                    var tempTotal = parseInt(temp[i][2]) * tempJumlah;
                    exist = true;
                    
                    $.ajax({
                        type:'get',
                        url:'{{ url("/manage_transaction/transaction/check_item") }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            idItem : temp[i][4]                
                        },
                        success:function(data) {
                            //console.log(data);
                            if(data['code'] == "non")
                            {
                                if(tempJumlah>data['detail']['stok'])
                                {
                                    Swal.fire
                                    ({
                                        title: 'Jumlah Stok Tidak Tersedia. Tolong Konfirmasi Kembali.',
                                        icon: 'error',
                                        timer: 1500,
                                        showConfirmButton: false,
                                        allowOutsideClick: false
                                    });
                                }
                                else
                                {
                                    temp[i][1] = tempJumlah;
                                    temp[i][3] = tempTotal;

                                }
                            }
                            else
                            {
                                if(tempJumlah>data['detail']['stok'])
                                {
                                    Swal.fire
                                    ({
                                        title: 'Jumlah Stok Tidak Tersedia. Tolong Konfirmasi Kembali.',
                                        icon: 'error',
                                        timer: 1500,
                                        showConfirmButton: false,
                                        allowOutsideClick: false
                                    });
                                }
                                else
                                {
                                    temp[i][1] = tempJumlah;
                                    temp[i][3] = tempTotal;

                                }
                            }
                        }, 
                        async: false
                    });
                    
                }
                else
                {
                    temp[i] = cart[i];
                }
            }        
            if(!exist)
                temp[newLen] = [namaProduk, qty, data['harga_jual'], qty * data['harga_jual'], data['id']];
            sessionStorage.setItem("carts", JSON.stringify(temp));
        }
        loadShopCart();
        setTotalSetelahDiskon();
    }

    function addItem()
    {
        var namaProduk =$('#listBarang').find(":selected").text();
        var idProduk =document.getElementById('listBarang').value;
        var jumlah =document.getElementById('jumlah').value;
        if(idProduk == 0)
        {
            Swal.fire
            ({
                title: 'Silahkan Pilih Barang terlebih dahulu.',
                icon: 'error',
                timer: 1500,
                showConfirmButton: false,
                allowOutsideClick: false
            });
        }
        else
        {
            if(jumlah<1)
            {
                Swal.fire
                ({
                    title: 'Jumlah harus lebih besar dari 0.',
                    icon: 'error',
                    timer: 1500,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
            }else
            {
                $.ajax({
                    type:'get',
                    url:'{{ url("/manage_transaction/transaction/check_item") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        idItem : idProduk                
                    },
                    success:function(data) {
                        //console.log(data);
                        if(data['code'] == "non")
                        {
                            if(jumlah>data['detail']['stok'])
                            {
                                Swal.fire
                                ({
                                    title: 'Jumlah Stok Tidak Tersedia. Tolong Konfirmasi Kembali.',
                                    icon: 'error',
                                    timer: 1500,
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                            }
                            else
                            {
                                addData(namaProduk,jumlah, data['detail']);
                            }
                        }
                        else
                        {
                            if(jumlah>data['detail']['stok'])
                            {
                                Swal.fire
                                ({
                                    title: 'Jumlah Stok Tidak Tersedia. Tolong Konfirmasi Kembali.',
                                    icon: 'error',
                                    timer: 1500,
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                            }
                            else
                            {
                                addData(namaProduk,jumlah, data['detail']);
                            }
                        }
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
        }
    }

    function orderShopCart()
    {
        var nama_pembeli = document.getElementById("nama_pembeli").value;
        var transactionCode = document.getElementById("trsCode").innerHTML;
        var jumlahBarang = document.getElementById("subTotBarang").innerHTML;
        jumlahBarang = jumlahBarang.substring(0,jumlahBarang.indexOf(' '));
        var total = $('#totalSetelahDiskon').data("totalSetelahDiskon");
        var metode_pembayaran = document.getElementById("metode_pembayaran").value;
        var diskon = document.getElementById("diskon").value;
        let keterangan_diskon = "-";
        console.log(nama_pembeli);
        console.log(transactionCode);
        console.log(diskon);

        keterangan_diskon = document.getElementById("keterangan_diskon").value;
        if(keterangan_diskon == "")
        {
            console.log("kosong");

            keterangan_diskon = "-";
        }
        console.log("keterangan");

        console.log(keterangan_diskon);

        // total = total.substring(total.indexOf(' '),total.length);

        if(jumlahBarang!=0)
        {
            var cart = JSON.parse(sessionStorage.getItem("carts"));
            $.ajax({
                type:'post',
                url:'{{ url("/manage_transaction/transaction_sell/sell") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    transactionCode:transactionCode,
                    jumlahBarang:jumlahBarang,
                    total:total,
                    cart:cart,
                    metode_pembayaran:metode_pembayaran,
                    diskon:diskon,
                    keterangan_diskon:keterangan_diskon,            
                    nama_pembeli:nama_pembeli
                },
                success:function(data) {
                    sessionStorage.clear();
                    Swal.fire
                    ({
                        title: 'Success Melakukan Pesanan.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    document.getElementById("shopCart").innerHTML = "";
                    document.getElementById("subTotBarang").innerHTML = 0 +" Barang";
                    document.getElementById("totalSebelumDiskon").innerHTML = "Rp. " + 0;
                    document.getElementById("metode_pembayaran").value = "";
                    document.getElementById("set_metode_pembayaran").innerHTML = "";
                    document.getElementById("diskon").value = "";
                    document.getElementById("keterangan_diskon").value = "";
                    document.getElementById("totalSebelumDiskon").innerHTML = "Rp. " + 0;
                    document.getElementById("totalDiskon").innerHTML = "Rp. " + 0;
                    document.getElementById("totalSetelahDiskon").innerHTML = "Rp. " + 0;

                },
                error: function(data){
                    console.log(data);
                }
            });
        }
        else
        {
            Swal.fire
            ({
                title: 'Keranjang anda masih kosong.',
                icon: 'error',
                timer: 1500,
                showConfirmButton: false,
                allowOutsideClick: false
            });
        }
    }
$(document).ready(function () {

    // set diskon 0
    $('#diskon').data('totalDiskon',0)
    //getListBarang
    $.ajax({
        type:'get',
        url:'{{ url("/manage_transaction/transaction_sell/get_list_products_seller") }}',
        data: {
            "_token": "{{ csrf_token() }}"                
        },
        success:function(data) {
            // console.log(data);
            document.getElementById("listBarang").innerHTML = data;
        },
        error: function(data){
            console.log(data);
        }
    });

    //editButton
    $(document).on("click", ".editButton", function () {
        // var position = $(this).data('pos');
        var qty = $(this).data('qty');
        var pos = $(this).data('pos');
        var idItem = $(this).data('idproduk');
        document.getElementById("qty").value = qty;
        $('#qty').data('pos',pos); //setter
        $('#qty').data('iditem',idItem); //setter
        // alert(position);
    });

    $("#qty").change(function(){
        var jumlah = document.getElementById('qty').value;
        if(jumlah<1)
        {
            Swal.fire
            ({
                title: 'Jumlah harus lebih besar dari 0.',
                icon: 'error',
                timer: 1500,
                showConfirmButton: false,
                allowOutsideClick: false
            });
        }else
        {
            var idItem = $(this).data('iditem');
            var pos = $(this).data('pos');
            $.ajax({
                type:'get',
                url:'{{ url("/manage_transaction/transaction/check_item") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    idItem : idItem                
                },
                success:function(data) {
                    
                    if(data['code'] == "non")
                    {
                        if(jumlah>data['detail']['stok'])
                        {
                            Swal.fire
                            ({
                                title: 'Jumlah Stok Tidak Tersedia. Tolong Konfirmasi Kembali.',
                                icon: 'error',
                                timer: 1500,
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        }
                        else
                        {
                            editData(pos,jumlah, data['detail']);
                        }
                    }
                    else
                    {
                        if(jumlah>data['detail']['stok'])
                        {
                            Swal.fire
                            ({
                                title: 'Jumlah Stok Tidak Tersedia. Tolong Konfirmasi Kembali.',
                                icon: 'error',
                                timer: 1500,
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        }
                        else
                        {
                            editData(pos,jumlah, data['detail']);
                        }
                    }
                    
                    // console.log(data);
                    // document.getElementById("listBarang").innerHTML = data;
                },
                error: function(data){
                    console.log(data);
                }
            });
        }
    });

    //removeButton
    $(document).on("click", ".rmButton", function () {
        var position = $(this).data('pos');
        document.getElementById("btnDelete").value = position;
    });
});

function setMetodePembayaran(metode)
{
    document.getElementById("set_metode_pembayaran").innerHTML = metode;
}

function setDiskon(diskon)
{
    document.getElementById("totalDiskon").innerHTML = "Rp. " + number_format(diskon, 0, ',', '.');
    $('#diskon').data('totalDiskon',diskon);
    setTotalSetelahDiskon();
}

function setTotalSetelahDiskon()
{
    console.log("sett");
    var totalSebelumDiskon = $('#totalSebelumDiskon').data("total");
    var totalDiskon = $('#diskon').data("totalDiskon");
    var totalSetelahDiskon = totalSebelumDiskon - totalDiskon;
    document.getElementById("totalSetelahDiskon").innerHTML = "Rp. " + number_format(totalSetelahDiskon, 0, ',', '.');
    $('#totalSetelahDiskon').data("totalSetelahDiskon", totalSetelahDiskon);
    console.log(totalSebelumDiskon);
    console.log(totalDiskon);
    console.log(totalSetelahDiskon);
    console.log("aaa");
}
</script>
@endsection