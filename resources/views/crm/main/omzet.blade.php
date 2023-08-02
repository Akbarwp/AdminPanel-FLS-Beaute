@extends('templates/main')

@section('css')
<style>
.hratas {
    border: none;
    height: 2px;
    color: #333;
    background-color: #333;
    margin-top: 0;
}

.upload {
    background-color: rgba(52, 25, 80, 1);
    color: white;
    width: 100px;
    border: 1px solid white;
    border-radius: 5px;
    width: 150px;
    height: 50px;

}
</style>
@endsection

@section('content')
<div class="container justify text-center">
    <div class="row align-items-center">
        <div class="col-md-4 text-left">
            <h4>CRM - {{ $owner->firstname }} {{ $owner->lastname }}</h4>
        </div>
        <div class="col-md-5">
            <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/crm/omzet/export/'.$owner->id) }}'">
                <i class="fa fa-file-pdf-o"></i>
                <span>Export</span>
            </button>
        
            <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/crm/omzet/print/'.$owner->id) }}')"><i
                    class='fa fa-print'></i>
                Print</button>
        </div>
    </div>
</div>
<div class="row d-flex justify-content-center align-items-center">
    <div class="col-12 grid-margin ">
        <div class="iq-card">

            <div class="iq-card-body">
                <div class="row">
                    <div class="col-md-2">
                        <h4>Point Saya</h4>
                    </div>
                    <div class="col-md-1">
                        <h4>:</h4>
                    </div>
                    <div class="col-md-3">
                        <h4>{{ number_format($owner->crm_poin, 0, ',', '.') }}</h4>
                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-primary" onclick="location.href='{{ url('/crm/omzet/history/'.$owner->id) }}'">History Point</button>
                    </div>
                
                </div>
                <hr>
                <table id="mytable" class="table table-hover table-striped table-light text-nowrap"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Reward</th>
                            <th>Point</th>
                            @if(auth()->user()->id == $owner->id)
                            <th>Claim</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($rewards as $reward)
                        <tr>
                            <td class="w-25">
                                <img src={{ asset('storage/' . $reward->image) }} alt=profile-img
                                    class="img-fluid img-thumbnail" style="width:75%;"/>
                            <td class="align-middle">
                                {{ $reward->reward }}
                            </td >
                            <td class="align-middle">{{ number_format($reward->poin, 0, ',', '.') }}</td>
                            @if(auth()->user()->id == $owner->id)
                            <td class="align-middle" >
                                <div class="form-group text-left " style="align-items:center" >
                                    @if($owner->crm_poin >= $reward->poin)
                                    <button type="button" data-toggle='modal'
                                        data-target='#modalacc' data-edit="{{ $reward->id }}" class="btn btn-primary btn-claim"><i class="fa fa-envelope-open"></i>Claim
                                    </button>
                                    @else
                                    <button type="button" data-toggle='modal'
                                        data-target='#modalacc' class="btn btn-secondary" disabled><i class="fa fa-envelope-open "></i>Claim
                                    </button>
                                    @endif
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal acc -->
<div class="modal fade" id="modalacc" role="dialog" style="border-radius:45px">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="{{ url('/crm/omzet/claim_reward/'.$owner->id) }}" method="post" enctype="multipart/form-data" name="update_form">
                <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
                    <p id="employeeidname" style="font-weight: bold;">Klaim Hadiah</p>
                    <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                </div>

                <div class="modal-body">
                    @csrf
                    <div class="col-12" hidden="">
                        <input type="text" name="id_reward">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm align-items-center">
                                <label for="exampleInputFirstName" style="color:black" id="keterangan"></label>
                            </div>                                
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-items-right">
                        <div class="btn-action" >
                            <button type="submit" class="btn-danger d-flex justify-content-center align-items-center" style="background-color:rgba(165,78,182); color:whitesmoke; height:35px; width:100px">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
@if ($message = Session::get('claim_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

$(document).ready(function(){
    $('#myTable').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
});

$(document).on('click', '.btn-claim', function(){
    var data_edit = $(this).attr('data-edit');
    $.ajax({
        method: "GET",
        url: "{{ url('/crm/omzet/get_reward') }}/" + data_edit,
        success:function(response)
        {
            $('input[name=id_reward]').val(response.reward.id);
            document.getElementById("keterangan").innerHTML = "Apakah anda yakin klaim hadiah "+response.reward.reward+" ?";
            validator.resetForm();
        }
    });
});
</script>
@endsection