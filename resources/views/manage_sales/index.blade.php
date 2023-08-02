@extends('templates/main')

@section('css')

@endsection

@section('content')
<div class="container justify text-left">
    <div class="d-flex justify-content-between">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-sm">
                    <h4 style="text-align:left;">Sales</h4>
                </div>
                <div class="col-sm">
                        <button type="button" class="btn btn-primary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.location.href='{{ url('/sales/export/'.$distributor->id_group) }}'">
                            <i class="fa fa-file-pdf-o"></i>
                            <span>Export</span></button>
                        <button type='button' class='btn btn-primary' style="background-color:rgba(165,78,182); color:whitesmoke" onclick="window.open('{{ url('/sales/print/'.$distributor->id_group) }}')">
                        <i class='fa fa-print'></i>Print</button>
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
                        <h4>Sales Dari {{ $distributor->firstname }} {{ $distributor->lastname }}</h4>
                    </div>
                    
                    <div class="table-responsive-xl">
                        
                        <table
                            class="table table-hover table-striped table-light display sortable"
                            cellspacing="0" id="tableSales">
                            <thead>
                                <br>
                                <tr id="_judul" onkeyup="_filter()" id="myFilter">
                                    <th>ID Sales</th>
                                    <th>Nama Sales</th>
                                    <th>Alamat Sales</th>
                                    <th>Nomor HP</th>
                                    <th>Aksi</th>
                                    <th>Stock Item</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($sales as $s)
                                <tr>
                                    <td>{{ $s->id }}</td>
                                    <td>{{ $s->firstname }} {{ $s->lastname }}</td>
                                    <td>{{ $s->address }}</td>
                                    <td>{{ $s->no_hp }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" style="background-color:rgba(165,78,182); color:whitesmoke" 
                                        onclick="location.href='{{ url('/sales/tracking/'.$s->id) }}'">
                                        <span><i class="fa fa-eye"></i>Track</span>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary"  style="background-color:rgba(165,78,182); color:whitesmoke"
                                        onclick="location.href='{{ url('/sales/product/'.$s->id) }}'">
                                        <span><i class="fa fa-eye"></i>Detail</span>
                                        </button>
                                    </td>
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
</div>
<!-- Modal Delete sales -->
<div class="modal fade" id="deleteSales" role="dialog" style="border-radius:45px">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
                    <p id="employeeidname" style="font-weight: bold;">Menghapus Sales A</p>
                    <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                </div>

                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-12">
                            Apakah Anda Yakin Untuk Menghapus Sales A?
                        </div>
                    </div>
                    <br>
                    <div class="row ">
                        <div class="col-6 text-right">
                            <button class="btn btn-secondary" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="" style="text-align:left">
                                <a style="color: white;">
                                    Cancel
                            </a>
                            </button>
                        </div>
                        <div class="col-6 text-left">
                            <button class="btn btn-danger" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="" style="text-align:left">
                                <a style="color: white;">
                                    Delete
                            </a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal edit sales -->
    <div class="modal fade" id="editSales" role="dialog" style="border-radius:45px">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background:rgba(52, 25, 80, 1); color:white;">
                    <p id="employeeidname" style="font-weight: bold;">DeusCode</p>
                    <button type="button" class="close" data-dismiss="modal" style="color:white;">×</button>
                </div>

                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-4">Username</div>
                        <div class="col-1">:</div>
                        <input type="text" class="form form-control col-6">
                    </div>
                    <div class="row form-group">
                        <div class="col-4">Nama Sales</div>
                        <div class="col-1">:</div>
                        <input type="text" class="form form-control col-6">
                    </div>
                    <div class="row form-group">
                        <div class="col-4">Provinsi</div>
                        <div class="col-1">:</div>
                        <select class="form form-control col-6 @error('province_id') is-invalid @enderror" id="province" name="province_id" onchange="getProvince(this.value)">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                                <option {{ old('province_id') == $province->id ? "selected" : "" }} value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                        @error('province_id')
                        <div class="invalid-feedback text-left">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row form-group">
                        <div class="col-4">Kota</div>
                        <div class="col-1">:</div>
                        <select class="form form-control col-6 @error('city_id') is-invalid @enderror" id="city" name="city_id">
                            <option value="">Pilih Kota</option>
                        </select>
                        @error('city_id')
                        <div class="invalid-feedback text-left">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row form-group">
                        <div class="col-4">Alamat</div>
                        <div class="col-1">:</div>
                        <input type="text" class="form form-control col-6">
                    </div>
                    <div class="row form-group">
                        <div class="col-4">Nomor KTP</div>
                        <div class="col-1">:</div>
                        <input type="number" class="form form-control col-6">
                    </div>
                    <div class="row form-group">
                        <div class="col-4">Nomor HP</div>
                        <div class="col-1">:</div>
                        <input type="text" class="form form-control col-6">
                    </div>
                    <div class="row form-group">
                        <div class="col-4">Email</div>
                        <div class="col-1">:</div>
                        <input type="text" class="form form-control col-6">
                    </div>
                    <div class="row form-group">
                        <div class="col-4">Gender</div>
                        <div class="col-1">:</div>
                        <div class="col-sm-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="row text-right">
                        <div class="col-12">
                            <button class="btn btn-primary text-right" style="background-color:rgba(165,78,182); color:whitesmoke" onclick="" style="text-align:left">
                                <a style="color: white;">
                                    Edit
                            </a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
$(document).ready(function(){
    $('#tableSales').DataTable(
        {
        "oSearch": { "bSmart": false, "bRegex": true },
        }
    );
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
                $('#city').html('<option value="">Pilih Kota</option>');
                $.each(result.cities, function (key, value) {
                    // <option {{ old('province_id') == $province->id ? "selected" : "" }} value="{{ $province->id }}">{{ $province->name }}</option>

                    // alert({{ old('province_id') }});

                    if("{{ old('province_id') }}" === "")
                    {
                        // alert("cc");
                        $("#city").append('<option value="' + value.id + '">' + value.name + '</option>');
                    }
                    else
                    {
                        // alert({{ old('city_id') }});
                        if("{{ old('city_id') }}" === "")
                        {
                            // alert("no");
                            $("#city").append('<option value="' + value.id + '">' + value.name + '</option>');
                        }
                        else if("{{ old('city_id') }}" === value.id.toString())
                        {
                            // alert("yes");
                            $("#city").append('<option selected value="' + value.id + '">' + value.name + '</option>');
                        }
                        else
                        {
                            $("#city").append('<option value="' + value.id + '">' + value.name + '</option>');
                        }
                    }
                });
            }
        });
        
    }
</script>
@endsection