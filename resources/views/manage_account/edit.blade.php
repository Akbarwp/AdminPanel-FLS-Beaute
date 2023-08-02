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
@endsection

@section('content')
<div class="container justify text-center">
    <form action="{{ url('/manage_account/users/'.$user->id) }}" method="post" name="create_form" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="profile-img" class="avatar-130 img-fluid img-preview roundimg"/>
                        {{-- <img src={{ asset('storage/' . $user->image) }} alt=profile-img class=avatar-50 img-fluid/> --}}
                    @else
                        <img src="{{ asset('images/manage_account/users/11.png') }}" alt="profile-img" class="avatar-130 img-fluid img-preview roundimg"/>
                    @endif
                    
                </div>
                <div class="btn-action col-3 d-flex justify-content-center align-items-center">
                    <label for="file-upload" class="custom-file-upload upload btn-primary d-flex justify-content-center align-items-center">
                        <p>Upload Foto</p>
                    </label>
                    <input class="form-control @error('image') is-invalid @enderror" id="file-upload" name="image" type="file" hidden="" onchange="previewImage()"/>
                    &nbsp;
                    &nbsp;
                    <label for="photo-delete" class="custom-file-upload upload btn-primary d-flex justify-content-center align-items-center" onclick="deleteImage()">
                        Delete Foto
                    </label>
                    {{-- <input class="form-control @error('image') is-invalid @enderror" id="photo-delete" name="photo-delete" type="button" hidden="" onchange="deleteImage()"/> --}}

                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label for="username" class="text">Username</label>
                </div>
                <div class="col-10">
                    <input type="text" name="username" class="form-control textField @error('username') is-invalid @enderror" id="username"
                        placeholder="Masukkan Username" value="{{old('username', $user->username)}}">
                    @error('username')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label for="firstname" class="text">Nama Depan</label>
                </div>
                <div class="col-10">
                    <input type="text" name="firstname" class="form-control textField @error('firstname') is-invalid @enderror" id="firstname"
                        placeholder="Masukkan Nama Depan" value="{{ old('firstname', $user->firstname) }}">
                    @error('firstname')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                <label for="lastname" class="text">Nama Belakang</label>
                </div>
                <div class="col-10">
                    <input type="text" name="lastname" class="form-control textField @error('lastname') is-invalid @enderror" id="lastname"
                        placeholder="Masukkan Nama Belakang" value="{{ old('lastname', $user->lastname) }}">
                    @error('lastname')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                <label for="lastname" class="text">Nomor HP</label>
                </div>
                <div class="col-10">
                    <input type="text" name="no_hp" class="form-control textField @error('no_hp') is-invalid @enderror" id="no_hp"
                            placeholder="Masukkan Nomor HP" value="{{ old('no_hp', $user->no_hp) }}">
                    @error('no_hp')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                <label for="ktp" class="text">Nomor KTP</label>
                </div>
                <div class="col-10">
                    <input type="text" name="ktp" class="form-control textField @error('ktp') is-invalid @enderror" id="ktp"
                        placeholder="Masukkan Nomor KTP" value="{{ old('ktp', $user->ktp) }}">
                    @error('ktp')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                <label for="password" class="text">Password Baru</label>
                </div>
                <div class="col-10">
                <input type="text" name="password" class="form-control textField" id="password"
                        placeholder="Masukkan Password Baru">
                </div>
                
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label for="email" class="text">Email</label>
                </div>
                <div class="col-10">
                    <input type="email" name="email" class="form-control textField @error('email') is-invalid @enderror" id="email" placeholder="Enter your Email" value="{{ old('email', $user->email) }}">
                    @error('email')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label class="text">Provinsi</label>
                </div>
                
                <div class="col-10">
                    <select class="form-control @error('province_id') is-invalid @enderror" id="province" name="province_id" onchange="getProvince(this.value)">
                        <option value="">Pilih Provinsi</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                    @error('province_id')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label class="text">Kota</label>
                </div>
                <div class="col-10">
                    <select class="form-control @error('city_id') is-invalid @enderror" id="city" name="city_id">
                        <option value="">Pilih Kota</option>
                    </select>
                    @error('city_id')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label for="address" class="text">Alamat</label>
                </div>
                <div class="col-10">
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                        placeholder="Masukkan Alamat" value="{{ old('address', $user->address) }}">
                    @error('address')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label class="text">Zip/Postal Code</label>
                </div>
                <div class="col-10">
                    <input class="form-control @error('postcode') is-invalid @enderror" type="text" min=5 max=5 name="postcode" id="postcode" placeholder="Enter your Zip/Portal Code" value="{{ old('postcode', $user->postcode) }}">
                    @error('postcode')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        @if($user->user_position != "superadmin_pabrik")
        @canany(['superadmin_pabrik','admin'])
        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label class="text">Posisi</label>
                </div>
                <div class="col-10">
                    <select class="form-control @error('user_position') is-invalid @enderror" id="user_position" name="user_position" onchange="getUserPosition(this.value)">
                        @if($checkAdmin)
                        <option value="admin">Admin</option>
                        @endif
                        @if($checkAccounting)
                        <option value="accounting_pabrik">Accounting</option>
                        @endif
                        @if($checkCashier)
                        <option value="cashier_pabrik">Cashier</option>
                        @endif
                        <option value="superadmin_distributor">Distributor</option>
                    </select>
                    @error('user_position')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>
        </div>
        @endif
        @endcan
        
        @if($user->user_position != "superadmin_distributor")
        @can('superadmin_distributor')
        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label class="text">Posisi</label>
                </div>
                <div class="col-10">
                    <select class="form-control @error('user_position') is-invalid @enderror" id="user_position" name="user_position" onchange="getUserPosition(this.value)" value="{{ old('user_position', $user->user_position) }}">
                        @if($checkAccounting)
                        <option value="accounting_distributor" selected>Accounting</option>
                        @endif
                        @if($checkCashier)
                        <option value="cashier_distributor">Cashier</option>
                        @endif
                        <option value="sales">Sales</option>
                        <option value="reseller">Reseller</option>
                    </select>
                    @error('user_position')
                    <div class="invalid-feedback text-left">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>
        </div>
        @endcan
        @endif
        <!-- <div class="col-12 d-flex justify-content-end">
            <button class="btn simpan-btn btn-sm" type="submit" autocomplete="off">
                <i class="mdi mdi-content-save">
                    ::before
                </i>
                Simpan
            </button>
        </div> -->

        
        <div class="form-group text-right">
            <input type="submit" onclick="" class="btn btn-primary submit" style="background-color:rgba(165,78,182); color:whitesmoke" value="Submit">
        </div>
    </form>
