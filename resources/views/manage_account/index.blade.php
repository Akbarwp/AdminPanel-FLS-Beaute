@extends('templates/main')

@section('css')
<style>
.tambahAkun{
    background-color:rgba(52, 25, 80, 1);
}
</style>
@endsection

@section('content')
<div class="container justify text-center">
    <div class="row">
        <div class="col-12">
            <div class="mt-3">
                <div class="row">
                    <div class="col-12">

                        <div class="row align-items-center">
                            <div class="col-md-3 text-left">
                                <h4>Daftar Akun</h4>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/manage_account/export/') }}'">
                                    <i class="fa fa-file-pdf-o"></i>
                                    <span>Export</span>
                                </button>
                                <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_account/print/') }}')"><i class='fa fa-print'></i>
                                    Print</button>
                            </div>
                            {{-- <div class="col-md-3 text-right">
                                <input type="submit" onclick="window.location.href='{{ url('/manage_account/users/create') }}'" class="btn btn-primary tambahAkun" style="background-color:rgba(165,78,182); color:whitesmoke" value="+ Add">
                            </div> --}}

                        </div>
                        <hr>
                        
                        @if($users->count())
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-12 grid-margin ">
                                <div class="iq-card">
                                    <div class="iq-card-body">
                                        <form action="/manage_report/akuns/getDate" method="get">
            <div class="row align-items-center">
                <div class="col-md-5 text-left">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                        </div>
                        <input class="form-control form-control-sm" id="min" name="min" placeholder="Tanggal Awal" type="text" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-5 text-left">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color:white;"><i class="fa fa-calendar-o"></i></span>
                        </div>
                        <input class="form-control form-control-sm" id="max" name="max" placeholder="Tanggal Akhir" type="text" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-2 ">
                    <button class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" type="submit" id="search">Cari</button>
                </div>
            </div>
            </form>
            <br>
            <div class="col text-left">
                
            </div>
            <div class="col text-left" id="logTableDiv">
                                        <div class="table-responsive-xl" style="overflow: scroll; ">
                                            <table class="table table-hover table-striped table-light text-nowrap text-left" cellspacing="0" id="logTable">
                                                <thead>
                                                    <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                                        <th scope="col">Nama</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Posisi</th>
                                                        <th scope="col">Admin Input</th>
                                                        <th scope="col">Tanggal Diinput</th>
                                                        @canany(['superadmin_pabrik','superadmin_distributor'])
                                                        <th scope="col">History Admin Edit</th>
                                                        @endcan
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>

                                                <tbody id="tablebody">
                                                    @foreach($users as $user)
                                                        <tr>
                                                            <td class='col-2'>
                                                                @if($user->image)
                                                                    <img src={{ asset('storage/' . $user->image) }} alt=profile-img class="avatar-50 roundimg" img-fluid/>
                                                                @else
                                                                    <img src={{ asset('images/manage_account/users/11.png') }} alt=profile-img class="avatar-50 roundimg" img-fluid/>
                                                                @endif
                                                                {{ $user->firstname}} {{ $user->lastname }}
                                                            </td>
                                                            <td>
                                                                {{ $user->email }}
                                                            </td>
                                                            <td>
                                                                @if($user->user_position == "superadmin_pabrik")
                                                                    superadmin
                                                                @elseif($user->user_position == "superadmin_distributor")
                                                                    distributor
                                                                @else
                                                                    {{ $user->user_position }}
                                                                @endif
                                                                {{-- {{ $user->user_position }} --}}
                                                            </td>
                                                            <td>{{ $user->nama_input }}</td>
                                                            {{-- @canany(['superadmin_pabrik','admin'])
                                                            <td>
                                                                @if($admins->where('id', $user->id_input)->first())
                                                                {{ $admins->where('id', $user->id_input)->first()->firstname }} {{ $admins->where('id', $user->id_input)->first()->lastname }}
                                                                @else
                                                                {{ $user->nama_input }}
                                                                @endif
                                                            </td>
                                                            @endcan
                                                            @can('superadmin_distributor')
                                                            <td>
                                                                {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                                                            </td>
                                                            @endcan --}}
                                                            <td>
                                                                {{ $user->created_at->format('d/m/y H:i:s') }}
                                                            </td>
                                                            @canany(['superadmin_pabrik','superadmin_distributor'])
                                                            <td>
                                                                <div class="form-group text-left">
                                                                    <button type="button" class="btn btn-primary btn-history" style="background-color:rgba(165,78,182); color:whitesmoke"  onclick="window.location.href='{{ url('/manage_account/users/'.$user->id) }}'">
                                                                        <i class="fa fa-eye "></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            @endcan
                                                            @if($users->count() > 1 || auth()->user()->id != 1)
                                                            <td class='col-1'>
                                                                @if($user->id == 1 || (auth()->user()->user_position == "superadmin_distributor" && $user->user_position == "superadmin_distributor"))
                                                                <button type='button' class='btn btn-edit' style="background-color:rgba(165,78,182); color:whitesmoke" onclick='window.location.href="{{url('/manage_account/users/'.$user->id.'/edit')}}"' style='color: #FDBE33;'>
                                                                    <i class='fas fa-edit'></i>&nbspEdit</button>
                                                                @else
                                                                    <div class='btn-group'>
                                                                    <button type='button' class='btn btn-edit' style="background-color:rgba(165,78,182); color:whitesmoke" onclick='window.location.href="{{url('/manage_account/users/'.$user->id.'/edit')}}"' style='color: #FDBE33;'>
                                                                    <i class='fas fa-edit'></i>&nbspEdit</button>
                                                                    
                                                                    @canany(['superadmin_pabrik','superadmin_distributor'])
                                                                    <form action="{{ url('/manage_account/users/'.$user->id) }}" method="post" onsubmit='return submitForm(this, {{ $user }});'>
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button type='submit' data-delete="{{ $user->id }}" class='btn btn-remove' style="background-color:rgba(165,78,182); color:whitesmoke" data-toggle='modal' style='color: #D17826;'>
                                                                        <i class='fas fa-trash'></i>&nbspHapus</button>
                                                                    </form>
                                                                    @endcan
                                                                </div>
                                                                @endif
                                                            </td>
                                                            @else
                                                            <td class='col-1'>
                                                                <button type='button' class='btn btn-edit' style="background-color:rgba(165,78,182); color:whitesmoke" onclick='window.location.href="{{url('/manage_account/users/'.$user->id.'/edit')}}"' style='color: #FDBE33;'>
                                                                    <i class='fas fa-edit'></i>&nbspEdit</button>
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
                        </div>
                        @else
                        <p class="text-center fs-4">No user found</p>
                        @endif
                        

                        <!-- Modal history -->
                        <div class="modal fade" id="modalHistory" role="dialog"
                        style="border-radius:45px">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header"
                                        style="background:rgba(52, 25, 80, 1); color:white;">
                                        <p id="employeeidname" style="font-weight: bold;">
                                            History
                                            Edit</p>
                                        <button type="button" class="close" data-dismiss="modal"
                                            style="background-color:rgba(165,78,182); color:whitesmoke">×</button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group">
                                            <table
                                                class="table table-hover table-striped table-light "
                                                id="myTableHistory">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal Edit</th>
                                                        <th>Kegiatan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyHistory">
                                                    {{-- <tr>
                                                        <td id="history_tanggal"></td>
                                                        <td id="history_kegiatan"></td>
                                                    </tr> --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
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

@if ($message = Session::get('delete_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
@endif

function submitForm(form, user) {
    var teks = "Data pegawai \"" + user['firstname'] + " " + user['lastname'] + "\" akan terhapus, klik oke untuk melanjutkan"
    if(user['user_position'] == "superadmin_distributor")
    {
        teks = "Seluruh data akun distributor \"" + user['firstname'] + " " + user['lastname'] + "\" akan terhapus termasuk resellernya, klik oke untuk melanjutkan"
    }

    swal({
        title: "Apa Anda Yakin?",
        text: teks,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((isOkay) => {
        if (isOkay) {
            form.submit();
        }
    });
    return false;
}

$(document).ready(function(){
    $('input[name=search]').on('keyup', function(){
        var searchTerm = $(this).val().toLowerCase();
        $("tbody tr").each(function(){
        var lineStr = $(this).text().toLowerCase();
        if(lineStr.indexOf(searchTerm) == -1){
            $(this).hide();
        }else{
            $(this).show();
        }
        });
    });

    var table=$('#logTable').DataTable({
        "oSearch": { "bSmart": false, "bRegex": true },
        "aaSorting": [],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
        },
    });
    var date_input_min = $('input[name="min"]'); //our date input has the name "date"
    var date_input_max = $('input[name="max"]'); //our date input has the name "date"
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    var options = {
        format: 'mm/dd/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    };
    date_input_min.datepicker(options);
    date_input_max.datepicker(options);
});

</script>
@endsection