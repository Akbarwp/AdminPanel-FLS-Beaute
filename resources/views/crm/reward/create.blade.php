
@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="mt-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between">
                        <div class="container">
                            <div class="row d-flex ">
                                <div class="col-xl-5 form-group" style="background-color:rgba(165,78,182); color:whitesmoke; text-align:left;">
                                    <h4 style="text-align:left;">
                                        Add CRM Reward
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('/crm/reward/store/'.$type) }}" method="post" name="create_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-group">
                            <div class="col-4">
                                Gambar
                            </div>
                            <div class="col-1">
                                :
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <img src="{{ asset('images/emas.png') }}" alt=profile-img class="img-fluid img-thumbnail img-preview" style="width:25%"/>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <input type="file" class="custom-file-input" id="pictfile" name="image" onchange="previewImage()">
                                        <label class="custom-file-label text-left" for="pictfile" id="filename">Pilih Gambar Reward</label>
                                        
                                    </div>
                                </div>
                                <div class="col-12" hidden="">
                                    <input type="text" name="image_name" id="new_image_name">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Reward</div>
                            <div class="col-1">:</div>
                            <input type="text" class="form form-control col-6" name="reward">
                        </div>
                        <div class="row form-group">
                            <div class="col-4">Point</div>
                            <div class="col-1">:</div>
                            <input type="number" class="form form-control col-6" name="poin">
                        </div>
                        {{-- <div class="row form-group">
                            <div class="col-4">Detail Reward</div>
                            <div class="col-1">:</div>
                            <input type="text" class="form form-control col-6" name="detail">
                        </div> --}}
                        <div class="row text-right">
                            <div class="col-12">
                                <button class="btn btn-primary text-right" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/reward/') }}'"
                                    style="text-align:left">
                                    <a style="color: white;">
                                        Submit
                                    </a>
                                </button>
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
$(document).ready(function(){
    $('#myTable').DataTable();
});

function previewImage() {
    const image = document.querySelector('#pictfile');
    const imgPreview = document.querySelector('.img-preview');
    
    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    let fileName = image.files[0].name;
    document.getElementById("filename").innerHTML = fileName;
    document.getElementById("new_image_name").value = fileName;

    oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
    }
}
</script>
@endsection
