@extends('templates/main')

@section('css')

@endsection

@section('content')
<div class="container justify text-center">
    <div class="iq-card">
        <div class="iq-card-body">
            <div class="col text-left">
                <label class="labelclass">Add Barang Sales</label>
            </div><hr style="margin:8px;">
            <div class="col text-left">
                <div class="col-12" hidden="">
                    <input type="text" name="id_sales" id="id_sales" value="{{ $id_sales }}">
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label class="labelclass">Barang:</label>
                        <select id="listBarang" class="form-control" data-live-search="true">
                            {{-- <option value="0">Silahkan Pilih Barang</option>
                            <option value="1">Barang 1</option>
                            <option value="2">Barang 2</option>
                            <option value="3">Barang 3</option> --}}
                        </select>
                    </div>
                
                    <div class="col-lg-3" >
                        <label class="labelclass">Jumlah:</label>
                        <input type="number" id="jumlah" class="form-control" placeholder="Masukkan Jumlah Barang /pieces">
                    </div>
                    {{-- <div class="col-lg-3" >
                        <label class="labelclass">Bonus:</label>
                        <input type="number" id="bonus" class="form-control" placeholder="Masukkan Bonus">
                    </div> --}}
                    <div class="col-lg-3" >
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
                            <th scope="col">Harga Jual</th>
                            <th scope="col">Nilai Total Barang</th>
                            {{-- <th scope="col">Bonus</th> --}}
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="shopCart">
                        
                    </tbody>
                </table>
            </div>
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-sm text-right">
                    <button type="button" class="form-control btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="orderShopCart()">
                        <span>Masukkan Stok Sales</span>
                    </button>
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
                <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
                    <p id="employeeidname" style="font-weight: bold;">Edit Jumlah Barang</p>
                    <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                </div>

                <div class="modal-body">
                    {{-- <div class="row form-group">
                        <div class="col-lg-12">
                            <label class="labelclass">Barang:</label>
                            <input type="text" id="nama_produk" class="form-control" readonly>
                            <select id="listBarang" class="form-control" data-live-search="true">
                                <option value="0">Silahkan Pilih Barang</option>
                                <option value="1">Barang 1</option>
                                <option value="2">Barang 2</option>
                                <option value="3">Barang 3</option>
                            </select>
                        </div>
                    </div>
                     --}}
                    <div class="row form-group">
                        <div class="col-lg-12" >
                            <label class="labelclass">Jumlah:</label>
                            <input type="number" id="qty" class="form-control" placeholder="Masukkan Jumlah Barang /pieces">
                        </div>
                    </div>
                    {{-- <div class="row form-group">
                        <div class="col-lg-12" >
                            <label class="labelclass">Bonus:</label>
                            <input type="number" id="bonus" class="form-control" placeholder="Masukkan Bonus">
                        </div>
                    </div> --}}
                    
                    {{-- <hr>

                    <div class="row text-right mr-3" style="width:100%">
                        <div class="col">
                            <button type="button" class="btn btn-sm btn-primary rmButton" style="background-color:rgba(165,78,182); color:whitesmoke" data-toggle="modal" data-target="" data-pos=`+i+`>
                                <span><i class=""></i>Edit</span>
                            </button>
                        </div>
                    </div> --}}
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Modal delete-->
    <div class="modal fade" id="modaldelete" role="dialog" style="border-radius:45px">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
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
      
</div>

@endsection

@section('script')
@canany(['superadmin_pabrik','reseller'])
<script>
    // //getDistributorName
    // $.ajax({
    //     type:'get',
    //     url:'{{ url("/manage_transaction/transaction_sell/getPenjualName") }}',
    //     data: {
    //         "_token": "{{ csrf_token() }}"                
    //     },
    //     success:function(data) {
    //         // console.log(data);
    //         document.getElementById("distributorName").innerHTML = data;
    //     },
    //     error: function(data){
    //         console.log(data);
    //     }
    // });    
</script>
@endcan

