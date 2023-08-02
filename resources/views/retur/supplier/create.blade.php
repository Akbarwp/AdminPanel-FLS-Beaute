@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="container justify text-center">
    @if(auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales")
    <h4 style="text-align:left;">Retur ke Pabrik</h4>
    @else
    <h4 style="text-align:left;">Retur ke Distributor</h4>
    @endif
    <hr>

    <form action="{{ url('/retur/to_supplier/store/') }}" method="post" name="create_form" enctype="multipart/form-data">
        @csrf
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="position-relative" style="margin-right:8px;">
                                <div class="form-group mb-0">
                                    @if(auth()->user()->user_position != "sales")
                                        <select class="form-control selectpicker @error('id_transaction') is-invalid @enderror" id="id_transaction" name="id_transaction" data-live-search="true" onchange="getDetails(this.value)">
                                            <option value="">Silahkan Pilih Kode Transaksi</option>
                                        @foreach($transactions as $transaction)
                                            <option {{ old('id_transaction') == $transaction->id ? "selected" : "" }} value="{{ $transaction->id }}">{{ $transaction->transaction_code }}</option>
                                        @endforeach
                                        </select>
                                    @else
                                        <select class="form-control selectpicker @error('id_transaction') is-invalid @enderror" id="id_transaction" name="id_transaction" data-live-search="true" onchange="getDetails(this.value)">
                                            <option value="">Silahkan Pilih Tanggal Terima Barang</option>
                                        @foreach($transactions as $transaction)
                                            <option {{ old('id_transaction') == $transaction->id ? "selected" : "" }} value="{{ $transaction->id }}">{{ $transaction->created_at->format('d/m/y H:i:s') }}</option>
                                        @endforeach
                                        </select>
                                    @endif
                                    @error('id_transaction')
                                    <div class="invalid-feedback text-left">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row text-left">
                        <div class="col-1">Supplier</div>
                        <div class="col-1">:</div>
                        <div class="col-9" id="nama_supplier"></div>
                    </div>
                    <div class="row text-left">
                        <div class="col-1">Tanggal</div>
                        <div class="col-1">:</div>
                        <div class="col-9" id="tanggal_transaksi"></div>
                    </div>
                    <br>
                </div>
            </div>

            <div class="iq-card-body">
                <div class="table-responsive-xl" style="overflow: scroll; ">
                    <table class="table table-hover table-light text-nowrap">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Kuantitas Barang</th>
                                <th scope="col">Harga Satuan</th>
                                <th scope="col">Total</th>
                                <th scope="col">Kuantitas Barang yang Diretur</th>
                                <th scope="col">Gambar</th>
                            </tr>
                        </thead>
                        <tbody id="list">
                        </tbody>
                    </table>
                </div>
                <div class="col text-left">
                    <div class="row">
                        <div class="col">
                            <textarea class="form-control " rows="3" id="keterangan" name="keterangan" placeholder="Keterangan Retur"></textarea>
                        </div>
                        <div class="col" style="padding-right:32px">
                            <input type="submit" onclick="" class="btn btn-primary submit" style="background-color:rgba(165,78,182); color:whitesmoke" value="Submit">
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
@if ($message = Session::get('create_retur_failed'))
    swal(
        "Transaksi Gagal!",
        "{{ $message }}",
        "error"
    );
@endif

$(document).ready(function(){
    getDetails({{ old('id_transaction') }});
});

function getDetails(id)
{
    // if("{{ auth()->user()->user_position }}" != "sales")
    // {
        var base_url = '{{ URL::to("/") }}';

        $.ajax({
            type:'get',
            url: base_url + "/retur/to_supplier/getDetails/" + id,
            success:function(data) {
                console.log("success");
                document.getElementById("nama_supplier").innerHTML = data.namaSupplier;
                document.getElementById("tanggal_transaksi").innerHTML = data.tanggalTransaksi;
                document.getElementById("list").innerHTML = data.list;
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
    // }
    // else
    // {
    //     var base_url = '{{ URL::to("/") }}';

    //     $.ajax({
    //         type:'get',
    //         url: base_url + "/retur/to_supplier/getDetails/" + id,
    //         success:function(data) {
    //             console.log("success");
    //             document.getElementById("nama_supplier").innerHTML = data.namaSupplier;
    //             document.getElementById("tanggal_transaksi").innerHTML = data.tanggalTransaksi;
    //             document.getElementById("list").innerHTML = data.list;
    //         },
    //         error: function(data){
    //             console.log("error");
    //             console.log(data);
    //         }
    //     });
    // }
}

function previewImage(id) {
    const image = document.querySelector('#file-upload'+id);
    const imgPreview = document.querySelector('.img-preview'+id);
    
    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    let fileName = image.files[0].name;
    document.getElementById("file-name"+id).innerHTML = fileName;

    
    oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
    }
}
</script>
@endsection