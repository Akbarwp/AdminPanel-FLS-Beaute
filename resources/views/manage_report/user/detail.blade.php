@extends('templates/main')

@section('css')
<style>
    .topnav {
    }

    .topnav a {
        font-weight:500;
        color:grey;
        text-decoration: none;
    }

    .topnav a:hover {
        border-bottom: 3px solid rgba(253, 190, 51, 1);
    }

    .topnav a.active {
        color:blue;
        border-bottom: 3px solid rgba(253, 190, 51, 1);
    }
</style>
@endsection

@section('content')
<div class="container justify text-center">
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-sm-4" style="text-align:left;">
                    <h4 style="text-align:left;">Laporan Pegawai</h4>
                </div>
                <div class="col-sm">
                    <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="location.href='{{ url('/manage_report/users/detail/export/'.$user->id) }}'">
                        <i class="fa fa-file-pdf-o"></i>
                        <span>Export</span>
                    </button>
                    <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_report/users/detail/print/'.$user->id) }}')"><i class='fa fa-print'></i>
                    Print</button>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="iq-card">
        <div class="iq-card-body row">
            <div class="row justify-content-center align-items-center" style="padding:8px;">
                <div class="col-sm">
                    @if($user->image)
                        <img src={{ asset('storage/' . $user->image) }} alt=profile-img class="avatar-50 roundimg" img-fluid/>
                    @else
                        <img src={{ asset('images/manage_account/users/11.png') }} alt=profile-img class="avatar-50 roundimg" img-fluid/>
                    @endif
                </div>
                <div class="col-sm text-left">
                    <p style="font-weight:500;">{{ $user->firstname }} {{ $user->lastname }}</p>
                    <p style="color:grey; font-weight:500;s">{{ $user->email }}</p>
                    <p style="color:grey;">{{ $user->user_position }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="iq-card">
        <div class="iq-card-body">
            <div class="row justify-content-center align-items-center" style="padding:8px;">
                <div class="col-sm text-left">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-primary active" onclick="fswitch(1)">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked> Pembelian
                    </label>
                    <label class="btn btn-outline-primary" onclick="fswitch(2)">
                        <input type="radio" name="options" id="option2" autocomplete="off"> Penjualan
                    </label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center" style="padding:8px;">
                <div class="col-sm" id="logTable">
                </div>
            </div>
            
            
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function fswitch($i){
    var base_url = '{{ URL::to("/") }}';

    // PEMBELIAN
    if($i==1)
    {
        $.ajax({
            type:'get',
            url: base_url + "/manage_report/users/get_pembelian/",
            data: {
                ajaxid: {{ $user->id }},
                "_token": "{{ csrf_token() }}"        
            },
            
            success:function(data) {
                document.getElementById("logTable").innerHTML = data;
                $('#myTable').DataTable(
                    {
                        "oSearch": { "bSmart": false, "bRegex": true },
                    }
                );
                // $('#myTable').DataTable({
                //     "aaSorting": [],
                // });
            },
            error: function(data){
                console.log(data);
            }
        });
    }
    // PENJUALAN
    else
    {
        $.ajax({
            type:'get',
            url: base_url + "/manage_report/users/get_penjualan/",
            data: {
                ajaxid: {{ $user->id }},
                "_token": "{{ csrf_token() }}"        
            },
            
            success:function(data) {
                document.getElementById("logTable").innerHTML = data;
                $('#myTable').DataTable(
                    {
                        "oSearch": { "bSmart": false, "bRegex": true },
                    }
                );
                
            },
            error: function(data){
                console.log(data);
            }
        });
    }
}

$(document).ready(function(){

    fswitch(1);

});
</script>
@endsection