@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="container justify text-center">
    <div class="row ">

        <div class="col-md-3 text-left">
            <h4>History {{ $user->firstname }} {{ $user->lastname }}</h4>
        </div>
        <div class="row align-items-center">
            <div class="col">
                <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/manage_account/history/export/'.$user->id) }}'">
                    <i class="fa fa-file-pdf-o"></i>
                    <span>Export</span>
                </button>
                <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/manage_account/history/print/'.$user->id) }}')"><i class='fa fa-print'></i>
                    Print
                </button>
            </div>
        </div>
        
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <div class="iq-card">
                <div class="iq-card-body ">
                    <table class="table text-left table-hover table-striped table-light" id="myTable">
                        <thead>
                            <tr>
                                <th>Tanggal Edit</th>
                                <th>Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userHistories as $userHistory)
                            <tr>
                                <td>
                                    {{ $userHistory->created_at->format('d/m/y H:i:s') }}
                                </td>
                                <td>{{ $userHistory->kegiatan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>
<script>
    $.fn.dataTable.moment( 'DD/MM/YY HH:mm:ss' );
    $(document).ready(function(){
        $('#myTable').DataTable({   
            "oSearch": { "bSmart": false, "bRegex": true },
            "columnDefs": [{ "orderDataType": "date-time", "targets": [0] }],
            "order": [[ 0, "desc" ]],
        });
    });

</script>
@endsection