<script>

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
    // const date = new Date();
    // var dateNow = date.toLocaleString('en-US', {timeZone: 'Asia/Jakarta',});
    // var dateNowText = dateNow.substring(0, dateNow.indexOf(','));
    // document.getElementById("dateNow").innerHTML = dateNowText;

    // var timeNow = date.toLocaleString('en-US', {timeZone: 'Asia/Jakarta', hour: "2-digit",minute: "2-digit", hour12: false});
    // document.getElementById("timeNow").innerHTML = timeNow;

    // setInterval(function() {
    //     var second = new Date()
    //     if(second.getSeconds()==0)
    //     {
    //         timeNow = second.toLocaleString('en-US', {timeZone: 'Asia/Jakarta', hour: "2-digit",minute: "2-digit", hour12: false});
    //         document.getElementById("timeNow").innerHTML = timeNow;
    //     }
    // }, 1 * 1000); 

    //function to load shopping cart
    function loadShopCart()
    {
        
        var cart = JSON.parse(sessionStorage.getItem("carts"));//no brackets
        var i;
        var cartFromSession = '';
        // var totalHarga=0;
        for (i = 0; i < cart.length; i++) {
            // totalHarga+=cart[i][3];
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
                        url:'{{ url("/sales/product/create/check_item") }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            idItem : temp[i][4]                
                        },
                        success:function(data) {
                            //console.log(data);
                            if(tempJumlah>data['detailDistributor']['stok'])
                            {
                                swal
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
    }

    function addItem()
    {
        var namaProduk =$('#listBarang').find(":selected").text();
        var idProduk =document.getElementById('listBarang').value;
        var jumlah =document.getElementById('jumlah').value;
        if(idProduk == 0)
        {
            swal
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
                swal
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
                    url:'{{ url("/sales/product/create/check_item/") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        idItem : idProduk                
                    },
                    success:function(data) {
                        console.log(data);
                        
                        if(jumlah>data['detailDistributor']['stok'])
                        {
                            swal
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
        // var transactionCode = document.getElementById("trsCode").innerHTML;
        var id_sales = document.getElementById("id_sales").value;

        // var jumlahBarang = document.getElementById("subTotBarang").innerHTML;
        // jumlahBarang = jumlahBarang.substring(0,jumlahBarang.indexOf(' '));
        // var total = $('#totalHarga').data("total");
        // total = total.substring(total.indexOf(' '),total.length);
        var cart = JSON.parse(sessionStorage.getItem("carts"));

        // console.log(cart);
        // console.log(cart.length);
        if(cart.length > 0)
        {
            $.ajax({
                type:'post',
                url:'{{ url("/sales/product/store/stok/") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    cart:cart, 
                    idSales:id_sales,
                },
                success:function(data) {
                    console.log("sukses");
                    sessionStorage.clear();
                    swal
                    ({
                        title: 'Success Menambahkan Stok Sales.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    document.getElementById("shopCart").innerHTML = "";
                    window.location.href = "{{ url( '/sales/product/'.$id_sales) }}";
                    // swal({
                    //     title: 'Success Menambahkan Stok Sales.',
                    //     icon: 'success',
                    //     buttons: true,
                    //     successMode: true,
                    // })
                    // .then((isOkay) => {
                    //     if (isOkay) {
                    //         window.location.href = "{{ url( '/sales/product/create/stok/'.$id_sales) }}";
                    //     }
                    // });
                    // document.getElementById("totalHarga").innerHTML = "Rp. " + 0;
                },
                error: function(data){
                    console.log("error");
                    console.log(data);
                }
            });
        }
        else
        {
            swal
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
    //getListBarang
    var id_sales = document.getElementById("id_sales").value;

    $.ajax({
        type:'get',
        url:'{{ url("/sales/product/create/get_list_products_sales/") }}',
        data: {
            "_token": "{{ csrf_token() }}",   
            idSales : id_sales          
        },
        success:function(data) {
            console.log("data");
            console.log(data);
            document.getElementById("listBarang").innerHTML = data;
        },
        error: function(data){
            console.log("error");
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
            swal
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
                url:'{{ url("/sales/product/create/check_item") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    idItem : idItem                
                },
                success:function(data) {
                    if(jumlah>data['detailDistributor']['stok'])
                    {
                        swal
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
</script>
@endsection