</div>
@endsection

@section('script')
<script type="text/javascript">

    $(function() {
        // alert("ready");
        // console.log("bbb");

        // const $select = document.querySelector('#user_position');
        // $select.value = {{ '$user->user_position' }}

    
        
        // $("#form_cluster").hide();
        // $("#toko_online").hide();

        // $("#user_position").val("{{ $user->user_position }}");
        $("#user_position").val("{{ old('user_position', $user->user_position) }}");
        $("#province").val("{{ $user->province_id }}");
        getProvince({{ $user->province_id }});
        

        if("{{ auth()->user()->user_position }}" == "superadmin_pabrik" || "{{ auth()->user()->user_position }}" == "admin")
        {
            if(("{{ $user->user_position }}" == "superadmin_distributor" && "{{ old('user_position') }}" == "superadmin_distributor") || ("{{ $user->user_position }}" == "superadmin_distributor" && "{{ old('user_position') }}" == "")) {
                $("#form_cluster").show();
                $("#toko_online").show();

                $("#cluster").val("{{ $user->cluster }}");
                $("#tokopedialink").val("{{ $user->tokopedia }}");
                $("#shopeelink").val("{{ $user->shopee }}");
                $("#lazadalink").val("{{ $user->lazada }}");
                $("#bukalapaklink").val("{{ $user->bukalapak }}");
                $("#bliblilink").val("{{ $user->blibli }}");

                if("{{ $user->tokopedia }}" != ""){
                    $('#tokopedia').prop('checked', true);
                }
                if("{{ $user->shopee }}" != ""){
                    $('#shopee').prop('checked', true);
                }
                if("{{ $user->lazada }}" != ""){
                    $('#lazada').prop('checked', true);
                }
                if("{{ $user->bukalapak }}" != ""){
                    $('#bukalapak').prop('checked', true);
                }
                if("{{ $user->blibli }}" != ""){
                    $('#blibli').prop('checked', true);
                }

            }
            else {
                $("#form_cluster").hide();
                $("#toko_online").hide();
            }
        }
        else
        {
            if(user_position == "reseller") {
                $("#toko_online").show();
            }
            else {
                $("#toko_online").hide();
            }
        }
        
    });

    function getProvince(province)
    {
        $('#city').html('');
        $.ajax({
            url: "{{ url('fetch-cities') }}",
            type: "POST",
            data: {
                province_id: province,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                var check=false;
                $('#city').html('<option value="">Pilih Kota</option>');
                $.each(result.cities, function (key, value) {
                    $("#city").append('<option value="' + value
                        .id + '">' + value.name + '</option>');

                        if("{{ $user->city_id }}" == value.id){
                            check=true;
                        }
                });

                if(check) {
                    $("#city").val("{{ $user->city_id }}");
                }
                
            }
        });
        
    }

    function getUserPosition(user_position)
    {
        // alert(user_position);
        if("{{ auth()->user()->user_position }}" == "superadmin_pabrik")
        {
            if(user_position == "superadmin_distributor") {
                $("#form_cluster").show();
                $("#toko_online").show();

                $("#cluster").val("{{ $user->cluster }}");
                $("#tokopedialink").val("{{ $user->tokopedia }}");
                $("#shopeelink").val("{{ $user->shopee }}");
                $("#lazadalink").val("{{ $user->lazada }}");
                $("#bukalapaklink").val("{{ $user->bukalapak }}");
                $("#bliblilink").val("{{ $user->blibli }}");

                if("{{ $user->tokopedia }}" != ""){
                    $('#tokopedia').prop('checked', true);
                }
                if("{{ $user->shopee }}" != ""){
                    $('#shopee').prop('checked', true);
                }
                if("{{ $user->lazada }}" != ""){
                    $('#lazada').prop('checked', true);
                }
                if("{{ $user->bukalapak }}" != ""){
                    $('#bukalapak').prop('checked', true);
                }
                if("{{ $user->blibli }}" != ""){
                    $('#blibli').prop('checked', true);
                }
            }
            else {
                $("#form_cluster").hide();
                $("#toko_online").hide();
            }
        }
        else
        {
            if(user_position == "reseller") {
                $("#toko_online").show();
            }
            else {
                $("#toko_online").hide();
            }
        }

    }

    function previewImage() {
        const image = document.querySelector('#file-upload');
        const imgPreview = document.querySelector('.img-preview');
        
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }

    function deleteImage() {
        const image = document.querySelector('#file-upload');
        const imgPreview = document.querySelector('.img-preview');
        imgPreview.src = "{{ asset('images/manage_account/users/11.png') }}";

        image.value = "";
    }

    
</script>
@endsection