
@extends('templates/main')

@section('css')
@endsection

@section('content')
<div class="container justify text-left">

    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-sm">
                    <h4 style="text-align:left;">Reward</h4>
                </div>
                <div class="col-sm" style="text-align:left;">
                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/reward/export-reward') }}'">
                        <i class="fa fa-file-pdf-o"></i>
                        <span>Export</span>
                    </button>
                    
                    <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/crm/reward/print-reward') }}')"><i class='fa fa-print'></i>
                Print</button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <br>
    <div class="row ">
        <div class="col" >
            <div class="iq-card">
                <div class="iq-card-body">
                    <div class="row d-flex justify-content-between m-1">
                        <h4>Reward Distributor</h4>
                        <button class="btn btn-primary " style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/reward/create/distributor') }}'" style="text-align:left; background-color:rgba(52, 25, 80, 1);">
                            <a style="color: white;">
                                + Add Reward
                        </a>
                        </button>
                    </div>
                    
                    <div class="table-responsive-xl">
                        
                        <table
                            class="table table-hover table-striped table-light display sortable"
                            cellspacing="0" id="tableDistributor">
                            <thead>
                                <br>
                                <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                    <th>ID</th>
                                    <th>Reward</th>
                                    <th>Point</th>
                                    {{-- <th>Detail Reward</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($distributor_rewards as $reward)
                                <tr>
                                    <td>{{ $reward->id }}</td>
                                    <td>{{ $reward->reward }}</td>
                                    <td>{{ $reward->poin }}</td>
                                    {{-- <td>{{ $reward->detail }}</td> --}}
                                    <td><button type="button" class="btn btn-sm btn-warning btn-edit" style="background-color:rgba(165,78,182); color:whitesmoke" data-toggle='modal' data-target="#editReward" data-edit="{{ $reward->id }}">
                                        <span><i class="fa fa-edit"></i>Edit</span>
                                    </button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col" >
            <div class="iq-card">
                <div class="iq-card-body">
                    <div class="row d-flex justify-content-between m-1">
                        <h4>Reward Reseller</h4>
                        <button class="btn btn-primary " style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/reward/create/reseller') }}'" style="text-align:left; background-color:rgba(52, 25, 80, 1);">
                            <a style="color: white;">
                                + Add Reward
                        </a>
                        </button>
                    </div>
                    <div class="table-responsive-xl">
                        <table
                            class="table table-hover table-striped table-light display sortable"
                            cellspacing="0" id="tableReseller">
                            <thead>
                                <br>
                                <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                    <th>ID</th>
                                    <th>Reward</th>
                                    <th>Point</th>
                                    {{-- <th>Detail Reward</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($reseller_rewards as $reward)
                                <tr>
                                    <td>{{ $reward->id }}</td>
                                    <td>{{ $reward->reward }}</td>
                                    <td>{{ $reward->poin }}</td>
                                    {{-- <td>{{ $reward->detail }}</td> --}}
                                    <td><button type="button" class="btn btn-sm btn-warning btn-edit" style="background-color:rgba(165,78,182); color:whitesmoke" data-toggle='modal' data-target="#editReward" data-edit="{{ $reward->id }}">
                                        <span><i class="fa fa-edit"></i>Edit</span>
                                    </button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal edit reward -->
    <div class="modal fade" id="editReward" role="dialog" style="border-radius:45px">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form action="{{ url('/crm/reward/update') }}" method="post" enctype="multipart/form-data" name="update_form">

                    <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
                        <p id="employeeidname" style="font-weight: bold;">DeusCode</p>
                        <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                    </div>

                    <div class="modal-body">
                        @csrf
                        <div class="col-12" hidden="">
                            <input type="text" name="id">
                        </div>
                        <div class="col-12" hidden="">
                            <input type="text" name="image_name" id="new_image_name">
                        </div>
                        <div class="row form-group">
                            <div class="col-4">
                                Gambar
                            </div>
                            <div class="col-1">
                                :
                            </div>
                            <div class="col-6">
                                <div class="row form-group">
                                    <img src="{{ asset('images/emas.png') }}" alt=profile-img class="img-fluid img-thumbnail img-edit img-preview" style="width:25%"/>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <input type="file" class="custom-file-input" id="pictfile" name="image" onchange="previewImage()">
                                        <label class="custom-file-label text-left" for="pictfile" id="image_name">Pilih Gambar Reward</label>
                                    </div>
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
                                <button class="btn btn-primary text-right" onclick="msuccess('remove')" style="background-color:rgba(165,78,182); color:whitesmoke; text-align:left">
                                    <a style="color: white;">
                                        Submit
                                </a>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
@if ($message = Session::get('create_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

@if ($message = Session::get('update_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

$(document).ready(function(){
    // $('#myTable').DataTable();
    var table=$('#tableDistributor').DataTable({
        "oSearch": { "bSmart": false, "bRegex": true },
    });
});

$(document).ready(function(){
    // $('#myTable').DataTable();
    var table=$('#tableReseller').DataTable({
        "oSearch": { "bSmart": false, "bRegex": true },
    });
});

$(document).on('click', '.btn-edit', function(){
    var data_edit = $(this).attr('data-edit');
    $.ajax({
        method: "GET",
        url: "{{ url('/crm/reward/edit') }}/" + data_edit,
        success:function(response)
        {
        document.getElementById("image_name").innerHTML = response.reward.image_name;
        $('.img-edit').attr("src", "{{ asset('storage') }}/" + response.reward.image);
        $('input[name=id]').val(response.reward.id);
        $('input[name=reward]').val(response.reward.reward);
        $('input[name=poin]').val(response.reward.poin);
        $('input[name=detail]').val(response.reward.detail);
        validator.resetForm();
        }
    });
});

function previewImage() {
    const image = document.querySelector('#pictfile');
    const imgPreview = document.querySelector('.img-preview');
    
    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    let fileName = image.files[0].name;
    document.getElementById("image_name").innerHTML = fileName;
    document.getElementById("new_image_name").value = fileName;

    oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
    }
}

</script>
@endsection
